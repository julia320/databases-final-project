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

    <h3>Upload Transcript Here:</h3>
	<form action="transcript_upload.php" method="post" enctype="multipart/form-data">
	    Select file to upload:<br>
	    <input type="file" name="transcript"><br><br>
	    <input type="submit" value="Upload" name="submit">
	</form>

	<?php 
	session_start();

	if (isset($_POST['submit'])) {
		$target_dir = "uploads/";
		$target_file = $target_dir.basename($_FILES["transcript"]["name"]);
		echo $target_file."<br/>";

		$contents= file_get_contents($_FILES['transcript']['tmp_name']);
		header("Content-Type: application/pdf");
		echo $contents;
	}

	?>

</body>
</html>