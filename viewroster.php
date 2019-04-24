<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Course Roster</title>
        <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
        <link rel = "stylesheet" type="text/css" href="style.css"/>
    </head>
	<body class="gray-bg">
        <?php
            session_start();
            $crn = $_POST['crn'];

            //Ensure user is logged in
            $loggedin = $_SESSION['loggedin'];
            if(!$loggedin) {
                header("Location: login.php");
                die();
            }

            //send to menu page if they don't have sufficient permissions
            if(!($_SESSION['type']=="secr" || $_SESSION['type']=="admin")) {
                header("Location: menu.php");
                die();
            }

            $search = $_POST['search'];

            //Connect to database
            $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
            if (!$connection) {
                die("Couldn't connect: ".mysqli_error());
            }         

            //"back to menu" button
            echo "<div style=\"display: inline-block;\" class=\"menu-button\">";
            echo "<form action=\"menu.php\"><input type=\"submit\" value=\"Menu\"/></form></div>";

            $query = "select dept, courseno, name from course where crn=".$crn;
            $result = mysqli_query($connection, $query);
            $courserow = mysqli_fetch_assoc($result);
            $dept = $courserow["dept"];
            $courseno = $courserow["courseno"];
            $coursename = $courserow["name"];
            echo "<h1>Course Roster for ".$dept." ".$courseno.": ".$coursename."</h1>";
            
            //Link to View Schedule
            echo "<div style=\"display: inline-block;\">";
            echo "<form action=\"view-rosters.php\"><input type=\"submit\" value=\"Back to Course Selection\"/></form></div>";

            $query = "select u.lname, u.fname, u.uid, u.email from user u, transcript t where t.uid=u.uid and t.grade='IP' and t.crn=".$crn." order by u.lname";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                //Display CRN, department, course number, name, credits, day, and time
                echo "<thead><tr><th>Last Name</th><th>First Name</th><th>UID</th><th>Email</th></tr></thead>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";

            } else {
                echo "<br><br><br>";
                echo "<div style=\"text-align: center;\" class=\"gray-text\">";
                echo "There are no students currently registered.</div>";
            }

            //close sql connection
            mysqli_close($connection);
        ?>
	</body>
</html>
