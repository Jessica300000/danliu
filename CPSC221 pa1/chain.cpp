#include "chain.h"
#include "chain_given.cpp"
#include <cmath>
#include <iostream>

// PA1 functions

/**
 * Destroys the current Chain. This function should ensure that
 * memory does not leak on destruction of a chain.
 */
Chain::~Chain()
{
      clear();
}

/**
 * Inserts a new node at the back of the List.
 * This function **SHOULD** create a new ListNode.
 *
 * @param ndata The data to be inserted.
 */
void Chain::insertBack(const Block &ndata)
{
      Node *insertNode = new Node(ndata);

      if (head_ == NULL)
      {
            head_ = insertNode;
      }
      else
      {
            Node *temp = head_;
            while (temp->next != NULL)
                  temp = temp->next;
            temp->next = insertNode;
            insertNode->prev = tail_;
      }
}

/**
 * Swaps the two nodes at the indexes "node1" and "node2".
 * The indexes of the nodes are 1 based.
 * assumes i and j are valid (in {1,length_} inclusive)
 * 
 */
void Chain::swap(int i, int j)
{

      if (i == j)
            return;

      Node *first = walk(head_, min(i, j));
      Node *second = walk(head_, max(i, j));

      if(first->next == second) {
            first->next = second->next;
            second->prev = first ->prev;
            first->prev = second;
            second->next = first;
            if (second->prev != NULL)
            {
                  second->prev->next = second;
            }
            if (first->next != NULL)
            {
                  second->next->prev = first;
            }
            
            

      }

      // if (first != NULL && second != NULL)
      // {

      //       // Link previous of first with second
      //       if (first->prev != NULL)
      //             first->prev->next = second;
      //       else
      //             head_ = second;

      //       // Link previous of second with first
      //       if (second->prev != NULL)
      //             second->prev->next = first;
      //       else
      //             head_ = first;

      //       // Swap first and second by swapping their
      //       // next node links
      //       Node *temp;
      //       temp = first->next;
      //       first->next = second->next;
      //       second->next = temp;
      // }
}

/**
 * Reverses the chain
 */
void Chain::reverse()
{
      if (length_ <= 1)
      return;
      if (length_ % 2 == 0)
      {
            for (int i = 0; i < length_ / 2; i++)
            {
                  swap(1 + i, length_ - i);
            }
      }
      else
      {
            for (int i = 0; i < (length_ - 1) / 2; i++)
            {
                  swap(1 + i, length_ - i);
            }
      }

      // Node *tempNode = NULL;
      // Node *prevNode = NULL;
      // Node *currentNode = head_;

      // while (currentNode != NULL)
      // {
      //       tempNode = currentNode->next;
      //       currentNode->next = prevNode;
      //       prevNode = currentNode;
      //       currentNode = tempNode;
      // }
      // head_ = prevNode;
}

/*
* Modifies the current chain by "rotating" every k nodes by one position.
* In every k node sub-chain, remove the first node, and place it in the last 
* position of the sub-chain. If the last sub-chain has length less than k,
* then don't change it at all. 
* Some examples with the chain a b c d e:
*   k = 1: a b c d e
*   k = 2: b a d c e
*   k = 3: b c a d e
*   k = 4: b c d a e
*/
void Chain::rotate(int k)
{
      if (k <= 1)
            return;
      Node *curr = head_;
      for (int num = length_/k; num > 0;num--)
      {
            Node *last = walk(curr,k);
            Node *temp = curr->next;
            curr->next = temp->next;
            curr->next->prev = curr;
            temp->next = last->next;
            temp->next->prev = temp;
            last->next = temp;
            temp->prev = last;
            curr = temp;
      }

      // Node *temp = head_;
      // Node *curr;

      // for (int i = 0; i < k - 1; i++)
      // {
      //       temp = temp->next;
      // }
      // temp->next = head_;
      // temp = head_;

      // for (int i = 0; i < k - 2; i++)
      // {
      //       temp = temp->next;
      //       curr = temp;
      // }
      // curr->next = temp->next->next;
      // head_ = temp->next;

      // temp->next = NULL;


}

/**
 * Destroys all dynamically allocated memory associated with the
 * current Chain class.
 */
void Chain::clear()
{
      Node *curr;
      Node *temp;

      
            curr = head_;
            temp = NULL;
            for (int i = 0; i <= length_; i++)
            {
                  temp = curr->next;
                  delete curr;
                  curr = temp;
            }

            tail_ = NULL;
            head_ = NULL;
      

}

/* makes the current object into a copy of the parameter:
 * All member variables should have the same value as
 * those of other, but the memory should be completely
 * independent. This function is used in both the copy
 * constructor and the assignment operator for Chains.
 */
void Chain::copy(Chain const &other)
{
      head_ = new Node();
      tail_ = new Node();
      head_->next = tail_;
      tail_->prev = head_;
      length_ = 0;
      // height_ = other.height_;
      // width_ = other.width_;
      // length_ = other.length_;
      Node *othercurr = other.head_->next;
      for (int i = 0; i < other.size(); i++)
      {
            Node *nNode = new Node(othercurr->data);
            height_ = othercurr->data.height();
            width_ = othercurr->data.width();
            Node *pNode = tail_->prev;
            nNode->next = tail_;
            tail_->prev = nNode;
            nNode->prev = pNode;
            pNode->next = nNode;
            
            othercurr = othercurr->next;
            length_++;
      }

      // Node *othercurr = other.head_->next;
      // Node *curr = head_;
      // Node* temp = tail_;

      // for (int i = 1; i <= other.size(); i++)
      // {
      //       Node *newnode = new Node(othercurr->data);
      //       height_ = othercurr->data.height();
      //       width_ = othercurr->data.width();
      //       curr->next = newnode;
      //       newnode = curr->prev->next;
      //       curr = curr->next;
      //       length_++;
      // }
      // curr = tail_;
}
/***********************************
 * swapColumns
 * parameters: 1 <= i <= numCols_
 *              1 <= j <= numCols_
 *
 * Swaps the positions of columns i and j
 * in the original grid of blocks by
 * moving nodes in the chain.
 *
 ***********************************/

void Chain::swapColumns(int i, int j)
{
      if (i < numCols_ && j < numCols_ && i != j)
      {
            for (int a = 0; a < numRows_; a++)
            {
                  swap(i + (3 * a), j + (3 * a));
            }
      }
}

/* 
      if (i < 0 || i > numCols_ || j < 0 || j > numCols_ || 1 == j)
            return;
      Node *first1 = walk(head_, min(i, j));
      Node *first2 = walk(head_, min(i, j) + 3);
      Node *first3 = walk(head_, min(i, j) + 6);
      Node *second1 = walk(head_, max(i, j));
      Node *second2 = walk(head_, max(i, j) + 3);
      Node *second3 = walk(head_, max(i, j) + 6);

      if (first1->next != second1)
      {
            Node *temp = first1->prev;
            first1->prev = second1->prev;
            second1->prev = temp;
            temp = first1->next;
            first1->next = second1->next;
            second1->next = temp;
            first1->prev->next = first1;
            second1->next->prev = second1;

            Node *temp1 = first2->prev;
            first2->prev = second2->prev;
            second2->prev = temp1;
            temp1 = first2->next;
            first2->next = second2->next;
            second2->next = temp1;
            first2->prev->next = first2;
            second2->next->prev = second2;

            Node *temp2 = first3->prev;
            first3->prev = second3->prev;
            second3->prev = temp2;
            temp2 = first3->next;
            first3->next = second3->next;
            second3->next = temp2;
            first3->prev->next = first3;
            second3->next->prev = second3;
      }
      else
      {
            first1->next = second1->next;
            second1->prev = first1->prev;
            first1->prev = second1;
            second1->next = first1;
            first2->next = second2->next;
            second2->prev = first2->prev;
            first2->prev = second2;
            second2->next = first2;
            first3->next = second3->next;
            second3->prev = first3->prev;
            first3->prev = second3;
            second3->next = first3;
      }

      if (first3->next != NULL)
      {
            first3->next->prev = first3;
      }
      else
      {
            tail_ = first3;
      }
      if (second1->prev != NULL)
      {
            second1->prev->next = second1;
      }
      else
      {
            head_ = second1;
      }
} */

/***********************************
 * swapRows
 * parameters: 1 <= i <= numRows_
 *              1 <= j <= numRows_
 *
 * Swaps the positions of rows i and j
 * in the original grid of blocks by
 * moving nodes in the chain.
 *
 ***********************************/
void Chain::swapRows(int i, int j)
{
      if (i < numRows_ && j < numRows_ && i != j)
      {
            for (int a = 1; a <= numCols_; a++)
            {
                  swap(3 * (i - 1) + a, 3 * (j - 1) + a);
            }
      }
}
// if (i < 0 || i > numRows_ || j < 0 || j > numRows_ || 1 == j)
//       return;
// Node *first1 = walk(head_, (min(i, j) - 1) * 3 + 1);
// Node *first2 = walk(head_, (min(i, j) - 1) * 3 + 2);
// Node *first3 = walk(head_, (min(i, j) - 1) * 3 + 3);
// Node *second1 = walk(head_, (max(i, j) - 1) * 3 + 1);
// Node *second2 = walk(head_, (max(i, j) - 1) * 3 + 2);
// Node *second3 = walk(head_, (max(i, j) - 1) * 3 + 3);

// if (first1->next != second1)
// {
//       Node *temp = first1->prev;
//       first1->prev = second1->prev;
//       second1->prev = temp;
//       temp = first1->next;
//       first1->next = second1->next;
//       second1->next = temp;
//       first1->prev->next = first1;
//       second1->next->prev = second1;

//       Node *temp1 = first2->prev;
//       first2->prev = second2->prev;
//       second2->prev = temp1;
//       temp1 = first2->next;
//       first2->next = second2->next;
//       second2->next = temp1;
//       first2->prev->next = first2;
//       second2->next->prev = second2;

//       Node *temp2 = first3->prev;
//       first3->prev = second3->prev;
//       second3->prev = temp2;
//       temp2 = first3->next;
//       first3->next = second3->next;
//       second3->next = temp2;
//       first3->prev->next = first3;
//       second3->next->prev = second3;
// }
// else
// {
//       first1->next = second1->next;
//       second1->prev = first1->prev;
//       first1->prev = second1;
//       second1->next = first1;
//       first2->next = second2->next;
//       second2->prev = first2->prev;
//       first2->prev = second2;
//       second2->next = first2;
//       first3->next = second3->next;
//       second3->prev = first3->prev;
//       first3->prev = second3;
//       second3->next = first3;
// }

// if (first3->next != NULL)
// {
//       first3->next->prev = first3;
// }
// else
// {
//       tail_ = first3;
// }
// if (second1->prev != NULL)
// {
//       second1->prev->next = second1;
// }
// else
// {
//       head_ = second1;
// }
//
