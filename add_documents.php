<!DOCTYPE html>
<head>
    <title>Received Documents</title>
</head>

<body>

	<?php session_start(); 
		// if they aren't the GS, redirect them
		if ($_SESSION['role'] != 'GS') {
        	header("Location: home.php");
        	die();
    	}

    	// get the applicant the GS wants to update
    	$conn = mysqli_connect("localhost", "TheSpookyLlamas", "TSL_jjy_2019", "TheSpookyLlamas");
    	$applicants = mysqli_query($conn, "SELECT * FROM users WHERE role='A'");
		while ($row = $applicants->fetch_assoc()) {
			if (isset($_POST[$row['userID']])) {
				$_SESSION['applicantID'] = $row['userID'];
				$fname = $row['fname'];
				$lname = $row['lname'];
				$name = $fname." ".$lname;
			}
		}
		if (!$_SESSION['applicantID'])
			echo "Error: Applicant not found</br>";

		// page header info
        echo "<h2 style='text-align: center;'>Mark documents as Received</h2>
        	<h4 style='text-align: center;'>Update transcript and recommendation letter for ".$name."</h4>";
	?>

	<!-- form for GS to update documents -->
	<form align='center' action='add_documents.php' method='post'>
		Has <?php echo $name;?>'s transcript been recieved?	&nbsp
		Yes<input type='radio' name='transcript' value='yes' required>
		No<input type='radio' name='transcript' value='no'><br/>

		<br/>Has <?php echo $name;?>'s recommendation letter been received?	&nbsp
		Yes<input type='radio' name='rec' value='yes' required>
		No<input type='radio' name='rec' value='no'> <br/>

		<input type='submit' name='submitdocs' value='Submit'>
	</form>


	<?php
		// if they have submitted their answers
		if (isset($_POST['submitdocs'])) {
			print_r($_POST);

			// get the transcript and rec letter answers
			if ($_POST['transcript'] == 'yes') $tr = 1;
			else $tr = 0;
			if ($_POST['rec'] == 'yes') $rec = 1;
			else $rec = 0;

			// insert it into the database
			$q = "INSERT INTO academic_info (uid, transcript, recletter) VALUES (".$_SESSION['applicantID'].", ".$tr.", ".$rec.") ON DUPLICATE KEY UPDATE transcript=".$tr.", recletter=".$rec;
			$result = mysqli_query($conn, $q);
			if (!$result)
				die("Insert query failed: ".mysqli_error());


			// update the status 
			if ($tr == 1 && $rec == 1) {
				$q = "UPDATE app_review SET status=3 WHERE uid=".$_SESSION['applicantID'];
				mysqli_query($conn, $q);
			}
			else {
				$q = "UPDATE app_review SET status=2 WHERE uid=".$_SESSION['applicantID'];
				mysqli_query($conn, $q);
			}

			// redirect to home
			header("Location: home.php");
        	die();
		}
	?>

</body>
</html>