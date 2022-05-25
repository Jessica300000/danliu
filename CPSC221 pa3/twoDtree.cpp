
/**
 *
 * twoDtree (pa3)
 * slight modification of a Kd tree of dimension 2.
 * twoDtree.cpp
 * This file will be used for grading.
 *
 */

#include "twoDtree.h"

/* node constructor given */
twoDtree::Node::Node(pair<int, int> ul, pair<int, int> lr, HSLAPixel a)
	: upLeft(ul), lowRight(lr), avg(a), LT(NULL), RB(NULL)
{
}

/* destructor given */
twoDtree::~twoDtree()
{
	clear();
}

/* copy constructor given */
twoDtree::twoDtree(const twoDtree &other)
{
	copy(other);
}

/* operator= given */
twoDtree &twoDtree::operator=(const twoDtree &rhs)
{
	if (this != &rhs)
	{
		clear();
		copy(rhs);
	}
	return *this;
}

/* twoDtree constructor */
twoDtree::twoDtree(PNG &imIn)
{
	/* your code here */
	stats stats_imIn(imIn);
	pair<int, int> ul;
	pair<int, int> lr;
	height = imIn.height();
	width = imIn.width();
	ul = make_pair(0, 0);
	lr = make_pair(width - 1, height - 1);
	root = buildTree(stats_imIn, ul, lr, true);
}

/* buildTree helper for twoDtree constructor */
twoDtree::Node *twoDtree::buildTree(stats &s, pair<int, int> ul, pair<int, int> lr, bool vert)
{

	/* your code here */
	int currHeight = lr.second - ul.second + 1;
	int currWidth = lr.first - ul.first + 1;
	

	Node *currNode = new Node(ul, lr, s.getAvg(ul, lr));

	if (lr.first == ul.first && lr.second == ul.second)
	{
		return currNode;
	}

	if (lr.first == ul.first){
		vert = false;
	}
		
	else if (lr.second == ul.second){
		vert = true;
	}
		

	double minE = 0;

	pair<int, int> newLowerRight(0, 0);
	pair<int, int> newUpperLeft(0, 0);

	if (vert == true)
	{

		for (int i = 0; i < currWidth - 1; i++)
		{

			pair<int, int> LR (ul.first + i, lr.second);
			pair<int, int> UL(ul.first + i + 1, ul.second);

            double leftE = s.entropy(ul, LR);
			double leftAR = i + 1;
			double weightedLE = leftE * leftAR;

			double rightE = s.entropy(UL, lr);
			double rightAR = currWidth - i - 1;
			double weightedRE = rightE * rightAR;

			double totalWE = weightedLE + weightedRE;

			if (totalWE <= minE || i == 0)
			{
				minE = totalWE;
				newLowerRight = LR;
				newUpperLeft = UL;
			}
		}
	}
	else
	{
		for (int i = 0; i < currHeight - 1; i++)
		{

			pair<int, int> LR(lr.first, ul.second + i);
			pair<int, int> UL(ul.first, ul.second + i + 1);

			double upE = s.entropy(ul, LR);
			double upAR = i + 1;
			double weightedUE = upE * upAR;

			double botE = s.entropy(UL, lr);
			double botAR = currHeight - i - 1;
			double weightedBE = botE * botAR;

			double totalWE = weightedUE + weightedBE;

			if (totalWE <= minE || i == 0)
			{
				minE = totalWE;
				newLowerRight = LR;
				newUpperLeft = UL;
			}
		}
	}

	currNode->LT = buildTree(s, ul, newLowerRight, !vert);
	currNode->RB = buildTree(s, newUpperLeft, lr, !vert);

	return currNode;
}

void twoDtree::renderPicture(PNG &pic, Node *&node)
{
	pair<int, int> UL = node->upLeft;
	pair<int, int> LR = node->lowRight;

	if (node->LT == NULL && node->RB == NULL)
	{
		for (int i = UL.first; i <= LR.first; i++)
		{
			for (int j = UL.second; j <= LR.second; j++)
			{
				HSLAPixel *currPic = pic.getPixel(i, j);
				*currPic = node->avg;
			}
		}
		return;
	}

	renderPicture(pic, node->LT);
	renderPicture(pic, node->RB);
}
//new

/* render your twoDtree into a png */
PNG twoDtree::render()
{
	/* your code here */
	PNG ans = PNG(width, height);
	renderPicture(ans, root);
	return ans;
}

/* prune function modifies tree by cutting off
 * subtrees whose leaves are all within tol of 
 * the average pixel value contained in the root
 * of the subtree
 */
void twoDtree::prune(double tol)
{
	pruneTree(root, tol);
}

/* helper function for destructor and op= */

bool twoDtree::withinTolerance(Node *node, HSLAPixel avg, double tol)
{
	if (node == NULL)
	{
		return true;
	}
	
	else if (node->LT == NULL && node->RB == NULL)
	{
		return node->avg.dist(avg) <= tol;
	}

	else
	{
		return withinTolerance(node->LT, avg, tol) && withinTolerance(node->RB, avg, tol);
	}
} //new

void twoDtree::pruneTree(Node *node, double tol)
{
	if (node == NULL)
		return;

	HSLAPixel pix = node->avg;

	if (withinTolerance(node, pix, tol))
	{
		clearChild(node->LT);
		clearChild(node->RB);
	}
	else
	{
		pruneTree(node->LT, tol);
		pruneTree(node->RB, tol);
	}
} //new

void twoDtree::clearChild(Node *&node)
{
	if (node == NULL)
		return;

	clearChild(node->LT);
	clearChild(node->RB);

	delete node;
	node = NULL;
} //new

/* frees dynamic memory associated w the twoDtree */
void twoDtree::clear()
{
	/* your code here */
	clearChild(root);
}

void twoDtree::copyTree(Node *&currRoot, Node *newRoot)
{
	if (newRoot == nullptr)
	{
		currRoot = NULL;
		return;
	}

	currRoot = new Node(newRoot->upLeft, newRoot->lowRight, newRoot->avg);
	copyTree(currRoot->RB, newRoot->RB);
	copyTree(currRoot->LT, newRoot->LT);
} //new

/* helper function for copy constructor and op= */
void twoDtree::copy(const twoDtree &orig)
{

	/* your code here */
	width = orig.width;
	height = orig.height;

	copyTree(root, orig.root);
}
