package ui;

import exceptions.NotInsideException;
import model.Task;
import model.ToDoList;
import persistence.JsonReader;
import persistence.JsonWriter;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import java.applet.Applet;
import java.applet.AudioClip;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.*;
import java.util.Arrays;
import java.awt.Graphics;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.URL;
import java.net.URI;

// Represents the to-do list application
public class GuiMain extends JFrame implements ActionListener {

    private static JTable jt;
    private JPanel myPanel1;
    private JPanel myPanel2;
    private Task task;
    private static ToDoList toDoList;
    private static String[] column = {"Content", "Date", "Complete?"};
    private Image image;
    private JsonWriter jsonWriter;
    private JsonReader jsonReader;
    private static final String JSON_STORE = "./data/todolist.json";
    private JLabel label6;
    private File file1;
    private URL url;
    private URI uri;

    // EFFECTS: runs the To-to List application
    public GuiMain() {
        super("To-do List");
        setPreferredSize(new Dimension(800, 600));
        //  setBounds(200, 200, 800, 800);
        setDefaultCloseOperation(EXIT_ON_CLOSE);
        play();
        init();
        jsonWriter = new JsonWriter(JSON_STORE);
        jsonReader = new JsonReader(JSON_STORE);
        buttonOne();
        buttonTwo();
        buttonThree();
        buttonFour();
        buttonFive();
        table();
        getInfo();
        pack();
        setLocationRelativeTo(null);
        setVisible(true);
        setResizable(false);
    }

    // EFFECTS: Construct a frame
    void init() {
        setLayout(new FlowLayout());
        JSplitPane pane = new JSplitPane();
        pane.setPreferredSize(new Dimension(800, 600));
        add(pane);
        panel();
        pane.setOrientation(JSplitPane.VERTICAL_SPLIT);
        myPanel1.setSize(790, 400);
        myPanel2.setSize(790, 200);
        pane.setDividerLocation(500);
        pane.setTopComponent(myPanel1);
        pane.setBottomComponent(myPanel2);
        toDoList = new ToDoList("8 8, 2021");
    }

    // EFFECTS: Add background and color
    void panel() {
        myPanel1 = new JPanel() {
            @Override
            public void paint(Graphics g) {
                ImageIcon icon = new ImageIcon("background.jpeg");
                image = icon.getImage();
                g.drawImage(image, 0, 0, null);
            }
        };
        myPanel2 = new JPanel();
        myPanel2.setBackground(Color.WHITE);
        //  JPanel panel6 = new JPanel();
        label6 = new JLabel(" ");
        label6.setForeground(Color.orange);
        myPanel1.add(label6);
        //      myPanel1.add(panel6);

    }

    // EFFECTS: Construct a table
    void table() {
        JScrollPane sp = new JScrollPane();
        sp.setBounds(30, 40, 400, 400);
        myPanel1.add(sp);
        JScrollPane scrollPane = new JScrollPane();
        sp.setViewportView(scrollPane);
        jt = new JTable();
        scrollPane.setViewportView(jt);
    }


    //EFFECTS: Constructing a button
    private void buttonOne() {
        JButton button1 = new JButton("Add Task");
        button1.setBounds(170, 44, 110, 27);
        button1.setActionCommand("add");
        button1.addActionListener(this);
        myPanel2.add(button1);
    }

    //EFFECTS: Constructing a button
    private void buttonTwo() {
        JButton button2 = new JButton("Remove Task");
        button2.setBounds(1, 44, 90, 27);
        button2.setActionCommand("remove");
        button2.addActionListener(this);
        myPanel2.add(button2);
    }

    //EFFECTS: Constructing a button
    private void buttonThree() {
        JButton button3 = new JButton("Completed");
        button3.setBounds(180, 44, 150, 27);
        button3.setActionCommand("completed");
        button3.addActionListener(this);
        myPanel2.add(button3);
    }

    //EFFECTS: Constructing a button
    private void buttonFour() {
        JButton button4 = new JButton("Save");
        button4.setBounds(180, 44, 150, 27);
        button4.setActionCommand("save");
        button4.addActionListener(this);
        myPanel2.add(button4);
    }

    //EFFECTS: Constructing a button
    private void buttonFive() {
        JButton button5 = new JButton("Load");
        button5.setBounds(180, 44, 150, 27);
        button5.setActionCommand("load");
        button5.addActionListener(this);
        myPanel2.add(button5);
    }

    //EFFECTS: get information from todolist
    public static void getInfo() {

        Object[][] data = new Object[toDoList.getTasks().size()][];
        for (int i = 0; i < toDoList.getTasks().size(); i++) {
            Task p1 = toDoList.getTasks().get(i);
            System.out.println(p1);
            Object[] ff = {p1.getContent(), p1.getDate(), p1.getComplete()};
            System.out.println(Arrays.toString(ff));
            data[i] = ff;

        }

        jt.setModel(new DefaultTableModel(data, column));
    }

    // MODIFIES: this
    //EFFECTS: remove a task from todolist
    private void remove() {
        int row = jt.getSelectedRow();
        int length = jt.getSelectedRows().length;
        if (row != -1) {
            for (int i = 0; i < length; i++) {

                try {
                    toDoList.removeTask(row + 1);
                } catch (Exception exception) {
                    exception.printStackTrace();
                }

            }
        }
        getInfo();
    }

    // MODIFIES: this
    // EFFECTS: Task  changes completion
    private void completed() {

        int row = jt.getSelectedRow();
        int length = jt.getSelectedRows().length;
        if (row != -1) {
            for (int i = 0; i < length; i++) {
                try {
                    toDoList.changeComplete(row);
                } catch (NotInsideException notInsideException) {
                    notInsideException.printStackTrace();
                }
            }
        }
        getInfo();
    }

    // EFFECTS: saves the todolist to file
    private void save() {
        try {
            jsonWriter.open();
            jsonWriter.write(toDoList);
            jsonWriter.close();
            JOptionPane.showMessageDialog(null,
                    "Saved this to-do list to " + JSON_STORE,
                    "save", JOptionPane.INFORMATION_MESSAGE);
            //  label6.setText("Saved this to-do list to " + JSON_STORE);
        } catch (FileNotFoundException e) {
            JOptionPane.showMessageDialog(null,
                    "Unable to write to file: " + JSON_STORE,
                    "error", JOptionPane.WARNING_MESSAGE);
            //  System.out.println("Unable to write to file: " + JSON_STORE);
        }
    }


    // MODIFIES: this
    // EFFECTS: loads todolist from file
    private void load() {
        try {
            toDoList = jsonReader.read();
            getInfo();
        } catch (IOException e) {
            JOptionPane.showMessageDialog(null,
                    "Unable to read from file: " + JSON_STORE,
                    "error", JOptionPane.WARNING_MESSAGE);

        }
    }

    //EFFECTS: This is the method that is called when the the JButton btn is clicked
    public void actionPerformed(ActionEvent e) {
        if (e.getActionCommand().equals("add")) {
            new Add();
        } else if (e.getActionCommand().equals("remove")) {
            remove();
        } else if (e.getActionCommand().equals("completed")) {
            completed();
        } else if (e.getActionCommand().equals("save")) {
            save();
        } else if (e.getActionCommand().equals("load")) {
            load();
        }
    }


    // EFFECTS: return todolist
    public static ToDoList getToDoList() {
        return toDoList;
    }

    // EFFECTS: play the music
    public void play() {
        try {
            file1 = new File("music2.wav");
            uri = file1.toURI();
            url = uri.toURL();
            AudioClip aau;
            aau = Applet.newAudioClip(url);
            aau.loop();
        } catch (Exception e) {
            e.printStackTrace();
        }

    }


    public static void main(String[] args) {
        new GuiMain();
    }
}
