#include "block.h"
#include <cmath>
#include <iostream>

/* Returns the width, in pixels
 * of the current block
 */
int Block::width() const
{
    return data[0].size();

  
}

/* Returns the width, in pixels
 * of the current block
 */
int Block::height() const
{

    return data.size();
}

/* Given an image whose size is large enough, place
 * the current block in the image so that its upper left corner
 * is at position column, row. Existing pixels in the image
 * will be replaced by those of the block.
 */
void Block::render(PNG &im, int column, int row) const
{
    for(int y = row; y < (height() + row); y++){
        for(int x = column; x < (width() + column); x++){
            HSLAPixel* pixel = im.getPixel(x,y);
            pixel->h = data[y-row][x-column].h;
            pixel->s = data[y-row][x-column].s;
            pixel->l = data[y-row][x-column].l;
            pixel->a = data[y-row][x-column].a;
    }
  }
}

/* create a block of pixels whose color values are the same as the
 * rectangle in the image described by the upper left corner (column, row)
 * whose size is width x height.
 */
void Block::build(PNG &im, int column, int row, int width, int height)
{
    for (int y = row; y < (height + row); y++){
    vector<HSLAPixel> variable;
    for(int x = column; x < (width + column); x++){
      HSLAPixel* pixel = im.getPixel(x,y);
      variable.push_back(*pixel);
    }
    data.push_back(variable);
  }


}

/* Flip the current block across its horizontal midline.
 * This function changes the existing block.
 */
void Block::flipVert()
{
   for(int y = 0; y < height()/2; y++) {
        for(int x = 0;x < width(); x++) {
        int newY = height() - y -1;
        swap(data[y][x], data[newY][x]);
        }
    }
    //  for(int x = 0; x < width(); x++)
    //   {
    //     for(int y = 0; y < height()/2; y++)
    //       { 
    //          vector<vector<HSLAPixel>> tmp;
    //          tmp[x][y] = data[x][y];
    //          data[x][y] = data[x][height() - y -1];
    //          data[x][height() - y -1] = tmp[x][y];
    //       }
    //   }

    
   
}

/* Flip the current block across its vertical midline.
 * This function changes the existing block.
 */
void Block::flipHoriz()
{
    // for(int x = 0; x < width()/2; x++)
    //   {
    //     for(int y = 0; y < height(); y++)
    //       { 
    //         vector<vector<HSLAPixel>> tmp;
    //         tmp[x][y] = data[x][y];
    //         data[x][y] = data[width()-x-1][y];
    //         data[width()-x-1][y] = tmp[x][y];
    //       }
    //   }

    for(int x = 0;x < width()/2; x++) {
      for(int y = 0; y < height(); y++) {
        int newX = width() - x -1;
        swap(data[y][x], data[y][newX]);

      }
    }
}

/* Rotate the current block 90 degrees counterclockwise.
 * This function changes the existing block.
 */
void Block::rotateRight()
{ 

    for(int x = 0; x < width()/2; x++)
      {
        for(int y = x; y < height()-x-1; y++)
          { 
            swap(data[y][x], data[width() - 1 - y][x]);
            swap(data[width() - 1 - y][x], data[height() - 1 - x][width() - 1 - y]);
            swap(data[height() - 1 - x][width() - 1 - y], data[y][height() - 1 - x]);
            
          }
      }
}
