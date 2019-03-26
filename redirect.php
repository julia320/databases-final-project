<?php
	
	// if no role is set, need to go all the way back to log in page
	if (!isset($_SESSION['role'])) {
        header("Location: login.php");
        die();
    }

    // if an applicant, go to application page
    if ($_SESSION['role'] == "A") {
        //header("Location: application_form_general_page1.php");
        //die();
        echo "Cannot redirect to application, branches not merged";
    }

    // if a reviewer, go to review page
    if ($_SESSION['role'] == "FR" || $_SESSION['role'] == "CAC") {
        header("Location: review.php");
        die();
    }

    // Systems Administrators and Grad Secretaries have access to everything
    // do we need to redirect them? unclear currently

?>