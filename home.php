<!DOCTYPE html>
<head>
    <title>APPS Home Page</title>

	<!-- CSS styling -->
	<style>
		tbody tr:nth-child(odd) {
  			background-color: #ff33cc;
		}

		tbody tr:nth-child(even) {
  			background-color: #e495e4;
		}

		h2 {
			color: #00bfff;
		}

	</style

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
        	echo "<div ><h2 style='text-align: center;'>Applicant Home Page</h2>
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
	    				<input type='submit' name='".$row['uid']."' value='View Application'>
					  </form>"; 
			}

			// if their application is complete
			else if ($row['status'] == 3) {
				echo "Your application is complete!</p>";
				echo "<p style='text-align: center;'>Refer back to this page frequently to see when a decision has been made.</p>";
				echo "<form align='center' action='application_view_form.php' method='post'>
	    				<input type='submit' name='".$row['uid']."' value='View Application'>
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
		else if ($_SESSION['role'] == "FR" || $_SESSION['role'] == "CAC") {

			// page header info
        	echo "<h2 style='text-align: center;'>Reviewer Home Page</h2>
        		<h4 style='text-align: center;'>View completed applications and review them here</h4>";

			// get all the applicants whose application is complete
			$result = mysqli_query($conn, "SELECT DISTINCT userID, fname, lname FROM users, app_review WHERE status>2 AND userID=uid");

			// start table
			echo "<table border='1' align='center' style='border-collapse:collapse;'>
	            	<tr>
	                	<th>First Name</th>
		                <th>Last Name</th>
		                <th></th>
					</tr>";

			// show each applicant with a button to the review page
			for ($i=0; $i < $result->num_rows; $i++) {
				$row = $result->fetch_assoc();
				// the button will go to a different place based on role
				if ($_SESSION['role'] == "FR")
					$button = "<form action='application_form_review.php' method='post'>
		    						<input type='submit' name='".$row['userID']."' value='Review Application'>
						  		</form>";
				else 
					$button = "<form action='application_form_review_CAC.php' method='post'>
		    						<input type='submit' name='".$row['userID']."' value='Review Application'>
						  		</form>";

				echo "<tr>
                    	<td>".$row['fname']."</td>
	                    <td>".$row['lname']."</td>
	                    <td>".$button."</td>
	                </tr>";
			}
		}// end-reviewer view



		// if the user is a Grad Secretary, let them search for applicants, mark docs as received
		else if ($_SESSION['role'] == "GS") {

			// header information
			echo "<h2 style='text-align: center;'>Graduate Secretary Home Page</h2>
			<h4 style='text-align: center;'>When an applicant's documents have been received, mark them as such here</h4>";


			// search bar for the GS to find applicants
			echo "<form align='center' method='post' action='home.php'>
				<input name='search' type='text'>
				<input name='submit' type='submit' value='Search for applicant'>
				</form></br></br>";

			// get all the applicants whose name matches what they searched
			if (isset($_POST['submit'])) {
				$result = mysqli_query($conn, "SELECT userID, fname, lname FROM users WHERE role='A' AND (fname LIKE '".$_POST['search']."' OR lname LIKE '".$_POST['search']."')");

				// if there were matches, show them
				if ($result->num_rows > 0) {
					// start table
					echo "<table border='1' align='center'; style='border-collapse: collapse;'>
			        	    	<tr>
	        		        		<th>First Name</th>
							<th>Last Name</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>";
					
					// show each applicant with a button to the review page
					for ($i=0; $i < $result->num_rows; $i++) {
						$row = $result->fetch_assoc();
						echo "<tr>
	        		        		<td>".$row['fname']."</td>
					                <td>".$row['lname']."</td>
	                    				<td><form align='center' action='add_documents.php' method='post'>
	    							<input type='submit' name='".$row['userID']."' value='Check documents'>
							</form></td>
							<td><form align='center' action='view_faculty_review.php' method='post'>
								<input type='submit' name='".$row['userID']."' value='View review'>
							</form></td>
							<td><form align='center' action='view_cac_review.php' method='post'>
								<input type='submit' name='".$row['userID']."' value='View CAC review'>
							</form></td>
							<td><form align='center' action='final_decision.php' method='post'>
								<input type='submit' name='".$row['userID']."' value='Update decision'>
							</form></td>
				                </tr>";
					}
				}

				// if there were no matches, tell them
				else 
					echo "There are no applicants matching that name.";
			}
	
		}// end-Grad secretary view


		// if the user is a Systems admin
		else if ($_SESSION['role'] == 'SA') {
			header("Location: system_admin_page.php");
        	die();
		}
    ?>

</body>
</html>
