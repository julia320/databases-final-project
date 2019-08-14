<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Approve Student Advising Forms</title>
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
            $studUID = $_SESSION["studuid"];

            //Ensure user is logged in
            $loggedin = $_SESSION['loggedin'];
            if(!$loggedin) {
                header("Location: login.php");
                die();
            }

            //send to menu page if they don't have sufficient permissions
            if(!(in_array("adv", $_SESSION['types']) || in_array("admin", $_SESSION['types']))) {
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

            if(isset($_POST['accept'])) {
                $query = "delete from adv_form where uid=".$_SESSION['studuid'];
                $row = mysqli_fetch_assoc(mysqli_query($connection, $query));
                $query = "update user set hold='no' where uid=".$_SESSION['studuid'];
                $row = mysqli_fetch_assoc(mysqli_query($connection, $query));
                header("Location: viewAdvForm.php");
                die();
            } else if(isset($_POST['reject'])) {
                $query = "delete from adv_form where uid=".$_SESSION['studuid'];
                $row = mysqli_fetch_assoc(mysqli_query($connection, $query));
                header("Location: viewAdvForm.php");
                die();
            }

            $query = "select fname, lname from user where uid=".$_SESSION['studuid'];
            $row = mysqli_fetch_assoc(mysqli_query($connection, $query));
            $fname = $row['fname'];
            $lname = $row['lname'];
            echo "<h2>Advising Form for ".$fname." ".$lname."</h2>";
            echo "<hr>";

            //no search terms - select all courses from current year
            $query = "select * from course, user, adv_form where course.instructor=user.uid and adv_form.crn=course.crn and adv_form.uid=".$_SESSION['studuid']." order by dept, courseno";
            $result = mysqli_query($connection, $query);
            
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                //Display CRN, department, course number, name, credits, day, and time
                echo "<thead><tr><th>CRN</th><th>Dept</th><th>Number</th><th>Name</th><th>Credits</th><th>Day</th><th>Time</th><th>Prerequisite 1</th><th>Prerequisite 2</th><th>Instructor</th></tr></thead>";
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
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";

            } else {
                //If nothing came back from the query, there was a problem
                die("Bad query: ".$query);
            }

            //Approve or deny buttons
            echo '<br><br><div style="text-align: center;"><div style="display: inline-block;">';
            echo '<form method="post" action="approve-adv-form.php">';
            echo '<input type="submit" name="accept" value="APPROVE FORM" class="menu-button"> ';
            echo '<input type="submit" name="reject" value="DENY FORM" class="menu-button">';
            echo '</form></div></div>';

            //close sql connection
            mysqli_close($connection);
        ?>
	</body>
</html>
