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
    <h3> Update Grade </h3>
    <hr>
    <!--
    <form action="edit-grades-admin.php" method="post">
      Select course: <input type="text" name="uid">
      <input type="submit" name="search" value="Search"> <br>
    </form>
  -->
      <?php

        // Connect to database
        $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        // Check connection
        if(!$conn){
          die("Connection failed: " . mysqli_connect_error());
        }

        if($_POST["grade"]=='A' || $_POST["grade"]=='A-' || $_POST["grade"]=='B+' || $_POST["grade"]=='B' || $_POST["grade"]=='B-' || $_POST["grade"]=='C+' || $_POST["grade"]=='C' || $_POST["grade"]=='F') {
          // update grade
          $gradeQuery = "update transcript SET grade='".$_POST[grade]."' where uid='".$_POST[uid]."' AND crn='".$_POST[crn]."'";
          $gradeResult = mysqli_query($conn, $gradeQuery);

          header("Location: edit-grades-inst.php");
          die();
        } else {
          echo "Please enter a valid grade!";
          echo '<br><br>';
          echo '<form action="edit-grades-inst.php"><input type="submit" value="View Profile">';
          echo "</form>";
        }


      ?>

  </body>
</html>
