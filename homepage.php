<?php
	session_start();
	$user_id = $_POST['uid'];
	$pswd = $_POST['pswd'];
	$_SESSION["uid"] = $user_id;
	$server = "localhost";
	$username = "markeilblow";
	$password = "Mercedes01123!!";
	$servername = "markeilblow";
  $conn = mysqli_connect($server, $username, $password, $servername);
	if(!$conn){
		die("Connection failed: " . mysqli_connect_error());
	}
  	if(isset($_POST['reset']))
	{
		$query = "DELETE FROM form1";
		$result = mysqli_query($conn, $query);
		$query2 = "SELECT * FROM form1";
		$result2 = mysqli_query($conn, $query);
		if(mysqli_num_rows($result2) == 0)
		{
			$query = "DELETE FROM thesis_status";
			$result = mysqli_query($conn, $query);
			$query2 = "SELECT * FROM thesis_status";
			$result2 = mysqli_query($conn, $query);
			if(mysqli_num_rows($result2) == 0)
			{
	                        $query = "DELETE FROM alumni";
	                        $result = mysqli_query($conn, $query);
        	                $query2 = "SELECT * FROM alumni";
                	        $result2 = mysqli_query($conn, $query);
                        	if(mysqli_num_rows($result2) == 0)
                        	{
		                        $query = "DELETE FROM students";
		                        $result = mysqli_query($conn, $query);
                		        $query2 = "SELECT * FROM students";
                        		$result2 = mysqli_query($conn, $query);
                        		if(mysqli_num_rows($result2) == 0)
					{
			                        $query = "DELETE FROM faculty";
			                        $result = mysqli_query($conn, $query);
                        			$query2 = "SELECT * FROM faculty";
                        			$result2 = mysqli_query($conn, $query);
                        			if(mysqli_num_rows($result2) == 0)
                        			{
				                        $query = "DELETE FROM student_courses";
				                        $result = mysqli_query($conn, $query);
                        				$query2 = "SELECT * FROM student_courses";
                        				$result2 = mysqli_query($conn, $query);
                        				if(mysqli_num_rows($result2) == 0)
                        				{
					                        $query = "DELETE FROM course_catalog";
					                        $result = mysqli_query($conn, $query);
                        					$query2 = "SELECT * FROM course_catalog";
                        					$result2 = mysqli_query($conn, $query);
                        					if(mysqli_num_rows($result2) == 0)
								{
									// Name of the file
									$filename = 'advising_script.sql';
// MySQL host
									$mysql_host = 'localhost';
// MySQL username
									$mysql_username = 'visheshj123';
// MySQL password
									$mysql_password = 'Viswa123!';
// Database name
									$mysql_database = 'visheshj123';
// Connect to MySQL server
									$con = @new mysqli($mysql_host,$mysql_username,$mysql_password,$mysql_database);
// Check connection
									if ($con->connect_errno) {
    										echo "Failed to connect to MySQL: " . $con->connect_errno;
    										echo "<br/>Error: " . $con->connect_error;
									}
									// Temporary variable, used to store current query
									$templine = '';
									// Read in entire file
									$lines = file($filename);
									// Loop through each line
									foreach ($lines as $line) {
									// Skip it if it's a comment
    										if (substr($line, 0, 2) == '--' || $line == '')
        										continue;
									// Add this line to the current segment
    										$templine .= $line;
										// If it has a semicolon at the end, it's the end of the query
    										if (substr(trim($line), -1, 1) == ';') {
        										// Perform the query
        										$con->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . $con->error() . '<br /><br />');
        										// Reset temp variable to empty
        										$templine = '';
    										}
									}
									echo "Reset Successful";
									$con->close($con);
								}
							}
						}
					}
				}
			}
		}

	}
	if(isset($_POST["submit"]))
	{
	  // if(is_int($user_id))
	  // {
		$query = "SELECT u_id  FROM students WHERE u_id ='$user_id' AND pswd = '$pswd'";
		$result = mysqli_query($conn,$query);
		if(mysqli_num_rows($result) != 1)
		{
			$query = "SELECT u_id  FROM alumni WHERE u_id ='$user_id' AND pswd = '$pswd'";
			$result = mysqli_query($conn,$query);
                	if(mysqli_num_rows($result) != 1)
			{
		                $query = "SELECT f_id  FROM faculty WHERE f_id ='$user_id' AND pswd = '$pswd' AND adv = 'yes'";
                        	$result = mysqli_query($conn,$query);
                        	if(mysqli_num_rows($result) != 1)
                        	{
                                        $query = "SELECT f_id  FROM faculty WHERE f_id ='$user_id' AND pswd = '$pswd' AND admin = 'yes'";
                                	$result = mysqli_query($conn,$query);
                                	if(mysqli_num_rows($result) != 1)
                                	{
                                        	$query = "SELECT f_id  FROM faculty WHERE f_id ='$user_id' AND pswd = '$pswd' AND grad_sec = 'yes'";
                                        	$result = mysqli_query($conn,$query);
                                        	if(mysqli_num_rows($result) != 1)
                                        	{
                                                	echo "User/password combination not found. <br/>";
                                        	}
                                        	if(mysqli_num_rows($result) == 1)
                                        	{
                                                	header("Location: GradSecretary.php" );
                                                	die();
                                        	}
                                	}
                                	if(mysqli_num_rows($result) == 1)
                                	{
                                        	header("Location: admin.php");
                                        	die();
                                	}
                        	}
                        	if(mysqli_num_rows($result) == 1)
                        	{
                                	header("Location: Advisor.php");
                                	die();
                        	}
			}
			if(mysqli_num_rows($result) == 1)
        		{
                		header("Location: Alumni.php");
                		die();
        		}
		}

	  // }
	  // else
	  // {
	//	   echo "UserID must be 8 digits";
	  // }
	}
	if(mysqli_num_rows($result) == 1)
        {
                header("Location: mainPage.php");
                die();
        }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Welcome to Mini Banner</title>
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
label{
display:inline-block;
width:200px;
margin-right:30px;
text-align:right;
}
input{
}
form.reset{
float: right;
top: 100px;
}
fieldset{
border:none;
width:500px;
margin:0px auto;
}
	div.employee{
		float: right;
	}
    </style>
  </head>

<div class="title">Advising System</div>

  <form class="reset" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <input type="submit" name="reset" value="Reset">
</form>


<form method="post" action="">


	<h2>Please login.</br></br></br>


<fieldset>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">


	<label for="u_id"> User ID (8 digits): </label>
	<input type="number" name="uid" /><br />
	<label for="pswd"> Password: </label>
        <input type="password" name="pswd" /><br />
	<input type="submit" value="Login" name="submit" />
	</form>

</fieldset>


</form>
</html>

