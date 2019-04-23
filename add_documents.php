<!DOCTYPE html>
<head>
    <title>Received Documents</title>
	<!-- <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />-->
    <link rel = "stylesheet" type="text/css" href="style.css"/> 
</head>

<body>

	<?php session_start(); 
		// if they aren't the GS, redirect them
		if ($_SESSION['type'] != 'secr') {
        	header("Location: home.php");
        	die();
    	}

    	// get the applicant the GS wants to update
    	$conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
    	$applicants = mysqli_query($conn, "SELECT * FROM user WHERE type='App'");
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


        // determine if the documents have already been received
        $result = mysqli_query($conn, "SELECT transcript, recletter FROM academic_info WHERE uid=".$_SESSION['applicantID']);
        if (!$result) 
        	echo "Error retrieving application info: ".mysqli_error();

        $row = $result->fetch_assoc();
        $transcript = $row['transcript'];
        $recletter = $row['recletter'];


        // determine which buttons to include
        if ($transcript == 1 && $recletter == 1) {
        	echo "<p style='text-align:center;'>This applicant's documents have already been received.</p>";
        	$submit = "<input type='submit' name='submit' value='Home'>";
        }
       	// rec letter not needed
        else if ($recletter == 1) {
        	$tr_button = "Has ".$name."'s transcript been recieved?	&nbsp
				Yes<input type='radio' name='transcript' value='yes' required>
				No<input type='radio' name='transcript' value='no'><br/>";
			$rec_button = "";
			$submit = "<input type='submit' name='submitdocs' value='Submit'>";
        }
        // transcript not needed
        else if ($transcript == 1) {
        	$tr_button = "";
        	$rec_button = "<br/>Has ".$name."'s recommendation letter been received?	&nbsp
				Yes<input type='radio' name='rec' value='yes' required>
				No<input type='radio' name='rec' value='no'> <br/>";
			$submit = "<input type='submit' name='submitdocs' value='Submit'>";
        }
        // if neither has been received, show both buttons
        else {
        	$tr_button = "Has ".$name."'s transcript been recieved?	&nbsp
				Yes<input type='radio' name='transcript' value='yes' required>
				No<input type='radio' name='transcript' value='no'><br/>";
			$rec_button = "<br/>Has ".$name."'s recommendation letter been received?	&nbsp
				Yes<input type='radio' name='rec' value='yes' required>
				No<input type='radio' name='rec' value='no'> <br/>";
			$submit = "<input type='submit' name='submitdocs' value='Submit'>";
        }
	?>

	<!-- form for GS to update documents -->
	<form align='center' action='add_documents.php' method='post'>
		<?php echo $tr_button;
		echo $rec_button;
		echo $submit;
		?>
		
	</form>


	<?php
		// if they didn't have anything to submit, go home
		if (isset($_POST['submit'])) {
			header("Location: home.php");
			die();
		}

		// if they have submitted their answers
		if (isset($_POST['submitdocs'])) {

			// get the transcript and rec letter answers
			if (isset($_POST['transcript'])) {
				if ($_POST['transcript'] == 'yes') 
					$tr = 1;
				else 
					$tr = 0;
			}
			else 
				$tr = $transcript; // if not changed, set it to what it alreay was

			if (isset($_POST['rec'])) {
				if ($_POST['rec'] == 'yes') 
					$rec = 1;
				else
					$rec = 0;
			}
			else 
				$rec = $recletter;

			// now figure out what the status should be
			$update_needed = true;
			if ($tr == 1 && $rec == 1)
				$status = 5; // done
			else if ($tr == 1)
				$status = 4; // waiting for rec
			else if ($rec == 1)
				$status = 3; // waiting for transcript
			else 
				$update_needed = false; // if answer was no, nothing changed

			// insert it into the database
			$q = "INSERT INTO academic_info (uid, transcript, recletter) VALUES (".$_SESSION['applicantID'].", ".$tr.", ".$rec.") ON DUPLICATE KEY UPDATE transcript=".$tr.", recletter=".$rec;
			$result = mysqli_query($conn, $q);
			if (!$result)
				die("Insert query failed: ".mysqli_error());


			// update the status 
			if ($update_needed) {
				$q = "UPDATE app_review SET status=".$status." WHERE uid=".$_SESSION['applicantID'];
				echo $q;
				$result = mysqli_query($conn, $q);
				if (!$result)
					die("Update query failed: ".mysqli_error());
			}

			// redirect to home
			header("Location: home.php");
        	die();
		}
	?>

</body>
</html>