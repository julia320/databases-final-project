<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <title>Create New User</title>
</head>

<body>
    <?php

        session_start();
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //If they somehow got here without logging in, politely send them away
        if(!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        }

        //send to menu page if they don't have sufficient permissions
        if(!($_SESSION['type']=="admin")) {
            header("Location: menu.php");
            die();
        }

        $type = $_SESSION['type'];
        $role = "";
        if(!$type=="admin") {
            header("Location: login.php");
        } 
        //connect to database
        $servername = "localhost";
        $username = "SELECT_team_name"; 
        $password = "Password123!"; 
        $dbname = "SELECT_team_name";
        $connection = mysqli_connect($servername, $username, $password, $dbname);
        $query = "select usid from user;";	
        $result	= mysqli_query($connection, $query);

        //"back to menu" button
        echo "<div style=\"display: inline-block;\">";
        echo "<form action=\"menu.php\"><input type=\"submit\" value=\"Menu\"/></form></div>";

        // define variables and set to empty values
        $fnameErr = $lnameErr = $emailErr = $passwordErr = $typeErr = $uidErr = "";
        $uid = $fname = $lname = $email = $active = $type = $street = $city = $state = $zip = $phone = $submit = "";
        $accountSuccess = TRUE;
        $customUID = FALSE;
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["fname"])) {
                $fnameErr = "Please enter a first name!";
                $accountSuccess = FALSE;
            } else {
                $fname = test_input($_POST["fname"]);
            }

            if (empty($_POST["lname"])) {
                $lnameErr = "Please enter a last name!";
                $accountSuccess = FALSE;
            } else {
                $lname = test_input($_POST["lname"]);
            }

            if (empty($_POST["email"])) {
                $emailErr = "Please enter an email!";
                $accountSuccess = FALSE;
            } else {
                $email = test_input($_POST["email"]);
            }

            if (empty($_POST["street"])) {
                $streetErr = "Please enter a steet!";
                $accountSuccess = FALSE;
            } else {
                $street = test_input($_POST["street"]);
            }

            if (empty($_POST["city"])) {
                $cityErr = "Please enter a city!";
                $accountSuccess = FALSE;
            } else {
                $city = test_input($_POST["city"]);
            }

          
            if (empty($_POST["state"])) {
                $stateErr = "Please enter a state!";
                $accountSuccess = FALSE;
            } else {
                $state = test_input($_POST["state"]);
            }

          
            if (empty($_POST["zip"])) {
                $zipErr = "Please enter a zip code!";
                $accountSuccess = FALSE;
            } else {
                $zip = test_input($_POST["zip"]);
            }

          
            if (empty($_POST["phone"])) {
                $phoneErr = "Please enter a phone number!";
                $accountSuccess = FALSE;
            } else {
                $phone = test_input($_POST["phone"]);
            }

            if (empty($_POST["active"])) {
                $activeErr = "Indicate if the user is active!";
                $accountSuccess = FALSE;
            } else {
                $active = test_input($_POST["active"]);
            }


            if($accountSuccess) {
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['userid'] = $usid;
                $_SESSION['password'] = '123456';
                $query = "";
                if($customUID) {
                    $query = "insert into course (fname, lname, password, active, type, street, city, zip, phone, email, state, uid) values ('".$fname."','".$lname."','123456','".$active."','".$type."','".$street."','".$city."','".$zip."','".$phone."','".$email."','".$state."', ".$uid.")";	
                } else {
                    $query = "insert into course (fname, lname, password, active, type, street, city, zip, phone, email, state) values ('".$fname."','".$lname."','123456','".$active."','".$type."','".$street."','".$city."','".$zip."','".$phone."','".$email."','".$state."')";	
                }

                $result	= mysqli_query($connection, $query);
                header("Location: managecourses.php");
                die();
            }
            
        }
    ?>

    <h2 class="rubik">Create a new course:</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" class="source-sans">

        Title: <input type="text" name="name" value="<?php echo $name;?>">
        <span class="error">
            <?php echo "*".$nameErr;?></span>
        <br><br>

        Department: <input type="text" name="dept" value="<?php echo $dept;?>">
        <span class="error">
            <?php echo "*".$deptErr;?></span>
        <br><br>

        Number: <input type="number" name="courseno" value="<?php echo $courseno;?>">
        <span class="error">
            <?php echo "*".$coursenoErr;?></span>
        <br><br>

        Credits: <input type="number" name="credits" value="<?php echo $credits;?>">
                <span class="error">
            <?php echo "*".$creditsErr;?></span>

        <br><br>

        Time: <input type="text" name="tme" value="<?php echo $tme;?>">
                <span class="error">
            <?php echo "*".$tmeErr;?></span>

        <br><br>

        Instructor UID: <input type="number" name="instructor" value="<?php echo $instructor;?>">
                <span class="error">
            <?php echo "*".$instructorErr;?></span>

        <br><br>

        Room ID(optional): <input type="number" name="uid" value="<?php echo $uid;?>">
        <span class="error">
            <?php echo $uidErr;?></span>
        <br><br>

        Prereq 1 (optional): <input type="number" name="uid" value="<?php echo $uid;?>">
        <span class="error">
            <?php echo $uidErr;?></span>
        <br><br>


        Prereq 2 (optional): <input type="number" name="uid" value="<?php echo $uid;?>">
        <span class="error">
            <?php echo $uidErr;?></span>
        <br><br>


        <input type="submit" name="submit" value="Create new course!">

        

    </form>
</body>

</html>