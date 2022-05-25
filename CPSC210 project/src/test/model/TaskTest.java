package model;

import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;

import static org.junit.jupiter.api.Assertions.*;

class TaskTest {
    private Task task1;
    private Task task2;

    @BeforeEach
    public void runBefore() {
        task1 = new Task("Go to bed", 2013, 12, 5);
        task2 = new Task("have a dinner", 2013, 14, 17);
    }

    @Test
    public void testConstructor() {
        assertEquals("Go to bed", task1.getContent());
        assertEquals(5, task1.getDay());
        assertEquals(2013, task1.getYear());
        assertEquals(12, task1.getMonth());
        assertEquals(1, task1.getId());
        assertEquals(false, task1.getComplete());
        assertEquals("12-5-2013", task1.getDate());

    }

    @Test
    public void testDate() {
        assertEquals("empty", task2.getDate());
        Task task3 = new Task("sleep", -1, 12, 12);
        assertEquals("empty", task3.getDate());
        Task task4 = new Task("task4", 2014, -2, 12);
        assertEquals("empty", task4.getDate());
        Task task5 = new Task("task5", 2014, 10, -2);
        assertEquals("empty", task5.getDate());
        Task task6 = new Task("task6", 2014, 10, 40);
        assertEquals("empty", task6.getDate());

    }

    @Test
    public void testSetComplete() {
        assertEquals(false, task1.getComplete());
        task1.setComplete();
        assertEquals(true, task1.getComplete());
    }

    @Test
    public void testToString() {
        assertEquals(task1.toString(), "[ id:1 Content is Go to bed, date = 12-5-2013, " +
                "Complete is \"true\", incomplete is \"false\": false]");
    }
}