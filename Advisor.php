<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Advisor Page</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body>
    <div style="display: inline-block;" class="menu-button">
        <form action="menu.php"><input type="submit" value="Menu"/></form>
    </div>

    <h2>Advisor Page</h2>
    <hr>

    <?php
    session_start();
    $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
    if($mysqli->connect_error) 
        die("Connection failed: " . mysqli_connect_error());

    //advisors uid
    $aid = $_SESSION['uid']; 

    if(empty($_SESSION['uid']))
        $aid = $_POST['searchID1'];
    else if($_SESSION['uid'] == 0)
        $aid = $_POST['searchID1'];


    // Advisor views students
    $query = "SELECT * FROM user WHERE advisor=".$aid." AND (type='PHD' OR type='MS')";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows == 0) 
      echo "<p>You do not have any advisees.</p>";

    while ($row = mysqli_fetch_assoc($result)) {
      ?><div class="student-info">
        <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            
            <?php echo $row["uid"] . " " . $row["fname"] . " " . $row["lname"]; ?>
            <input hidden type="text" name="uid" value="<?php echo $row['uid']; ?>">
            <input type="submit" name="form1" value="View Form1">
          <?php
            if ($row['program'] == 'PHD') {
                echo "<input type='submit' name='Thesis' value='Approve Thesis'>";
            }
          ?>

        <?php
            if ($row['hold'] == 'yes') {
                echo '<input type="submit" name="hold" value="View & Approve Advising Form">';
            }
          ?>
            
        </form>
        </div>
    <?php
    }// End: viewing studentsdsfa;dd


	// Advisor views alumni
	$aid = $_SESSION['uid']; //advisors uid
    $query = "SELECT * FROM user WHERE advisor=".$aid." AND type='alum')";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)){
    ?>
        <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <div class="student-info">
                <?php echo $row["uid"] . " " . $row["fname"] . " " . $row["lname"]; ?>
                <input hidden type="text" name="uid" value="<?php echo $row["uid"]; ?>">
                <input type="submit" name="form1" value="View Form1">
            </div>
        </form>


    <?php
    }// End: viewing alumni



    if(isset($_POST['form1'])){
        ?>
        <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <input type="submit" name="Back" value="Back">
        </form>
        <?php
        $uid = $_POST['uid'];
        $query = "SELECT u_id, form1.crn, dept, semester, year FROM form1, course WHERE u_id =".$uid." AND form1.crn=course.crn";
        $result = mysqli_query($conn, $query) or die ("Couldn't find course: ".mysql_error($conn));

        echo "<div class='form1-info'>";
        while ($row = mysqli_fetch_assoc($result)){
            echo "<br/>CRN: ".$row["form1.crn"]." Department: ".$row["dept"]." Semester: ".$row["semester"]." Year: ".$row['year']."<br/>";
        }
        echo "</div>";
    }

    if(isset($_POST['hold'])){
        header("Location: approve-adv-form.php");
        $_SESSION['studuid'] = $_POST['uid'];
        die();
    }
//}


    if(isset($_POST["Thesis"])){
        ?>
        <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <input type="submit" name="Back" value="Back">
        </form>

        <?php
        $query = "UPDATE thesis_status SET status = 'passed' WHERE u_id=".$uid;
        $result = mysqli_query($conn, $query);
        echo "Thesis approved";
    }


    if(isset($_POST['Transcript'])){
        $uid = $_POST['uid'];
        $query = "SELECT * FROM transcript, course WHERE uid=".$uid." AND course.crn=transcript.crn";
        $result = mysqli_query($conn, $query) or die ("Error fetching transcript: ".mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($result)){
            ?>
            <br>
            <div class="Transcript-info">

             <?php
             echo "Course: ".$row["name"]." Department: ".$row["dept"]." Semester: " . $row["semester"]." Year: ".$row['year']." Credits: ".$row["credits"]." Grade: ".$row["grade"]."<br/>";
             ?>
            </div>
         <?php
        }
    }
?>

</body>
</html>