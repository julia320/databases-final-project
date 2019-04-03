<?php

	// make connection to database
	$conn = mysqli_connect("localhost", "TheSpookyLlamas", "TSL_jjy_2019", "TheSpookyLlamas");
	if (!$conn) die("Connection failed: ".mysqli_connect_error());

	// open the sql file and read from it
	$file = fopen("apps_schema.sql", "r") or die ("File does not exist.");
	$contents = fread($file, filesize($file));

	// separate each query 
	$queries = explode(';', $contents);

	// run each query 
	foreach ($queries as $q) {
		$result = mysqli_query($conn, $q);
		if (!result)
			die ("Query failed: ".mysqli_error());
	}

	// close the file
	fclose($file);


	// go back to home
	header("Location: home.php");
    die();
?>