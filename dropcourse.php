<!DOCTYPE html>

<head>
    <title>Redirecting...</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body>
    <?php

        session_start();

        //connect to database
        $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        //"back to menu" button
        echo "<div style=\"display: inline-block;\">";
        echo "<form action=\"menu.php\"><input type=\"submit\" value=\"Menu\"/></form></div>";

        //If they somehow got here without logging in, politely send them away
        if(!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        } else {
            //get CRN of course to drop and update the table
            $courseToDrop = $_POST['crn'];
            $query = "delete from transcript where uid = '".$_SESSION['studuid']."' and crn = '".$courseToDrop."'";
            $result	= mysqli_query($connection, $query);

            //Redirect back to add/drop page
            header("Location: ".$_SESSION['redir']);
            die();
        }
        
    ?>
</body>

</html>