<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit Student Schedules</title>
        <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
        <link rel = "stylesheet" type="text/css" href="style.css"/>
    </head>
	<body class="gray-bg">

        <div style="display: inline-block;" class="menu-button">
            <form action="menu.php"><input type="submit" value="Menu"/></form>
        </div>

        <form action="add-drop-admin.php" method="post">
            Enter student ID: <input type="text" name="uid">
            <input type="submit" name="search" value="Search"> <br>
        </form>
        <?php
            session_start();

            //Ensure user is logged in
            $loggedin = $_SESSION['loggedin'];
            if(!$loggedin) {
                header("Location: login.php");
                die();
            }

            //send to menu page if they don't have sufficient permissions
            if(!in_array("admin", $_SESSION['types'])) {
                header("Location: menu.php");
                die();
            }

            //Connect to database
            $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
            if (!$connection) {
                die("Couldn't connect: ".mysqli_error());
            }

            //no UID search
            if(empty($_POST["uid"])) {
                $query = "select fname, lname, uid, email, type from user where type = 'MS' or type = 'PHD'";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    //Display a table of all the students
                    echo "<thead><tr><th>First Name</th><th>Last Name</th><th>UID</th><th>Email</th><th>Student Type</th></tr></thead>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["fname"] . "</td>";
                        echo "<td>" . $row["lname"] . "</td>";
                        echo "<td>" . $row["uid"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["type"] . "</td>";
                        echo "<td>";
                        echo "<form action=\"set-studuid-add-drop.php\" method=\"post\">";
                        echo "<input type=\"hidden\" name=\"studuid\" value=\"" . $row["uid"] . "\">";
                        echo "<input type=\"submit\" value=\"Edit Student Schedule\"/>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                } else {
                    //If nothing came back from the query, there was a problem
                    die("Bad query: ".mysqli_error());
                }

            //A specific UID was searched
            } else {
                $query = "select fname, lname, uid, email, type from user where (type = 'MS' or type = 'PHD') and uid=".$_POST["uid"];
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    //Display a table of all the students
                    echo "<thead><tr><th>First Name</th><th>Last Name</th><th>UID</th><th>Email</th><th>Student Type</th></tr></thead>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["fname"] . "</td>";
                        echo "<td>" . $row["lname"] . "</td>";
                        echo "<td>" . $row["uid"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["type"] . "</td>";
                        echo "<td>";
                        echo "<form action=\"set-studuid-add-drop.php\" method=\"post\">";
                        echo "<input type=\"hidden\" name=\"studuid\" value=\"" . $row["uid"] . "\">";
                        echo "<input type=\"submit\" value=\"Edit Student Schedule\"/>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                } else {
                    echo "No students with that UID!";
                }
            }

            //close sql connection
            mysqli_close($connection);
        ?>
	</body>
</html>