package model;

import static org.junit.jupiter.api.Assertions.*;

import exceptions.NotInsideException;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;

public class ToDoListTest {
    private ToDoList toDoList;
    private ToDoList emptyList;
    private Task task1;
    private Task task2;
    //  private Task task3;

    @BeforeEach
    public void runBefore() {
        task1 = new Task("swim", 2021, 9, 1);
        task2 = new Task("study", 2021, 11, 5);
        emptyList = new ToDoList("empty list");
        toDoList = new ToDoList("first list");
        toDoList.addTask(task1);
        toDoList.addTask(task2);
    }

    @Test
    public void testConstructor() {
        assertEquals(emptyList.getName(), "empty list");
        assertTrue(emptyList.isEmpty());
        assertEquals(emptyList.size(), 0);
    }

    @Test
    public void testAddToEmpty() {
        assertTrue(emptyList.isEmpty());
        emptyList.addTask(task1);
        assertFalse(emptyList.isEmpty());
        assertEquals(1, emptyList.size());
    }

    @Test
    public void testAddToNonEmpty() {
        assertFalse(toDoList.isEmpty());
        assertEquals(2, toDoList.size());
        Task task3 = new Task("reading", 2021, 7, 24);
        toDoList.addTask(task3);
        assertEquals(3, toDoList.size());
    }

    @Test
    public void testRemove() {
        assertEquals(2, toDoList.size());
        toDoList.removeTask(1);
        assertEquals(1, toDoList.size());

    }

    @Test
    public void testChangeComplete() {
        assertEquals(false, toDoList.getTasks().get(1).getComplete());
        try {
            toDoList.changeComplete(1);
        } catch (NotInsideException e) {
            fail();
        }
        assertEquals(true, toDoList.getTasks().get(1).getComplete());
    }

    @Test
    public void TestUnchanged() {
        try {
            toDoList.changeComplete(3);
            fail();
        } catch (NotInsideException e) {

        }
    }

    @Test
    public void TestNegativeUnchanged() {
        try {
            toDoList.changeComplete(-1);
            fail();
        } catch (NotInsideException e) {

        }
    }


    @Test
    public void testSize() {
        assertEquals(0, emptyList.size());
        assertEquals(2, toDoList.size());
    }

    @Test
    public void testEmpty() {
        assertTrue(emptyList.isEmpty());
        assertFalse(toDoList.isEmpty());
    }


}
