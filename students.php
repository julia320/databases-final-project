<!DOCTYPE html>
<html>
  <head>
    <title> Students </title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
  </head>
  <body>
    <div style="display: inline-block;" class="menu-button">
      <form action="menu.php"><input type="submit" value="Menu"/></form>
    </div>
    <h3> List of students: </h3>
    <hr>
    <!--
    <form action="edit-grades-admin.php" method="post">
      Select course: <input type="text" name="uid">
      <input type="submit" name="search" value="Search"> <br>
    </form>
  -->
      <?php
        session_start();
        // // Send to login page if user is not logged in
        // if(!$_SESSION['loggedin']) {
        //     header("Location: login.php");
        //     die();
        // }

        // Connect to database
        $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        // Check connection
        if(!$conn){
          die("Connection failed: " . mysqli_connect_error());
        }

        $query = "select U.fname, U.lname, U.uid FROM user U, transcript T, course C where C.crn='".$_POST["crn"]."' AND C.crn=T.crn AND T.uid=U.uid AND T.grade='IP';";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result)>0){

          while ($row = mysqli_fetch_assoc($result)) {

            echo '<form action="students-grades-update.php" method="post">';
            echo $row['fname'].' '.$row['lname'];
            echo '<input type="text" name="grade">';
            echo '<input type="hidden" name="uid" value='.$row['uid'].">";
            echo '<input type="hidden" name="crn" value='.$_POST["crn"].">";
            echo '<input type="submit" name="submit" value="Submit">';
            echo '<br>';
            echo '</form>';

          }
        }
        else{
          echo "No student grades available for edit.";
        }

      ?>

  </body>
</html>
