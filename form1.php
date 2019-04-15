<?php
          session_start();
	  echo "Student: " . $_SESSION["uid"] . "<br/>";
	$server = "localhost";
	$username = "markeilblow";
	$password = "Mercedes01123!!";
	$servername = "markeilblow";
    $conn = mysqli_connect($server, $username, $password, $servername);
	  $user = $_SESSION["uid"];

	  $first = $_SESSION["first"];
	  $middle = $_SESSION["middle"];
	  $last = $_SESSION["last"];
	  $program = $_SESSION["program"];
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
	  $one1 = $_POST['dept1'];
          $two2 = $_POST['dept2'];
          $three3 = $_POST['dept3'];
          $four4 = $_POST['dept4'];
          $five5 = $_POST['dept5'];
          $six6 = $_POST['dept6'];
          $seven7 = $_POST['dept7'];
          $eight8 = $_POST['dept8'];
          $nine9 = $_POST['dept9'];
          $ten10 = $_POST['dept10'];
          $eleven11 = $_POST['dept11'];
          $twelve12 = $_POST['dept12'];
          if(isset($_POST["submit"]))
	  {

		  if($user == $_SESSION["uid"] || $user == 0)
		  {
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
			  ('$user',
			  '$first',
			  '$middle',
			  '$last',
			  '$program',
			  '$one1',
			  'f2020',
			  '$one')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$two2',
                          'f2020',
                          '$two')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$three3',
                          'f2020',
                          '$three')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$four4',
                          'f2020',
                          '$four')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$five5',
                          'f2020',
                          '$five')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$six6',
                          'f2020',
                          '$six')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$seven7',
                          'f2020',
                          '$seven')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$eight8',
                          'f2020',
                          '$eight')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$nine9',
                          'f2020',
                          '$nine')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$ten10',
                          'f2020',
                          '$ten')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$eleven11',
                          'f2020',
                          '$eleven')";
		  $result = mysqli_query($conn,$query);
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
                          ('$user',
                          '$first',
                          '$middle',
                          '$last',
                          '$program',
                          '$twelve12',
                          'f2020',
                          '$twelve')";
                  $result = mysqli_query($conn,$query);
		  if ($result)
		  {

			  header("Location: mainPage.php ");
		  	  die();

         	  }
         	  else
         	  {
                 	echo "Error: " . $query . "<br/>" . mysqli_error($conn);
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
      body{
        background-color: grey;
      }
      div.title{
          font-family: Tahoma, Geneva, sans-serif;
          font-size: 3em;
          text-align: center;
          color: white;
          background-color: orange;
            }
      ul {
        color: orange;
        font-weight:normal;
        list-style: none;
        padding-left: 20px;
        margin: 0;
        width: 600px;
      }
      li {
        width: 150px;
        display: inline-block;
      }
      span {
        color: red;
      }
      div.suspension{
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
      div.signout{
        float: right;
      }
      label{
display:inline-block;
width:200px;
margin-right:30px;
text-align:right;
}
input{
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
    </style>
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
          $query = "SELECT * FROM course_catalog";
          $result = mysqli_query($conn, $query);
          echo "Available Courses: <br/><br/>";
        while($row = $result->fetch_assoc())
        {
                echo $row["crn"] . "    " . $row["title"] . "<br/>";
	}
?>
</div>
<div id="right_col">
<fieldset>
  <form method="post" action="mainPage.php">
    User ID (8 digits): <br/>
    <input type="text" name="tUser" /><br/>


    Course 1: <br/>
    <label for="dept1">Dept:</label>
    <input type="text" name="dept1" />
    <label for="crn1">CRN:</label>
    <input type="text" name="crn1" /><br />

    Course 2: <br/>
    <label for="dept2">Dept:</label>
    <input type="text" name="dept2" />
    <label for="crn2">CRN:</label>
    <input type="text" name="crn2" /><br />

    Course 3: <br/>
    <label for="dept3">Dept:</label>
    <input type="text" name="dept3" />
    <label for="crn3">CRN:</label>
    <input type="text" name="crn3" /><br />

    Course 4: <br/>
    <label for="dept4">Dept:</label>
    <input type="text" name="dept4" />
    <label for="crn4">CRN:</label>
    <input type="text" name="crn4" /><br />

    Course 5: <br/>
    <label for="dept5">Dept:</label>
    <input type="text" name="dept5" />
    <label for="crn5">CRN:</label>
    <input type="text" name="crn5" /><br />

    Course 6: <br/>
    <label for="dept6">Dept:</label>
    <input type="text" name="dept6" />
    <label for="crn6">CRN:</label>
    <input type="text" name="crn6" /><br />

    Course 7: <br/>
    <label for="dept7">Dept:</label>
    <input type="text" name="dept7" />
    <label for="crn7">CRN:</label>
    <input type="text" name="crn7" /><br />

    Course 8: <br/>
    <label for="dept8">Dept:</label>
    <input type="text" name="dept8" />
    <label for="crn8">CRN:</label>
    <input type="text" name="crn8" /><br />

    Course 9: <br/>
    <label for="dept9">Dept:</label>
    <input type="text" name="dept9" />
    <label for="crn9">CRN:</label>
    <input type="text" name="crn9" /><br />

    Course 10: <br/>
    <label for="dept10">Dept:</label>
    <input type="text" name="dept10" />
    <label for="crn10">CRN:</label>
    <input type="text" name="crn10" /><br />

    Course 11: <br/>
    <label for="dept11">Dept:</label>
    <input type="text" name="dept11" />
    <label for="crn11">CRN:</label>
    <input type="text" name="crn11" /><br />

    Course 12: <br/>
    <label for="dept12">Dept:</label>
    <input type="text" name="dept12" />
    <label for="crn12">CRN:</label>
    <input type="text" name="crn12" /><br />


    <input type="submit" value="Submit for Approval" name="submit" /><br/><br/>
  </form>
</fieldset>
</div>
</div>
</body>
</html>

