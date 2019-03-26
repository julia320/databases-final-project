<?php
  session_start();
?> 
<!DOCTYPE html>
<html>
<head>
	<title>Log In to APPS</title>
	<!--<link rel="stylesheet" type="text/css" href="style.css">
 	CSS Styling -->	
	<style>
		/* 2 columns for logging in/signing up */
		.row {
			text-align: center;
			display: flex;
		}
		.column {
			text-align: center;
			flex: 50%;
		}
		form label {  
			display: inline-block;  
			width: 150px;
			font-weight: bold;
		}login
	</style>	
</head>

<body>

	<?php 
		
		// if they tried to log in, verify their information
		if (isset($_POST['login'])) {
			$_SESSION['username'] = $_POST['username_login'];
			$_SESSION['password'] = $_POST['password_login'];
			$_SESSION['id'] = $_POST['uid'];
			verify_user();
		}
		// if they tried to sign up, validate data and add to database
		if (isset($_POST['signup'])) {
			// connect to the database
                        $conn = mysqli_connect("localhost", "sloanej", "Westland76!", "sloanej");
			if (!$conn) die("Connection failed: ".mysqli_connect_error());
			// make sure they don't already have an account
			if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='".$_POST['email']."'")) > 0)
				echo "<p>There is already an account with that email address, try logging in:</p>";
			// make sure username isn't taken
			else if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE username='".$_POST['username']."'")) > 0)
                        	echo "<p>That username is taken, please select a different one:</p>";
			// make sure their passwords matched
			else if ($_POST['password'] == $_POST['password2']) {
				// create a user id for the new account
				$query = "SELECT MAX(userID) AS max FROM users";
				$row = mysqli_query($conn, $query)->fetch_assoc();
				$id = $row['max'] + 1;
	
				// add info to the database
				$query = "INSERT INTO users VALUES ('A', '".$_POST['fname']."', '".$_POST['lname']."', '".$_POST['username']."', '".$_POST['password']."', '".$_POST['email']."', ".$id.")";
				if (mysqli_query($conn, $query)) {
					$_SESSION['role'] = 'A';
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['password'] = $_POST['password'];
					$_SESSION['id'] = $id;
					//echo "Signup successful PAGE REDIRECT";
					header("Location:application_form_general_page1.php");
					exit;
				}
				else
					echo "failure ".mysqli_error();
			}
			else echo "<p>Passwords must match.</p>";
		}
	?>

	<h2 style="text-align: center;">Graduate Application System</h2>
	<div class="row">
		<!-- Log in -->
		<div class="column">
			<h3>Log In</h3>
			<p>Log in to complete your application, view its satus, or see the final decision</p><br>
			<form method="POST" action="login.php">
				<input type="text" name="uid" placeholder="UID" required pattern="[0-9]*"><br/><br/>
				<input type="text" name="username_login" placeholder="Username" required><br/><br/>
				<input type="text" name="password_login" placeholder="Password" required><br/><br/>
				<input type="submit" name="login" value="Log In">
			</form>
		</div>


		<!-- Sign up -->
		<div class="column">
			<h3>Sign Up</h3>
			<p>Sign up here if you don't already have an account to begin your application</p><br>
			<form method="POST" action="login.php">
				<label for="fname">First name:</label>
				<input type="text" name="fname" required><br/><br/>

				<label for="lname">Last name:</label>
				<input type="text" name="lname" required><br/><br/>

				<label for="email">Email:</label>
				<input type="text" name="email" required><br/><br/>

				<label for="username">Username:</label>
				<input type="text" name="username" required><br/><br/>

				<label for="password">Password:</label>
				<input type="text" name="password" required><br/>
				
				<label for="password2">Confirm Password:</label>
				<input type="text" name="password2" required><br/><br/>

			    	<input type="submit" name="signup" value="Create Account">
			</form>
		</div>
	</div>

	<?php
		function verify_user()
		{
			// connect to the database
            $conn = mysqli_connect("localhost", "sloanej", "Westland76!", "sloanej");
			if (!$conn) die("Connection failed: ".mysqli_connect_error());
			// query the database for entered username
			$query = 'SELECT role, userID, password FROM users WHERE username="'.$_SESSION['username'].'"';
			$result = mysqli_query($conn, $query);
			
			// validate the username and password
			if (mysqli_num_rows($result)<=0) {
				echo "<p>No users with that username. Try again:</p>";
			}
			else {
				$row = $result->fetch_assoc();
				if ($_SESSION['password'] != $row['password']) {
					echo "<p>Incorrect password, try again:</p>";
				}
				else if ($_SESSION['id'] != $row['userID']) {
					echo "<p>Incorrect ID, try again:</p>";
				}
				else {
					// direct to application page
					$_SESSION['role'] = $row['role'];
					//"<p>Login successful, REDIRECT PAGE<p>";
					header("Location:application_form_general_page1.php");
					exit;
				}
			}
		}
	?>

</body>
</html>
