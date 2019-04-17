<!DOCTYPE html>

<head>
    <title>JARS Main Menu</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
    <style>
        input[type=submit] {
            background-color: #76b852;
            border: none;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            margin: 4px 2px;
            width: 70%;
        }

        input[type=submit]:hover {
            background-color: #76b852;
            border: none;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
            width: 80%;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
    </style>
</head>

<body class="gray-bg">
    <?php

        session_start();

        //connect to database
        $servername = "localhost";
        $username = "SELECT_team_name";
        $password = "Password123!";
        $dbname = "SELECT_team_name";
        $connection = mysqli_connect($servername, $username, $password, $dbname);

        //If they somehow got here without logging in, politely send them away
        if (!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        }

        //determine what type of user is currently logged in
        $type = $_SESSION['type'];
        $role = "";
        if ($type == "admin") {
            $role = "Admin";
        } else if ($type == "MS") {
            $role = "Masters Student";
        } else if ($type == "PHD") {
            $role = "PhD Student";
        } else if ($type == "inst") {
            $role = "Instructor";
        } else if ($type == "secr") {
            $role = "Secretary";
        } else if ($type == "alum") {
            $role = "Alumni";
        } else if ($type == "adv") {
            $role = "Advisor";
        } else if ($type == "app") {
            $role = "Applicant";
        } else if ($type == "reg") {
            $role = "Registrar";
        } else if ($type == "cac") {
            $role = "CAC";
        } else if ($type == "rev") {
            $role = "Reviewer";
        } else {
            header("Location: login-regs.php");
            die();
        }
        echo "<div style=\"text-align: center;\"><div style=\"display: inline-block; width: 80%;\">";
        echo "Welcome, " . $_SESSION['fname'] . ". You are logged in with " . $role . " privileges.<br><br>";
        $nextItem = true;

        //LOGOUT
        echo "<div><form action=\"logout.php\"><input type=\"submit\" value=\"Logout\"/></form></div>";

        //EDIT PROFILE
        $editInfoPrompt = "";
        if ($type == "admin") {
            $editInfoPrompt = "Edit Profiles";
            $editInfoAction = "edit-info-admin.php";
        } else if ($type == "MS" || $type == "PHD" || $type == "inst" || $type = "secr") {
            $editInfoPrompt = "Edit Profile";
            $editInfoAction = "edit-info-reg.php";
        } else {
            $nextItem = false;
        }
        if ($nextItem) {
            echo "<div><form action=\"" . $editInfoAction . "\"><input type=\"submit\" value=\"" . $editInfoPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //VIEW SCHEDULE
        $schedulePrompt = "";
        if ($type == "admin") {
            $scheduleAction = "view-schedule-admin.php";
            $schedulePrompt = "View Schedules";
        } else if ($type == "MS" || $type == "PHD") {
            $scheduleAction = "view-schedule-reg.php";
            $schedulePrompt = "View My Schedule";
        } else if ($type == "inst") {
            $scheduleAction = "view-schedule-inst.php";
            $schedulePrompt = "View My Schedule";
        } else if ($type == "secr") {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div><form action=\"" . $scheduleAction . "\"><input type=\"submit\" value=\"" . $schedulePrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //TRANSCRIPTS
        $transPrompt = "";
        if ($type == "admin" || $type == "secr" || $type == "inst") {
            $transAction = "viewTransAdmin.php";
            $transPrompt = "View Transcripts";
        } else if ($type == "MS" || $type == "PHD") {
            $transAction = "viewtrans.php";
            $transPrompt = "View My Transcript";
            $_SESSION["studuid"] = $_SESSION["uid"];
        }

        if ($nextItem) {
            echo "<div><form action=\"" . $transAction . "\"><input type=\"submit\" value=\"" . $transPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //ADD/DROP
        $addPrompt = "";
        $addAction = "";
        if ($type == "admin") {
            $addAction = "add-drop-admin.php";
            $addPrompt = "Edit Student Schedules (Add/Drop)";
        } else if ($type == "MS" || $type == "PHD") {
            $activeQuery = "select active from user where uid=" . $_SESSION["uid"];
            $activeOrNot = mysqli_fetch_assoc(mysqli_query($connection, $activeQuery))["active"];
            if ($activeOrNot == "yes") {
                $addAction = "add-drop.php";
                $_SESSION["studuid"] = $_SESSION["uid"];
                $addPrompt = "Add/Drop Classes";
            } else {
                $nextItem = false;
                echo "To register for classes, you must be active. Contact a system admin to change your status.";
            }
        } else if ($type == "secr" || $type == "inst") {
            $nextItem = false;
        } else {
            die("Error with add/drop user type logic");
        }

        if ($nextItem) {
            echo "<div><form action=\"" . $addAction . "\"><input type=\"submit\" value=\"" . $addPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //EDIT GRADES
        $editPrompt = "";
        if ($type == "admin" || $type == "secr") {
            $editAction = "edit-grades-admin.php";
            $editPrompt = "Edit Grades";
        } else if ($type == "inst") {
            $editAction = "edit-grades-inst.php";
            $editPrompt = "Edit Grades";
        } else if ($type == "MS" || $type == "PHD") {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div><form action=\"" . $editAction . "\"><input type=\"submit\" value=\"" . $editPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //ROSTERS
        $rostPrompt = "";
        if ($type == "admin" || $type == "secr") {
            $rostAction = "view-rosters.php";
            $rostPrompt = "View Course Rosters";
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div><form action=\"" . $rostAction . "\"><input type=\"submit\" value=\"" . $rostPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //ADD NEW USERS
        if ($type == "admin") {
            echo "<div><form action=\"manageusers.php\"><input type=\"submit\" value=\"Manage Users\"/></form></div>";
        }

        echo "</div></div>";

    ?>
</body>

</html>
