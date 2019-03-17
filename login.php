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
			/*margin: 50px;*/
		}

		.column {
			text-align: center;
			flex: 50%;
			/*margin: 100px;*/
		}

		form label {  
			display: inline-block;  
			width: 150px;
			font-weight: bold;
		}

	</style>	
</head>

<body>
	<h2 style="text-align: center;">Graduate Application System</h2>
	<div class="row">
		<!-- Log in -->
		<div class="column">
			<h3>Log In</h3>
			<p>Log in to complete your application, view its satus, or see the final decision</p><br>
			<form>
				<input type="text" name="uid" placeholder="UID" required pattern="[0-9]*"><br/><br/>
				<input type="text" name="username" placeholder="Username" required><br/><br/>
				<input type="text" name="password" placeholder="Password" required><br/><br/>
				<input type="submit" name="submit" value="Log In">
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

			    <input type="submit" name="submit" value="Create Account">
			</form>
		</div>
	</div>
</body>
</html>