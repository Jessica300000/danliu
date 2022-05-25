package persistence;

import model.ToDoList;
import model.Task;
import org.junit.jupiter.api.Test;

import java.io.IOException;
import java.util.List;

import static org.junit.jupiter.api.Assertions.*;

public class JsonReaderTest extends JsonTest {

    @Test
    void testReaderNonExistentFile() {
        JsonReader reader = new JsonReader("./data/noSuchFile.json");
        try {
            ToDoList td = reader.read();
            fail("IOException expected");
        } catch (IOException e) {
            // pass
        }
    }

    @Test
    void testReaderEmptyToDoList() {
        JsonReader reader = new JsonReader("./data/testReaderEmptyToDoList.json");
        try {
            ToDoList td = reader.read();
            assertEquals("My to-do list", td.getName());
            assertEquals(0, td.size());
        } catch (IOException e) {
            fail("Couldn't read from file");
        }
    }

    @Test
    void testReaderGeneralToDoList() {
        JsonReader reader = new JsonReader("./data/testReaderGeneralToDoList.json");
        try {
            ToDoList td = reader.read();
            assertEquals("My to-do list", td.getName());
            List<Task> tasks = td.getTasks();
            assertEquals(2, tasks.size());
            checkTask("go to bad", 29, 7, 2021, tasks.get(0));
            checkTask("fitness", 30, 7, 2021, tasks.get(1));
        } catch (IOException e) {
            fail("Couldn't read from file");
        }
    }
}



