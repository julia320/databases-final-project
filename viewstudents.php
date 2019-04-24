<!DOCTYPE html>
<html lang="en">
    <head>
        <title>View Students</title>
        <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
        <link rel = "stylesheet" type="text/css" href="style.css"/>
    </head>
	<body>
        <div style="display: inline-block;" class="menu-button">
            <form action="menu.php"><input type="submit" value="Menu"/></form>
        </div>
         <form action="viewstudents.php" method="post">
            Enter user ID: <input type="text" name="search">
            <input type="submit" value="Search"> <br>
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
            if(!($_SESSION['type']=="secr")) {
                header("Location: menu.php");
                die();
            }

            //connect to database
            $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

            //no UID search
            if(empty($_POST["search"])) {
                $query = "select fname, lname, uid, email, type, active from user WHERE type='MS' OR type='PHD' order by lname";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    //Display a table of all the students
                    echo "<thead><tr><th>First Name</th><th>Last Name</th><th>UID</th><th>Email</th><th> Type</th><th>Active</th></tr></thead>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["fname"] . "</td>";
                        echo "<td>" . $row["lname"] . "</td>";
                        echo "<td>" . $row["uid"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["type"] . "</td>";
                        echo "<td>" . $row["active"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                    }else {
                        //If nothing came back from the query, there was a problem
                        die("Bad query: ".mysqli_error($connection));
                    }

            //A specific UID was searched
            }else {
                $query = "select fname, lname, uid, email, type, active from user where uid=".$_POST["search"]." AND (type='MS' OR type='PHD') order by lname";

                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    //Display a table of all the students
                    echo "<thead><tr><th>First Name</th><th>Last Name</th><th>UID</th><th>Email</th><th> Type</th><th>Active</th></tr></thead>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["fname"] . "</td>";
                        echo "<td>" . $row["lname"] . "</td>";
                        echo "<td>" . $row["uid"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["type"] . "</td>";
                        echo "<td>" . $row["active"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                } else {
                    echo "No User with that UID!";
                }
            }
            //close sql connection
            mysqli_close($connection);
        ?>

	</body>
</html>