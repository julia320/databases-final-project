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
			$result = mysqli_query($conn, "SELECT status, decision FROM app_review WHERE uid=".$_SESSION['id']);
			$row = $result->fetch_assoc();
			
			echo "<p style='text-align: center;'><strong>Status: </strong>";

			// if their application is incomplete
			if (!isset($row['status']) || $row['status']==0) {
				echo "Application incomplete</p>";
				echo "<form align='center' action='application_form_general_page1.php' method='get'>
	    				<input type='submit' value='Finish Application'>
					  </form>";
			}

			// if their application is complete
			else if ($row['status'] == 1) {
				echo "Your application is complete!</p>";
				echo "<p style='text-align: center;'>Refer back to this page frequently to see when a decision has been made.</p>";
				echo "<form align='center' action='application_form_general_page1.php' method='get'>
	    				<input type='submit' value='View/Edit Application'>
					  </form>"; 
			}

			else if (isset($row['decision'])) {
				echo "Decision has been made</p><br/>";
				echo "<p style='text-align: center;'><strong>Decision: </strong>".$row['decision']."</p>";
			}

		}// end-applicant view


		// if the user is a reviewer, show them the list of applicants
		else if ($_SESSION['role'] == "FR" || $_SESSION['role'] == "CAC") {

			// page header info
        	echo "<h2 style='text-align: center;'>Reviewer Home Page</h2>
        		<h4 style='text-align: center;'>View completed applications and review them here</h4>";

			// get all the applicants whose application is complete
			$result = mysqli_query($conn, "SELECT fname, lname FROM users, app_review WHERE status=1 AND userID=uid");

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
	                    <td><form action='review.php' method='post'>
	    						<input type='submit' name='".$_SESSION['id']."' value='Review Application'>
					  		</form>
					  	</td>
	                </tr>";
			}
		}
    ?>

</body>
</html>