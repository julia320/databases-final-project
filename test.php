<!DOCTYPE html>
<?php
	session_start();
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>System Admin Page</title>
    <style type = "text/css">

      body {
        background-color: grey;

      }
      span.err{
        color: red;
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




    </style>
  </head>
  <body>
  <form class="signout" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <input type="submit" name="signout" value="Sign out">
    <input type="submit" name="Addcourse" value="Add a course">
    <input type="submit" name="editcourse" value="Edit courses">
</form>

      <div class="Title">
        Advisor Page
      </div>
  <?php

	$server = "localhost";
	$username = "markeilblow";
	$password = "Mercedes01123!!";
	$servername = "markeilblow";
 $conn = mysqli_connect($server, $username, $password, $servername);




   //advisors uid
   $aid = $_SESSION['uid']; //advisors uid
    $query = "SELECT * FROM students";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)){
      ?>
      <form class="student-info" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="student-info">
          <?php echo $row["u_id"] . " " . $row["fname"] . " " . $row["lname"]; ?>
          <input hidden type="text" name="uid" value="<?php echo $row["u_id"]; ?>">
          <input type="submit" name="form1" value="Edit Form1">
          <input type="submit" name="Transcript" value="Edit Transcript">
          <input type="submit" name="Account" value="Edit Account Details">
          <?php
           ?>

            </div>
            </form>


      <?php

    }

    if(isset($_POST["editcourse"])){
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
                echo "Failed to add course";
              }



    }

    if(isset($_POST["deleteCoursebttn"])){
      //echo $_POST['crn'] . $_POST['dept'];
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
        echo "Failed to delete course";
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


    if(isset($_POST['Transcript'])){
      $uid = $_POST['uid'];
      $query = "SELECT * FROM student_courses WHERE u_id = '$uid'";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($result)){
        ?>
        <br>
        <style "text/css">

        form.student-info{
          display: none;
        }

        </style>
        <form class="stuff" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <input type="submit" name="Editclass" value="Edit">

          <input hidden type="text" name="uid" value="<?php echo $uid; ?>">

        <div class="Transcript-info">

        <?php
          echo "Course: " . $row["title"] . " Department: " . $row["dept"] . " semYear: " . $row["semYear"] . " Credits: " . $row["credit"] . " Grade:" . $row["lettergrade"] . " Program:" . $row["program"] . "<br/>";
          ?>
            <input hidden type="text" name="uid" value="<?php echo $uid; ?>">
              <input hidden type="text" name="title" value="<?php echo $row["title"]; ?>">
              <input hidden type="text" name="dept" value="<?php echo $row["dept"]; ?>">
              <input hidden type="text" name="semYear" value="<?php echo $row["semYear"]; ?>">
            </div>
              </form>
          <?php
      }



}

if($_POST["Editclass"]){
  $uid = $_POST["uid"];
  $title = $_POST["title"];
  $dept = $_POST["dept"];
  $semYear = $_POST["semYear"];

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
 ?>



  </body>
</html>

