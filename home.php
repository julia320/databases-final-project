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

        // if user is an applicant, show their status
        if ($_SESSION['role'] == "A") {

        	// page header info
        	echo "<h2 style='text-align: center;'>Applicant Home Page</h2>
        		<h4 style='text-align: center;'>Complete your application or view its status here</h4>";

			// find status of the applicant
			$result = mysqli_query($conn, "SELECT uid FROM academic_info WHERE uid=".$_SESSION['id']);
			if (mysqli_num_rows($result) == 0){
				echo "<p style='text-align: center;'><strong>Status: </strong>";
				echo "Application incomplete</p>";
				echo "<form align='center' action='application_form.php' method='get'>
		    				<input type='submit' value='Apply'>
						  </form>";
			}
			else{
				$result = mysqli_query($conn, "SELECT status FROM app_review WHERE uid=".$_SESSION['id']);	//altered query
				if (mysqli_num_rows($result) == 0){
					echo "<p style='text-align: center;'><strong>Status: </strong>";
					echo "Your application has not yet been reviewed</p>";
					echo "<p style='text-align: center;'> Refer back to this page frequently to see when a decision has been made.</p>";
				}
				else{
					$row = $result->fetch_assoc();
					if ($row['status'] == 3 || $row['status'] == 2) {	 	//change from 1 to 3
						echo "<p style='text-align: center;'><strong>Status: </strong>";
						echo "Your application is complete!</p>";
						echo "<p style='text-align: center;'>Refer back to this page frequently to see when a decision has been made.</p>";
					}
					if ($row['status'] == 4) {
						echo "<p style='text-align: center;'><strong>Status: </strong>";
						echo "Congratulations! You have been admitted.</p>";
						
					}
					if ($row['status'] == 5) {
						echo "<p style='text-align: center;'><strong>Status: </strong>";
						echo "Congratulations! You have been admitted with aid.</p>";
					}
					if ($row['status'] == 6) {
						echo "<p style='text-align: center;'><strong>Status: </strong>";
						echo "Sorry You have been rejected.</p>";
					}
				}
			}
		}// end-applicant view


		// if the user is a reviewer, show them the list of applicants
		if ($_SESSION['role'] == "FR" || $_SESSION['role'] == "CAC") {

			// page header info
        	echo "<h2 style='text-align: center;'>Reviewer Home Page</h2>
        		<h4 style='text-align: center;'>View completed applications and review them here</h4>";

			// get all the applicants whose application is complete
			$result = mysqli_query($conn, "SELECT fname, lname, userID FROM users WHERE userID IN (SELECT uid FROM academic_info)");	//changed machanism
			

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
			if ($_SESSION['role'] == "FR"){		//add these 2 if statements
				for ($i=0; $i < $result->num_rows; $i++) {
					$row = $result->fetch_assoc();
					$_SESSION_['id'] = $row['userID'];
					echo "<tr>
	                    	<td>".$row['fname']."</td>
		                    <td>".$row['lname']."</td>
		                    <td><form action='application_form_review.php' method='post'>	
		    						<input type='submit' name='".$_SESSION['id']."' value='Review Application'>
						  		</form>
						  	</td>
		                </tr>";	// change review.php to applicatoin form review
				}
			}
			if ($_SESSION['role'] == "CAC"){
				for ($i=0; $i < $result->num_rows; $i++) {
					$row = $result->fetch_assoc();
					echo "<tr>
	                    	<td>".$row['fname']."</td>
		                    <td>".$row['lname']."</td>
		                    <td><form action='application_form_review_CAC.php' method='post'>	
		    						<input type='submit' name='".$_SESSION['id']."' value='Review Application'>
						  		</form>
						  	</td>
		                </tr>";	// change review.php to applicatoin form review
				}
			}
			//*Note: Right now, this only works if there's one applicant

		}
    ?>

</body>
</html>