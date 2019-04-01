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
				$applicantID = $row['userID'];
				$fname = $row['fname'];
				$lname = $row['lname'];
				$name = $fname." ".$lname;
			}
		}
		if (!$applicantID)
			echo "Error: Applicant not found</br>";

		// page header info
        echo "<h2 style='text-align: center;'>Mark documents as Received</h2>
        	<h4 style='text-align: center;'>Update transcript and recommendation letter for ".$name."</h4>";
	?>

	<!-- form for GS to update documents -->
	<form align='center' action='add_documents.php' method='post'>
		Has <?php echo $name;?>'s transcript been recieved?	&nbsp
		Yes<input type='radio' name='transcript' value='yes'>
		No<input type='radio' name='transcript' value='no'><br/>

		<br/>Has <?php echo $name;?>'s recommendation letter been received?	&nbsp
		Yes<input type='radio' name='rec' value='yes'>
		No<input type='radio' name='rec' value='no'> <br/>

		<input type='submit' name='submitdocs' value='Submit'>
	</form>


	<?php
		// if they have submitted their answers
		if (isset($_POST['submitdocs'])) {

			// get the transcript and rec letter answers
			if ($_POST['transcript'] == 'yes') $tr = true;
			else $tr = false;
			if ($_POST['rec'] == 'yes') $rec = true;
			else $rec = false;

			// insert it into the database
			$q = "INSERT INTO app_review (uid, transcript, recletter) VALUES (".$applicantID.", ".$tr.", ".$rec.") ON DUPLICATE KEY UPDATE transcript=".$tr.", recletter=".$rec;
			$result = mysqli_query($conn, $q);
			if (!$result)
				die("Insert query failed: ".mysqli_error());
		}
	?>

</body>
</html>