<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Requirements Page</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<style>
        input[type=submit] 
        {
            background-color: #76b852;
            border: none;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            margin: 4px 2px;
            width: 70%;
        }

        form.signout
        {
            float: right;
            top: 100px;
        }
</style>

<body class="gray-bg">
  <form class="signout" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <input type="submit" value="Back" formaction="menu.php">
    <input type="submit" name="signout" value="Sign out">
  </form>

  <div class="Title">
    View or manage course requirements.
  </div>

  <form class="main-menu" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
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
	  $username = "ARGv";
	  $password = "CSCI2541_sp19";
	  $servername = "ARGv";
    $conn = mysqli_connect($server, $username, $password, $servername);
    
    //MS REQUIREMENTS
    if($_POST["MS"])
    {
      $pro = "MS";
      $query = "SELECT * FROM requirements WHERE program = '$pro'";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($result))
      {
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
          form.stuff
          {
            display: none;
          }
          form.student-info
          {
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
          <input type="submit" name="submitChange1" value="Submit">
        </form>
  <?php
      }
    }

    //CHANGE MS REQUIREMENTS
    if($_POST["submitChange1"])
    {
      $query = "DELETE FROM requirements WHERE program = 'MS'";
      /*$query = "UPDATE student_courses SET title = '$_POST[courseChange]',
              dept = '$_POST[deptChange]', crn = '$_POST[crnChange]', semYear = '$_POST[semYearChange]',
              credit = '$_POST[creditChange]', lettergrade = '$_POST[Lgradechange]', numgrade = '$_POST[Ngradechange]'
              WHERE u_id = '$uid' AND title = '$title' AND dept = '$dept' AND semYear = '$semYear'";*/
      $result = mysqli_query($conn, $query);
      if ($result)
      {
  ?>
        <span class="oldcourse">
          Deleted old course
        </span>
  <?php
      }
      else 
      {

        
        echo "Error: " . $query . "<br/>" . mysqli_error($conn);
        
  
      }
      $query = "INSERT INTO requirements (program, GPA, NumCredits, Thesis, CScredits, nonCScourses, Blower, suspensionCount) VALUES ('$_POST[pChange]', '$_POST[gChange]', '$_POST[crChange]', '$_POST[thChange]', '$_POST[csChange]', '$_POST[nocsChange]', '$_POST[blowChange]','$_POST[suspChange]')";
      $result = mysqli_query($conn, $query);
      if ($result)
      {
  ?>
        <span class="updatedcomplete ">
          Update successful
        </span>
  <?php
      }
      else 
      {
        echo "Error: " . $query . "<br/>" . mysqli_error($conn);
      }
    }

    //PHD REQUIREMENTS
    if($_POST["PHD"])
    {
      $pro = "PhD";
      $query = "SELECT * FROM requirements WHERE program = '$pro'";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($result))
      {
        echo " Program: " . $row["program"] . "<br/>";
	      echo " Minimum GPA: " . $row["GPA"]. "<br/>";
	      echo " Minimum number of credits: " . $row["NumCredits"] . "<br/>";
	      echo " Requires Thesis: " . $row["Thesis"] . "<br/>";
	      echo " Minimum CS credits: " . $row["CScredits"] . "<br/>";
	      echo " Minimum non-CS courses: " . $row["nonCScourses"] . "<br/>";
	      echo " Maximum grades lower than 'B' allowed: " . $row["Blower"] . "<br/>";
	      echo " Suspension Count: " . $row["suspensionCount"]. "<br/>";
  ?>


      <style media="screen">
        form.stuff
        {
          display: none;
        }
        form.student-info
        {
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
    
    //CHANGE PHD REQUIREMENTS
    if($_POST["submitChange"])
    {
      $query = "DELETE FROM requirements WHERE program = 'PhD'";
      /*$query = "UPDATE student_courses SET title = '$_POST[courseChange]',
              dept = '$_POST[deptChange]', crn = '$_POST[crnChange]', semYear = '$_POST[semYearChange]',
              credit = '$_POST[creditChange]', lettergrade = '$_POST[Lgradechange]', numgrade = '$_POST[Ngradechange]'
              WHERE u_id = '$uid' AND title = '$title' AND dept = '$dept' AND semYear = '$semYear'";*/
      $result = mysqli_query($conn, $query);
      if ($result)
      {
  ?>
        <span class="oldcourse">
          Deleted old course
        </span>
  <?php
      }
      else 
      {
  ?>
        <span class="err">
          That is not a course option
        </span>
  <?php
      }
      $query = "INSERT INTO requirements (program, GPA, NumCredits, Thesis, CScredits, nonCScourses, Blower, suspensionCount) VALUES ('$_POST[pChange]', '$_POST[gChange]', '$_POST[crChange]', '$_POST[thChange]', '$_POST[csChange]', '$_POST[nocsChange]', '$_POST[blowChange]','$_POST[suspChange]')";
      $result = mysqli_query($conn, $query);
      if ($result)
      {
  ?>
        <span class="updatedcomplete">
          Update successful
        </span>
  <?php
      }
      else 
      {
        echo "Error: " . $query . "<br/>" . mysqli_error($conn);
      }
    }

    $crn2 = " ";
    $dept2 = " ";
    //CORE REQUIREMENTS
    if($_POST["core"])
    {
      $query = "SELECT * FROM corereq";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($result))
      {
	      echo "Course No: " . $row["courseno"] . "<br/>";
	      echo " Department: " . $row["dept"]. "<br/>";
	      echo  "Program: " . $row["program"] . "<br/>";

	      $crn2 = $row["courseno"];
        $dept2 = $row["dept"];
	  	  $program2 = $row["program"];
    ?>
        <input hidden type="text" name="courseno" value="<?php echo $crn2; ?>">
        <input hidden type="text" name="dept2" value="<?php echo $dept2; ?>">
		    <input hidden type="text" name="program2" value="<?php echo $program2; ?>">

        <style media="screen">
          form.stuff
          {
            display: none;
          }
          form.student-info
          {
            display: none;
          }
        </style>
  
        <form class="changeForm" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <input type="submit" name="editcore" value="Edit">
          <input type="submit" name="deletecore" value="Delete course">
          <input hidden type="text" name="courseno" value="<?php echo $crn2; ?>">
          <input hidden type="text" name="dept" value="<?php echo $dept2; ?>">
          <input hidden type="text" name="program" value="<?php echo $program2; ?>">
        </form>
    <?php
      }
    }
      
    //CHANGE CORE REQUIREMENTS
    if(isset($_POST["editcore"]))
    {
      $cno = $_POST["courseno"];
      $depart = $_POST["dept"];
      $pro = $_POST["program"];
    ?>
      <style media="screen">
        form.student-info
        {
          display: none;
        }
      </style>
      <form class="newCourse" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
      <input hidden type="text" name= "addcno" value = "<?php echo $cno; ?>">
        <input hidden type="text" name= "adddept2" value = "<?php echo $depart; ?>">
        <input hidden type="text" name= "addpro" value = "<?php echo $pro; ?>">
        <input type="text" name= "addcourseno" placeholder="insert courseno" required>
        <input type="text" name= "adddept" placeholder="insert dept" required>
        <input type="text" name= "addprogram" placeholder="insert program" required>
        <input type="submit" name="editcore1" value="Update Core Req">
      </form>

    <?php
    }
    //SUBMIT EDIT TO CORE
    if(isset($_POST["editcore1"]))
    {
    ?>
      <style media="screen">
        form.student-info
        {
          display: none;
        }
      </style>
    <?php
        
      $query = "UPDATE corereq
                SET courseno = '$_POST[addcourseno]', dept = '$_POST[adddept]', program = '$_POST[addprogram]'
                WHERE courseno = '$_POST[addcno]' AND dept = '$_POST[adddept2]' AND program = '$_POST[addpro]' ";
      $result = mysqli_query($conn, $query);
      if ($result)
      {
    ?>
        <span class="addSuccess">
          Added course to catalog
        </span>
    <?php
      }
      else
      {
        echo "Failed to edit core req"  . mysqli_error($conn);
      }
    }
    //DELETE CORE
    if(isset($_POST["deletecore"]))
    {
	    $query = "DELETE FROM corereq WHERE courseno = '$_POST[courseno]' AND program = '$_POST[program]' AND dept = '$_POST[dept]'";
	    $result = mysqli_query($conn, $query);
      if ($result)
      {
    ?>
        <span class="addSuccess">
            Deleted course from catalog
        </span>
    <?php
      }
      else
      {
        echo "Failed to delete course"  . mysqli_error($conn);
      }
    }


    //COURSE CATALOG
    if(isset($_POST["editcourses1"]))
    {
    ?>
      <style media="screen">
        form.student-info
        {
          display: none;
        }
      </style>
    <?php
      $query = "SELECT * FROM course";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($result))
      {
    ?>
        <form class="changeCourse" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="Transcript-info">

    <?php
          echo "CourseNo:" . $row["courseno"] . "<br/>";
          echo "Course: " . $row["name"] . "<br/>";
          echo "Credits: " . $row["credits"] . "<br/>";
          echo "pre-req1" . $row["prereq1"] . "<br/>";
          echo "prereq2" . $row["prereq2"] . "<br/>";
          echo "Semester: " . $row["semester"] . "<br/>";
          echo "Year: " . $row["year"] . "<br/>";
          echo"Department: " . $row["dept"] . "<br/>";
          $crn = $row["courseno"];
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
    //EDIT CATALOG
    if(isset($_POST["editcourse"]))
    {
      $crn = $_POST["crn"];
      $dept = $_POST["dept"];
    ?>
      <style media="screen">
        form.student-info
        {
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
        <input type="text" name= "addsem" placeholder="insert sem" required>
        <input type="text" name= "addyear" placeholder="insert year" required>
        <input type="submit" name="editCoursebttn" value="Add course">
      </form>

    <?php
    }
    //SUBMIT EDIT TO COURSE CATALOG
    if(isset($_POST["editCoursebttn"]))
    {
    ?>
      <style media="screen">
        form.student-info
        {
          display: none;
        }
      </style>
    <?php
        
      $query = "UPDATE course
                SET name = '$_POST[addtitle]', credits = '$_POST[addcredit]', year = '$_POST[addyear]',
                prereq1 = '$_POST[addprereq1]', prereq2 = '$_POST[addprereq2]', semester = '$_POST[addsem]'
                WHERE courseno = '$_POST[addcrn]' AND dept = '$_POST[addDept]'";
      $result = mysqli_query($conn, $query);
      if ($result)
      {
    ?>
        <span class="addSuccess">
          Added course to catalog
        </span>
    <?php
      }
      else
      {
        echo "Failed to add course"  . mysqli_error($conn);
      }
    }
    //DELETE COURSE FROM CATALOG
    if(isset($_POST["deleteCoursebttn"]))
    {
      //echo $_POST['crn'] . $_POST['dept'];
      $query = "DELETE FROM form1 WHERE courseno = '$_POST[crn]'";
	    $result = mysqli_query($conn, $query);
	    $query = "DELETE FROM transcript WHERE courseno = '$_POST[crn]'";
	    $result = mysqli_query($conn, $query);
	    $query = "DELETE FROM corereq WHERE courseno = '$_POST[crn]'";
	    $result = mysqli_query($conn, $query);
      $query = "DELETE FROM course WHERE courseno = '$_POST[crn]' AND dept = '$_POST[dept]'";
      $result = mysqli_query($conn, $query);
      if ($result)
      {
    ?>
        <span class="addSuccess">
            Deleted course from catalog
        </span>
    <?php
      }
      else
      {
        echo "Failed to delete course"  . mysqli_error($conn);
      }
    }
    //CREATE NEW COURSE
    if(isset($_POST['Addcourse']))
    {
    ?>
      <style media="screen">
        form.student-info
        {
          display: none;
        }
      </style>
        <form class="newCourse" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <input type="text" name= "addcrn" placeholder="insert crn" required>
          <input type="text" name= "addtitle" placeholder="insert title" required>
          <input type="text" name= "addcredit" placeholder="insert credit" required>
          <input type="text" name= "addprereq1" placeholder="insert prereq" required>
          <input type="text" name= "addprereq2" placeholder="insert prereq" required>
          <input type="text" name= "addsem" placeholder="insert sem" required>
          <input type="text" name= "addyear" placeholder="insert year" required>
          <input type="text" name= "addDept" placeholder="insert dept" required>
          <input type="submit" name="newCoursebttn" value="Add course">
        </form>
    <?php
    }
    
    //SUBMIT NEW COURSE
    if(isset($_POST["newCoursebttn"]))
    {
    ?>
      <style media="screen">
        form.student-info
        {
          display: none;
        }
      </style>
    <?php
      $query = "INSERT INTO course (courseno, name, credits, prereq1, prereq2, semester, year, dept)
          VALUES ('$_POST[addcrn]', '$_POST[addtitle]', '$_POST[addcredit]', '$_POST[addprereq1]',
          '$_POST[addprereq2]', '$_POST[addsem]', '$_POST[addyear]', '$_POST[addDept]')";
      $result = mysqli_query($conn, $query);
      if ($result)
      {
    ?>
        <span class="addSuccess">
          Added course to catalog
        </span>
    <?php
      }
      else
      {
        echo "Failed to add course";
      }
    }
    if(isset($_POST['signout']))
    {
      session_unset();
      session_destroy();
      header("Location: logout.php");
    }
?>
</body>
</html>

