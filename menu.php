<!DOCTYPE html>

<head>
    <title>Main Menu</title>
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

        //determine the user types of the logged in user
        $type = $_SESSION['type'];
        $typeArray = explode(",", $type);
        $role = "";
        for($i=0; $i<count($typeArray); $i++) {
            if ($typeArray[$i] == "admin") {
                $role = $role."Admin";
            } else if ($typeArray[$i] == "MS") {
                $role = $role."Masters Student";
            } else if ($typeArray[$i] == "PHD") {
                $role = $role."PhD Student";
            } else if ($typeArray[$i] == "inst") {
                $role = $role."Instructor";
            } else if ($typeArray[$i] == "secr") {
                $role = $role."Secretary";
            } else if ($typeArray[$i] == "alum") {
                $role = $role."Alumni";
            } else if ($typeArray[$i] == "adv") {
                $role = $role."Advisor";
            } else if ($typeArray[$i] == "App") {
                $role = $role."Applicant";
            } else if ($typeArray[$i] == "reg") {
                $role = $role."Registrar";
            } else if ($typeArray[$i] == "cac") {
                $role = $role."CAC";
            } else if ($typeArray[$i] == "rev") {
                $role = $role."Reviewer";
            } else {
                echo "ERROR";
                die();
            }
            
            if($i!=(count($typeArray)-1)) {
                $role = $role.", ";
            }
        }
        $_SESSION['types'] = $typeArray;

        echo "<div style=\"text-align: center;\"><div style=\"display: inline-block; width: 80%;\">";
        echo "Welcome, " . $_SESSION['fname'] . ". You are logged in with " . $role . " privileges.<br><br>";
        $nextItem = true;

        //LOGOUT
        echo "<div class=\"logout\"><form action=\"logout.php\"><input type=\"submit\" value=\"Logout\"/></form></div>";

        //EDIT PROFILE (ADD/EDIT IF ADMIN)
        $editInfoPrompt = "";
        if (in_array("admin", $typeArray)) {
            $editInfoPrompt = "Edit/Manage Profiles";
            $editInfoAction = "manageusers.php";
        } else {
            $editInfoPrompt = "Edit Profile";
            $editInfoAction = "edit-info-reg.php";
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $editInfoAction . "\"><input type=\"submit\" value=\"" . $editInfoPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //VIEW SCHEDULE
        $schedulePrompt = "";
        if (in_array("admin", $typeArray)) {
            $scheduleAction = "view-schedule-admin.php";
            $schedulePrompt = "View Schedules";
        } else if (in_array("MS", $typeArray) || in_array("PHD", $typeArray)) {
            $scheduleAction = "view-schedule-reg.php";
            $schedulePrompt = "View My Schedule";
        } else if (in_array("inst", $typeArray)) {
            $scheduleAction = "view-schedule-inst.php";
            $schedulePrompt = "View My Schedule";
        } else if (in_array("secr", $typeArray)) {
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
        if (in_array("admin", $typeArray) || in_array("secr", $typeArray) || in_array("inst", $typeArray) || in_array("adv", $typeArray)) {
            $transAction = "viewTransAdmin.php";
            $transPrompt = "View Student Transcripts";
        } else if (in_array("MS", $typeArray) || in_array("PHD", $typeArray)) {
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
        if (in_array("admin", $typeArray)) {
            $addAction = "add-drop-admin.php";
            $addPrompt = "Edit Student Schedules (Add/Drop)";
        } else if (in_array("MS", $typeArray) || in_array("PHD", $typeArray)) {
            $activeQuery = "select active from user where uid=" . $_SESSION["uid"];
            $activeOrNot = mysqli_fetch_assoc(mysqli_query($connection, $activeQuery))["active"];
            $holdQuery = "select hold from user where uid=" . $_SESSION["uid"];
            $holdOrNot = mysqli_fetch_assoc(mysqli_query($connection, $holdQuery))["hold"];
            if ($activeOrNot == "yes" && $holdOrNot == "no") {
                $addAction = "add-drop.php";
                $_SESSION["studuid"] = $_SESSION["uid"];
                $addPrompt = "Add/Drop Classes";
            } else {
                $nextItem = false;
                if($activeOrNot == "no") {
                    echo "To register for classes, you must be active. Contact a system admin to change your status.";
                } else if($holdOrNot == "yes") {
                    echo "↓    Before you register, your advisor must approve your advising form    ↓";
                }
            }
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $addAction . "\"><input type=\"submit\" value=\"" . $addPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //ADVISING FORMS
        $advFormPrompt = "";
        $advFormAction = "";
        if (in_array("admin", $typeArray) || in_array("adv", $typeArray)) {
            $advFormAction = "approve-adv-form.php";
            $advFormPrompt = "Approve Student Advising Forms";
        } else if (in_array("MS", $typeArray) || in_array("PHD", $typeArray)) {
            $advFormQuery = "select hold from user where uid=" . $_SESSION["uid"];
            $holdOrNot = mysqli_fetch_assoc(mysqli_query($connection, $advFormQuery))["hold"];
            if ($holdOrNot == "yes") {
                $advFormQuery = "select * from adv_form where uid=" . $_SESSION["uid"];
                $awaitingApproval = mysqli_query($connection, $activeQuery);
                if(mysqli_num_rows($awaitingApproval) <= 0) {
                    $nextItem = true;
                    $advFormAction = "submit-adv-form.php";
                    $advFormPrompt = "Submit Advising Form";
                } else {
                    echo "<br>Your form has been submitted. Check back when you advisor approves it.<br>";
                    $nextItem = false;
                }
            } else {
                $nextItem = false;
            }
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $advFormAction . "\"><input type=\"submit\" value=\"" . $advFormPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //EDIT GRADES
        $editPrompt = "";
        if (in_array("admin", $typeArray) || in_array("secr", $typeArray)) {
            $editAction = "edit-grades-admin.php";
            $editPrompt = "Edit Grades";
        } else if (in_array("inst", $typeArray)) {
            $editAction = "edit-grades-inst.php";
            $editPrompt = "Edit Grades";
        } else if (in_array("MS", $typeArray) || in_array("PHD", $typeArray)) {
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
        if (in_array("admin", $typeArray) || in_array("secr",$typeArray)) {
            $rostAction = "view-rosters.php";
            $rostPrompt = "View Course Rosters";
        } else if (in_array("inst", $typeArray)) {
            $rostAction = "view-rosters-inst.php";
            $rostPrompt = "View My Rosters";
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
        if (in_array("admin", $typeArray)) {
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
        if (in_array("admin", $typeArray) || in_array("secr", $typeArray)) {
            $statPrompt = "View/Update Applicants' Status";
        } else if (in_array("rev", $typeArray) || in_array("cac", $typeArray)) {
            $statPrompt = "Review Applications";
        } else if (in_array("App", $typeArray)) {
            $statPrompt = "View Applicant Status";
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $statAction . "\"><input type=\"submit\" value=\"" . $statPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        // MATRICULATE STUDENTS
        if (in_array("admin", $typeArray) || in_array("secr", $typeArray)) {
            $matPrompt = "Matriculate Students";
            $matAction = "matriculate.php";
        }
        else
            $nextItem = false;

        if ($nextItem)
            echo "<div class=\"main-menu\"><form action=\"" . $matAction . "\"><input type=\"submit\" value=\"" . $matPrompt . "\"/></form></div>";
        else
            $nextItem = true;

        //ADVISING OPTIONS
        $advPrompt = "";
        $advAction = "Advisor.php";
        if (in_array("admin", $typeArray) || in_array("adv", $typeArray)) {
            $advPrompt = "View Advising Options";
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $advAction . "\"><input type=\"submit\" value=\"" . $advPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //DONATE
        $donPrompt = "";
        $donAction = "Alumni.php";
        if (in_array("admin", $typeArray) || in_array("alum", $typeArray)) {
            $donPrompt = "Donate";
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $donAction . "\"><input type=\"submit\" value=\"" . $donPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //ASSIGN ADVISORS
        $assignPrompt = "";
        $assignAction = "";
        if (in_array("secr", $typeArray)) {
            $assignAction = "assignAdvisor.php";
            $assignPrompt = "Assign Students Advisors";
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $assignAction . "\"><input type=\"submit\" value=\"" . $assignPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //FORM 1 FROM ADS
        $form1Prompt = "";
        $form1Action = "";
        if (in_array("MS", $typeArray) || in_array("PHD", $typeArray)) {
            $query = "SELECT * FROM form1 WHERE u_id = '".$_SESSION['uid']."'";
            $result = mysqli_query($conn, $query);
            //$result = $mysqli->query($query);
            if (mysqli_num_rows($result) == 0) {
                $form1Prompt = "Create Form 1";
                $form1Action = "form1.php";
            } else {
                $form1Prompt = "View Form 1";
                $form1Action = "viewform.php";
            }
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $form1Action . "\"><input type=\"submit\" value=\"" . $form1Prompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        //APPLY TO GRADUATE (ADS)
        $gradPrompt = "";
        $gradAction = "applytograd.php";
        if (in_array("MS", $typeArray) || in_array("PHD", $typeArray)) {
            $gradPrompt = "Apply to Graduate";
        } else {
            $nextItem = false;
        }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $gradAction . "\">";
            echo "<input type=\"submit\" value=\"" . $gradPrompt . "\"/>";
            echo "</form></div>";
        } else {
            $nextItem = true;
        }

        //COURSE CATALOG (ADS)
        $catPrompt = "View Course Catalog";
        $catAction = "catalog.php";
        // if (in_array( "MS" || in_array( "PHD") {
        //     $catPrompt = "Apply to Graduate";
        // } else {
        //     $nextItem = false;
        // }

        if ($nextItem) {
            echo "<div class=\"main-menu\"><form action=\"" . $catAction . "\"><input type=\"submit\" value=\"" . $catPrompt . "\"/></form></div>";
        } else {
            $nextItem = true;
        }

        echo "</div></div>";

    ?>
</body>

</html>
