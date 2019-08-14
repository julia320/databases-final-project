<!DOCTYPE html>
<html>
<head>
	<title>Upload Transcript</title>
	<link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>
<body>

	<div style="display: inline-block;" class="menu-button">
        <form action="menu.php"><input type="submit" value="Menu"/></form>
    </div><br><br>

	<?php 
	session_start();
	$conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

	// if they haven't filled out their application yet, make them
	$q = "SELECT status FROM app_review WHERE uid=".$_SESSION['uid'];
	$result = mysqli_query($conn, $q);
	$row = $result->fetch_assoc();
	if ($row['status'] < 2) {
		echo "<p style='color:red;'>Please return to the menu and complete your application before uploading a transcript.</p>";
	}
	else {
		echo '<h3>Upload Transcript Here:</h3>
		<form action="transcript_upload.php" method="post" enctype="multipart/form-data">
		    Select file to upload:<br>
		    <input type="file" name="transcript"><br><br>
		    <input type="submit" value="Upload" name="submit">
		</form>';
	}

	if (isset($_POST['submit'])) {
		$target_dir = "uploads/";
		$target_file = $target_dir.basename($_FILES["transcript"]["name"]);

		$contents= file_get_contents($_FILES['transcript']['tmp_name']);

		if ($_FILES['transcript']['size'] > 1000000)
        	die("<p style='color:red;'>Exceeded filesize limit.</p>");

		// use prepared statement to escape quotes, etc in the file
		$query = mysqli_prepare($conn, "UPDATE academic_info SET transcript_doc=?");
		mysqli_stmt_bind_param($query, "s", $contents);
		mysqli_stmt_execute($query) or die ("<p style='color:red;'>Error uploading file: ".mysqli_error($conn)."</p>");


		/* Update transcript value and status */
		// Check if the rec letter was already received
		$result = mysqli_query($conn, "SELECT recletter FROM academic_info WHERE uid=".$_SESSION['uid']);
	    if (!$result) echo "Error retrieving application info: ".mysqli_error();
	    $row = $result->fetch_assoc();
	    $rec = $row['recletter'];

	    // Mark transcript as received
		mysqli_query($conn, "UPDATE academic_info SET transcript=1 WHERE uid=".$_SESSION['uid']);

		// if they have the letter, then it is now complete
	    if ($rec == 1) 
	      mysqli_query($conn, "UPDATE app_review SET status=5 WHERE uid=".$_SESSION['uid']) or die ("Update status failed: ".mysqli_error($conn));

	    // if letter is missing, status is now 4
	    else 
	      mysqli_query($conn, "UPDATE app_review SET status=4 WHERE uid=".$_SESSION['uid']) or die ("Update status failed: ".mysqli_error($conn));

		echo "<p>File uploaded sucessfully! You may now return to the home page to check your status.</p>";
	}

	?>

</body>
</html>