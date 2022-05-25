package model;

import exceptions.NotInsideException;
import org.json.JSONArray;
import org.json.JSONObject;
import persistence.Writable;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;


// Represents a set of tasks
public class ToDoList implements Writable {
    private String name;
    private List<Task> taskList;

    // EFFECTS: set is empty
    public ToDoList(String name) {
        this.name = name;
        taskList = new ArrayList<>();
    }

    // EFFECTS: Returns the name of this to-do list
    public String getName() {
        return name;
    }

    // MODIFIES: this
    // EFFECTS: EFFECTS: Task t is added to the ToDoList
    public void addTask(Task t) {
        taskList.add(t);
    }

    // REQUIRES: Tasks whose ID is t are part of the ToDoList
    // MODIFIES: this
    // EFFECTS: Task  is removed from the ToDoList
    public void removeTask(int t) {

        taskList.remove(t - 1);
    }

    // REQUIRES: Tasks whose ID is t are part of the ToDoList
    // MODIFIES: this
    // EFFECTS: Task  changes completion
    public void changeComplete(int t) throws NotInsideException {
        if (t < 0 || t >= taskList.size()) {
            throw new NotInsideException();
        }

        taskList.get(t).setComplete();

    }

    // EFFECTS: returns an unmodifiable list of tasks in this to-do list
    public List<Task> getTasks() {
        return Collections.unmodifiableList(taskList);
    }

    // EFFECTS: Returns the number of items in the set
    public int size() {
        return taskList.size();
    }

    //EFFECTS:returns a boolean: true if the TodoList is empty, false otherwise
    public boolean isEmpty() {
        return taskList.size() == 0;
    }


    @Override
    public JSONObject toJson() {
        JSONObject json = new JSONObject();
        json.put("name", name);
        json.put("taskList", taskListToJson());
        return json;
    }

    // EFFECTS: returns things in this todolist
    // as a JSON array
    private JSONArray taskListToJson() {
        JSONArray jsonArray = new JSONArray();

        for (Task t : taskList) {
            jsonArray.put(t.toJson());
        }

        return jsonArray;
    }


}
