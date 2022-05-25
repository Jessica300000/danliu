package persistence;

import model.ToDoList;
import model.Task;
import org.junit.jupiter.api.Test;

import java.io.IOException;
import java.util.List;

import static org.junit.jupiter.api.Assertions.*;

public class JsonWriterTest extends JsonTest {

    @Test
    void testWriterInvalidFile() {
        try {
            ToDoList list = new ToDoList("My to-do list");
            JsonWriter writer = new JsonWriter("./data/my\0illegal:fileName.json");
            writer.open();
            fail("IOException was expected");
        } catch (IOException e) {
            // pass
        }
    }

    @Test
    void testWriterEmptyWorkroom() {
        try {
            ToDoList td = new ToDoList("My to-do list");
            JsonWriter writer = new JsonWriter("./data/testWriterEmptyToDoList.json");
            writer.open();
            writer.write(td);
            writer.close();

            JsonReader reader = new JsonReader("./data/testWriterEmptyToDoList.json");
            td = reader.read();
            assertEquals("My to-do list", td.getName());
            assertEquals(0, td.size());
        } catch (IOException e) {
            fail("Exception should not have been thrown");
        }
    }

    @Test
    void testWriterGeneralToDoList() {
        try {
            ToDoList td = new ToDoList("My to-do list");
            td.addTask(new Task("Go to shopping", 2021, 6, 29));
            td.addTask(new Task("Go to the beach", 2021, 6, 30));
            JsonWriter writer = new JsonWriter("./data/testWriterGeneralToDoList.json");
            writer.open();
            writer.write(td);
            writer.close();

            JsonReader reader = new JsonReader("./data/testWriterGeneralToDoList.json");
            td = reader.read();
            assertEquals("My to-do list", td.getName());
            List<Task> tasks = td.getTasks();
            assertEquals(2, tasks.size());
            checkTask("Go to shopping", 29, 6, 2021, tasks.get(0));
            checkTask("Go to the beach", 30, 6, 2021, tasks.get(1));

        } catch (IOException e) {
            fail("Exception should not have been thrown");
        }
    }
}
