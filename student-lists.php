<!DOCTYPE html>
<html lang="en">
    <head>
        <title>View Student Lists</title>
        <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
        <link rel = "stylesheet" type="text/css" href="style.css"/>
    </head>
	<body>
        <div style="display: inline-block;" class="menu-button">
            <form action="menu.php"><input type="submit" value="Menu"/></form>
        </div>

        <h2>Student Lists</h2>
        <hr>
        
        <?php
            session_start();

            //Ensure user is logged in
            $loggedin = $_SESSION['loggedin'];
            if(!$loggedin) {
                header("Location: login.php");
                die();
            }

            //send to menu page if they don't have sufficient permissions
            if(!(in_array("admin", $_SESSION['types']) || in_array("secr", $_SESSION['types']))) {
                header("Location: menu.php");
                die();
            }

            //connect to database
            $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

            echo '<form action="student-lists.php" method="post">';

            echo '<select name="program">';
            echo '<option value="" disabled selected>Select Program Type (degree)</option>';
            echo '<option value="PHD">PhD</option>';
            echo '<option value="MS">Masters</option>';
            echo '</select>';
            echo 'OR';
            echo '<select name="year">';
            echo '<option value="" disabled selected>Select Admit Year</option>';
            $query = "select distinct dated from academic_info where uid in (SELECT DISTINCT R.uid FROM app_review R, user U WHERE R.uid=U.uid AND (type='App' or type='MS' or type='PHD') AND status IN (6,7))";
            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="PHD">'.$row['dated'].'</option>';
            }
            echo '</select>';
            
            echo '<input type="submit" name="admitted" value="View ADMITTED Students"/>';
            echo '<input type="submit" name="current" value="View CURRENT Students"/>';
            echo '</form>';

            //no UID search
            if(empty($_POST["search"])) {
                $query = "select fname, lname, uid, email, active, hold from user where type='MS' or type='PHD' order by lname";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    //Display a table of all the students
                    echo "<thead><tr><th>First Name</th><th>Last Name</th><th>UID</th><th>Email</th><th>Active</th><th>Hold Status</th></tr></thead>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["fname"] . "</td>";
                        echo "<td>" . $row["lname"] . "</td>";
                        echo "<td>" . $row["uid"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["active"] . "</td>";
                        echo "<td>" . $row["hold"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                } else {
                    //If nothing came back from the query, there was a problem
                    die("Bad query: ".mysqli_error());
                }

            }

            //close sql connection
            mysqli_close($connection);
        ?>

	</body>
</html>