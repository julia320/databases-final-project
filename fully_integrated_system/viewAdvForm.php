<!DOCTYPE html>
<html>
  <head>
    <title> View Student Advising Forms </title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
  </head>
  <body>
    <div style="display: inline-block;" class="menu-button">
      <form action="menu.php"><input type="submit" value="Menu"/></form>
    </div>
    <h3> Search for Student Advising Forms </h3>
    <hr>
    <form action="viewForm1.php" method="post">
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

            //Connect to database
            $servername = "localhost";
            $username = "ARGv";
            $password = "CSCI2541_sp19";
            $dbname = "ARGv";
            $connection = mysqli_connect($servername, $username, $password, $dbname);
            if (!$connection) {
                die("Couldn't connect: ".mysqli_error());
            }

            //student clicked - set studuid and redirect
            if(isset($_POST['submitted'])) {
                $_SESSION['studuid'] = $_POST['studuid'];
                header("Location: approve-adv-form.php");
                die();
            }

            $uid = $_SESSION["uid"];

            //no UID search
            if(empty($_POST["uid"])) {
                $query = "select distinct fname, lname, uid, email, type from user where advisor =".$_SESSION['uid']." and uid in (select uid from adv_form)";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) 
                {
                    echo "<table>";
                    //Display a table of all the students
                    echo "<thead><tr><th>First Name</th><th>Last Name</th><th>UID</th><th>Email</th><th>Student Type</th></tr></thead>";
                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        echo "<tr>";
                        echo "<td>" . $row["fname"] . "</td>";
                        echo "<td>" . $row["lname"] . "</td>";
                        echo "<td>" . $row["uid"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["type"] . "</td>";
                        echo "<td>";
                        echo "<form action=\"viewAdvForm.php\" method=\"post\">";
                        echo "<input type=\"hidden\" name=\"studuid\" value=\"" . $row["uid"] . "\">";
                        echo "<input type=\"submit\" value=\"View Student Advising Form\" name=\"submitted\"/>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                } 
                else {
                    //If nothing came back from the query, there was a problem
                    die("None of your students have pending Advising Forms.");
                }

            //A specific UID was searched
            } else {
                $query = "select distinct fname, lname, uid, email, type from user where advisor =".$_SESSION['uid']." and uid=".$_POST['uid']." and uid in (select uid from adv_form)";
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
                        //echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["type"] . "</td>";
                        echo "<td>";
                        echo "<form action=\"viewAdvForm.php\" method=\"post\">";
                        echo "<input type=\"hidden\" name=\"studuid\" value=\"" . $row["uid"] . "\">";
                        echo "<input type=\"submit\" value=\"View Student Advising Form\" name=\"submitted\"/>";
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
