<?php
session_start();


	$server = "localhost";
	$username = "markeilblow";
	$password = "Mercedes01123!!";
	$servername = "markeilblow";
    echo $_SESSION["uid"];
    $zero = 0;
      // define connection variable
        $conn = mysqli_connect($server, $username, $password, $servername);
      // Check connection
        if(!$conn){
                  die("Connection failed: " . mysqli_connect_error());
         }
        //echo "Connected successfully <br/>";
//      $aQuery = "SELECT f_id FROM faculty WHERE adv = 'yes' ORDER BY rand() LIMIT 1";
//      $aResult = mysqli_query($conn, $aQuery);
//
//	$adv = '';
//      if(mysqli_num_rows($aResult) != 1)
//      {
//		echo "Advisor not added";
//	}
//	else
//	{
//		$aRow = mysqli_fetch_row($aResult);;
//		$adv = $aRow[0];
//	}

          if(isset($_POST["submit"]))
          {

		  if($_SERVER["REQUEST_METHOD"] == "POST")
		  {
			  if(empty($_POST['firstname']))
			  {
				  $fErr = "First name is required";
			  }
			  else
			  {
				  $first_name = $_POST['firstname'];
			  }
			  if(empty($_POST['lastname']))
                          {
                                  $lErr = "Last name is required";
                          }
                          else
                          {
                                  $last_name = $_POST['lastname'];
			  }
			  if(empty($_POST['middle']))
                          {
                                  $miErr = "Middle name is required";
                          }
                          else
                          {
                                  $middle = $_POST['middle'];
			  }
			  if(empty($_POST['username']))
                          {
                                  $uErr = "Username is required";
                          }
                          else
                          {
				  $u_id = $_POST['username'];
				  $length = strlen((string)$u_id);
				  if($length != 8)
				  {
					  $uErr = "Username must be 8 numbers";
				  }
				  else
				  {
					  $user_id = $_POST['username'];
				  }
			  }
			  if(empty($_POST['pswd']))
                          {
                                  $pErr = "Password is required";
                          }
                          else
                          {
                                  $pswd = $_POST['pswd'];
			  }
			  if(empty($_POST['addr']))
                          {
                                  $addErr = "Address is required";
                          }
                          else
                          {
                                  $addr = $_POST['addr'];
			  }
			  if(empty($_POST['phone']))
                          {
                                  $phErr = "Phone number is required";
                          }
                          else
                          {
                                  $phone = $_POST['phone'];
			  }
			  if(empty($_POST['degree']))
                          {
                                  $degErr = "Degree Program is required";
                          }
                          else
                          {
                                  $degree = $_POST['degree'];
			  }
			  if(empty($_POST['gradYear']))
                          {
                                  $grErr = "Graduation Year is required";
                          }
                          else
                          {
                                  $gradYear = $_POST['gradYear'];
			  }
			  if(empty($_POST['adv']))
                          {
                                  $advErr = "Advisor is required";
                          }
                          else
                          {
                                  $advisor = $_POST['adv'];
                          }
			  if(empty($_POST['donation']))
                          {
                                  $dErr = "Donation is required";
                          }
                          else
                          {
                                  $donation = $_POST['donation'];
			  }
			$query = "SELECT u_id  FROM alumni WHERE u_id ='$user_id'";
			$result = mysqli_query($conn,$query);
                	if(mysqli_num_rows($result) == 0)
			{
				$query = "SELECT u_id  FROM students WHERE u_id ='$user_id'";
				$result = mysqli_query($conn,$query);
                		if(mysqli_num_rows($result) == 0)
				{
                                        $query = "SELECT f_id  FROM faculty WHERE f_id ='$user_id'";
                                       	$result = mysqli_query($conn,$query);
					if(mysqli_num_rows($result) == 0)
                                       	{
                                               		$query = "INSERT INTO alumni (
                               				fname,
                               				minit,
			  				lname,
			  				addr,
                               				pnumber,
                               				u_id,
							pswd,
							program,
							gradYear,
							donation,
							a_id)
                               				VALUES
							('$first_name',
                                  			'$middle',
				  			'$last_name',
				  			'$addr',
                                  			'$phone',
							'$user_id',
							'$pswd',
							'$degree',
                               				'$gradYear',
							'$donation',
							'$advisor')";
                         				$result = mysqli_query($conn,$query);
		 					if($result)
		  					{
								echo "Success";
								header("Location: admin.php");
                               	  				die();
			  				}
			  				else
			  				{
			 					echo "Error". mysqli_error($conn);
		  					}

                                	}
                                	else
                                	{
                                        	echo "User ID taken. <br/>";
                                	}
                        	}
                        	else
                        	{
                                	echo "User ID taken. <br/>";
                        	}
			}
		  	else
                        {
                                echo "User ID taken. <br/>";
                        }
		}
	  }
 ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  ! "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
     <title>Create Account</title>
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
      form.signout{
        float: right;
        top: 100px;
      }
        label{
  display:inline-block;
  width:200px;
  margin-right:30px;
  text-align:right;
  }
  input{
  }
  fieldset{
  border:none;
  width:500px;
  margin:0px auto;
  }
      </style>
    </head>

  <body>
  	<div class="title">Create an Alumni</div>
<form class="signout" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="submit" value="Back" formaction="admin.php">
        <input type="submit" name="signout" value="Sign out">
</form>


    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

      <fieldset>
      <label for="firstname">First name:</label>
      <input type="text" name="firstname" /><br />

<span class="error">* <?php echo $fErr;?></span>
<br><br>

      <label for="middle">Middle Initial:</label>
      <input type="text" name="middle" /><br />
<span class="error">* <?php echo $miErr;?></span>
<br><br>

      <label for="lastname">Last name:</label>
      <input type="text" name="lastname" /><br />
<span class="error">* <?php echo $lErr;?></span>
<br><br>

      <label for="username">User ID (8 digits):</label>
      <input type="number" name="username" /><br />
<span class="error">* <?php echo $uErr;?></span>
<br><br>
      <label for="pswd">Password:</label>
      <input type="password" name="pswd" /><br />
<span class="error">* <?php echo $pErr;?></span>
<br><br>

      <label for="phone">Phone:</label>
      <input type="number" name="phone" /><br />
<span class="error">* <?php echo $phErr;?></span>
<br><br>

      <label for="addr">Address:</label>
      <input type="text" name="addr" /><br />
<span class="error">* <?php echo $addErr;?></span>
<br><br>
      <label for="degree">Degree Program:</label>
      <input type="text" name="degree" /><br />
<span class="error">* <?php echo $degErr;?></span>
<br><br>

      <label for="gradYear">Graduation Year:</label>
      <input type="number" name="gradYear" /><br />
<span class="error">* <?php echo $grErr;?></span>
<br><br>

      <label for="adv">Advisor:</label>
      <input type="number" name="adv" /><br />
<span class="error">* <?php echo $advErr;?></span>
<br><br>

      <label for="donation">Donation: $</label>
      <input type="number" name="donation" /><br />
<span class="error">* <?php echo $dErr;?></span>
<br><br>

  <input type="submit" value="Submit" name="submit" />
      </fieldset>
    </form>
  </body>
  </html>

