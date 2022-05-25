# My Personal Project- To-do List Application

## Dan Liu 14118566

This *to-do list app* stores the user's tasks and will keep track of the deadlines for these tasks. In addition, 
it can mark tasks as completed or unfinished. It is often used by students and office workers, because it can help 
people remember their to-do list well. Since I wanted to see how our usual to-do app was made, I was interested in this 
project. Besides, I could use it myself in the future.
- As a user, I want to be able to add tasks to my to-do list.
- As a user, I want to be able to delete tasks from my to-do list.
- As a user, I want to be able to mark tasks as completed.
- As a user, I want to be able to see all the tasks on my to-do list.
- As a user, I want to be able to save my to-do list to a file.
- As a user, I want to be able to load a to-do list from a file.
- As a user, I want to add multiple tasks to the to-do list.
- As a user, I want to be able to load and save the state of the to-do list application.

###Phase 4: Task 2

I choose "Test and design a class in your model package that is robust. You must have at least one method that throws a 
checked exception.  You must have one test for the case where the exception is expected and another where the exception 
is not expected." The class I chose and designed is ToDoList class.
The method I chose to throw a checked exception is changeComplete(int t).
I also did two tests for cases where exceptions are expected.
### Phase 4: Task 3

if I had more time to work on the project, I would perform refactoring to improve the design.
- I found that the code in the completed () and remove () methods was duplicated.
- Simply having the code appear twice is problematic because changing the behavior of one method requires changing the 
  behavior of the other.
- To eliminate duplication, I can extract a method and call it from within each original method.