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
		}

	</style>	
</head>

<body>

	<?php 
		session_start(); 
		// if they tried to log in, verify their information
		if (isset($_POST['login'])) {
			$_SESSION['username'] = $_POST['username_login'];
			$_SESSION['password'] = $_POST['password_login'];
			$_SESSION['id'] = $_POST['uid'];
			verify_user();
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
			<form>
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
			$conn = mysqli_connect("localhost", TheSpookyLlamas", "TSL_jjy_2019", "TheSpookyLlamas");
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
				if ($_SESSION['uid'] != $row['userID']) {
					echo "<p>Incorrect ID, try again:</p>";
				}
				else {
					// direct to application page
					$_SESSION['role'] = $row['role'];
					echo "<p>Login successful, REDIRECT PAGE<p>"
				}
			}
		}
	?>

</body>
</html>