<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <title>Create New User</title>
    <link rel = "stylesheet" type="text/css" href="style.css"/>
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
        if(!in_array("admin", $_SESSION['types'])) {
            header("Location: menu.php");
            die();
        }
        
        //connect to database
        $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        //"back to menu" button
        echo "<div style=\"display: inline-block;\" class=\"menu-button\">";
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
            if (empty($_POST["type"])) {
                $typeErr = "What type of user are you creating?";
                $accountSuccess = FALSE;
            } else {
                $type = test_input($_POST["type"]);
            }

            if (empty($_POST["uid"])) {
                $customUID = FALSE;
            } else {
                $uid = test_input($_POST["uid"]);
                $doesUIDexist = "select * from user where uid = ".$uid;
                $result	= mysqli_query($connection, $doesUIDexist);
                if (mysqli_num_rows($result) > 0) {
                    $uidErr = "UID is already taken. Try again.";
                    $accountSuccess = FALSE;
                } else {
                    $customUID = TRUE;
                }
            }


            if($accountSuccess) {
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['userid'] = $usid;
                $_SESSION['password'] = '123456';
                $query = "";
                if($customUID) {
                    $query = "insert into user (fname, lname, password, active, type, street, city, state, zip, phone, email, uid) values ('".$fname."','".$lname."','123456','".$active."','".$type."','".$street."','".$city."','".$state."','".$zip."','".$phone."','".$email."',".$uid.")";	
                } else {
                    $query = "insert into user (fname, lname, password, active, type, street, city, state, zip, phone, email) values ('".$fname."','".$lname."','123456','".$active."','".$type."','".$street."','".$city."','".$state."','".$zip."','".$phone."','".$email."')";	
                }

                $result	= mysqli_query($connection, $query);
                header("Location: manageusers.php");
                die();
            }
            
        }
    ?>

    <h2>Create a new user:</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

        First name: <input type="text" name="fname" value="<?php echo $fname;?>">
        <span class="error">
            <?php echo "*".$fnameErr;?></span>
        <br><br>
        Last name: <input type="text" name="lname" value="<?php echo $lname;?>">
        <span class="error">
            <?php echo "*".$lnameErr;?></span>
        <br><br>
        Email: <input type="text" name="email" value="<?php echo $email;?>">
        <span class="error">
            <?php echo "*".$emailErr;?></span>
        <br><br>
        Street: <input type="text" name="street" value="<?php echo $street;?>">
                <span class="error">
            <?php echo "*".$streetErr;?></span>

        <br><br>
        City: <input type="text" name="city" value="<?php echo $city;?>">
                <span class="error">
            <?php echo "*".$cityErr;?></span>

        <br><br>
        State: <input type="text" name="state" value="<?php echo $state;?>">
                <span class="error">
            <?php echo "*".$stateErr;?></span>

        <br><br>
        Zip Code: <input type="text" name="zip" value="<?php echo $zip;?>">
                <span class="error">
            <?php echo "*".$zipErr;?></span>

        <br><br>
        Phone: <input type="text" name="phone" value="<?php echo $phone;?>">
                <span class="error">
            <?php echo "*".$phoneErr;?></span>

        <br><br>
        Active: <input type="text" name="active" value="<?php echo $active;?>">
        <span class="error">
            <?php echo "*".$activeErr;?></span>
        <br><br>
        Type:
        <select name="type">
            <option value="admin">System Admin</option>
            <option value="secr">Grad Secratary</option>
            <option value="cac">Chair of Admissions Comm</option>
            <option value="rev">Faculty Reviewer</option>
            <option value="adv">Faculty Advisor</option>
            <option value="inst">Faculty Instructor</option>
            <option value="App">Applicant</option>
            <option value="MS">Masters Student</option>
            <option value="PHD">PhD Student</option>
            <option value="alum">Alum</option>
            <!-- <option value="reg">Registrar</option> -->
        </select>
        <br><br>
        Custom UID (optional): <input type="number" name="uid" value="<?php echo $uid;?>">
        <span class="error">
            <?php echo $uidErr;?></span>
        <br><br>

        <input type="submit" name="submit" value="Add new user!">

        

    </form>
</body>

</html>