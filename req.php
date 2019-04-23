<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Requirements Page</title>
    <!-- <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/> -->
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
      form.degrees{
        float: left;
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

  <form class="degrees" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <input type="submit" name="MS" value="Master">
    <input type="submit" name="PHD" value="Doctorate">
    <input type="submit" name="core" value="Core">
    <input type="submit" name="editcourses1" value="Catalog">
</form>
</br>
</br>
</br>
</br>
</br>
</br>
<?php
session_start();
	$server = "localhost";
	$username = "markeilblow";
	$password = "Mercedes01123!!";
	$servername = "markeilblow";
  $conn = mysqli_connect($server, $username, $password, $servername);
if($_POST["MS"]){
  $pro = "MS";
  $query = "SELECT * FROM requirements WHERE program = '$pro'";
  $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($result)){
        ?>

        <?php
	  echo "Program: " . $row["program"] . "<br/>";
	  echo " Minimum GPA: " . $row["GPA"]. "<br/>";
	  echo  "Minimum number of credits: " . $row["NumCredits"] . "<br/>";
	  echo " Requires Thesis: " . $row["Thesis"] . "<br/>";
	  echo " Minimum CS credits: " . $row["CScredits"] . "<br/>";
	  echo " Maximum non-CS courses: " . $row["nonCScourses"] . "<br/>";
	  echo " Maximum grades lower than 'B' allowed: " . $row["Blower"] . "<br/>";
	  echo " Suspension Count: " . $row["suspensionCount"]. "<br/>";
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

    <input type="text" name="pChange" placeholder="Program:" required>
    <input type="text" name="gChange" placeholder="GPA:" required>
      <input type="text" name="crChange" placeholder="Credits:" required>
    <input type="text" name="thChange" placeholder="Thesis:" required>
    <input type="text" name="csChange" placeholder="CS:" required>
    <input type="text" name="nocsChange" placeholder="non CS:" required>
    <input type="text" name="blowChange" placeholder="Lower than B:" required>
      <input type="text" name="suspChange" placeholder="Suspension Count:" required>
    <input type="submit" name="submitChange" value="Submit">
      </form>
<?php
  }
}
if($_POST["submitChange"]){

  $query = "DELETE FROM requirements WHERE program = 'MS'";
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
   $query = "INSERT INTO requirements (program, GPA, NumCredits, Thesis, CScredits, nonCScourses, Blower, suspensionCount) VALUES ('$_POST[pChange]', '$_POST[gChange]', '$_POST[crChange]', '$_POST[thChange]', '$_POST[csChange]', '$_POST[nocsChange]', '$_POST[blowChange]','$_POST[suspChange]')";
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
if($_POST["PHD"]){
  $pro = "PhD";
  $query = "SELECT * FROM requirements WHERE program = '$pro'";
  $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($result)){
        ?>

        <?php
	  echo "Program: " . $row["program"] . "<br/>";
	  echo " Minimum GPA: " . $row["GPA"]. "<br/>";
	  echo  "Minimum number of credits: " . $row["NumCredits"] . "<br/>";
	  echo " Requires Thesis: " . $row["Thesis"] . "<br/>";
	  echo " Minimum CS credits: " . $row["CScredits"] . "<br/>";
	  echo " Minimum non-CS courses: " . $row["nonCScourses"] . "<br/>";
	  echo " Maximum grades lower than 'B' allowed: " . $row["Blower"] . "<br/>";
	  echo " Suspension Count: " . $row["suspensionCount"]. "<br/>";
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

    <input type="text" name="pChange" placeholder="Program:" required>
    <input type="text" name="gChange" placeholder="GPA:" required>
      <input type="text" name="crChange" placeholder="Credits:" required>
    <input type="text" name="thChange" placeholder="Thesis:" required>
    <input type="text" name="csChange" placeholder="CS:" required>
    <input type="text" name="nocsChange" placeholder="non CS:" required>
    <input type="text" name="blowChange" placeholder="Lower than B:" required>
      <input type="text" name="suspChange" placeholder="Suspension Count:" required>
    <input type="submit" name="submitChange" value="Submit">
      </form>
<?php
  }
}
if($_POST["submitChange1"]){

  $query = "DELETE FROM requirements WHERE program = 'PhD'";
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
   $query = "INSERT INTO requirements (program, GPA, NumCredits, Thesis, CScredits, nonCScourses, Blower, suspensionCount) VALUES ('$_POST[pChange]', '$_POST[gChange]', '$_POST[crChange]', '$_POST[thChange]', '$_POST[csChange]', '$_POST[nocsChange]', '$_POST[blowChange]','$_POST[suspChange]')";
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
$crn2 = " ";
$dept2 = " ";
if($_POST["core"]){
  $query = "SELECT * FROM corereq";
  $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($result)){
        ?>

        <?php
	  echo "CRN: " . $row["crn"] . "<br/>";
	  echo " Department: " . $row["dept"]. "<br/>";
	  echo  "Program: " . $row["program"] . "<br/>";

	       $crn2 = $row["crn"];
               $dept2 = $row["dept"];
	  	$program2 = $row["program"];
?>
                <input hidden type="text" name="crn2" value="<?php echo $crn2; ?>">
                  <input hidden type="text" name="dept2" value="<?php echo $dept2; ?>">
		<input hidden type="text" name="program2" value="<?php echo $program2; ?>">


  <style media="screen">
    form.stuff{
      display: none;
    }
    form.student-info{
      display: none;
    }
  </style>
  <form class="changeForm" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">


    <input type="text" name="crnChange" placeholder="crn:" required>
    <input type="text" name="departChange" placeholder="dept:" required>
      <input type="text" name="prgrmChange" placeholder="program:" required>
    <input type="submit" name="submitChange2" value="Submit">
      </form>
<?php
  }
}
      //$crn2 = $_POST["crn2"];
      //$dept2 = $_POST["dept2"];
if($_POST["submitChange2"]){

  $query = "DELETE FROM corereq WHERE program = 'MS' AND dept = '$dept2' AND crn = '$crn2'";
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
   $query = "INSERT INTO corereq (crn, dept, program) VALUES ('$_POST[crnChange]', '$_POST[departChange]', '$_POST[prgrmChange]')";
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
   if(isset($_POST["editcourses1"])){
      ?>
      <style media="screen">
      form.student-info{
        display: none;
      }
        </style>
      <?php
      $query = "SELECT * FROM course_catalog";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($result)){
          ?>
          <form class="changeCourse" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <div class="Transcript-info">

            <?php
              echo "CRN:" . $row["crn"] . "Course: " . $row["title"] . " Credits: " . $row["credit"] . " pre-req1" . $row["pre-req1"] . " pre-req2" . $row["pre-req2"]
               . " semYear: " . $row["semYear"] . " Department: " . $row["dept"] . "<br/>";
               $crn = $row["crn"];
               $dept = $row["dept"];
              ?>
                  <input type="submit" name="editcourse" value="Edit">
                  <input type="submit" name="deleteCoursebttn" value="Delete course">
                <input hidden type="text" name="crn" value="<?php echo $crn; ?>">
                  <input hidden type="text" name="dept" value="<?php echo $dept; ?>">
                </div>
            </form>

          <?php
      }
    }
    if(isset($_POST["editcourse"])){
      $crn = $_POST["crn"];
      $dept = $_POST["dept"];
      ?>
      <style media="screen">
      form.student-info{
        display: none;
      }
        </style>
        <form class="newCourse" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">


        <input hidden type="text" name= "addcrn" value = "<?php echo $crn; ?>">
        <input hidden type="text" name= "addDept" value = "<?php echo $dept; ?>">
      <input type="text" name= "addtitle" placeholder="insert title" required>
      <input type="text" name= "addcredit" placeholder="insert credit" required>
      <input type="text" name= "addprereq1" placeholder="insert prereq" required>
      <input type="text" name= "addprereq2" placeholder="insert prereq" required>
      <input type="text" name= "addsemyear" placeholder="insert semYear" required>
        <input type="submit" name="editCoursebttn" value="Add course">

          </form>

      <?php
    }
    if(isset($_POST["editCoursebttn"])){
      ?>
      <style media="screen">
      form.student-info{
        display: none;
      }
        </style>
      <?php
              $query = "UPDATE course_catalog
                SET title = '$_POST[addtitle]', credit = '$_POST[addcredit]',
                pre_req1 = '$_POST[addprereq1]', pre_req2 = '$_POST[addprereq2]', semYear = '$_POST[addsemyear]'
                WHERE crn = '$_POST[addcrn]' AND dept = '$_POST[addDept]'";
              $result = mysqli_query($conn, $query);
              if ($result){
                  ?>
                  <span class="addSuccess">
                    Added course to catalog
                  </span>
                  <?php
              }
              else{
                echo "Failed to add course"  . mysqli_error($conn);
              }
    }
    if(isset($_POST["deleteCoursebttn"])){
      //echo $_POST['crn'] . $_POST['dept'];
	$query = "DELETE FROM form1 WHERE crn = '$_POST[crn]'";
	$result = mysqli_query($conn, $query);
	$query = "DELETE FROM student_courses WHERE crn = '$_POST[crn]'";
	$result = mysqli_query($conn, $query);
	$query = "DELETE FROM corereq WHERE crn = '$_POST[crn]'";
	$result = mysqli_query($conn, $query);
      $query = "DELETE FROM course_catalog WHERE crn = '$_POST[crn]' AND dept = '$_POST[dept]'";
      $result = mysqli_query($conn, $query);
      if ($result){
          ?>
          <span class="addSuccess">
            Deleted course from catalog
          </span>
          <?php
      }
      else{
        echo "Failed to delete course"  . mysqli_error($conn);
      }
    }
    if(isset($_POST['Addcourse'])){
      ?>
      <style media="screen">
      form.student-info{
        display: none;
      }
        </style>
          <form class="newCourse" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">


        <input type="text" name= "addcrn" placeholder="insert crn" required>
        <input type="text" name= "addtitle" placeholder="insert title" required>
        <input type="text" name= "addcredit" placeholder="insert credit" required>
        <input type="text" name= "addprereq1" placeholder="insert prereq" required>
        <input type="text" name= "addprereq2" placeholder="insert prereq" required>
        <input type="text" name= "addsemyear" placeholder="insert semYear" required>
        <input type="text" name= "addDept" placeholder="insert dept" required>
        <input type="submit" name="newCoursebttn" value="Add course">
            </form>
      <?php
    }
    if(isset($_POST["newCoursebttn"])){
?>
<style media="screen">
form.student-info{
  display: none;
}
  </style>
<?php
        $query = "INSERT INTO course_catalog (crn, title, credit, pre_req1, pre_req2, semYear, dept)
          VALUES ('$_POST[addcrn]', '$_POST[addtitle]', '$_POST[addcredit]', '$_POST[addprereq1]',
          '$_POST[addprereq2]', '$_POST[addsemyear]', '$_POST[addDept]')";
        $result = mysqli_query($conn, $query);
        if ($result){
            ?>
            <span class="addSuccess">
              Added course to catalog
            </span>
            <?php
        }
        else{
          echo "Failed to add course";
        }
    }
    if(isset($_POST['signout'])){
      session_unset();
      session_destroy();
      header("Location: homepage.php");
    }
?>
</body>
</html>

