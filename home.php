<!DOCTYPE html>
<head>
    <title>APPS Home Page</title>
</head>

<body>
	<?php
        session_start();

        if (!isset($_SESSION['role'])) {
        	header("Location: login.php");
        	die();
    	}

        // connect to the database
		$conn = mysqli_connect("localhost", "TheSpookyLlamas", "TSL_jjy_2019", "TheSpookyLlamas");

		// if no role is set, need to go all the way back to log in page
		if (!isset($_SESSION['role'])) {
	        header("Location: login.php");
	        die();
	    }

        // if user is an applicant, show their status
        if ($_SESSION['role'] == "A") {

        	// page header info
        	echo "<h2 style='text-align: center;'>Applicant Home Page</h2>
        		<h4 style='text-align: center;'>Complete your application or view its status here</h4>";

			// find status of the applicant
			$result = mysqli_query($conn, "SELECT uid, status FROM app_review WHERE uid=".$_SESSION['id']);
			$row = $result->fetch_assoc();
			
			echo "<p style='text-align: center;'><strong>Status: </strong>";

			// if their application is incomplete
			if (!isset($row['status']) || $row['status'] == 1) {
				echo "Application incomplete</p>";
				echo "<form align='center' action='application_form.php' method='post'>
	    				<input type='submit' value='Finish Application'>
					  </form>";
			}

			// if transcript and rec letter are needed
			else if ($row['status'] == 2) {
				echo "Your application is pending</p>";
				echo "<p style='text-align: center;'>We are still waiting to receive your transcript and recommendation letter, please check back later.</p>";
				echo "<form align='center' action='application_view_form.php' method='post'>
	    				<input type='submit' value='View Application'>
					  </form>"; 
			}

			// if their application is complete
			else if ($row['status'] == 3) {
				echo "Your application is complete!</p>";
				echo "<p style='text-align: center;'>Refer back to this page frequently to see when a decision has been made.</p>";
				echo "<form align='center' action='application_view_form.php' method='get'>
	    				<input type='submit' name='".$row['userID']."' value='View Application'>
					  </form>"; 
			}

			// if they were admitted
			else if ($row['status'] == 4 || $row['status'] == 5) {
				echo "Congratulations!</p>";
				echo "<p style='text-align: center;'>We are happy to inform you that you have been selected for admission to this school! </p>";

				// should we list their advisor here and if they got aid?
				if ($row['status'] == 5) {
					echo "<p style='text-align: center;'>You have also been selected for financial aid, please speak to our office about that.</p>";
				}
			}

			// if they were rejected
			else if ($row['status'] == 6) {
				echo "</p>";
				echo "<p style='text-align: center;'>We regret to inform you that you have not been chosen as a potential student for this school.</p>";
			}

			else 
				echo "Error: we could not find any information for this user</p><br/>";

		}// end-applicant view


		// if the user is a reviewer, show them the list of applicants
		if ($_SESSION['role'] == "FR" || $_SESSION['role'] == "CAC") {

			// page header info
        	echo "<h2 style='text-align: center;'>Reviewer Home Page</h2>
        		<h4 style='text-align: center;'>View completed applications and review them here</h4>";

			// get all the applicants whose application is complete
			$result = mysqli_query($conn, "SELECT userID, fname, lname FROM users, app_review WHERE status=3 AND userID=uid");

			// the button will go to a different place based on role
			if ($_SESSION['role'] == "FR")
				$button = "<form action='application_form_review.php' method='post'>
	    						<input type='submit' name='".$row['userID']."' value='Review Application'>
					  		</form>";
			else 
				$button = "<form action='application_form_review_CAC.php' method='post'>
	    						<input type='submit' name='".$row['userID']."' value='Review Application'>
					  		</form>";

			//$result = mysqli_query($conn, "SELECT fname, lname, userID FROM users WHERE userID IN (SELECT uid FROM academic_info)");	//changed machanism
			// $result2 = mysqli_query($conn, "SELECT * FROM app_review");
			// if (mysqli_num_rows($result2) == 0){


			// start table
			echo "<table border='1' align='center'; style='border-collapse: collapse;'>
	            	<tr>
	                	<th>First Name</th>
		                <th>Last Name</th>
		                <th></th>
					</tr>";

			// show each applicant with a button to the review page
			for ($i=0; $i < $result->num_rows; $i++) {
				$row = $result->fetch_assoc();
				echo "<tr>
                    	<td>".$row['fname']."</td>
	                    <td>".$row['lname']."</td>
	                    <td>".$button."</td>
	                </tr>";
			}
		}// end-reviewer view


		// if the user is a Grad Secretary, let them mark when transcripts/rec letters are received
		else if ($_SESSION['role'] == "GS") {

			// header information
			echo "<h2 style='text-align: center;'>Graduate Secretary Home Page</h2>
        		<h4 style='text-align: center;'>When an applicant's documents have been received, mark them as such here</h4>";

			// get all the applicants whose application is complete
			$result = mysqli_query($conn, "SELECT userID, fname, lname FROM users WHERE role='A'");

			// start table
			echo "<table border='1' align='center'; style='border-collapse: collapse;'>
	            	<tr>
	                	<th>First Name</th>
		                <th>Last Name</th>
		                <th></th>
					</tr>";

			// show each applicant with a button to the review page
			for ($i=0; $i < $result->num_rows; $i++) {
				$row = $result->fetch_assoc();
				echo "<tr>
	                	<td>".$row['fname']."</td>
	                    <td>".$row['lname']."</td>
	                    <td><form action='add_documents.php' method='post'>
	    						<input type='submit' name='".$row['userID']."' value='Mark documents as Received'>
					  		</form>
					  	</td>
	                </tr>";
			}
		}// end-Grad secretary view
    ?>

</body>
</html>
