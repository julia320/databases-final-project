<!DOCTYPE html>
<head>
    <title>APPS Home Page</title>
	<link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>

	<!-- CSS styling -->
	<style>
		tbody tr:nth-child(odd) {
  			background-color: #edb1ed;
		}

		tbody tr:nth-child(even) {
  			background-color: #c9efef;
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
        if (in_array("App", $_SESSION['types'])) {

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

				// Matriculation
				echo "<p style='text-align: center;'>NOTE: In order to accept your spot, you must send in a $50 deposit by mail. Once this deposit has been received, you will be able to register for classes.</p>";
			}

			// if they were rejected
			else if ($row['status'] == 8) {
				echo "</p>";
				echo "<p style='text-align: center;'>We regret to inform you that you have not been chosen as a potential student for this school.</p>";
			}

			else 
				echo "Error: we were unable to find your information</p><br/>";

		}// end-applicant view


		// if the user is a reviewer, show them the list of applicants
		else if (in_array("rev", $_SESSION['types']) || in_array("cac", $_SESSION['types'])) {

			// page header info
        	echo "<h2 style='text-align: center;'>Reviewer Home Page</h2>
        		<h4 style='text-align: center;'>View completed applications and review them here</h4>";

        	// search bar for the reviewer to find applicants (NAME)
			echo "<form align='center' method='post' action='home.php'>
					<input name='search' type='text'>
					<input name='nameSearch' type='submit' value='Search by name'>
				</form><br>";

			// search bar for the reviewer to find applicants (UID)
			echo "<form align='center' method='post' action='home.php'>
					<input name='search' type='text'>
					<input name='uidSearch' type='submit' value='Search by UID'>
				</form></br></br>";


			// results from name search
			if (isset($_POST['nameSearch'])) {
				$searchResult = mysqli_query($conn, "SELECT DISTINCT user.uid, fname, lname FROM user, app_review WHERE type='App' AND status=5 AND user.uid=app_review.uid AND (fname LIKE '%".$_POST['search']."%' OR lname LIKE '%".$_POST['search']."%')");

				// display results
				if ($searchResult->num_rows > 0) 
					reviewTable($searchResult);
				else 
					echo "<p style='text-align:center; color:red;'>There are no finished applications with that name.</p>";
			}

			// results from UID search
			if (isset($_POST['uidSearch'])) {
				$searchResult = mysqli_query($conn, "SELECT DISTINCT user.uid, fname, lname, status FROM user, app_review WHERE type='App' AND status=5 AND user.uid=app_review.uid AND user.uid=".$_POST['search']);

				// display results
				if ($searchResult->num_rows > 0) 
					reviewTable($searchResult);
				else 
					echo "<p style='text-align:center; color:red;'>There are no finished applications matching that UID.</p>";
			}

			// get all the rest of the applicants whose application is complete
			$resultAll = mysqli_query($conn, "SELECT DISTINCT user.uid, fname, lname FROM user, app_review WHERE status=5 AND type='App' AND user.uid=app_review.uid");

			if ($resultAll->num_rows > 0) {
				// show all other applicants
				echo "</table><br/>&nbsp<br/>&nbsp<br/> <h3 style='text-align:center;'>All Applicants:</h3>";
				echo $_SESSION['error'];
				$_SESSION['error'] = "";
				reviewTable($resultAll);
			}
			else 
				echo "<p style='text-align:center;'>There are currently no applications to review</p>";

		}// end-reviewer view

		
		// if the user is a Grad Secretary, let them search for applicants, mark docs as received 
		else if (in_array("secr", $_SESSION['types']) || in_array("admin", $_SESSION['types'])) {

			// header information
			echo "<h2 style='text-align: center;'>Graduate Secretary Home Page</h2>
			<h4 style='text-align: center;'>When an applicant's documents have been received, mark them as such here</h4>";

			// search bar for the secretary to find applicants (NAME)
			echo "<form align='center' method='post' action='home.php'>
					<input name='search' type='text'>
					<input name='nameSearch' type='submit' value='Search by name'>
				</form><br>";

			// search bar for the secretary to find applicants (UID)
			echo "<form align='center' method='post' action='home.php'>
					<input name='search' type='text'>
					<input name='uidSearch' type='submit' value='Search by UID'>
				</form></br></br>";

			// results from name search
			if (isset($_POST['nameSearch'])) {
				$searchResult = mysqli_query($conn, "SELECT DISTINCT user.uid, fname, lname, status FROM user, app_review WHERE type='App' AND status>1 AND type='App' AND user.uid=app_review.uid AND (fname LIKE '".$_POST['search']."' OR lname LIKE '".$_POST['search']."')");

				// Show completed apps that match the search
				if ($searchResult->num_rows > 0) 
					secrTable($searchResult);
				else 
					echo "<p style='text-align:center; color:red;'>There are currently no applications under that name.</p>";
			}

			// results from UID search
			if (isset($_POST['uidSearch'])) {
				$searchResult = mysqli_query($conn, "SELECT DISTINCT user.uid, fname, lname, status FROM user, app_review WHERE type='App' AND status>1 AND type='App' AND user.uid=app_review.uid AND user.uid=".$_POST['search']);

				// Show completed apps that match the search
				if ($searchResult->num_rows > 0) 
					secrTable($searchResult);
				else 
					echo "<p style='text-align:center; color:red;'>There are currently no applications matching that UID.</p>";
			}
			
			echo $_SESSION['error'];
			$_SESSION['error'] = "";

			// Show the rest of the completed applications
			$resultAll = mysqli_query($conn, "SELECT DISTINCT user.uid, fname, lname FROM user, app_review WHERE status>1 AND type='App' AND user.uid=app_review.uid");
	
			if ($resultAll->num_rows > 0) {
				// show all other applicants
				echo "</table><br/>&nbsp<br/>&nbsp<br/> <h3 style='text-align:center;'>All Applicants:</h3>";
				secrTable($resultAll);
			}
			else 
				echo "<p style='text-align:center;'>There are currently no submitted applications.</p>";
	
		}// end-Grad secretary view



		/* Displays the table seen by the reviewers */
		function reviewTable ($results)
		{
			// start table
			echo "<table border='1' align='center' style='border-collapse:collapse;'>
		          	<tr><th>First Name</th><th>Last Name</th><th></th></tr>";

			for ($i=0; $i < $results->num_rows; $i++) {
				$row = $results->fetch_assoc();

				$button = "<form action='application_form_review.php' method='post'>
		    					<input type='submit' name='".$row['uid']."' value='Review Application'>
						  	</form>";

				echo "<tr><td>".$row['fname']."</td><td>".$row['lname']."</td><td>".$button."</td></tr>";
			}
		}


		/* Displays the table seen by the Graduate Secretary */
		function secrTable ($results)
		{
			// start table
			echo "<table border='1' align='center'; style='border-collapse: collapse;'>
	        	<tr><th>First Name</th><th>Last Name</th><th></th><th></th><th></th><th></th></tr>";

	        // show each applicant with a button to the review page
			for ($i=0; $i < $results->num_rows; $i++) {
				$row = $results->fetch_assoc();

				echo "<tr><td>".$row['fname']."</td><td>".$row['lname']."</td>
                		<td><form align='center' action='add_documents.php' method='post'>
							<input type='submit' name='".$row['uid']."' value='Manage documents'></form></td>
						<td><form align='center' action='review_list.php' method='post'>
							<input type='submit' name='".$row['uid']."' value='Faculty reviews'></form></td>
						<td><form align='center' action='view_cac_review.php' method='post'>
							<input type='submit' name='".$row['uid']."' value='CAC review'></form></td>
						<td><form align='center' action='final_decision.php' method='post'>
							<input type='submit' name='".$row['uid']."' value='Update decision'></form></td>
		            </tr>";
			}
		}
    ?>

</body>
</html>
