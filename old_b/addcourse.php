<!DOCTYPE html>

<head>
    <title>Add a Course</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body style="text-align: center; font-size: 20px;">
    <div style="display: inline-block;">
    <br><br><br>
    <?php
        session_start();

        //connect to database
        $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        //If they somehow got here without logging in, politely send them away
        if (!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        }

        //get CRN of course
        $courseToAdd = $_POST['crn'];

        //global variable to hold whether a student is allowed to register
        $canAdd = true;

        //get student's current course list and check for schedule conflicts
        $query = "select crn from transcript where uid = " . $_SESSION['studuid'] . " and grade='IP'";
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result) > 0) {
            $conflicts = false;
            while ($row = mysqli_fetch_assoc($result)) {
                $crn1 = $row['crn'];
                $crn2 = $courseToAdd;
                //echo "CRN 1: ".$crn1."<br>";
                //echo "CRN 2: ".$crn2."<br>";

                //get the days for the two CRNs
                $getD1 = "select day from course where crn=" . $crn1;
                $getD2 = "select day from course where crn=" . $crn2;
                $D1 = mysqli_fetch_assoc(mysqli_query($connection, $getD1))['day'];
                $D2 = mysqli_fetch_assoc(mysqli_query($connection, $getD2))['day'];
                //echo $D1."<br>";
                //echo $D2."<br>";

                //if they're on different days, no problems
                if ($D1 != $D2) {
                    $conflicts = false;
                } else {
                    //get the times for the two CRNs
                    //this can't be null - error checking occurs on add-drop page
                    $getT1 = "select tme from course where crn=" . $crn1;
                    $getT2 = "select tme from course where crn=" . $crn2;
                    $T1 = mysqli_fetch_assoc(mysqli_query($connection, $getT1))['tme'];
                    $T2 = mysqli_fetch_assoc(mysqli_query($connection, $getT2))['tme'];

                    //extract substrings and cast to ints to get start and end times
                    $s1 = (int) substr($T1, 0, 4);
                    $s2 = (int) substr($T2, 0, 4);
                    $e1 = (int) substr($T1, 5, 4);
                    $e2 = (int) substr($T2, 5, 4);

                    //if there's overlap, return true. Otherwise, return false
                    if ($s1 >= $s2 && $s1 <= $e2) {
                        $conflicts = true;
                        break;
                    } else if ($e1 <= $e2 && $e1 >= $s2) {
                        $conflicts = true;
                        break;
                    } else {
                        $conflicts = false;
                    }
                }
            }

            //If there were conflicts, show an error message
            if ($conflicts) {
                echo "You have a scheduling conflict with the course you tried to add. Pick another.";
                echo "<br><br>";
                echo "<form action=\"add-drop.php\" class=\"menu-button\">";
                echo "<input type=\"submit\" value=\"Return to Add/Drop Page\"/>";
                echo "</form>";
		        $canAdd = false;
		        die();
            }
        }

        //check that student has met prerequisites
        $P1Err = "";
        $P2Err = "";
        $getPre1 = "select prereq1 from course where crn=" . $courseToAdd . " and prereq1 is not null";
        $getPre2 = "select prereq2 from course where crn=" . $courseToAdd . " and prereq2 is not null";
        $preRes1 = mysqli_query($connection, $getPre1);
        $preRes2 = mysqli_query($connection, $getPre2);
        //echo mysqli_error() . "<br>";
        //echo $preRes2 . "<br>";

        //there is a first prereq
        if (mysqli_num_rows($preRes1) > 0) {
            //echo "Found prereq1";
            $P1 = mysqli_fetch_assoc($preRes1)['prereq1'];
	        $P1Dept = substr($P1, 0, 4);
            $P1Num = substr($P1, 5, 4);
            $findIfP1isFulfilled = "select c.crn from course as c, transcript as t where c.crn = t.crn and uid = " . $_SESSION['studuid'] . " and c.dept = '" . $P1Dept . "' and c.courseno =" . $P1Num . " and not (t.grade = 'IP' or t.grade='F')";
            if (!(mysqli_num_rows(mysqli_query($connection, $findIfP1isFulfilled)) > 0)) {
                $canAdd = false;
                $P1Err = "You haven't fulfilled the first prerequisite: " . $P1Dept . " " . $P1Num . ".<br>";
            }
        }

        //there is a second prereq
        if (mysqli_num_rows($preRes2) > 0) {
            //echo "Found prereq2";
            $P2 = mysqli_fetch_assoc($preRes2)['prereq2'];
	        $P2Dept = substr($P2, 0, 4);
            $P2Num = substr($P2, 5, 4);
            $findIfP2isFulfilled = "select c.crn from course as c, transcript as t where c.crn = t.crn and uid = " . $_SESSION['studuid'] . " and c.dept = '" . $P2Dept . "' and c.courseno =" . $P2Num . " and not (t.grade = 'IP' or t.grade='F')";
            if (!(mysqli_num_rows(mysqli_query($connection, $findIfP2isFulfilled)) > 0)) {
                $canAdd = false;
                $P2Err = "You haven't fulfilled the second prerequisite: " . $P2Dept . " " . $P2Num . ".<br>";
            }
        }

        //check that student hasn't already taken the course
        $getCourseDept = 'select dept from course where crn='.$courseToAdd;
        $getCourseNum = 'select courseno from course where crn='.$courseToAdd;
        $courseDept = mysqli_fetch_assoc(mysqli_query($connection, $getCourseDept))['dept'];
        $courseNum = mysqli_fetch_assoc(mysqli_query($connection, $getCourseNum))['courseno'];
        $getAlreadyTaken = 'select t.crn from transcript t, course c where t.uid='.$_SESSION['studuid'].' and c.crn=t.crn and c.courseno='.$courseNum.' and c.dept="'.$courseDept.'" and not t.grade="F"';
        $wasItTaken = mysqli_query($connection, $getAlreadyTaken);
        // echo $getAlreadyTaken;
        // die();
        if (mysqli_num_rows($wasItTaken) > 0) {
            $alreadyTaken = "Sorry. Under current university policy, you can't take a course more than once if you passed.";
            $canAdd = false;
        }

        //not all prereqs were fulfilled
        if (!$canAdd) {
            //don't let user add course
            echo $P1Err;
            echo $P2Err;
            echo $alreadyTaken;
            echo "<br><br>";
            echo "<form action=\"add-drop.php\" class=\"menu-button\">";
            echo "<input type=\"submit\" value=\"Return to Add/Drop Page\"/>";
            echo "</form>";
        }

        //no errors - add course
        if($canAdd) {
            $addQuery = "insert into transcript (uid, grade, crn) values (" . $_SESSION['studuid'] . ",'IP'," . $courseToAdd . ")";
            $addResult = mysqli_query($connection, $addQuery);
            header("Location: add-drop.php");
            die();
        }

    ?>
    </div>
</body>

</html>
