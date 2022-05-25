package persistence;

import model.Task;

import static org.junit.jupiter.api.Assertions.assertEquals;

public class JsonTest {
    protected void checkTask(String content, int day, int month, int year, Task task) {
        assertEquals(content, task.getContent());
        assertEquals(day, task.getDay());
        assertEquals(month, task.getMonth());
        assertEquals(year, task.getYear());
    }
}
