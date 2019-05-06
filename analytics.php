<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Course Analytics</title>
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
        <form class="menu-button" action="menu.php" method="post">
            <input type="submit" value="Menu" formaction="menu.php">
        </form>
        <h2>Examine Course Analytics</h2><hr>
        <div style="text-align: center;">
            <div style="display: inline-block;">
                <form method="post" action="analytics.php">
                    <input type="number" placeholder="Desired Support" required min="1" max="99" style="width: 250px;" name="support">
                    <input type="number" placeholder="Desired Confidence" required min="1" max="99" style="width: 250px;" name="confidence">
                    <br><br>
                    <input type="submit" name="timeToMine" value="Find Associations">
                </form>
            </div>
        </div>
        <?php
            session_start();
            //Ensure user is logged in
            $loggedin = $_SESSION['loggedin'];
            if(!$loggedin) {
                header("Location: login.php");
                die();
            }

            //send to menu page if they don't have sufficient permissions
            if(!(in_array("secr", $_SESSION['types']) || in_array("admin", $_SESSION['types']))) {
                header("Location: menu.php");
                die();
            }

            //connect to database
            $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

            //determine number of entries
            $getEntries = "select count(distinct uid) from transcript";
            $numEntries = mysqli_fetch_assoc(mysqli_query($connection, $getEntries))['count(distinct uid)'];

            //setup association array
            $getCRNS = "select count(distinct crn) from transcript";
            $arrDim = mysqli_fetch_assoc(mysqli_query($connection, $getCRNS))['count(distinct crn)'];
            $assoc_arr = array_fill(0, $arrDim, array_fill(0, $arrDim, 0));
            
            //map array indices
            $getCRNS = "select distinct crn from transcript";
            $CRNsResultSet = mysqli_query($connection, $getCRNS);
            $counter = 0;
            while($row = mysqli_fetch_assoc($CRNsResultSet)) {
                $arr_map[$row['crn']] = $counter;
                $counter++;
            }

            //get list of student IDs from table
            $getUIDS = "select distinct uid from transcript";
            $UIDsResult = mysqli_query($connection, $getUIDS);
            $UIDsInTranscript = [];
            while($row = mysqli_fetch_assoc($UIDsResult)) {
                $UIDsInTranscript[] = $row;
            }
            
            //Assemble list of courses that each student is taking
            $coursesList = [];
            for($i = 0; $i<$numEntries; $i++) {
                $getCourses = "select crn from transcript where uid=".$UIDsInTranscript[$i]['uid'];
                // echo $query."<br>";
                $coursesList[$i] = [];
                $courseSet = mysqli_query($connection, $getCourses);
                while($row = mysqli_fetch_assoc($courseSet)) {
                    $coursesList[$i][] = $row;
                }
            }

            //DEBUG ONLY - PRINT COURSE LIST
            // for($i = 0; $i<$numEntries; $i++) {
            //     echo "<b>".$UIDsInTranscript[$i]['uid'].": </b>";
            //     for($j = 0; $j<count($coursesList[$i]); $j++) {
            //         $q = "select name from course where crn=".$coursesList[$i][$j]['crn'];
            //         echo mysqli_fetch_assoc(mysqli_query($connection, $q))['name'].", ";
            //     }
            //     echo "<br>";
            // }

            //Populate association matrix
            for($i = 0; $i<$numEntries; $i++) {

                //This logic handles finding all combinations of courses within a single student
                //That is, everything except the middle diagonal
                $alreadyProcessed = array();
                foreach ($coursesList[$i] as $first) {
                    // Loop the array twice (as @Dagon mentioned)
                    foreach ($coursesList[$i] as $second) {
                        // Keep track of what you've already processed
                        $combination = array($first['crn'], $second['crn']);
                        // Sorting the numbers will ensure that 2 - 1 and 1 - 2 are the same
                        sort($combination);
                        // Ensure they aren't the same number and you haven't already processed them
                        if ($first === $second || in_array($combination, $alreadyProcessed)) {
                            continue;
                        }

                        //now first and second are the coordinates in the association matrix
                        $assoc_arr[$arr_map[$first['crn']]][$arr_map[$second['crn']]]++;
                        $assoc_arr[$arr_map[$second['crn']]][$arr_map[$first['crn']]]++;

                        // Add it to the list of what you've already processed
                        $alreadyProcessed[] = $combination;
                    }
                }

                //Populate the middle diagonal
                foreach ($coursesList[$i] as $justAnArr) {
                    $assoc_arr[$arr_map[$justAnArr['crn']]][$arr_map[$justAnArr['crn']]]++;
                }
            }
            $assoc_arr[0][0]--;

            //DEBUG: Print association matrix as an aligned rectangle rather than the PHP mess
            // header('Content-Type: text/plain');
            // echo "\n";
            // for($i=0; $i<$arrDim; $i++) {
            //     for($j=0; $j<$arrDim; $j++) {
            //         echo $assoc_arr[$i][$j];
            //         echo "\t";
            //     }
            //     echo "\n";
            // }

            //Time to do some data mining! Get parameters from user
            if(isset($_POST['timeToMine'])) {
                $support = $_POST['support']/100.0;
                $confidence = $_POST['confidence']/100.0;
                $foundNone = true;
                echo "<br><br>";
                echo "Analyzing course assocations with desired support of ".$_POST['support']."% and desired confidence of ".$_POST['confidence']."%:";
                echo "<ul>";
                $associations = [];
                $counter = 0;

                //loop through all associations
                for($i=0; $i<$arrDim; $i++) {
                    for($j=0; $j<$arrDim; $j++) {
                        //exclude middle diagonal - it doesn't correlate two things
                        if($i!=$j) {

                            //if support passes, check confidence
                            if($assoc_arr[$i][$j]/$numEntries >= $support) {

                                //if confidence passes, print association
                                if($assoc_arr[$i][$j]/$assoc_arr[$i][$i] >= $confidence) {
                                    $foundNone = false;
                                    $getAssocC1 = "select courseno, dept, name from course where crn=".array_search($i, $arr_map);
                                    $assocResC1 = mysqli_query($connection, $getAssocC1);
                                    $getAssocC2 = "select courseno, dept, name from course where crn=".array_search($j, $arr_map);
                                    $assocResC2 = mysqli_query($connection, $getAssocC2);
                                    echo "<li>";
                                    while($row = mysqli_fetch_assoc($assocResC1)) {
                                        echo $row['dept']." ".$row['courseno'].": ".$row['name'];
                                    }
                                    echo " ⇒ ";
                                    while($row = mysqli_fetch_assoc($assocResC2)) {
                                        echo $row['dept']." ".$row['courseno'].": ".$row['name'];
                                    }
                                    echo "</li>";
                                }
                            }
                        }
                    }
                }
                echo "</ul>";
                // echo $support;
                // echo $confidence;
                if($foundNone) {
                    echo "No associations were found with the specified confidence and support levels.";
                }
            }

            //close sql connection
            mysqli_close($connection);
        ?>
	</body>
</html>
