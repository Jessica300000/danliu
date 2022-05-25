package ui;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import model.Task;
import model.ToDoList;

// EFFECTS: Add a task to To-to List
public class Add extends JFrame implements ActionListener {
    private static Task task;
    private JPanel panel;
    JLabel label = null;
    JLabel label1 = null;
    JLabel label2 = null;
    JLabel label3 = null;
    JLabel label6 = null;
    private JTextField textField;
    private JTextField textField1;
    private JTextField textField2;
    private JTextField textField3;
    private Image image;


    // EFFECTS: Construct an Add panel
    public Add() {
        super("Add Task");
        setPreferredSize(new Dimension(500, 500));
        setDefaultCloseOperation(HIDE_ON_CLOSE);
        setLayout(new FlowLayout());
        background();
        add(panel);
        panel.setPreferredSize(new Dimension(500, 500));
        firstLine();
        secondLine();
        thirdLine();
        forthLine();
        fiveLine();
        button1();
        pack();
        setLocationRelativeTo(null);
        setVisible(true);
        setResizable(false);
    }

    // EFFECTS： Change the background color
    private void background() {
        panel = new JPanel(new GridLayout(6, 1));
        panel.setBackground(Color.pink);
    }

    // EFFECTS： Add fist line and change the background color
    private void firstLine() {
        JPanel jp1 = new JPanel();
        jp1.setBackground(Color.pink);
        label = new JLabel("Enter the contents of the task:");
        jp1.add(label);
        textField = new JTextField();
        jp1.add(textField);
        textField.setColumns(20);
        panel.add(jp1);

    }

    // EFFECTS： Add second line and change the background color
    private void secondLine() {

        JPanel jp2 = new JPanel();
        jp2.setBackground(Color.white);
        label1 = new JLabel("Please enter the deadline year of the task (XXXX, only numbers): ");
        jp2.add(label1);
        textField1 = new JTextField();
        jp2.add(textField1);
        textField1.setColumns(4);
        panel.add(jp2);
    }

    // EFFECTS： Add third line and change the background color
    private void thirdLine() {
        JPanel jp3 = new JPanel();
        jp3.setBackground(Color.PINK);
        label2 = new JLabel("Please enter the deadline month of the task (XX, only numbers): ");
        jp3.add(label2);
        textField2 = new JTextField();
        jp3.add(textField2);
        textField2.setColumns(4);
        panel.add(jp3);
    }

    // EFFECTS： Add fourth line and change the background color
    private void forthLine() {
        JPanel jp4 = new JPanel();
        jp4.setBackground(Color.white);
        label3 = new JLabel("Please enter the deadline day of the task (XX, only numbers): ");
        jp4.add(label3);
        textField3 = new JTextField();
        jp4.add(textField3);
        textField3.setColumns(4);
        panel.add(jp4);
    }

    // EFFECTS： Add five line and change the background color
    private void fiveLine() {
        JPanel jp6 = new JPanel();
        label6 = new JLabel(" ");
        label6.setForeground(Color.RED);
        jp6.add(label6);
        panel.add(label6);
    }

    //EFFECTS: Constructing a button
    private void button1() {
        JPanel jp5 = new JPanel();

        jp5.setBackground(Color.white);
        JButton button1 = new JButton("save");
        button1.setBounds(170, 44, 110, 27);
        button1.setActionCommand("save");
        button1.addActionListener(this);
        jp5.add(button1);
        panel.add(jp5);
    }


    // MODIFIES: this
    // EFFECTS: EFFECTS: Task task is added to the ToDoList
    public void addTask() {

        try {
            String content = textField.getText();
            String year = textField1.getText();
            String month = textField2.getText();
            String day = textField3.getText();
            int year2 = Integer.parseInt(year);
            int month2 = Integer.parseInt(month);
            int day2 = Integer.parseInt(day);
            task = new Task(content, year2, month2, day2);
            setVisible(false);
            //  new GuiMain().setVisible(true);

        } catch (NumberFormatException e) {
            label6.setText("                              Please enter a number for the date");
        }

    }

    // EFFECTS: return Task
    public static Task getTask() {
        return task;
    }

    //EFFECTS:  called when the the JButton btn is clicked
    @Override
    public void actionPerformed(ActionEvent e) {
        if (e.getActionCommand().equals("save")) {
            addTask();
            GuiMain.getToDoList().addTask(task);
            GuiMain.getInfo();
        }

    }
}
