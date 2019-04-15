<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Update Page</title>
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
      div.student-info{
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

#wrap {
   width:1000px;
   margin:0 auto;
}
#left_col {
   float:left;
   width:500px;
}
#right_col {
   float:right;
   width:500px;
}

  fieldset{
  border:none;
  width:500px;
  margin:0px auto;
  }
    </style>
  </head>
  <body>
<form class="signout" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="submit" value="Back" formaction="admin.php">
        <input type="submit" name="signout" value="Sign out">
</form>

      <div class="Title">
        Update Page
      </div>
<?php
        session_start();
?>


<?php
	$server = "localhost";
	$username = "markeilblow";
	$password = "Mercedes01123!!";
	$servername = "markeilblow";
$conn = mysqli_connect($servername, $username, $password, $dbname);
  if($mysqli->connect_error) {
   die("Connection failed: " . mysqli_connect_error());
 }
 $user_id = $_POST['searchID'];
 $query = "SELECT * FROM students WHERE u_id = '$user_id'";
 $result = mysqli_query($conn, $query);
	  if($result){
		  echo "query successful";
	  
	  }
	  else{
		 echo "Error: " . $query . "<br/>" . mysqli_error($conn);
	  }
 while($row = mysqli_fetch_assoc($result))
  {
	 //if($user_id == 0)
	 //{
	 //}
	 //else
	 //{
  ?>
      <form class="info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="info">
          <?php echo $row["u_id"] . " " . $row["fname"] . " " . $row["lname"]; ?>
          <input hidden type="text" name="uid" value="<?php echo $row["u_id"]; ?>">
          <input type="submit" name="form1" value="Edit Form 1">
	  <input type="submit" name="Transcript" value="Edit Transcript">
	  <input type="submit" name="User" value="Edit User">
</div>
</form>
<?php
	 //}
 }
$user_id = $_POST['searchID'];
 $query = "SELECT * FROM alumni WHERE u_id = '$user_id'";
 $result = mysqli_query($conn, $query);
 while($row = mysqli_fetch_assoc($result))
 {
	 //if($user_id == 0)
	 //{
	 //}
	 //else
	 //{
?>
      <form class="info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="info">
         <?php echo $row["u_id"] . " " . $row["fname"] . " " . $row["lname"]; ?>
          <input hidden type="text" name="uid" value="<?php echo $row["u_id"]; ?>">
         <input type="submit" name="User2" value="Edit User">
</div>
</form>
<?php
	 //}
 }
?>

<?php
$user_id = $_POST['searchID'];
 $query = "SELECT * FROM faculty WHERE f_id = '$user_id'";
 $result = mysqli_query($conn, $query);
 while($row = mysqli_fetch_assoc($result))
 {
	 if($user_id == 0)
	 {
	 }
	 else
	 {
	?>

      <form class="info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="info">
          <?php echo $row["f_id"] . " " . $row["fname"] . " " . $row["lname"]; ?>
          <input hidden type="text" name="uid" value="<?php echo $row["f_id"]; ?>">
          <input type="submit" name="User1" value="Edit User">
</div>
</form>
<?php
	 }
}
if($_POST["Transcript"]){
  $uid = $_POST["uid"];
  $title = $_POST["title"];
  $dept = $_POST["dept"];
  $semYear = $_POST["semYear"];
      $query = "SELECT * FROM student_courses WHERE u_id = '$uid'";
      $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($result)){
        ?>


        <?php
          echo "Course: " . $row["title"] . " Department: " . $row["dept"] . "CRN: " . $row["crn"] . " semYear: " . $row["semYear"] . " Credits: " . $row["credit"] . " Grade:" . $row["lettergrade"] . " Program:" . $row["program"] . "<br/>";

  ?>

  <style media="screen">
    form.stuff{
      display: none;
    }
    form.student-info{
      display: none;
    }
  </style>
  <form class="changeForm" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">

    <input hidden type="text" name="uid" value="<?php echo $uid; ?>">
      <input hidden type="text" name="title" value="<?php echo $title; ?>">
      <input hidden type="text" name="dept" value="<?php echo $dept; ?>">
      <input hidden type="text" name="semYear" value="<?php echo $semYear; ?>">

    <input type="text" name="courseChange" placeholder="Course:" required>
    <input type="text" name="deptChange" placeholder="Dept:" required>
      <input type="text" name="crnChange" placeholder="crn:" required>
    <input type="text" name="semYearChange" placeholder="semYear:" required>
    <input type="text" name="creditChange" placeholder="Credit:" required>
    <input type="text" name="Lgradechange" placeholder="Letter Grade:" required>
    <input type="text" name="Ngradechange" placeholder="Number Grade:" required>
      <input type="text" name="program" placeholder="program" required>
    <input hidden type="text" name="uid" value="<?php echo $uid; ?>" required>
    <input type="submit" name="submitChange" value="Submit">
      </form>

  <?php
  }
}
if($_POST["submitChange"]){
  $uid = $_POST["uid"];
  echo $uid;
  $query = "DELETE FROM student_courses WHERE u_id = '$uid' AND title = '$title' AND dept = '$dept' AND semYear = '$semYear'";
  /*$query = "UPDATE student_courses SET title = '$_POST[courseChange]',
              dept = '$_POST[deptChange]', crn = '$_POST[crnChange]', semYear = '$_POST[semYearChange]',
              credit = '$_POST[creditChange]', lettergrade = '$_POST[Lgradechange]', numgrade = '$_POST[Ngradechange]'
              WHERE u_id = '$uid' AND title = '$title' AND dept = '$dept' AND semYear = '$semYear'";*/
              $result = mysqli_query($conn, $query);
              if ($result){
                ?>
                  <span class="oldcourse">
                    Deleted old course
                  </span>
                <?php
   }
   else {
     ?>
     <span class="err">
       That is not a course option
     </span>
     <?php
   }
   $query = "INSERT INTO student_courses (title, dept, crn, semYear, u_id, credit, lettergrade, numgrade, program)
   VALUES ('$_POST[courseChange]', '$_POST[deptChange]', '$_POST[crnChange]', '$_POST[semYearChange]',
               '$uid', '$_POST[creditChange]', '$_POST[Lgradechange]', '$_POST[Ngradechange]',
               '$_POST[program]')";
    $result = mysqli_query($conn, $query);
               if ($result){
                 ?>
                 <span class="updatedcomplete ">
                   Update successful
                 </span>
                 <?php
    }
    else {
    echo "Error: " . $query . "<br/>" . mysqli_error($conn);
    }
}
//editing form1
    if(isset($_POST['form1'])){
      $uid = $_POST['uid'];
      $_SESSION['form1'] = $uid;
      $query = "SELECT * FROM form1 WHERE u_id = '$uid'";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($result)){
        ?>
        <br>
          <div class="form1-info">
	<?php
          echo "CRN: " . $row["crn"] . " Department:" . $row["dept"] . " SemYear:" . $row["semYear"] . "<br/>";
          ?>
<?php
  $uid = $_POST["uid"];
  $title = $row["fname"];
  $dept = $row["minit"];
  $semYear = $row["lname"];
  ?>

  <style media="screen">
    form.stuff{
      display: none;
    }
    form.student-info{
      display: none;
    }
  </style>
  <form class="changeForm" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">

    <input hidden type="text" name="uid" value="<?php echo $uid; ?>">
      <input hidden type="text" name="fname" value="<?php echo $fname; ?>">
      <input hidden type="text" name="minit" value="<?php echo $minit; ?>">
      <input hidden type="text" name="lname" value="<?php echo $lname; ?>">

    <input type="text" name="deptChange1" placeholder="Dept:" required>
      <input type="text" name="crnChange1" placeholder="crn:" required>
    <input type="text" name="semYearChange1" placeholder="semYear:" required>
      <input type="text" name="program1" placeholder="program" required>
    <input hidden type="text" name="uid" value="<?php echo $uid; ?>" required>
    <input type="submit" name="submitChange1" value="Submit">
      </form>

  <?php
}
    }
if($_POST["submitChange1"]){
  $uid = $_POST["uid"];
  echo $uid;
  $query = "DELETE FROM form1 WHERE u_id = '$uid' AND crn = '$crn' AND semYear = '$semYear'";
  /*$query = "UPDATE student_courses SET title = '$_POST[courseChange]',
              dept = '$_POST[deptChange]', crn = '$_POST[crnChange]', semYear = '$_POST[semYearChange]',
              credit = '$_POST[creditChange]', lettergrade = '$_POST[Lgradechange]', numgrade = '$_POST[Ngradechange]'
              WHERE u_id = '$uid' AND title = '$title' AND dept = '$dept' AND semYear = '$semYear'";*/
              $result = mysqli_query($conn, $query);
              if ($result){
                ?>
                  <span class="oldcourse">
                    Deleted old entry
                  </span>
                <?php
   }
   else {
     ?>
     <span class="err">
       That is not a course option
     </span>
     <?php
   }
   $query = "INSERT INTO form1(
                          u_id,
                          fname,
                          minit,
                          lname,
                          program,
                          dept,
                          semYear,
                          crn)
                          VALUES
			  ('$uid', '$fname', '$minit', '$lname','$_POST[program1]', '$_POST[deptChange1]', '$_POST[semYearChange1]', '$_POST[crnChange1]')";
    $result = mysqli_query($conn, $query);
               if ($result){
                 ?>
                 <span class="updatedcomplete ">
                   Update successful
                 </span>
                 <?php
    }
    else {
    echo "Error: " . $query . "<br/>" . mysqli_error($conn);
    }
}?>
            </div>
<?php

?>

<?php

	//signing out
    if(isset($_POST['signout'])){
      session_unset();
      session_destroy();
      header("Location: homepage.php");
    }

//editing a user
    if(isset($_POST['User']))
    {
	    $uid = $_POST['uid'];
	    $_SESSION['user'] = $uid;
      //editing a student
      $query = "SELECT * FROM students WHERE u_id = '$uid'";
      $result = mysqli_query($conn, $query);
      if($result)
      {
      	while ($row = mysqli_fetch_assoc($result))
	{
        ?>
      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
	  <label for="firstname">First name:</label>
	  <?php echo $row["fname"] . " ";?>
	  <input type="text" name="firstname" />
	  <input type="submit" name="update1" value="Update"><br/>
	  </div>
	  </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="minit">Middle Initial:</label>
          <?php echo $row["minit"] . " ";?>
          <input type="text" name="minit" />
          <input type="submit" name="update2" value="Update"><br/>
	  </div>
	  </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="lastname">Last name:</label>
          <?php echo $row["lname"] . " ";?>
          <input type="text" name="lastname" />
          <input type="submit" name="update3" value="Update"><br/>
	  </div>
	  </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="bday">Birthdate:</label>
          <?php echo $row["bday"] . " ";?>
          <input type="text" name="bday" />
          <input type="submit" name="update4" value="Update"><br/>
	  </div>
	  </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="phone">Phone:</label>
          <?php echo $row["pnumber"] . " ";?>
          <input type="text" name="phone" />
          <input type="submit" name="update5" value="Update"><br/>
	  </div>
	  </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="username">Username:</label>
          <?php echo $row["u_id"] . " ";?>
          <input type="text" name="username" />
          <input type="submit" name="update6" value="Update"><br/>
	  </div>
	  </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="pswd">Password:</label>
          <?php echo $row["pswd"] . " ";?>
          <input type="text" name="pswd" />
          <input type="submit" name="update7" value="Update"><br/>
	  </div>
	  </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="addr">Address:</label>
          <?php echo $row["addr"] . " ";?>
          <input type="text" name="addr" />
          <input type="submit" name="update8" value="Update"><br/>
	  </div>
          </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="degree">Degree Program:</label>
          <?php echo $row["program"] . " ";?>
          <input type="text" name="degree" />
          <input type="submit" name="update9" value="Update"><br/>
	  </div>
          </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="major">Major:</label>
          <?php echo $row["major"] . " ";?>
          <input type="text" name="major" />
          <input type="submit" name="update10" value="Update"><br/>
	  </div>
	  </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="gradYear">Graduation Year:</label>
          <?php echo $row["gradYear"] . " ";?>
          <input type="text" name="gradYear" />
          <input type="submit" name="update11" value="Update"><br/>
	  </div>
	  </form>

      	  <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">
          <label for="adID">Advisor:</label>
          <?php echo $row["a_id"] . " ";?>
          <input type="text" name="adID" />
          <input type="submit" name="update12" value="Update>"<br/>
          </div>
          </form>
	<?php
	}
      }
    }
    if(isset($_POST['User2']))
    {
    	$uid = $_POST['uid'];
	$_SESSION['user'] = $uid;
       //editing alumni
	$query = "SELECT * FROM alumni WHERE u_id = '$uid'";
	$result = mysqli_query($conn, $query);
	if($result)
	{
        	while ($row = mysqli_fetch_assoc($result))
        	{?>
      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="firstname2">First name:</label>
	  		<?php echo $row["fname"] . " ";?>
	  		<input type="text" name="firstname2" />
	  		<input type="submit" name="update101" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="minit2">Middle initial:</label>
	  		<?php echo $row["minit"] . " ";?>
	  		<input type="text" name="minit2" />
	  		<input type="submit" name="update102" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="lastname2">Last name:</label>
	  		<?php echo $row["lname"] . " ";?>
	  		<input type="text" name="lastname2" />
	  		<input type="submit" name="update103" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="addr2">Address:</label>
	  		<?php echo $row["addr"] . " ";?>
	  		<input type="text" name="addr2" />
	  		<input type="submit" name="update104" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="phone2">Phone:</label>
	  		<?php echo $row["pnumber"] . " ";?>
	  		<input type="number" name="phone2" />
	  		<input type="submit" name="update105" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="username2">User ID:</label>
	  		<?php echo $row["u_id"] . " ";?>
	  		<input type="number" name="username2" />
	  		<input type="submit" name="update106" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="pswd2">Password:</label>
	  		<?php echo $row["pswd"] . " ";?>
	  		<input type="text" name="pswd2" />
	  		<input type="submit" name="update107" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="degree2">Degree Program:</label>
	  		<?php echo $row["program"] . " ";?>
	  		<input type="text" name="degree2" />
	  		<input type="submit" name="update108" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="gradYear2">Graduation Year:</label>
	  		<?php echo $row["gradYear"] . " ";?>
	  		<input type="number" name="gradYear2" />
	  		<input type="submit" name="update109" value="Update"><br/>
			</div>
			</form>

                        <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                        <div class="Transcript-info">
                        <label for="adv2">Advisor:</label>
                        <?php echo $row["a_id"] . " ";?>
                        <input type="number" name="adv2" />
                        <input type="submit" name="update111" value="Update"><br/>
                        </div>
                        </form>

			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="donation">Donation: $</label>
	  		<?php echo $row["donation"] . " ";?>
	  		<input type="number" name="donation" />
	  		<input type="submit" name="update110" value="Update"><br/>
			</div>
			</form>
	<?php	}
	}
    }

    if(isset($_POST['User1']))
    {
	//$uid = $_SESSION['uid'];
    	$uid = $_POST['uid'];
	//$_SESSION['user'] = $uid;
	//editing faculty
	$query = "SELECT * FROM faculty WHERE f_id = '$uid'";
	$result = mysqli_query($conn, $query);
	if($result)
	{
		while ($row = mysqli_fetch_assoc($result))
                {?>
      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="firstname1">First name:</label>
	  		<?php echo $row["fname"] . " ";?>
	  		<input type="text" name="firstname1" />
	  		<input type="submit" name="update01" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="minit1">Middle initial:</label>
	  		<?php echo $row["minit"] . " ";?>
	  		<input type="text" name="minit1" />
	  		<input type="submit" name="update02" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="lastname1">Last name:</label>
	  		<?php echo $row["lname"] . " ";?>
	  		<input type="text" name="lastname1" />
	  		<input type="submit" name="update03" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="fID">Faculty ID:</label>
	  		<?php echo $row["f_id"] . " ";?>
	  		<input type="text" name="fID" />
	  		<input type="submit" name="update04" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="admin">System Admin?:</label>
	  		<?php echo $row["admin"] . " ";?>
	  		<input type="text" name="admin" />
	  		<input type="submit" name="update05" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="advisor1">Advisor?:</label>
	  		<?php echo $row["adv"] . " ";?>
	  		<input type="text" name="advisor1" />
	  		<input type="submit" name="update06" value="Update"><br/>
			</div>
			</form>

      			<form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        		<div class="Transcript-info">
	  		<label for="gradSec">First name:</label>
	  		<?php echo $row["grad_sec"] . " ";?>
	  		<input type="text" name="gradSec" />
	  		<input type="submit" name="update07" value="Update"><br/>
			</div>
			</form>
<?php
		}
	}
	else
	{
		echo "No information to show";
	}
    }
?>

<?php
	  	//editing student name
              if(isset($_POST["update1"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['firstname']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['firstname'];
		}
                $query = "UPDATE students SET fname = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update2"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['minit']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['minit'];
		}
                $query = "UPDATE students SET minit = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update3"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['lastname']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['lastname'];
		}
                $query = "UPDATE students SET lname = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update4"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['bday']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['birth'];
		}
                $query = "UPDATE students SET bday = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update5"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['phone']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['phone'];
		}
                $query = "UPDATE students SET pnumber = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update6"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['username']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['username'];
		}
                $query = "UPDATE students SET u_id = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update7"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['pswd']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['pswd'];
		}
                $query = "UPDATE students SET pswd = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update8"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['addr']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['addr'];
		}
                $query = "UPDATE students SET addr = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

              if(isset($_POST["update9"]))
              {
                $uid = $_SESSION['user'];
                if(empty($_POST['degree']))
                {
                        echo "Empty";
                }
                //else
                //{
                        if($_POST['degree'] == 'MS' || $_POST['degree'] == 'PhD')
                        {
                                $temp = $_POST['degree'];
                  //      }
                  //      else
                  //      {
                  //              echo "Must enter MS or PhD";
                  //      }
                        //$temp = $_POST['degree'];
                //}
                $query = "UPDATE students SET program = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
                        }
                        else
                        {
                                echo "Must enter MS or PhD";
                        }
              }

	      if(isset($_POST["update10"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['major']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['major'];
		}
                $query = "UPDATE students SET major = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update11"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['gradYear']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['gradYear'];
		}
                $query = "UPDATE students SET gradYear = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update12"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['adID']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['adID'];
		}
                $query = "UPDATE students SET a_id = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }



	  	//editing faculty
              if(isset($_POST["update01"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['firstname1']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['firstname1'];
		}
                $query = "UPDATE faculty SET fname = '$temp' WHERE f_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update02"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['minit1']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['minit1'];
		}
                $query = "UPDATE faculty SET minit = '$temp' WHERE f_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update03"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['lastname1']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['lastname1'];
		}
                $query = "UPDATE faculty SET lname = '$temp' WHERE f_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	  	//editing student name
              if(isset($_POST["update1"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['firstname']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['firstname'];
		}
                $query = "UPDATE students SET fname = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update2"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['minit']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['minit'];
		}
                $query = "UPDATE students SET minit = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update3"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['lastname']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['lastname'];
		}
                $query = "UPDATE students SET lname = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	  	//editing student name
              if(isset($_POST["update1"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['firstname']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['firstname'];
		}
                $query = "UPDATE students SET fname = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update2"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['minit']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['minit'];
		}
                $query = "UPDATE students SET minit = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update3"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['lastname']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['lastname'];
		}
                $query = "UPDATE students SET lname = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	  	//editing alumni
              if(isset($_POST["update101"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['firstname2']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['firstname2'];
		}
                $query = "UPDATE alumni SET fname = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

              if(isset($_POST["update102"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['minit2']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['minit2'];
		}
                $query = "UPDATE alumni SET minit = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

              if(isset($_POST["update103"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['lastname2']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['lastname2'];
		}
                $query = "UPDATE alumni SET lname = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

              if(isset($_POST["update104"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['addr2']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['addr2'];
		}
                $query = "UPDATE alumni SET addr = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

              if(isset($_POST["update105"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['phone2']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['phone2'];
		}
                $query = "UPDATE alumni SET pnumber = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

              if(isset($_POST["update106"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['username2']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['username2'];
		}
                $query = "UPDATE alumni SET u_id = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

              if(isset($_POST["update107"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['pswd2']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['pswd2'];
		}
                $query = "UPDATE alumni SET pswd = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

              if(isset($_POST["update108"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['degree2']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['degree2'];
		}
                $query = "UPDATE alumni SET program = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

              if(isset($_POST["update109"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['gradYear2']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['gradYear2'];
		}
                $query = "UPDATE alumni SET gradYear = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

              if(isset($_POST["update110"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['donation']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['donation'];
		}
                $query = "UPDATE alumni SET donation = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
	      }
	      if(isset($_POST["update111"]))
              {
                $uid = $_SESSION['user'];
                if(empty($_POST['adv2']))
                {
                        echo "Empty";
                }
                else
                {
                        $temp = $_POST['adv2'];
                }
                $query = "UPDATE alumni SET a_id = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }
	  	//editing student name
              if(isset($_POST["update1"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['firstname']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['firstname'];
		}
                $query = "UPDATE students SET fname = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update2"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['minit']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['minit'];
		}
                $query = "UPDATE students SET minit = '$temp' WHERE u_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update04"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['fID']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['fID'];
		}
		$query = "UPDATE students SET a_id = 911 WHERE a_id = '$uid'";
		$result = mysqli_query($conn, $query);
                $query = "UPDATE faculty SET f_id = '$temp' WHERE f_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
				$query = "UPDATE students SET a_id = '$temp' WHERE a_id = 911";
				$result = mysqli_query($conn, $query);
				header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	  	//editing student name
              if(isset($_POST["update05"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['admin']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['admin'];
		}
                $query = "UPDATE faculty SET admin = '$temp' WHERE f_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update06"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['advisor']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['advisor'];
		}
                $query = "UPDATE faculty SET adv = '$temp' WHERE f_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	      if(isset($_POST["update07"]))
	      {
		$uid = $_SESSION['user'];
                if(empty($_POST['gradSec']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['gradSec'];
		}
                $query = "UPDATE faculty SET grad_sec = '$temp' WHERE f_id = '$uid'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
                                header("Location: Admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }

	  //editing form1
	      if(isset($_POST["update301"]))
	      {
		$uid = $_SESSION['user'];
		$crn = $_POST['courseNo'];
                if(empty($_POST['crn']))
                {
                        echo "Empty";
		}
		else
		{
			$temp = $_POST['crn'];
			$temp1 = $_POST['dept2'];
			$temp2 = $_POST['semYear2'];
		}
                $query = "UPDATE form1 SET crn = '$temp', dept = '$temp1', semYear = '$temp2' WHERE u_id = '$uid' AND crn = '$crn'";
                $result = mysqli_query($conn, $query);
                        if($result === TRUE)
                        {
				echo "Done";
				header("Location: admin.php");
                        }
                        else
                        {
                                echo "Couldn't update". mysqli_error($conn);
                        }
              }
?>
</body>
</html>

