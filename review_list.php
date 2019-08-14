<!DOCTYPE html>
<head>
    <title>List of Reviews</title>
	<link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/> 
</head>

<body>

	<?php
	session_start();

	// connect to mysql
	$conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	//"back to menu" button
	echo "<div style=\"display: inline-block;\" class=\"menu-button\">";
	echo "<form action=\"menu.php\"><input type=\"submit\" value=\"Menu\"/></form></div>";

	// Get the student whose reviews we are looking at 
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

	echo "<h3>List of reviews for ".$name."</h3>";


	// View all reviews for that student
	$q = "SELECT user.uid, lname, reviewer, rating FROM user, app_review WHERE user.uid=reviewer AND type LIKE '%rev%' AND app_review.uid=".$_SESSION['applicantID'];
	$reviews = mysqli_query($conn, $q) or die ("Error: line 120");
	while ($row = $reviews->fetch_assoc()) {
		// if a review has been made, show the button
		if ($row['rating'] != NULL) {
			echo "<form action='view_faculty_review.php' method='post'>
			<input type='submit' name=".$row['uid']." value=\"".$row['lname']."'s Review\">
			</form>";
		}
	}

	// home button
	echo "<form action='home.php' method='post'>
			<input type='submit' name='home' value='Back'>
		</form>";
	?>
</body>