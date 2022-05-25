
#include "stats.h"

stats::stats(PNG &im)
{

    /* your code here! */
    HSLAPixel *currPixel;

    sumHueX.clear();
    sumHueX.resize(im.width() + 1, vector<double>(im.height() + 1, 0));
    sumHueY.clear();
    sumHueY.resize(im.width() + 1, vector<double>(im.height() + 1, 0));
    sumSat.clear();
    sumSat.resize(im.width() + 1, vector<double>(im.height() + 1, 0));
    sumLum.clear();
    sumLum.resize(im.width() + 1, vector<double>(im.height() + 1, 0));

    hist.clear();
    hist.resize(im.width() + 1, vector<vector<int>>(im.height() + 1, vector<int>(36, 0)));

    for (size_t i = 1; i <= im.width(); i++)
    {
        for (size_t j = 1; j <= im.height(); j++)
        {
            
            vector<int> aHist;
            vector<int> lHist;
            vector<int> alHist;
            vector<int> currHist = hist[i][j];
            int rangeOfColors = 36;
            currPixel = im.getPixel(i - 1, j - 1);

            double currHue = currPixel->h;
            int currHistVal = ((currHue == 360) ? 0 : currHue / 10);

            sumSat[i][j] = sumSat[i][j - 1] + sumSat[i - 1][j] - sumSat[i - 1][j - 1] + currPixel->s;
            sumLum[i][j] = sumLum[i][j - 1] + sumLum[i - 1][j] - sumLum[i - 1][j - 1] + currPixel->l;
            sumHueX[i][j] = sumHueX[i][j - 1] + sumHueX[i - 1][j] - sumHueX[i - 1][j - 1] + cos(currHue * PI / 180);
            sumHueY[i][j] = sumHueY[i][j - 1] + sumHueY[i - 1][j] - sumHueY[i - 1][j - 1] + sin(currHue * PI / 180);

            aHist = hist[i][j - 1];
            lHist = hist[i - 1][j];
            alHist = hist[i - 1][j - 1];

            for (int k = 0; k < rangeOfColors; k++)
            {
                hist[i][j][k] = aHist[k] + lHist[k] - alHist[k];
            }

            hist[i][j][currHistVal]++;
        }
    }
}

long stats::rectArea(pair<int, int> ul, pair<int, int> lr)
{

    /* your code here */
    long area = abs(lr.first - ul.first + 1) * abs(lr.second - ul.second + 1);
    return area;
}

HSLAPixel stats::getAvg(pair<int, int> ul, pair<int, int> lr)
{

    /* your code here */
    HSLAPixel avgPixel;
    lr = make_pair(lr.first + 1, lr.second + 1);
    ul = make_pair(ul.first + 1, ul.second + 1);

    double sumX, sumY, avgSat, avgLum;

    avgSat = sumSat[lr.first][lr.second] - sumSat[lr.first][ul.second - 1] - sumSat[ul.first - 1][lr.second] + sumSat[ul.first - 1][ul.second - 1];

    avgLum = sumLum[lr.first][lr.second] - sumLum[lr.first][ul.second - 1] - sumLum[ul.first - 1][lr.second] + sumLum[ul.first - 1][ul.second - 1];

    sumX = sumHueX[lr.first][lr.second] - sumHueX[lr.first][ul.second - 1] - sumHueX[ul.first - 1][lr.second] + sumHueX[ul.first - 1][ul.second - 1];

    sumY = sumHueY[lr.first][lr.second] - sumHueY[lr.first][ul.second - 1] - sumHueY[ul.first - 1][lr.second] + sumHueY[ul.first - 1][ul.second - 1];

    avgPixel.a = 1.0;
    avgPixel.s = avgSat / rectArea(ul, lr);
    avgPixel.l = avgLum / rectArea(ul, lr);

    double avgHue = atan2(sumY, sumX) * 180 / PI;

    if (avgHue < 0) {
        avgHue += 360;
    }
        

    avgPixel.h = avgHue;

    return avgPixel;
}

double stats::entropy(pair<int, int> ul, pair<int, int> lr)
{

    vector<int> distn;

    /* using private member hist, assemble the distribution over the
    *  given rectangle defined by points ul, and lr into variable distn.
    *  You will use distn to compute the entropy over the rectangle.
    *  if any bin in the distn has frequency 0, then do not add that 
    *  term to the entropy total. see .h file for more details.
    */

    /* my code includes the following lines:
        if (distn[i] > 0 ) 
            entropy += ((double) distn[i]/(double) area) 
                                    * log2((double) distn[i]/(double) area);
    */

    distn.resize(36);

    lr = make_pair(lr.first + 1, lr.second + 1);
    ul = make_pair(ul.first + 1, ul.second + 1);

    int rangeOfColors = 36;
    if (ul.first == 0 && ul.second == 0)
    {
        for (int k = 0; k < rangeOfColors; k++)
        {
            distn[k] = hist[lr.first][lr.second][k];
        }
    }
    else if (ul.second == 0)
    {
        for (int k = 0; k < rangeOfColors; k++)
        {
            distn[k] = hist[lr.first][lr.second][k] - hist[ul.first - 1][lr.second][k];
        }
    }
    else if (ul.first == 0)
    {
        for (int k = 0; k < rangeOfColors; k++)
        {
            distn[k] = hist[lr.first][lr.second][k] - hist[lr.first][ul.second - 1][k];
        }
    }
    else
    {
        for (int k = 0; k < rangeOfColors; k++)
        {
            distn[k] = hist[lr.first][lr.second][k] - hist[lr.first][ul.second - 1][k] - hist[ul.first - 1][lr.second][k] + hist[ul.first - 1][ul.second - 1][k];
        }
    }

    long area = rectArea(ul, lr);

    double entropy = 0.0;
    for (int i = 0; i < rangeOfColors; i++)
    {
        if (distn[i] > 0)
        {
            entropy += ((double)distn[i] / (double)area) * log2((double)distn[i] / (double)area);
        }
    }
    return -1 * entropy;
}
