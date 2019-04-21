<?php

  //START SESSION
  session_start();
  
  //CHECK FOR CORRECT USER
  echo "Student: " . $_SESSION["uid"] . "<br/>";
  
  //CONNECT TO SERVER
  /*$server = "localhost";
	$username = "ARGv";
	$password = "CSCI2541_sp19";
	$servername = "ARGv";
  $conn = mysqli_connect($server, $username, $password, $servername);*/
  $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
   
    //SET VARIABLES FOR INSERT
    $user = $_SESSION["uid"];
    $tUser = $_POST["tUser"];
	  $first = "";
	  $last = "";
    $program = "";

    //GETS NAME & PROGRAM FROM USER table
    $query = "SELECT * FROM user WHERE uid = '$user'";
    $result = mysqli_query($conn,$query);       
    if (mysqli_num_rows($result) != 0)
    {
      while($row = $result->fetch_assoc())
      {
        $first = $row["fname"];
        $last = $row["lname"];
        $program = $row["type"];
      }
    }


    //CRN VARIABLES
	  $one = $_POST['crn1'];
	  $two = $_POST['crn2'];
	  $three = $_POST['crn3'];
	  $four = $_POST['crn4'];
	  $five = $_POST['crn5'];
	  $six = $_POST['crn6'];
	  $seven = $_POST['crn7'];
	  $eight = $_POST['crn8'];
	  $nine = $_POST['crn9'];
	  $ten = $_POST['crn10'];
	  $eleven = $_POST['crn11'];
    $twelve = $_POST['crn12'];

    //DEPARTMENT VARIABLES
    $dept1 = $_POST['dept1'];
	  $dept2 = $_POST['dept2'];
	  $dept3 = $_POST['dept3'];
	  $dept4 = $_POST['dept4'];
	  $dept5 = $_POST['dept5'];
	  $dept6 = $_POST['dept6'];
	  $dept7 = $_POST['dept7'];
	  $dept8 = $_POST['dept8'];
	  $dept9 = $_POST['dept9'];
	  $dept10 = $_POST['dept10'];
	  $dept11 = $_POST['dept11'];
    $dept12 = $_POST['dept12'];

    //COURSENO VARIABLES
    $cno1 = $_POST['cno1'];
	  $cno2 = $_POST['cno2'];
	  $cno3 = $_POST['cno3'];
	  $cno4 = $_POST['cno4'];
	  $cno5 = $_POST['cno5'];
	  $cno6 = $_POST['cno6'];
	  $cno7 = $_POST['cno7'];
	  $cno8 = $_POST['cno8'];
	  $cno9 = $_POST['cno9'];
	  $cno10 = $_POST['cno10'];
	  $cno11 = $_POST['cno11'];
    $cno12 = $_POST['cno12'];
    
    //IF THE USER CLICKS SUBMIT
    if(isset($_POST["submit"]))
	  {
      //IF THE ENTERED USERID IS CORRECT
		  if($user == $_SESSION["uid"])
		  {

        //IF TRYING TO SUBMIT FORM FOR PHD
        if($program == 'PHD')
        {
          $cs = 0;
          //CHECK FOR NUMBER OF CS COURSES
          if($dept1 == "CSCI")
          {
            $cs++;
          }
          if($dept2 == "CSCI")
          {
            $cs++;
          }
          if($dept3 == "CSCI")
          {
            $cs++;
          }
          if($dept4 == "CSCI")
          {
            $cs++;
          }
          if($dept5 == "CSCI")
          {
            $cs++;
          }
          if($dept6 == "CSCI")
          {
            $cs++;
          }
          if($dept7 == "CSCI")
          {
            $cs++;
          }
          if($dept8 == "CSCI")
          {
            $cs++;
          }
          if($dept9 == "CSCI")
          {
            $cs++;
          }
          if($dept10 == "CSCI")
          {
            $cs++;
          }
          if($dept11 == "CSCI")
          {
            $cs++;
          }
          if($dept12 == "CSCI")
          {
            $cs++;
          }

          if($cs >= 10)
          {
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$one')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$two')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$three')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$four')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$five')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$six')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$seven')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              program,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$eight')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$nine')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$ten')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$eleven')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
              u_id,
              fname,      
              lname,
              crn)
              VALUES
              ('$user',
              '$first',
              '$last',
              '$twelve')";
            $result = mysqli_query($conn,$query);
            
            //CHECK FORM1 TABLE FOR CORRECT NUMBER OF CREDITS
            $test = "SELECT * FROM form1 WHERE u_id = '$user'";
            $testR = mysqli_query($conn,$test);
            if ($testR->num_rows > 9 && $testR->num_rows < 13) 
            {
			        header("Location: mainPage.php ");
		  	      die();
            }
            //ERROR OTHER WISE
            else
            {
              echo "Your plan does not meet the requirements for the MS degree";
              echo "Error: " . $query . "<br/>" . mysqli_error($conn);
		        }
          } 
        }

        //FORM FOR MS
        else if($program == 'MS')
        {
          //CHECKS FOR CORE CLASSES
          if($dept1 == "CSCI" && ($cno1 == 6212 || $cno1 == 6221 ||$cno1 == 6461))
          {
            $core++;
          }
          if($dept2 == "CSCI" && ($cno2 == 6212 || $cno2 == 6221 ||$cno2 == 6461))
          {
            $core++;
          }
          if($dept3 == "CSCI" && ($cno3 == 6212 || $cno3 == 6221 ||$cno3 == 6461))
          {
            $core++;
          }
          if($dept4 == "CSCI" && ($cno4 == 6212 || $cno4 == 6221 ||$cno4 == 6461))
          {
            $core++;
          }
          if($dept5 == "CSCI" && ($cno5 == 6212 || $cno5 == 6221 ||$cno5 == 6461))
          {
            $core++;
          }
          if($dept6 == "CSCI" && ($cno6 == 6212 || $cno6 == 6221 ||$cno6 == 6461))
          {
            $core++;
          }
          if($dept7 == "CSCI" && ($cno7 == 6212 || $cno7 == 6221 ||$cno7 == 6461))
          {
            $core++;
          }
          if($dept8 == "CSCI" && ($cno8 == 6212 || $cno8 == 6221 ||$cno8 == 6461))
          {
            $core++;
          }
          if($dept9 == "CSCI" && ($cno9 == 6212 || $cno9 == 6221 ||$cno9 == 6461))
          {
            $core++;
          }
          if($dept10 == "CSCI" && ($cno10 == 6212 || $cno10 == 6221 ||$cno10 == 6461))
          {
            $core++;
          }
          if($dept11 == "CSCI" && ($cno11 == 6212 || $cno11 == 6221 ||$cno11 == 6461))
          {
            $core++;
          }
          if($dept12 == "CSCI"&& ($cno12 == 6212 || $cno12 == 6221 ||$cno12 == 6461))
          {
            $core++;
          }

          //CHECKS FOR NON-CS CLASSES
          if($dept1 != "CSCI")
          {
            $nocs++;
          }
          if($dept2 != "CSCI")
          {
            $nocs++;
          }
          if($dept3 != "CSCI")
          {
            $nocs++;
          }
          if($dept4 != "CSCI")
          {
            $nocs++;
          }
          if($dept5 != "CSCI")
          {
            $nocs++;
          }
          if($dept6 != "CSCI")
          {
            $nocs++;
          }
          if($dept7 != "CSCI")
          {
            $nocs++;
          }
          if($dept8 != "CSCI")
          {
            $nocs++;
          }
          if($dept9 != "CSCI")
          {
            $nocs++;
          }
          if($dept10 != "CSCI")
          {
            $nocs++;
          }
          if($dept11 != "CSCI")
          {
            $nocs++;
          }
          if($dept12 != "CSCI")
          {
            $nocs++;
          }

          //IF FORM MEETS THE REQUIREMENTS, INSERT INTO TABLE
          if($core == 3 && $nocs < 3)
          {
            $query = "INSERT INTO form1(
                          u_id,
                          fname,
                          lname,
                          crn)
                          VALUES
                          ('$user',
                          '$first',
                          '$last',
                          '$one')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                          u_id,
                          fname,
                          lname,
                          crn)
                          VALUES
                          ('$user',
                          '$first',
                          '$last',
                          '$two')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                      u_id,
                      fname,
                      lname,
                      crn)
                      VALUES
                      ('$user',
                      '$first',
                      '$last',
                      '$three')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                      u_id,
                      fname,
                      lname,
                      crn)
                      VALUES
                      ('$user',
                      '$first',
                      '$last',
                      '$four')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                      u_id,
                      fname,
                      lname,
                      crn)
                      VALUES
                      ('$user',
                      '$first',
                      '$last',
                      '$five')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                      u_id,
                      fname,
                      lname,
                      crn)
                      VALUES
                      ('$user',
                      '$first',
                      '$last',
                      '$six')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                      u_id,
                      fname,
                      lname,
                      crn)
                      VALUES
                      ('$user',
                      '$first',
                      '$last',
                      '$seven')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                      u_id,
                      fname,
                      lname,
                      program,
                      crn)
                      VALUES
                      ('$user',
                      '$first',
                      '$last',
                      '$eight')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                      u_id,
                      fname,
                      lname,
                      crn)
                      VALUES
                      ('$user',
                      '$first',
                      '$last',
                      '$nine')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                      u_id,
                      fname,
                      lname,
                      crn)
                      VALUES
                      ('$user',
                      '$first',
                      '$last',
                      '$ten')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                      u_id,
                      fname,
                      lname,
                      crn)
                      VALUES
                      ('$user',
                      '$first',
                      '$last',
                      '$eleven')";
            $result = mysqli_query($conn,$query);
            $query = "INSERT INTO form1(
                      u_id,
                      fname,      
                      lname,
                      crn)
                      VALUES
                      ('$user',
                      '$first',
                      '$last',
                      '$twelve')";
            $result = mysqli_query($conn,$query);

            //CHECK FOR CORRECT NUMBER OF CREDITS
            $test = "SELECT * FROM form1 WHERE u_id = '$user'";
            $testR = mysqli_query($conn,$test);
            if ($testR->num_rows > 9 && $testR->num_rows < 13) 
            {
              header("Location: mainPage.php ");
              die();
            }
            //ERROR OTHER WISE
            else
            {
              echo "Error: " . $query . "<br/>" . mysqli_error($conn);
              echo "Your plan does not meet the requirements for the MS degree";
            }       
          }
        }
	    }
	  }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
   <title>Form 1</title>
    <style type = "text/css">
      body
      {
        background-color: grey;
      }
      div.title
      {
          font-family: Tahoma, Geneva, sans-serif;
          font-size: 3em;
          text-align: center;
          color: white;
          background-color: orange;
      }
      ul 
      {
        color: orange;
        font-weight:normal;
        list-style: none;
        padding-left: 20px;
        margin: 0;
        width: 600px;
      }
      li 
      {
        width: 150px;
        display: inline-block;
      }
      span 
      {
        color: red;
      }
      div.suspension
      {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin:auto;
        text-align: center;
        width: 200px;
        height: 200px;
        color: orange;
        font-weight: bold;
      }
      div.signout
      {
        float: right;
      }
      label
      {
        display:inline-block;
        width:200px;
        margin-right:30px;
        text-align:right;
      }
      input
      {
      }
      #wrap 
      {
        width:1000px;
        margin:0 auto;
      }
      #left_col 
      {
        float:left;
        width:500px;
      }
      #right_col 
      {
        float:right;
        width:500px;
      }
    </style>
    <!-- <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/> -->
  </head>

<body>
        <div class="title">Form 1</div>
  <p>Please enter your graduation plan.</p>
  
  <p>For the MS program, your plan must include the following:<br>
  	*3 core courses required for MS: CSCI 6212, CSCI 6221, and CSCI 6461<br>
	  *at least 30 credit hours of coursework<br>
	  *at most 2 courses outside the CS department as part of the 30 hours of coursework</p>

  <p>For the PhD program, your plan must include the following:<br>
        *at least 36 credit hours of coursework, with at least 30 from the CS department<br>
        *a thesis defense</p>
   <div id="wrap">
    <div id="left_col">
<?php
//CHANGED TO ARGV SQL
          $query = "SELECT * FROM course";
          $result = mysqli_query($conn, $query);
          echo "Available Courses: <br/><br/>";
        while($row = $result->fetch_assoc())
        {
                echo $row["courseno"] . "    " . $row["name"] . " " . $row["crn"] . "<br/>";
	      }
?>
    </div>
    <div id="right_col">
<fieldset>
  <form method="post">
    User ID (8 digits): <br/>
    <input type="text" name="tUser" /><br/>


    Course 1: <br/>
    <label for="dept1">Dept:</label>
    <input type="text" name="dept1" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno1" />
    <label for="crn1">CRN:</label>
    <input type="text" name="crn1" /><br />


    Course 2: <br/>
    <label for="dept2">Dept:</label>
    <input type="text" name="dept2" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno2" />
    <label for="crn2">CRN:</label>
    <input type="text" name="crn2" /><br />

    Course 3: <br/>
    <label for="dept3">Dept:</label>
    <input type="text" name="dept3" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno3" />
    <label for="crn3">CRN:</label>
    <input type="text" name="crn3" /><br />

    Course 4: <br/>
    <label for="dept4">Dept:</label>
    <input type="text" name="dept4" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno4" />
    <label for="crn4">CRN:</label>
    <input type="text" name="crn4" /><br />

    Course 5: <br/>
    <label for="dept5">Dept:</label>
    <input type="text" name="dept5" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno5" />
    <label for="crn5">CRN:</label>
    <input type="text" name="crn5" /><br />

    Course 6: <br/>
    <label for="dept6">Dept:</label>
    <input type="text" name="dept6" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno6" />
    <label for="crn6">CRN:</label>
    <input type="text" name="crn6" /><br />

    Course 7: <br/>
    <label for="dept7">Dept:</label>
    <input type="text" name="dept7" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno7" />
    <label for="crn7">CRN:</label>
    <input type="text" name="crn7" /><br />

    Course 8: <br/>
    <label for="dept8">Dept:</label>
    <input type="text" name="dept8" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno8" />
    <label for="crn8">CRN:</label>
    <input type="text" name="crn8" /><br />

    Course 9: <br/>
    <label for="dept9">Dept:</label>
    <input type="text" name="dept9" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno9" />
    <label for="crn9">CRN:</label>
    <input type="text" name="crn9" /><br />

    Course 10: <br/>
    <label for="dept10">Dept:</label>
    <input type="text" name="dept10" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno10" />
    <label for="crn10">CRN:</label>
    <input type="text" name="crn10" /><br />

    Course 11: <br/>
    <label for="dept11">Dept:</label>
    <input type="text" name="dept11" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno11" />
    <label for="crn11">CRN:</label>
    <input type="text" name="crn11" /><br />

    Course 12: <br/>
    <label for="dept12">Dept:</label>
    <input type="text" name="dept12" />
    <label for="crn1">Course No:</label>
    <input type="text" name="cno12" />
    <label for="crn12">CRN:</label>
    <input type="text" name="crn12" /><br />

    <input type="submit" value="Submit for Approval" name="submit" /><br/><br/>
  </form>
</fieldset>
  </div>
</div>
</body>
</html>

