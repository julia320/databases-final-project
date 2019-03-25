<!DOCTYPE html>
<head>
    <title>Applicant Status Page</title>
</head>

<body>
	<h2 style="text-align: center;">Applicant Home Page</h2>
	<h4 style="text-align: center;">Complete your application or view its status here</h4>

	<?php
        session_start();

        // if user is not an applicant, redirect
        if ($_SESSION['role'] != "A") {
            header("Location: redirect.php");
            die();
        }

        // connect to the database
		$conn = mysqli_connect("localhost", "TheSpookyLlamas", "TSL_jjy_2019", "TheSpookyLlamas");

		// find the status of the applicant
		$q = "SELECT status, decision FROM app_review WHERE uid=".$_SESSION['id'];
		$result = mysqli_query($conn, $q);
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
    ?>

</body>
</html>