<!DOCTYPE html>
<html>
<head>
	<title>Update Final Decision</title>
	<link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>
<body>

	<?php session_start();

		// if they aren't the GS, redirect them
		if ($_SESSION['type'] != 'secr') {
        	header("Location: home.php");
        	die();
    	}

		// connect to mysql
		$conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		// if something was already submitted
		if (isset($_POST['home'])) {
			header("Location: home.php");
        	die();
		}
		else if (isset($_POST['submit'])) {
			if ($_POST['decision'] == 'Reject') {
				$r = mysqli_query($conn,"UPDATE app_review SET status=8 WHERE uid=".$_SESSION['applicantID']);
				if (!$r)
					echo "Error: ".mysqli_error();
			}
			else if ($_POST['decision']=='Borderline Admit' || $_POST['decision']=='Admit Without Aid') {
				$r = mysqli_query($conn,"UPDATE app_review SET status=6 WHERE uid=".$_SESSION['applicantID']);
				if (!$r)
					echo "Error: ".mysqli_error();
			}
			else if ($_POST['decision'] == 'Admit With Aid') {
				$r = mysqli_query($conn,"UPDATE app_review SET status=7 WHERE uid=".$_SESSION['applicantID']);
				if (!$r)
					echo "Error: ".mysqli_error();
			}
			header("Location: home.php");
        	die();
		}

		// get the applicant the GS wants to update
		$applicants = mysqli_query($conn, "SELECT * FROM user WHERE type='App'");
		while ($row = $applicants->fetch_assoc()) {
			if (isset($_POST[$row['uid']])) {
		    	$_SESSION['applicantID'] = $row['uid'];
		      	$fname = $row['fname'];
		      	$lname = $row['lname'];
		      	$name = $fname." ".$lname;
		   	}
		}
		 
		if (!$_SESSION['applicantID'])
			echo "Error: Applicant not found</br>";


		// header info
		echo "<h2>Final decision for ".$name."</h2>";

		// Get the decision made by the CAC 
		$q = "SELECT status FROM app_review WHERE uid=".$_SESSION['applicantID']." AND reviewerRole='cac'";
		$result = mysqli_query($conn, $q);
		$row = $result->fetch_assoc();

		// if no decision made, give them the option of viewing the application
		if ($result->num_rows == 0 || $row['status'] < 4) {
			echo "<p>The CAC has not reviewed this application yet, but you may still view the application and make a final decision.</p><br/>";

			// button to view the application
			echo "<form action='application_view_form.php' method='post'>
				<input type='submit' name='".$_SESSION['applicantID']."' value='View application'>
				</form><br/>";
		}

		// if CAC has reviewed, show the final decision
		else {
			if ($row['status'] == 6) 
				echo "<p>The final decision made by the CAC was to admit without aid</p>";
			else if ($row['status'] == 7) 
				echo "<p>The final decision made by the CAC was to admit with aid</p>";
			else if ($row['status'] == 8) 
				echo "<p>The final decision made by the CAC was to reject the student</p>";
			else 
				echo "<p>Error: The CAC made a review but an invalid decision is stored</p>";
		}

		// now have the option to change the final decision
		echo "<br/><br/><p>Update the final decision (not required):</p>";
		echo "<form action='final_decision.php' method='post'>
				Reject:<input type='radio' name='decision' value='Reject'><br/>
				Borderline Admit:<input type='radio' name='decision' value='Borderline Admit'><br/>
				Admit Without Aid:<input type='radio' name='decision' value='Admit Without Aid'><br/>
				Admit With Aid:<input type='radio' name='decision' value='Admit With Aid'><br/>
				<input type='submit' name='submit' value='Submit'><br/><br/>
			</form>";


		// home button
		echo "<form action='home.php' method='post'>
				<input type='submit' name='home' value='Back to Home'>
			</form>";

	?>

</body>
</html>