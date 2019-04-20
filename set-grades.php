<!DOCTYPE html>

<head>
    <title>Grades</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body>
  <div style="display: inline-block;" class="menu-button">
    <form action="menu.php"><input type="submit" value="Menu"/></form>
  </div>
  <h3> Edit Grades </h3>
  <hr>
    <?php
        session_start();

        if(!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        }
        //send to menu page if they don't have sufficient permissions
        if(!(($_SESSION['type']=="secr") || ($_SESSION['type']=="admin"))) {
          header("Location: menu.php");
          die();
        }

        // Connect to database
        $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        // Check connection
        if(!$conn){
          die("Connection failed: " . mysqli_connect_error());
        }

        // Query checks that student is active and pulls up courses in which the grade is IP
        $query = "select C.dept, C.courseno, C.name, T.grade, T.crn, T.uid FROM transcript T, course C, user U
        where T.uid='".$_POST["studuid"]."' AND T.crn=C.crn AND T.grade='IP' AND T.uid=U.uid AND U.active='yes';";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result)>0){
            // Verify that student associated with UID is active and query all courses in transcript associated with UID that has grade="IP
            while($row = mysqli_fetch_assoc($result)){
              echo '<form action="set-grades.php" method="post">';
              echo 'Course name: '.$row['name']."<br>";
              echo 'CRN: '.$row['crn']."<br>";
              echo '<input type="hidden" name="crn" value='.$row['crn'].'>';
              echo '<input type="hidden" name="hitUpdate" value="TRUE">';
              echo '<input type="hidden" name="savedUID" value='.$row['uid'].'>';
              echo 'Grade: <input type="text" name="grade" value='.$row['grade']."><br>";
              echo '<input type="submit" name="update" value="Update">';
              echo "</form>";
            }
        }
        else if(isset($_POST['update'])){
          if($_POST["grade"]=='A' || $_POST["grade"]=='A-' || $_POST["grade"]=='B+' || $_POST["grade"]=='B' || $_POST["grade"]=='B-' || $_POST["grade"]=='C+' || $_POST["grade"]=='C' || $_POST["grade"]=='F') {
            // If update button is hit, update transcript
            $updateQuery = "update transcript SET grade='".$_POST["grade"]."' where crn='".$_POST["crn"]."' AND uid='".$_POST["savedUID"]."';";
            $updateResult = mysqli_query($conn, $updateQuery);

            echo "Update successful";

            header("Location: edit-grades-admin.php");
          } else {
            echo "Please enter a valid grade!";
          }
        }
        else{
          echo "No available courses associated with student. <br>";

          echo '<form action=edit-grades-admin.php method=post>';
          echo "<input type=\"submit\" value=\"Back\"/>";
        }
    ?>
</body>

</html>
