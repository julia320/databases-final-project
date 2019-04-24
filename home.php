<!DOCTYPE html>
<head>
    <title>APPS Home Page</title>
	<!-- <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" /> -->
    <link rel = "stylesheet" type="text/css" href="style.css"/>

	<!-- CSS styling -->
	<style>
		tbody tr:nth-child(odd) {
  			background-color: #ff33cc;
		}

		tbody tr:nth-child(even) {
  			background-color: #e495e4;
		}

		h2 {
			color: #5689DF;
		}

	</style>

</head>

<body>
	<?php
        session_start();

        if (!isset($_SESSION['type'])) {
        	header("Location: login.php");
        	die();
    	}

        // connect to the database
		$conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

		
		//"back to menu" button
		echo "<div style=\"display: inline-block;\" class=\"menu-button\">";
		echo "<form action=\"menu.php\"><input type=\"submit\" value=\"Menu\"/></form></div>";

        // if user is an applicant, show their status
        if ($_SESSION['type'] == "App") {

        	// page header info
        	echo "<div ><h2 style='text-align: center;'>Applicant Home Page</h2>
        		<h4 style='text-align: center;'>Complete your application or view its status here</h4>";

        	// tell them their uid
        	echo "<h4 style='text-align:center'>Your UID is:</h4> <p style='color:red; text-align:center'>".$_SESSION['uid']."</p>";

			// find status of the applicant
			$result = mysqli_query($conn, "SELECT uid, status FROM app_review WHERE uid=".$_SESSION['uid']);
			$row = $result->fetch_assoc();
			
			echo "<p style='text-align: center;'><strong>Status: </strong>";

			// if their application is incomplete
			if (!isset($row['status']) || $row['status'] == 1) {
				echo "Application incomplete</p>";
				echo "<form align='center' action='application_form.php' method='post'>
	    				<input type='submit' value='Start Application'>
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

			// if just transcript is needed
			else if ($row['status'] == 3) {
				echo "Your application is pending</p>";
				echo "<p style='text-align: center;'>We are still waiting to receive your transcript, please check back later.</p>";
				echo "<form align='center' action='application_view_form.php' method='post'>
	    				<input type='submit' name='".$row['uid']."' value='View Application'>
					  </form>"; 
			}

			// if just rec letter is needed
			else if ($row['status'] == 4) {
				echo "Your application is pending</p>";
				echo "<p style='text-align: center;'>We are still waiting to receive your recommendation letter, please check back later.</p>";
				echo "<form align='center' action='application_view_form.php' method='post'>
	    				<input type='submit' name='".$row['uid']."' value='View Application'>
					  </form>"; 
			}

			// if their application is complete
			else if ($row['status'] == 5) {
				echo "Your application is complete!</p>";
				echo "<p style='text-align: center;'>Refer back to this page frequently to see when a decision has been made.</p>";
				echo "<form align='center' action='application_view_form.php' method='post'>
	    				<input type='submit' name='".$row['uid']."' value='View Application'>
					  </form>"; 
			}

			// if they were admitted
			else if ($row['status'] == 6 || $row['status'] == 7) {
				echo "Congratulations!</p>";
				echo "<p style='text-align: center;'>We are happy to inform you that you have been selected for admission to this school! </p>";

				// tell them if they have received aid
				if ($row['status'] == 7) {
					echo "<p style='text-align: center;'>You have also been selected for financial aid, please speak to our office about that.</p>";
				}
			}

			// if they were rejected
			else if ($row['status'] == 8) {
				echo "</p>";
				echo "<p style='text-align: center;'>We regret to inform you that you have not been chosen as a potential student for this school.</p>";
			}

			else 
				echo "Error: we could not find any information for this user</p><br/>";

		}// end-applicant view


		// if the user is a reviewer, show them the list of applicants
		else if ($_SESSION['type'] == "rev" || $_SESSION['type'] == "cac") {

			// page header info
        	echo "<h2 style='text-align: center;'>Reviewer Home Page</h2>
        		<h4 style='text-align: center;'>View completed applications and review them here</h4>";

        	// search bar for reviewer to find applicants
			echo "<form align='center' method='post' action='home.php'>
				<input name='search' type='text'>
				<input name='appSearch' type='submit' value='Search for applicant'>
				</form></br></br>";

			// get all the applicants who match search and have a finished application
			if (isset($_POST['appSearch'])) {
				$resultSearch = mysqli_query($conn, "SELECT DISTINCT user.uid, fname, lname, status FROM user, app_review WHERE type='App' AND status>1 AND user.uid=app_review.uid AND (fname LIKE '".$_POST['search']."' OR lname LIKE '".$_POST['search']."')");
			}

			// get all the applicants whose application is complete
			$resultAll = mysqli_query($conn, "SELECT DISTINCT user.uid, fname, lname FROM user, app_review WHERE status>1 AND user.uid=app_review.uid");


			// Show completed apps that match the search
			if ($resultSearch->num_rows > 0) 
				reviewTable($resultSearch);
			else if (isset($_POST['appSearch']))
				echo "<p style='text-align:center; color:red;'>There are no finished applications with that name.</p>";

			// Show the rest of the completed applications
			if ($resultAll->num_rows > 0) {
				// show all other applicants
				echo "</table><br/>&nbsp<br/>&nbsp<br/> <h3 style='text-align:center;'>All Applicants:</h3>";
				reviewTable($resultAll);
			}
			else 
				echo "<p style='text-align:center;'>There are currently no applications to review</p>";

		}// end-reviewer view



		// if the user is a Grad Secretary, let them search for applicants, mark docs as received 
		else if ($_SESSION['type'] == "secr" || $_SESSION['type'] == "admin") {

			// header information
			echo "<h2 style='text-align: center;'>Graduate Secretary Home Page</h2>
			<h4 style='text-align: center;'>When an applicant's documents have been received, mark them as such here</h4>";


			// search bar for the GS to find applicants
			echo "<form align='center' method='post' action='home.php'>
				<input name='search' type='text'>
				<input name='submit' type='submit' value='Search for applicant'>
				</form></br></br>";

			// get all the applicants who match search and have submitted an application
			if (isset($_POST['submit'])) {
				$result = mysqli_query($conn, "SELECT DISTINCT user.uid, fname, lname, status FROM user, app_review WHERE type='App' AND status>1 AND user.uid=app_review.uid AND (fname LIKE '".$_POST['search']."' OR lname LIKE '".$_POST['search']."')");
				$msg = "<p style='text-align:center; color:red;'>There are currently no applications under that name.</p>";
			}
			// or just get all completed applications
			else {
				$result = mysqli_query($conn, "SELECT DISTINCT user.uid, fname, lname FROM user, app_review WHERE status=5 AND user.uid=app_review.uid");
				$msg = "<p style='text-align:center;'>There are currently no submitted applications.</p>";
			}

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
    							<input type='submit' name='".$row['uid']."' value='Check documents'>
								</form></td>
							<td><form align='center' action='view_faculty_review.php' method='post'>
								<input type='submit' name='".$row['uid']."' value='View review'>
								</form></td>
							<td><form align='center' action='view_cac_review.php' method='post'>
								<input type='submit' name='".$row['uid']."' value='View CAC review'>
								</form></td>
							<td><form align='center' action='final_decision.php' method='post'>
								<input type='submit' name='".$row['uid']."' value='Update decision'>
								</form></td>
			            </tr>";
				}
			}
			// if there were no matches, tell them
			else 
				echo $msg;
	
		}// end-Grad secretary view


		function reviewTable ($results)
		{
			// start table
			echo "<table border='1' align='center' style='border-collapse:collapse;'>
		          	<tr>
	               		<th>First Name</th>
		            	<th>Last Name</th>
		                <th></th>
					</tr>";

			for ($i=0; $i < $results->num_rows; $i++) {
				$row = $results->fetch_assoc();
				// the button will go to a different place based on role
				if ($_SESSION['type'] == "rev")
					$button = "<form action='application_form_review.php' method='post'>
		    						<input type='submit' name='".$row['uid']."' value='Review Application'>
						  		</form>";
				else 
					$button = "<form action='application_form_review_CAC.php' method='post'>
		    						<input type='submit' name='".$row['uid']."' value='Review Application'>
						  		</form>";

				echo "<tr>
                    	<td>".$row['fname']."</td>
	                    <td>".$row['lname']."</td>
	                    <td>".$button."</td>
	                </tr>";
			}
		}
    ?>

</body>
</html>
