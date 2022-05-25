package model;

import org.json.JSONObject;
import persistence.Writable;

import javax.xml.crypto.Data;

//Represent a task with a completion status
public class Task implements Writable {
    private static int nextTaskId = 1;
    private int id;
    private String content;
    private String date;
    private Boolean complete;
    private int year;
    private int month;
    private int day;

    /*
     *
     * EFFECTS: Task has id,content , date and boolean;
     */
    public Task(String content, int year, int month, int day) {
        id = nextTaskId++;
        this.content = content;
        this.day = day;
        this.year = year;
        this.month = month;
        if (day <= 31 && day > 0 && month > 0 && month <= 12 && year > 0) {
            date = month + "-" + day
                    + "-" + year;
        } else {
            date = "empty";
        }
        complete = false;

    }

    // EFFECTS: returns task id
    public int getId() {
        return id;
    }

    // EFFECTS: returns task due year
    public int getYear() {
        return year;
    }

    // EFFECTS: returns task due month
    public int getMonth() {
        return month;
    }

    // EFFECTS: returns task due day
    public int getDay() {
        return day;
    }

    // EFFECTS: returns task due date
    public String getDate() {
        return date;
    }

    // EFFECTS: returns task content
    public String getContent() {
        return content;
    }

    // EFFECTS: returns task completion
    public Boolean getComplete() {
        return complete;
    }

    /*
     * MODIFIES: this
     * EFFECTS: convert complete case to true
     */
    public void setComplete() {
        this.complete = true;
    }


    /*
     * EFFECTS: returns a string representation of Task
     */
    @Override
    public String toString() {
        return "[ id:" + id + " Content is " + content + ", date = " + date + ", "
                + "Complete is \"true\", incomplete is \"false\": " + complete + "]";
    }


    @Override
    public JSONObject toJson() {
        JSONObject json = new JSONObject();
        json.put("id", id);
        json.put("content", content);
        json.put("date", date);
        json.put("day", day);
        json.put("year", year);
        json.put("month", month);
        json.put("complete", complete);

        return json;
    }
}
