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
		
		.error {
			font-weight: bold;
			color: red;
		}

	</style>	
</head>

<body>

	<?php 
		session_start(); 

		// connect to the database
		$conn = mysqli_connect("localhost", "TheSpookyLlamas", "TSL_jjy_2019", "TheSpookyLlamas");
		if (!$conn) die("Connection failed: ".mysqli_connect_error());

		// if they tried to log in, verify their information
		if (isset($_POST['login'])) {
			$_SESSION['username'] = $_POST['username_login'];
			$_SESSION['id'] = $_POST['uid'];
			verify_user($conn);
		}

		// if they tried to sign up, validate data and add to database
		if (isset($_POST['signup'])) {
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['role'] = 'A';
			sign_up($conn);
		}

		// if the reset button was pressed, run commands
		if (isset($_POST['RESET'])) {
			mysqli_query($conn, "source apps_schema.sql");
			echo "reset";
		}
	?>

	<h2 style="text-align: center;">Graduate Application System</h2>
	<div class="row">
		<!-- Log in -->
		<div class="column">
			<h3>Log In</h3>
			<p>Log in to complete your application, view its satus, or see the final decision</p>
			<?php echo $_SESSION['errL']; ?><br>
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
			<p>Sign up here if you don't already have an account to begin your application</p>
			<?php echo $_SESSION['errS']; ?><br>
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

	<!-- RESET button -->
	<div align='center';>
		<form action="login.php" method="POST">
			<input type="submit" name="RESET" value="RESET">
		</form>
	</div>

	<?php
		function verify_user ($conn)
		{
			// query the database for entered username
			$query = 'SELECT role, userID, password FROM users WHERE username="'.$_SESSION['username'].'"';
			$result = mysqli_query($conn, $query);
			
			// validate the username and password
			if (mysqli_num_rows($result)<=0) {
				$_SESSION['errL'] = "<p class='error'>No users with that username. Try again:</p>";
			}
			else {
				$row = $result->fetch_assoc();
				if ($_POST['password_login'] != $row['password']) {
					$_SESSION['errL'] = "<p class='error'>Incorrect password, try again:</p>";
				}
				else if ($_SESSION['id'] != $row['userID']) {
					$_SESSION['errL'] = "<p class='error'>Incorrect ID, try again:</p>";
				}
				else {
					// direct to application page
					$_SESSION['role'] = $row['role'];
					$_SESSION['errL'] = "";
					header("Location: home.php");
					die();
				}
			}
		}

		function sign_up ($conn)
		{
            // make sure they don't already have an account
            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='".$_POST['email']."'")) > 0)
                    $_SESSION['errS'] = "<p class='error'>There is already an account with that email address, try logging in:</p>";

            // make sure username isn't taken
            else if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE username='".$_POST['username']."'")) > 0)
                    $_SESSION['errS'] = "<p class='error'>That username is taken, please select a different one:</p>";

            // make sure their passwords matched
			else if ($_POST['password'] == $_POST['password2']) {

	            // create a user id for the new account by doing max+1
	            $query = "SELECT MAX(userID) AS max FROM users";
	            $row = mysqli_query($conn, $query)->fetch_assoc();
	            $_SESSION['id'] = $row['max'] + 1;

	            // add info to the database
	            $query = "INSERT INTO users VALUES ('A', '".$_POST['fname']."', '".$_POST['lname']."', '".$_POST['username']."', '".$_POST['password']."', '".$_POST['email']."', ".$_SESSION['id'].")";
	            if (mysqli_query($conn, $query)) {
					$_SESSION['role'] = 'A';
					$_SESSION['errS'] = "";
					echo "redirect";
                    header("Location: home.php");
                    die();
            	}
                else
                    $_SESSION['errS'] = "<p class='error'>Failure creating account: ".mysqli_error()."</p>";
			}

			else 
				$_SESSION['errS'] = "<p class='error'>Passwords must match.</p>";
		}
	?>

</body>
</html>
