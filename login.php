<!DOCTYPE html>
<html>
<head>
	<title>ARGv Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />

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

<body class="gray-bg">

	<?php 
		session_start(); 

		// connect to the database
		$conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
		if (!$conn) die("Connection failed: ".mysqli_connect_error());

		// if they tried to log in, verify their information
		if (isset($_POST['login'])) {
			$_SESSION['uid'] = $_POST['uid'];
			verify_user($conn);
		}

		// if they tried to sign up, validate data and add to database
		if (isset($_POST['signup'])) {
			$_SESSION['type'] = 'App';
			sign_up($conn);
		}
	?>

	<h2 style="text-align: center;">ARGv Login</h2>
	<div class="row">
		<!-- Log in -->
		<div class="column box green-bg">
			<h3>Log In</h3>
			<p>Log in to view your account</p>
			<?php echo $_SESSION['errL']; ?><br>
			<form method="POST" action="login.php">
				<input type="text" name="uid" placeholder="UID" required pattern="[0-9]*"><br/><br/>
				<input type="password" name="password_login" placeholder="Password" required><br/><br/>
				<input type="submit" name="login" value="Log In">
			</form>
		</div>


		<!-- Sign up -->
		<div class="column box green-bg">
			<h3>Sign Up</h3>
			<p>Sign up here to begin your application if you don't already have an account</p>
			<?php echo $_SESSION['errS']; ?><br>
			<form method="POST" action="login.php">
				<!-- <label for="fname">First name:</label> -->
				<input type="text" name="fname" placeholder="First Name" required><br/><br/>

				<!-- <label for="lname">Last name:</label> -->
				<input type="text" name="lname" placeholder="Last Name" required><br/><br/>

                <!-- <label for="ssn">SSN:</label> -->
				<input type="number" name="ssn" placeholder="SSN" required><br/><br/>

                <!-- <label for="street">Street:</label> -->
				<input type="text" name="street" placeholder="Street" required><br/><br/>

                <!-- <label for="city">City:</label> -->
				<input type="text" name="city" placeholder="City" required><br/><br/>

                <!-- <label for="state">State:</label> -->
				<input type="text" name="state" placeholder="State" required><br/><br/>

                <!-- <label for="zip">Zip:</label> -->
				<input type="text" name="zip" placeholder="Zip Code" required><br/><br/>

				<!-- <label for="email">Email:</label> -->
				<input type="text" name="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"><br/><br/>

				<!-- <label for="password">Password:</label> -->
				<input type="password" name="password" placeholder="Password" required><br/><br/>
				
				<!-- <label for="password2">Confirm Password:</label> -->
				<input type="password" name="password2" placeholder="Confirm Password" required><br/><br/>

			    <input type="submit" name="signup" value="Create Account"><br/>
			</form>
		</div>
	</div>

	<!-- RESET button -->
	<div style="text-align: center;">
		<form action="reset.php" method="POST">
			<input type="submit" name="RESET" value="RESET DATABASE">
		</form>
	</div>

	<?php
		function verify_user ($conn)
		{
			// validate password
			$query = 'SELECT type, password, fname FROM user WHERE uid="'.$_SESSION['uid'].'"';
			$result = mysqli_query($conn, $query);

			$row = $result->fetch_assoc();
			if ($_POST['password_login'] != $row['password']) {
				$_SESSION['errL'] = "<p class='error'>Incorrect password, try again:</p>";
			}
			
			else {
				// direct to application page
				$_SESSION['type'] = $row['type'];
				$_SESSION['errL'] = "";
				$_SESSION["loggedin"] = TRUE;
				$_SESSION["fname"] = $row["fname"];
				header("Location: menu.php");
				die();
			}
		}

		function sign_up ($conn)
		{
            // make sure they don't already have an account
            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user WHERE email='".$_POST['email']."'")) > 0)
		    $_SESSION['errS'] = "<p class='error'>There is already an account with that email address, try logging in:</p>";

            
            // make sure their passwords matched
			else if ($_POST['password'] == $_POST['password2']) {

	            // create a user id for the new account by doing max+1
	            $query = "SELECT MAX(uid) AS max FROM user";
	            $row = mysqli_query($conn, $query)->fetch_assoc();
	            $_SESSION['id'] = $row['max'] + 1;

	            // add info to the database
	            $query = "INSERT INTO user (type, fname, lname, ssn, street, city, state, zip, password, email, uid) VALUES ('App', '".$_POST['fname']."', '".$_POST['lname']."', '".$_POST['ssn']."', '".$_POST['street']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['zip']."', '".$_POST['password']."', '".$_POST['email']."', ".$_SESSION['id'].")";
	            //JACK: I added these additional queries when creating a user to make the app forms work properly
	            $query2 = "INSERT INTO app_review (uid, reviewerRole) VALUES (" .$_SESSION['id']. ", 'rev')";
	            $query3 = "INSERT INTO app_review (uid, reviewerRole) VALUES (" .$_SESSION['id']. ", 'cac')";	
	            if (mysqli_query($conn, $query)&&mysqli_query($conn, $query2)&&mysqli_query($conn, $query3)) {
					$_SESSION['type'] = 'App';
                    $_SESSION['errS'] = "";
                    $_SESSION["loggedin"] = TRUE;
					echo "redirect";
                    header("Location: menu.php");
                    die();
            	}
                else
                    $_SESSION['errS'] = "<p class='error'>Failure creating account: ".mysqli_error($conn)."</p>";
			}

			else 
				$_SESSION['errS'] = "<p class='error'>Passwords must match.</p>";
		}
	?>

</body>
</html>
