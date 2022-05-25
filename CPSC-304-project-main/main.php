<!--Test Oracle file for UBC CPSC304 2018 Winter Term 1
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  This file shows the very basics of how to execute PHP commands
  on Oracle.
  Specifically, it will drop a table, create a table, insert values
  update values, and then query for values

  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the
  OCILogon below to be your ORACLE username and password -->

  <html>
    <head>
        <title>CPSC 304 Project/ Quarantine Sysytem</title>
        <link rel="stylesheet" href="style.php" media="screen">
    </head>
    <body>
        <embed src="BGM.mp3" loop="true" autostart="true" width="2" height="0"></embed>
        <h2 style="color:Black; font-family: sans-serif">Insert Quarantine People</h2>
        <form method="POST" action="main.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Name: <input type="text" name="insName"> <br /><br />
            Phone: <input type="text" name="insPhone"> <br /><br />
            ID: <input type="text" name="insID"> <br /><br />
            Vaccination Status: <input type="text" name="insStatus"> <br /><br />
            Check-in Time: <input type="text" name="insCheckInTime"> <br /><br />
            Check-out Time: <input type="text" name="insCheckOutTime"> <br /><br />
            Hotel Name: <input type="text" name="insHName"> <br /><br />
            Hotel Address: <input type="text" name="insHAddress"> <br /><br />

            <input type="submit" class= "button" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2 style="color:Black; font-family: sans-serif">Delete Quarantine People</h2>
        <form method="POST" action="main.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            ID: <input type="text" name="delID"> <br /><br />

            <input type="submit" class= "button" value="Delete" name="deleteSubmit"></p>
        </form>
        

        <hr />

        <h2 style="color:Black; font-family: sans-serif">Update Meal Price</h2>
        <p style="color:Black; font-family: sans-serif">The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="main.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            MealID: <input type="text" name="updateMID"> <br /><br />
            New Price: <input type="text" name="newPrice"> <br /><br />

            <input type="submit" class= "button" value="Update" name="updateSubmit"></p>
        </form>


        <hr />

        <h2 style="color:Black; font-family: sans-serif">Volunteer Age Filter</h2>
        <form method="GET" action="main.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectQueryRequest" name="selectQueryRequest">
            minAge: <input type="text" name="minAge"> <br /><br />
            maxAge: <input type="text" name="maxAge"> <br /><br />

            <input type="submit" class= "button" value="Filter" name="selectSubmit"></p>
        </form>

        <hr />

        <h2 style="color:Black; font-family: sans-serif">Quarantine People Info</h2>
        <form method="GET" action="main.php"> <!--refresh page when submitted-->
            <input type="hidden" id="projectQueryRequest" name="projectQueryRequest">
            <input type="checkbox" name="QID" id="QID">
                        <label for="QID">
                        ID
                        </label>
            <input type="checkbox" name="QName" id="QName">
                        <label for="QName">
                        Name
                        </label>
            <input type="checkbox" name="Phone" id="Phone">
                        <label for="Phone">
                        Phone
                        </label>
            <input type="checkbox" name="VStatus" id="VStatus">
                        <label for="VStatus">
                        Vaccination Status
                        </label><br /><br />

            <input type="submit" class= "button" value="Show" name="projectSubmit"></p>
        </form>

        <hr />

        <h2 style="color:Black; font-family: sans-serif">Volunteer Assigned</h2>
        <form method="GET" action="main.php"> <!--refresh page when submitted-->
        <p style="color:Black; font-family: sans-serif">Vaccination Status</p>
            <input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
            <select name="select">
                <option value="GreenStatus" selected="GreenStatus"> 1</option>
                <option value="YellowStatus" selected="YellowStatus"> 2</option>
                <option value="RedStatus" selected="RedStatus"> 3</option>
            </select>

            <input type="submit" class= "button" value="Show" name="joinSubmit"></p>
        </form>

        <hr />

        <h2 style="color:Black; font-family: sans-serif">Count The Number of Quarantine People</h2>
        <form method="GET" action="main.php"> <!--refresh page when submitted-->
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" class= "button" value="Count" name="countTuples"></p>
        </form>

        <hr />

        <h2 style="color:Black; font-family: sans-serif">Cheapest Mealtime</h2>
        <form method="GET" action="main.php"> <!--refresh page when submitted-->
        <p style="color:Black; font-family: sans-serif">Find the mealtime that the average price of meal is the minimum over all mealtimes</p>
            <input type="hidden" id="nestedQueryRequest" name="nestedQueryRequest">
            <input type="submit" class= "button" value="Find" name="nestedSubmit"></p>
        </form>

        <hr />

        <h2 style="color:Black; font-family: sans-serif">Find People Who Order In All Mealtime</h2>
        <form method="GET" action="main.php"> <!--refresh page when submitted-->
            <input type="hidden" id="divideQueryRequest" name="divideQueryRequest">
            <input type="submit" class= "button" value="Find" name="divideSubmit"></p>
        </form>

        


        <?php
        //this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message)
        {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr)
        { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

            return $statement;
        }

        function executeBoundSQL($cmdstr, $list)
        {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
            In this case you don't need to create the statement several times. Bound variables cause a statement to only be
            parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
            See the sample code below for how this function is used */

            global $db_conn, $success;
            $statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
                }

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printinsertResult($result)
        {
            echo "<table>";
            echo "<tr><th>ID</th><th>QName</th><th>Phone</th><th>VaccinationStatus</th><th>Check_inTime</th><th>Check_outTime</th><th>HName</th></th><th>HAddress</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td><td>" . $row[6] . "</td><td>" . $row[7] . "</td></tr>"; 
            }

            echo "</table>";

        }

        function printdeleteResult($result)
        {
            echo "<table>";
            echo "<tr><th>ID</th><th>QName</th><th>Phone</th><th>VaccinationStatus</th><th>Check_inTime</th><th>Check_outTime</th><th>HName</th></th><th>HAddress</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td><td>" . $row[6] . "</td><td>" . $row[7] . "</td></tr>"; 
            }

            echo "</table>";
        }
        function printupdateResult($result)
        { 
            echo "Update successful!";
            echo "<table>"; 
            echo "<tr><th>MealID</th><th>Price</th><th>Mealtime</th><th>ID</th><th>RName</th><th>RAddress</th><</tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function printselectionResult($result)
        {
            echo "<table>";
            echo "<tr><th>VolunteerID</th><th>Age</th><th>VName</th><th>RecordID</th><th>HName</th><th>HAddress</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }


        function printprojectionResultID($result)
        {
            echo "<table>";
            echo "<tr><th>ID</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function printprojectionResultQN($result)
        {
            echo "<table>";
            echo "<tr><th>QName</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function printprojectionResultP($result)
    {
        echo "<table>";
        echo "<tr><th>Phone</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultS($result)
    {
        echo "<table>";
        echo "<tr><th>VaccinationStatus</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultIN($result)
    {
        echo "<table>";
        echo "<tr><th>ID</th><th>QName</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultIP($result)
    {
        echo "<table>";
        echo "<tr><th>ID</th><th>Phone</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultIS($result)
    {
        echo "<table>";
        echo "<tr><th>ID</th><th>VaccinationStatus</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultNP($result)
    {
        echo "<table>";
        echo "<tr><th>QName</th><th>Phone</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultNS($result)
    {
        echo "<table>";
        echo "<tr><th>QName</th><th>VaccinationStatus</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultPS($result)
    {
        echo "<table>";
        echo "<tr><th>Phone</th><th>VaccinationStatus</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultINP($result)
    {
        echo "<table>";
        echo "<tr><th>ID</th><th>QName</th><th>Phone</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultINS($result)
    {
        echo "<table>";
        echo "<tr><th>ID</th><th>QName</th><th>VaccinationStatus</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultIPS($result)
    {
        echo "<table>";
        echo "<tr><th>ID</th><th>Phone</th><th>VaccinationStatus</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultNPS($result)
    {
        echo "<table>";
        echo "<tr><th>QName</th><th>Phone</th><th>VaccinationStatus</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printprojectionResultAll($result)
    {
        echo "<table>";
        echo "<tr><th>ID</th><th>QName</th><th>Phone</th><th>VaccinationStatus</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printJoinResult($result)
    {
        echo "<table>";
        echo "<tr><th>ID</th><th>QName</th><th>Phone</th><th>VaccinationStatus</th><th>Check_inTime</th><th>Check_outTime</th><th>HAddress</th><th>HName</th><th>VolunteerID</th></tr>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td><td>" . $row[6] . "</td><td>" . $row[7] . "</td><td>" . $row[8] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";

    }

    function printNestedResult($result)
    {
        echo "<table>";
        echo "<tr><th>Mealtime</th><th>Averageprice</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";

    }

    function printDivideResult($result)
    {
        echo "<table>";
        echo "<tr><th>Qname</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }


    function connectToDB()
    {
        global $db_conn;

        // Your username is ora_(CWL_ID) and the password is a(student number). For example,
        // ora_platypus is the username and a12345678 is the password.
        $db_conn = OCILogon("ora_caimq125", "a59000448", "dbhost.students.cs.ubc.ca:1522/stu");

        if ($db_conn) {
            debugAlertMessage("Database is Connected");
            return true;
        } else {
            debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }
    function disconnectFromDB()
    {
        global $db_conn;

        debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }

    function handleUpdateRequest()
    {
        global $db_conn;
        $updateMID = $_POST['updateMID'];
        $old_price = $_POST['oldPrice'];
        $new_price = $_POST['newPrice'];

        // you need the wrap the old name and new name values with single quotations
        executePlainSQL("UPDATE MOP SET Price='" . $new_price . "' WHERE MealID='" . $updateMID . "'");
        $result =executePlainSQL("SELECT * FROM MOP WHERE MealID='" . $updateMID . "'");
        printupdateResult($result);

        OCICommit($db_conn);
    }

    function handleResetRequest()
    {
        global $db_conn;
        // Drop old table
        executePlainSQL("DROP TABLE QQ");

        // Create new table
        echo "<br> creating new table <br>";
        executePlainSQL("CREATE TABLE QQ (id int PRIMARY KEY, name char(30))");
        OCICommit($db_conn);
    }

    function handleInsertRequest()
    {
        global $db_conn;

        //Getting the values from user and insert data into the table
        $tuple = array(
            ":bind1" => $_POST['insID'],
            ":bind2" => $_POST['insName'],
            ":bind3" => $_POST['insPhone'],
            ":bind4" => $_POST['insStatus'],
            ":bind5" => $_POST['insCheckInTime'],
            ":bind6" => $_POST['insCheckOutTime'],
            ":bind7" => $_POST['insHName'],
            ":bind8" => $_POST['insHAddress'],


        );

        $alltuples = array(
            $tuple
        );

        executeBoundSQL("INSERT INTO QQ VALUES (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7, :bind8)", $alltuples);
        $result = executePlainSQL("SELECT * FROM QQ");
        printinsertResult($result);
        OCICommit($db_conn);
    }

    function handleDeleteRequest()
    {
        global $db_conn;
        $id_to_delete = $_POST['delID'];
        executePlainSQL("DELETE FROM QQ WHERE ID ='" . $id_to_delete . "'");
        $result = executePlainSQL("SELECT * FROM QQ");
        printdeleteResult($result);

        OCICommit($db_conn);
    }


    function  handleSelectRequest()
    {
        global $db_conn;
        $minAge = $_GET['minAge'];
        $maxAge = $_GET['maxAge'];
        $result = executePlainSQL("SELECT * FROM VAW WHERE Age >'" . $minAge . "' AND Age <'" . $maxAge . "'");
        printselectionResult($result );

        OCICommit($db_conn);
    }

    function handleCountRequest()
    {
        global $db_conn;

        $result = executePlainSQL("SELECT Count(*) FROM QQ");

        if (($row = oci_fetch_row($result)) != false) {
            echo "<br> The number of tuples in QQ: " . $row[0] . "<br>";
        }
    }

    function handleProjectRequest()
    {
        global $db_conn;
        $QID = $_GET['QID'];
        $QName = $_GET['QName'];
        $Phone = $_GET['Phone'];
        $VStatus = $_GET['VStatus'];

        if ($QID == "on" && $QName == "" && $Phone == "" && $VStatus == "")
        {
            $result = executePlainSQL("SELECT ID FROM QQ");
            printprojectionResultID($result);
        }
        if ($QID == "" && $QName == "on" && $Phone == "" && $VStatus == "")
        {
            $result = executePlainSQL("SELECT QName FROM QQ");
            printprojectionResultQN($result);
        }
        if ($QID == "" && $QName == "" && $Phone == "on" && $VStatus == "")
        {
            $result = executePlainSQL("SELECT Phone FROM QQ");
            printprojectionResultP($result);
        }
        if ($QID == "" && $QName == "" && $Phone == "" && $VStatus == "on")
        {
            $result = executePlainSQL("SELECT VaccinationStatus FROM QQ");
            printprojectionResultS($result);
        }
        if ($QID == "on" && $QName == "on" && $Phone == "" && $VStatus == "")
        {
            $result = executePlainSQL("SELECT ID, QName FROM QQ");
            printprojectionResultIN($result);
        }
        if ($QID == "on" && $QName == "" && $Phone == "on" && $VStatus == "")
        {
            $result = executePlainSQL("SELECT ID, Phone FROM QQ");
            printprojectionResultIP($result);
        }
        if ($QID == "on" && $QName == "" && $Phone == "" && $VStatus == "on")
        {
            $result = executePlainSQL("SELECT ID, VaccinationStatus FROM QQ");
            printprojectionResultIS($result);
        }
        if ($QID == "" && $QName == "on" && $Phone == "on" && $VStatus == "")
        {
            $result = executePlainSQL("SELECT QName, Phone FROM QQ");
            printprojectionResultNP($result);
        }
        if ($QID == "" && $QName == "on" && $Phone == "" && $VStatus == "on")
        {
            $result = executePlainSQL("SELECT QName, VaccinationStatus FROM QQ");
            printprojectionResultNS($result);
        }
        if ($QID == "" && $QName == "" && $Phone == "on" && $VStatus == "on")
        {
            $result = executePlainSQL("SELECT Phone, VaccinationStatus FROM QQ");
            printprojectionResultPS($result);
        }
        if ($QID == "on" && $QName == "on" && $Phone == "on" && $VStatus == "")
        {
            $result = executePlainSQL("SELECT ID, QName, Phone FROM QQ");
            printprojectionResultINP($result);
        }
        if ($QID == "on" && $QName == "on" && $Phone == "" && $VStatus == "on")
        {
            $result = executePlainSQL("SELECT ID, QName, VaccinationStatus FROM QQ");
            printprojectionResultINS($result);
        }
        if ($QID == "on" && $QName == "" && $Phone == "on" && $VStatus == "on")
        {
            $result = executePlainSQL("SELECT ID, Phone, VaccinationStatus FROM QQ");
            printprojectionResultIPS($result);
        }
        if ($QID == "" && $QName == "on" && $Phone == "on" && $VStatus == "on")
        {
            $result = executePlainSQL("SELECT QName, Phone, VaccinationStatus FROM QQ");
            printprojectionResultNPS($result);
        }
        if ($QID == "on" && $QName == "on" && $Phone == "on" && $VStatus == "on")
        {
            $result = executePlainSQL("SELECT ID, QName, Phone, VaccinationStatus FROM QQ");
            printprojectionResultAll($result);
        }
    }


    function handleJoinRequest()
    {
        global $db_conn;

        $choice = $_GET['select'];
        if ($choice == "GreenStatus") {
            $result = executePlainSQL("SELECT qp.ID, qp.QName, qp.Phone, qp.VaccinationStatus, qp.Check_inTime, qp.Check_outTime, qp.HAddress, qp.HName, a.VolunteerID
            FROM QQ qp, Assist a WHERE qp.ID = a.ID AND qp.VaccinationStatus = 1");
            printJoinResult($result);

        }
        if ($choice == "YellowStatus") {
            $result = executePlainSQL("SELECT qp.ID, qp.QName, qp.Phone, qp.VaccinationStatus, qp.Check_inTime, qp.Check_outTime, qp.HAddress, qp.HName, a.VolunteerID
            FROM QQ qp, Assist a WHERE qp.ID = a.ID AND qp.VaccinationStatus = 2");
            printJoinResult($result);
        }
        if ($choice == "RedStatus") {
            $result = executePlainSQL("SELECT qp.ID, qp.QName, qp.Phone, qp.VaccinationStatus, qp.Check_inTime, qp.Check_outTime, qp.HAddress, qp.HName, a.VolunteerID
            FROM QQ qp, Assist a WHERE  qp.ID = a.ID AND qp.VaccinationStatus = 3");
            printJoinResult($result);
        }
        
        

        OCICommit($db_conn);
    }

    function handleNestedRequest()
    {
        global $db_conn;

        // $result = executePlainSQL("SELECT Temp.Mealtime, Temp.avgprice FROM (SELECT M.Mealtime, AVG(M.Price) avgprice
        // FROM MOP M GROUP BY M.Mealtime) AS Temp WHERE Temp.avgprice =(SELECT MIN(Temp.avgprice) FROM Temp)");
        $result = executePlainSQL("SELECT M.Mealtime, AVG(M.Price)
        FROM MOP M GROUP BY M.Mealtime Having AVG(M.Price) <= ALL(SELECT AVG(M2.Price) FROM MOP M2 GROUP BY M2.Mealtime)");
//Find the mealtime that the average price of meal is the minimum over all mealtimes
        printNestedResult($result);
        
    }

    function handleDivideRequest()
    {
        global $db_conn;

        $result = executePlainSQL("SELECT Q.Qname FROM QQ Q WHERE NOT EXISTS (SELECT DISTINCT M.Mealtime FROM MOP M WHERE NOT EXISTS (SELECT M2.Mealtime FROM MOP M2 WHERE M2.Mealtime =  M.Mealtime AND M2.ID = Q.ID))");

        printDivideResult($result);

        //Find People Who Order In All Mealtime

    }



    // HANDLE ALL POST ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handlePOSTRequest()
    {
        if (connectToDB()) {
            if (array_key_exists('resetTablesRequest', $_POST)) {
                handleResetRequest();
            } else if (array_key_exists('updateQueryRequest', $_POST)) {
                handleUpdateRequest();
            } else if (array_key_exists('insertQueryRequest', $_POST)) {
                handleInsertRequest();
            } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                
                handleDeleteRequest();
            } 

            disconnectFromDB();
        }
    }

    // HANDLE ALL GET ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest()
    {
        if (connectToDB()) {
            if (array_key_exists('countTuples', $_GET)) {
                handleCountRequest();
            } else if (array_key_exists('selectQueryRequest', $_GET)) {
                handleSelectRequest();
            } else if (array_key_exists('projectQueryRequest', $_GET)) {
                handleProjectRequest();
            } else if (array_key_exists('joinQueryRequest', $_GET)) {
                handleJoinRequest();
            } else if (array_key_exists('nestedSubmit', $_GET)) {
                handleNestedRequest();
            } else if (array_key_exists('divideSubmit', $_GET)) {
                handleDivideRequest();
            }

            disconnectFromDB();
        }
    }

    if (isset($_POST['deleteSubmit']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['reset'])) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest']) || isset($_GET['selectSubmit']) || isset($_GET['projectSubmit'])|| isset($_GET['joinSubmit']) 
    || isset($_GET['nestedQueryRequest']) || isset($_GET['divideQueryRequest'])) {
        handleGETRequest();
    }
    ?>
</body>

</html>