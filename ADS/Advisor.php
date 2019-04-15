<!DOCTYPE html>
<?php
	session_start();
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Advisor Page</title>
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

      form.back{
        float: right;
        top: 100px;
      }

    </style>
  </head>
  <body>
  <form class="signout" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <input type="submit" name="signout" value="Sign out">
</form>

      <div class="Title">
        Advisor Page
      </div>
  <?php

	$server = "localhost";
	$username = "visheshj123";
	$password = "Viswa123!";
	$servername = "visheshj123";
	$conn = mysqli_connect($server, $username, $password, $servername);

  if($mysqli->connect_error) {
   die("Connection failed: " . mysqli_connect_error());
 }


   //advisors uid
   $aid = $_SESSION['uid']; //advisors uid

    if(empty($_SESSION['uid']))
    {
            $aid = $_POST['searchID1'];
    }
    else if($_SESSION['uid'] == 0)
    {
            $aid = $_POST['searchID1'];
    }
	  
    if($_SESSION['uid'] == 0)
    {?>
          <form class="back" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="submit" value="Back" formaction="admin.php">
</form>
<?php
    }
    else
    {?>
          <form class="back" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="submit" value="Back" formaction="Advisor.php">
</form>
<?php
    }
    $query = "SELECT * FROM students s WHERE a_id = $aid";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)){
      ?>
      <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="student-info">
          <?php echo $row["u_id"] . " " . $row["fname"] . " " . $row["lname"]; ?>
          <input hidden type="text" name="uid" value="<?php echo $row["u_id"]; ?>">
          <input type="submit" name="form1" value="View Form1">
          <input type="submit" name="Transcript" value="View Transcript">
          <?php
          if ($row['program'] == 'phd'){
            ?>
            <input type="submit" name="Thesis" value="Approve Thesis">
            <?php

          }
           ?>

            </div>
            </form>


      <?php

    }

			//advisor views alumni
			$aid = $_SESSION['uid']; //advisors uid
	     $query = "SELECT * FROM alumni WHERE a_id = $aid";
	     $result = mysqli_query($conn, $query);
	     while ($row = mysqli_fetch_assoc($result)){
	       ?>
	       <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	         <div class="student-info">
	           <?php echo $row["u_id"] . " " . $row["fname"] . " " . $row["lname"]; ?>
	           <input hidden type="text" name="uid" value="<?php echo $row["u_id"]; ?>">
	           <input type="submit" name="form1" value="View Form1">
	           <input type="submit" name="Transcript" value="View Transcript">

	           <?php
	            ?>

	             </div>
	             </form>


	       <?php

	     }


    if(isset($_POST['signout'])){
      session_unset();
      session_destroy();
      header("Location: homepage.php");
    }

    if(isset($_POST['form1'])){
			?>
			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
				<input type="submit" name="Back" value="Back">
			</form>
			<?php
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
			?>
		<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
				<input type="submit" name="Back" value="Back">
			</form>

			<?php
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

