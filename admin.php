<!DOCTYPE html>
<?php
	session_start();
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>System Administrator</title>
    <style type = "text/css">
      body {
        background-color: grey;
      }
      div.Title{
        font-family: Tahoma, Geneva, sans-serif;
        font-size: 3em;
        text-align: center;
        color: white;
        background-color: orange;
      }
      form.student-info{
        color: white;
      }
      div.form1-info{
        color: white;
        border: solid orange;
        width: 400px;
      }
      div.Transcript-info{
        color: white;
        border: solid orange;
          width: 400px;
      }
      form.signout{
        float: right;
        top: 100px;
      }
      form.search{
        float: left;
        top: 300px;
      }
      form.create{
        float: left;
        top: 100px;
      }
    </style>
  </head>
  <body>


  <form class="signout" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <input type="submit" name="signout" value="Sign out" formaction="homepage.php">
</form>

      <div class="Title">
        System Administratior
      </div>
<form>
    <input type="submit" value="Create Advisor/GS" formaction="create2.php">
    <input type="submit" value="Create Student" formaction="create.php">
    <input type="submit" value="Create Alumni" formaction="create1.php">
    <input type="submit" value="Requirements" formaction="req.php">
</form>

  <form class="search" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <input type="search" name="searchID">
    <input type="submit" value="Edit User" formaction="edit.php">
</form>
</br></br>

<p><strong>Current Advisors:</strong></p>
<?php
	$server = "localhost";
	$username = "markeilblow";
	$password = "Mercedes01123!!";
	$servername = "markeilblow";
$conn = mysqli_connect($server, $username, $password, $servername);
if($mysqli->connect_error)
{
   die("Connection failed: " . mysqli_connect_error());
}
	//PRINT EMPLOYEES WITH OPTION TO DELETE
    $query = "SELECT * FROM faculty WHERE adv = 'yes'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)){
      ?>
      <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="Transcript-info">
          <?php echo $row["f_id"] . " " . $row["fname"] . " " . $row["lname"]; ?>
          <input hidden type="text" name="fid" value="<?php echo $row["f_id"]; ?>">
          <input type="submit" name="delete1" value="Delete">
            </div>
	    </form>
<?php
    }?>
  <form class="adView" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <input type="search" name="searchID1">
    <input type="submit" value="Lens" formaction="Advisor.php">
</form>
</br></br></br>

<p><strong>Current Graduate Sercretary:</strong></p>
<?php
        //PRINT EMPLOYEES WITH OPTION TO DELETE
    $query = "SELECT * FROM faculty WHERE grad_sec = 'yes'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)){
      ?>
      <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="Transcript-info">
          <?php echo $row["f_id"] . " " . $row["fname"] . " " . $row["lname"]; ?>
          <input hidden type="text" name="fid" value="<?php echo $row["f_id"]; ?>">
          <input type="submit" name="delete1" value="Delete">
            </div>
            </form>
<?php
    }?>
  <form class="gradView" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <input type="search" name="searchID1">
    <input type="submit" value="Lens" formaction="GradSecretary.php">
</form>
</br></br></br>

<p><strong>Current Alumni:</strong></p>
<?php
             //alumni
    $query = "SELECT * FROM alumni";;
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)){
      ?>
      <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="Transcript-info">
          <?php echo $row["u_id"] . " " . $row["fname"] . " " . $row["lname"]; ?>
          <input hidden type="text" name="uid2" value="<?php echo $row["u_id"]; ?>">
          <input type="submit" name="delete2" value="Delete">
	  </br></br>
            </div>
            </form>
<?php
    }?>


</br></br></br>
<p><strong>Current Students:</strong></p>

<?php
      //students
    $query = "SELECT * FROM students";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)){
      ?>
      <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="Transcript-info">
          <?php echo $row["u_id"] . " " . $row["fname"] . " " . $row["lname"]; ?></br>
          <input hidden type="text" name="uid" value="<?php echo $row["u_id"]; ?>">
	  <input type="submit" name="form1" value="View Form1">
	  <input type="submit" name="Transcript" value="View Transcript">
<?php
          if ($row['program'] == 'phd'){
            ?>
            <input type="submit" name="Thesis" value="Approve Thesis"></br>
<?php
	  }
?>
          <input type="submit" name="delete3" value="Delete">
</br></br>
            </div>
            </form>
<?php
    }
?>

</br></br></br>

<?php
    if(isset($_POST['signout'])){
      session_unset();
      session_destroy();
      header("Location: homepage.php");
    }
    if(isset($_POST['deleteT']))
    {
                  $uid = $_POST['uid'];
      $query = "DELETE FROM student_courses WHERE u_id = '$uid'";
            $result - mysqli_query($conn, $query);
            if($result)
            {
                    echo $uid . "'s transcript was deleted.";
            }
            else
            {
                    echo "could not delete.";
            }
    }
    if(isset($_POST['delete1']))
    {
	    $uid = $_POST['fid'];
	    $query = "UPDATE students SET a_id = NULL WHERE a_id = '$uid'";
	    $result = mysqli_query($conn, $query);
            $query = "DELETE FROM faculty WHERE f_id = '$uid'";
            $result - mysqli_query($conn, $query);
            if($result)
            {
		    echo $uid . " was deleted.";
	    }
	    else
	    {
		    echo "could not delete.";
	    }
    }
    if(isset($_POST['delete2']))
    {
            $uid = $_POST['uid2'];
            $query = "DELETE FROM alumni WHERE u_id = '$uid'";
            $result - mysqli_query($conn, $query);
            if($result)
            {
                    echo $uid . " was deleted.";
            }
            else
            {
                    echo "could not delete.";
            }
    }
    if(isset($_POST['delete3']))
    {
            $uid = $_POST['uid'];
            $query = "DELETE FROM students WHERE u_id = '$uid'";
            $result - mysqli_query($conn, $query);
            if($result)
            {
                    echo $uid . " was deleted.";
            }
            else
            {
                    echo "could not delete.";
            }
    }
    if(isset($_POST['delete4']))
    {
            $uid = $_POST['uid'];
            $query = "DELETE FROM form1 WHERE u_id = '$uid'";
            $result - mysqli_query($conn, $query);
            if($result)
            {
                    echo $uid . " was deleted.";
            }
            else
            {
                    echo "could not delete.";
            }
    }
     if(isset($_POST['delete5']))
    {
            $uid = $_POST['uid'];
            $query = "DELETE FROM student_courses WHERE u_id = '$uid'";
            $result - mysqli_query($conn, $query);
            if($result)
            {
                    echo $uid . " was deleted.";
            }
            else
            {
                    echo "could not delete.";
            }
    }
    if(isset($_POST['form1'])){
      $uid = $_POST['uid'];
      $query = "SELECT * FROM form1 WHERE u_id = '$uid'";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($result)){
        ?>
        <br>
          <div class="form1-info">


        <?php
          echo "CRN: " . $row["crn"] . " Department:" . $row["dept"] . " SemYear:" . $row["semYear"] . "<br/>";
          ?>
            </div>
          <?php
      }
    }
    if(isset($_POST["Thesis"])){
      $query = "UPDATE thesis_status SET status = 'passed' WHERE u_id = '$uid'";
      $result = mysqli_query($conn, $query);
      echo "Thesis approved";
    }
    if(isset($_POST['Transcript'])){
      $uid = $_POST['uid'];
      $query = "SELECT * FROM student_courses WHERE u_id = '$uid'";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($result)){
        ?>
        <br>
        <div class="Transcript-info">

        <?php
          echo "Course: " . $row["title"] . " Department: " . $row["dept"] . " semYear: " . $row["semYear"] . " Credits: " . $row["credit"] . " Grade:" . $row["lettergrade"] . " Program:" . $row["program"] . "<br/>";
          ?>
            </div>
          <?php
      }
    }

 ?>



  </body>
</html>

