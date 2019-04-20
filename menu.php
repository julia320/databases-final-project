<!DOCTYPE html>

<head>
    <title>JARS Main Menu</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body class="gray-bg">
    <?php

        session_start();

        //connect to database
        $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

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
        } else if ($type == "App") {
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
        echo "<div class=\"main-menu\"><form action=\"logout.php\"><input type=\"submit\" value=\"Logout\"/></form></div>";

        //EDIT PROFILE (ADD/EDIT IF ADMIN)
        $editInfoPrompt = "";
        if ($type == "admin") {
            $editInfoPrompt = "Edit/Manage Profiles";
            $editInfoAction = "manageusers.php";
        } else if ($type == "MS" || $type == "PHD" || $type == "inst" || $type == "secr") {
            $editInfoPrompt = "Edit Profile";
            $editInfoAction = "edit-info-reg.php";
        } else {
            $nextItem = false;
        }
        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $editInfoAction . "\"><input type=\"submit\" value=\"" . $editInfoPrompt . "\"/></form></div>";
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
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $scheduleAction . "\"><input type=\"submit\" value=\"" . $schedulePrompt . "\"/></form></div>";
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
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $transAction . "\"><input type=\"submit\" value=\"" . $transPrompt . "\"/></form></div>";
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
        } else {
            $nextItem = false;
        } 

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $addAction . "\"><input type=\"submit\" value=\"" . $addPrompt . "\"/></form></div>";
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
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $editAction . "\"><input type=\"submit\" value=\"" . $editPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //ROSTERS
        $rostPrompt = "";
        $rostAction = "";
        if ($type == "admin" || $type == "secr") {
            $rostAction = "view-rosters.php";
            $rostPrompt = "View Course Rosters";
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $rostAction . "\"><input type=\"submit\" value=\"" . $rostPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //GRADUATION REQUIREMENTS
        $reqPrompt = "";
        $reqAction = "";
        if ($type == "admin") {
            $reqAction = "req.php";
            $reqPrompt = "View Graduation Requirements";
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $reqAction . "\"><input type=\"submit\" value=\"" . $reqPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //APPLICANT STATUS
        $statPrompt = "";
        $statAction = "home.php";
        if ($type == "admin" || $type == "secr") {
            $statPrompt = "View/Update Applicants' Status";
        } else if ($type == "rev" || $type == "cac" || $type == "App") {
            $statPrompt = "View Applicant Status";
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $statAction . "\"><input type=\"submit\" value=\"" . $statPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        echo "</div></div>";

    ?>
</body>

</html>
