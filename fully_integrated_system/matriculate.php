<!DOCTYPE html>
<html>
<head>
    <title>Matriculation</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body class="gray-bg">

	<form class="menu-button" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="submit" value="Back" formaction="menu.php">
    </form>

    <h2 style='text-align:center;'>Matriculate Students</h2>
    <p style='text-align:center;'>When an accepted student's deposit has been received, mark it as such here to give them student priveleges.</p>

	<?php
        session_start();

        //connect to database
        $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        // If they don't have the correct permissions, go back to menu
        if ($_SESSION['type'] != 'secr' && $_SESSION['type'] != 'admin') {
            header("Location: menu.php");
            die();
        }

        /* Show the students that have been accepted */
        // search bar for the secretary to find applicants (NAME)
		echo "<form align='center' method='post' action='matriculate.php'>
				<input name='search' type='text'>
				<input name='nameSearch' type='submit' value='Search by name'>
			</form><br>";

		// search bar for the secretary to find applicants (UID)
		echo "<form align='center' method='post' action='matriculate.php'>
				<input name='search' type='text'>
				<input name='uidSearch' type='submit' value='Search by UID'>
			</form></br></br>";

		// start the form for checking deposits
	    echo "<form align='center' action='matriculate.php' method='post'>";

		// results from name search
		if (isset($_POST['nameSearch'])) {
			$q = "SELECT DISTINCT R.uid, status, fname, lname FROM app_review R, user U WHERE R.uid=U.uid AND status IN (6,7) AND type='App' AND (fname LIKE '%".$_POST['search']."%' OR lname LIKE '%".$_POST['search']."%')";

			$searchResult = mysqli_query($conn, $q) or die ("Error retrieving students: ".$q."<br/>".mysqli_error($conn));

			// display results
			if ($searchResult->num_rows > 0) 
				echo getTable($searchResult);
			else
				echo "<p style='text-align:center; color:red;'>There are currently no accepted students with that name.</p>";
		}

		// results from UID search
		if (isset($_POST['uidSearch'])) {
			$q = "SELECT DISTINCT R.uid, status, fname, lname FROM app_review R, user U WHERE R.uid=U.uid AND status IN (6,7) AND type='App' AND R.uid=".$_POST['search'];

			$searchResult = mysqli_query($conn, $q) or die ("Error retrieving students: ".$q."<br/>".mysqli_error($conn));

			// display results
			if ($searchResult->num_rows > 0) 
				echo getTable($searchResult);
			else
				echo "<p style='text-align:center; color:red;'>There are currently no accepted students with that UID.</p>";
		}
		

        // results from everyone
	    $result = mysqli_query($conn, "SELECT DISTINCT R.uid, status, fname, lname FROM app_review R, user U WHERE R.uid=U.uid AND type='App' AND status IN (6,7)") or die ("Error retrieving students: ".mysqli_error($conn));

	    // Show the rest of the completed applications
		if ($result->num_rows > 0) {
			echo "</table><br/>&nbsp<br/>&nbsp<br/> <h3 style='text-align:center;'>All Applicants:</h3>";
			echo getTable($result);
		}
		else 
			echo "<p style='text-align:center;'>There are currently no submitted applications.</p>";


		// end the form
		echo "<br/><input type='submit' name='submit' value='Submit'></form>";


		/* Get all the students that were marked off and change their type */
		if (isset($_POST['submit'])) {
			$ppl = mysqli_query($conn, "SELECT DISTINCT uid FROM app_review WHERE status IN (6,7)");
			for ($i=0; $i < $ppl->num_rows; $i++) {
				$row = $ppl->fetch_assoc();
				if (isset($_POST[$row['uid']])) {
					echo "<br/><p style='text-align:center;'>".$row['uid']." has been given student priveleges.</p>";
					// get what program they applied for 
					$q = "SELECT degreeType FROM academic_info WHERE uid=".$row['uid'];
					$r = mysqli_query($conn,$q) or die ("Error finding degree program: ".mysqli_error($conn));
					$row2 = $r->fetch_assoc();
					$program = $row2['degreeType'];

					// update their type
					mysqli_query($conn, "UPDATE user SET type='".$program."' WHERE uid=".$row['uid']) or die("Update type failed: ".mysqli_error($conn));
				
					// place hold on account
					mysqli_query($conn, "UPDATE user SET hold='yes' WHERE uid=".$row['uid']) or die("Update type failed: ".mysqli_error($conn));
				}
		    }
		}


        function getTable ($results)
        {
        	// start table
			$table = "<table border='1' align='center'; style='border-collapse: collapse;'>
	        	<tr><th>First Name</th><th>Last Name</th><th>Deposit Received?</th></tr>";

		    // show each applicant with a box to check if the deposit was received
			for ($i=0; $i < $results->num_rows; $i++) {
				$row = $results->fetch_assoc();

				$table .= "<tr><td>".$row['fname']."</td><td>".$row['lname']."</td>
	              	<td><input type='checkbox' name='".$row['uid']."' value='1'></td></tr>";
			}
			return $table;
        }
    ?>
</body>
</html>