package ui;

import exceptions.NotInsideException;
import model.Task;
import model.ToDoList;
import persistence.JsonReader;
import persistence.JsonWriter;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.List;
import java.util.Scanner;

// Represents the to-do list application
public class ToDoListApp {
    private static final String JSON_STORE = "./data/todolist.json";
    private ToDoList toDoList;
    private Scanner input;
    private JsonWriter jsonWriter;
    private JsonReader jsonReader;


    // EFFECTS: runs the To-to List application
    public ToDoListApp() throws FileNotFoundException {
        input = new Scanner(System.in);
        toDoList = new ToDoList("Jessica's to-do list");
        jsonWriter = new JsonWriter(JSON_STORE);
        jsonReader = new JsonReader(JSON_STORE);
        runToDoList();
    }

    // MODIFIES: this
    // EFFECTS: processes user input
    private void runToDoList() {
        boolean keepGoing = true;
        String command = null;
        input = new Scanner(System.in);
        //init();

        while (keepGoing) {
            displayMenu();
            command = input.next();
            command = command.toLowerCase();

            if (command.equals("q")) {
                keepGoing = false;
            } else {
                processCommand(command);
            }
        }

        System.out.println("\nGoodbye!");

    }

    // MODIFIES: this
    // EFFECTS: processes user command
    private void processCommand(String command) {
        if (command.equals("a")) {
            addTaskToList();
        } else if (command.equals("r")) {
            removeTaskFromList();
        } else if (command.equals("c")) {
            changeTheCompletion();
        } else if (command.equals("s")) {
            showAllTasks();
        } else if (command.equals("w")) {
            saveToDoList();
        } else if (command.equals("l")) {
            loadToDoList();
        } else {
            System.out.println("Selection not valid...");
        }
    }

    // MODIFIES: this
    // EFFECTS: initializes tasks
//    private void init() {
//        toDoList = new ToDoList();
//        input = new Scanner(System.in);
//    }

    // EFFECTS: displays menu of options to user
    private void displayMenu() {
        System.out.println("\nSelect from:");
        System.out.println("\ta -> add task");
        System.out.println("\ts -> show all tasks");
        System.out.println("\tr -> remove task");
        System.out.println("\tc -> change task completion status");
        System.out.println("\tw -> save to-do list to file");
        System.out.println("\tl -> load to-do list from file");
        System.out.println("\tq -> quit");
    }

    // MODIFIES: this
    // EFFECTS: Add task
    private void addTaskToList() {

        System.out.print("Enter the contents of the task: ");
        input.nextLine();
        String content1 = input.nextLine();
        System.out.print("Please enter the deadline year of the task (XXXX, only numbers): ");
        int year1 = input.nextInt();
        System.out.print("Please enter the deadline month of the task (XX, only numbers): ");
        int month1 = input.nextInt();
        System.out.print("Please enter the deadline day of the task (XX, only numbers): ");
        int day1 = input.nextInt();
        Task task1 = new Task(content1, year1, month1, day1);


        if (task1.getDate().equals("empty")) {
            System.out.println("Task addition failed because the date was entered incorrectly");
        } else {
            toDoList.addTask(task1);
            System.out.println("Task added Successfully！");
        }

    }

    // MODIFIES: this
    // EFFECTS: remove task
    private void removeTaskFromList() {
//        List<Task> tasks = toDoList.getTasks();
//        for (Task t : tasks) {
//            System.out.println(t);
//        }
        System.out.println("Which task do you want to delete? Please enter the id：");
        int choose = input.nextInt();

        if (choose <= toDoList.size() && choose > 0) {
            toDoList.removeTask(choose);
            System.out.println("Deletion has been completed!");
        } else {
            System.out.println("The deletion failed and the task does not exist.");
        }
//        for (Task t : tasks) {
//            System.out.println(t);
//        }

    }

    // MODIFIES: this
    // EFFECTS: change the task completion
    private void changeTheCompletion() {
//        List<Task> tasks = toDoList.getTasks();
//        for (Task t : tasks) {
//            System.out.println(t);
//        }
        System.out.println("Which task has been completed? Please enter the id：");
        int choose2 = input.nextInt();
        try {
            toDoList.changeComplete(choose2 - 1);
            System.out.println("The task has been marked as completed!");
        } catch (NotInsideException notInsideException) {
            notInsideException.printStackTrace();
            System.out.println("Marking task failed and the task does not exist.");
        }




    }

    // MODIFIES: this
    // EFFECTS: Show all tasks
    private void showAllTasks() {
        List<Task> tasks = toDoList.getTasks();
        for (Task t : tasks) {
            System.out.println(t);
        }
    }

    // EFFECTS: saves the todolist to file
    private void saveToDoList() {
        try {
            jsonWriter.open();
            jsonWriter.write(toDoList);
            jsonWriter.close();
            System.out.println("Saved this to-do list to " + JSON_STORE);
        } catch (FileNotFoundException e) {
            System.out.println("Unable to write to file: " + JSON_STORE);
        }
    }

    // MODIFIES: this
    // EFFECTS: loads todolist from file
    private void loadToDoList() {
        try {
            toDoList = jsonReader.read();
            System.out.println("Loaded this to-do list from " + JSON_STORE);
        } catch (IOException e) {
            System.out.println("Unable to read from file: " + JSON_STORE);
        }
    }


}


