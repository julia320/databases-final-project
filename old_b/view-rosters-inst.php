<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Select a Class</title>
        <style>
            input[type=text] {
                width: 70%;
                padding: 5px 15px;
                margin: 8px 0;
                border-radius: 10px;
                border: 1px solid;
            }
        </style>
        <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
        <link rel = "stylesheet" type="text/css" href="style.css"/>
    </head>
	<body class="gray-bg">
        <?php
            session_start();
            $_SESSION['redir'] = "view-rosters-inst.php";

            //Ensure user is logged in
            $loggedin = $_SESSION['loggedin'];
            if(!$loggedin) {
                header("Location: login.php");
                die();
            }

            //send to menu page if they don't have sufficient permissions
            if(!in_array("inst", $_SESSION['types'])) {
                header("Location: menu.php");
                die();
            }

            //Connect to database
            $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
            if (!$connection) {
                die("Couldn't connect: ".mysqli_error());
            }

            //"back to menu" button
            echo "<div style=\"display: inline-block;\" class=\"menu-button\">";
            echo "<form action=\"menu.php\"><input type=\"submit\" value=\"Menu\"/></form></div>";

            //no search terms - select all courses from current year
            $query = "select crn, dept, courseno, name, credits, day, tme, prereq1, prereq2 from course where semester = 'spring' and year = '2019' and tme is not null and instructor='".$_SESSION['uid']."' order by dept, courseno";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                //Display CRN, department, course number, name, credits, day, and time
                echo "<thead><tr><th>CRN</th><th>Dept</th><th>Number</th><th>Name</th><th>Credits</th><th>Day</th><th>Time</th><th>Prerequisite 1</th><th>Prerequisite 2</th></tr></thead>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["crn"] . "</td>";
                    echo "<td>" . $row["dept"] . "</td>";
                    echo "<td>" . $row["courseno"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["credits"] . "</td>";
                    echo "<td>" . $row["day"] . "</td>";
                    echo "<td>" . $row["tme"] . "</td>";
                    echo "<td>" . $row["prereq1"] . "</td>";
                    echo "<td>" . $row["prereq2"] . "</td>";
                    echo "<td>";
                    echo "<form action=\"viewroster.php\" method=\"post\">";
                    echo "<input type=\"hidden\" name=\"crn\" value=\"" . $row["crn"] . "\">";
                    echo "<input type=\"submit\" value=\"View Course Roster\"/>";
                    echo "</form>";
                    echo "</td>";

                    echo "</tr>";
                }
                echo "</table>";

            } else {
                //If nothing came back from the query, there was a problem
                echo "<div style=\"text-align: center;\" class=\"gray-text\">";
                echo "You aren't currently teaching any courses.</div>";
            }

            //close sql connection
            mysqli_close($connection);
        ?>
	</body>
</html>
