<?php
session_start();
/*Important variable that will be used later to determine if
we're ready to move to the next page of the application */
$done = false;
// connect to mysql
$conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If person is not an applicant, redirect
if ($_SESSION['type'] != 'App') {
    header("Location: home.php");
    die();
}

//HANDLE FORM VALIDATION
if (isset($_POST['submit'])) {

    // set the date
    $date = date("Y/m/d");

    $dataReady = true;

    //make sure nothing's empty
    if (empty($_POST["degreeType"]) || empty($_POST["semester"]) || empty($_POST["appYear"]) ||
        empty($_POST["gpa"]) || empty($_POST["dYear"]) || empty($_POST["university"]) ||
        empty($_POST["major"]) || empty($_POST["type"]) || empty($_POST["fnameRec"]) ||
        empty($_POST["lnameRec"]) || empty($_POST["institution"]) || empty($_POST["email"])) {

        $somethingEmpty = "One or more required fields are missing";
        $dataReady = false;
    }

    $appYearTest = $_POST["appYear"];
    $verbalTest = $_POST["verbal"];
    $quantitativeTest = $_POST["quantitative"];
    $yearTest = $_POST["year"];
    $advScoreTest = $_POST["advScore"];
    $toeflTest = $_POST["toefl"];
    $advYearTest = $_POST["advYear"];
    $aoiTest = $_POST["aoi"];
    $experienceTest = $_POST["experience"];
    $gpaTest = $_POST["gpa"];
    $dYearTest = $_POST["dYear"];
    $universityTest = $_POST["university"];
    $majorTest = $_POST["major"];
    $gpa2Test = $_POST["gpa2"];
    $dYear2Test = $_POST["dYear2"];
    $university2Test = $_POST["university2"];
    $major2Test = $_POST["major2"];
    $gpa3Test = $_POST["gpa3"];
    $dYear3Test = $_POST["dYear3"];
    $university3Test = $_POST["university3"];
    $major3Test = $_POST["major3"];

    $fnameRecTest = $_POST["fnameRec"];
    $lnameRecTest = $_POST["lnameRec"];
    $institutionTest = $_POST["institution"];
    $emailTest = $_POST["email"];
    $fnameRec2Test = $_POST["fnameRec2"];
    $lnameRec2Test = $_POST["lnameRec2"];
    $institution2Test = $_POST["institution2"];
    $email2Test = $_POST["email2"];
    $fnameRec3Test = $_POST["fnameRec3"];
    $lnameRec3Test = $_POST["lnameRec3"];
    $institution3Test = $_POST["institution3"];
    $email3Test = $_POST["email3"];

    $degreeType = $_POST["degreeType"];
    $semester = $_POST["semester"];
    $type = $_POST["type"];
    $type2 = $_POST["type2"];
    $type3 = $_POST["type3"];

    function isValidYear($value, $low = 1950, $high = 2019)
    {
        $value = (int) $value;
        if ($value > $high || $value < $low) {
            // return false (not a valid value)
            return false;
        }
        //otherwise the year is valid so return true
        return true;
    }
    function isValidAppYear($value, $low = 2019, $high = 2030)
    {
        $value = (int) $value;
        if ($value > $high || $value < $low) {
            // return false (not a valid value)
            return false;
        }
        //otherwise the year is valid so return true
        return true;
    }
    function isValidGPA($value, $low = 0, $high = 5.0)
    {
        $value = (double) $value;
        if ($value > $high || $value < $low) {
            // return false (not a valid value)
            return false;
        }
        //otherwise the year is valid so return true
        return true;
    }
    function isValidScore($value, $low = 130, $high = 170)
    {
        $value = (int) $value;
        if ($value > $high || $value < $low) {
            // return false (not a valid value)
            return false;
        }
        //otherwise the year is valid so return true
        return true;
    }
    function isValidTOEFL($value, $low = 0, $high = 120)
    {
        $value = (int) $value;
        if ($value > $high || $value < $low) {
            // return false (not a valid value)
            return false;
        }
        //otherwise the year is valid so return true
        return true;
    }

    // General checks
    if (empty($_POST['degreeType'])){
      $degreeTypeErr = "Degree type required";
      $dataReady = false;
    } 
    
    if (empty($_POST['semester'])){
      $semesterErr = "Semester required";
      $dataReady = false;
    } 
    if (!empty($appYearTest) && (!preg_match("/^[0-9]+$/i",$appYearTest) || !isValidAppYear($appYearTest))) {
      $appYearErr = "Not a valid date";
      $dataReady = false;
    }
    else if (empty($appYearTest)) {
        $appYearErr = "Application year required";
        $dataReady = false;
    }
    else $appYear = $appYearTest;
    
    if (empty($semester)){
        $semesterErr = "Application semester required";
        $dataReady = false;
    }

    //test checks
    if (!empty($verbalTest) && (!preg_match("/^[0-9]+$/i",$verbalTest) || !isValidScore($verbalTest))) {
      $verbalErr = "Not a valid GRE score (130-170)";
      $dataReady = false;
    }
    else $verbal = $verbalTest;
    
    if (!empty($quantitativeTest) && (!preg_match("/^[0-9]+$/i",$quantitativeTest) || !isValidScore($quantitativeTest))) {
      $quantitativeErr = "Not a valid GRE score (130-170)";
      $dataReady = false;
    } 
    else $quantitative = $quantitativeTest;
     
    if (!empty($yearTest) && (!preg_match("/^[0-9]+$/i",$yearTest) || !isValidYear($yearTest))) {
      $yearErr = "Not a valid date";
      $dataReady = false;
    }
    else $year = $yearTest;
    
    if (!empty($advScoreTest) && (!preg_match("/^[0-9]+$/i",$advScoreTest) || !isValidScore($advScoreTest))) {
      $advScoreErr = "Not a valid GRE score (130-170)";
      $dataReady = false;
    } 
    else $advScore = $advScoreTest;
    
    if (!empty($_POST['subject'])){
        $subject = $_POST["subject"]; 
    }
    else{
        $subject = NULL;
    }
    if (!empty($toeflTest) && (!preg_match("/^[0-9]+$/i",$toeflTest) || !isValidTOEFL($toeflTest))) {
      $toeflErr = "Not a valid TOEFL score (0-120)";
      $dataReady = false;
    } 
    else if (empty($toeflTest)) $toefl = "NULL";
    else $toefl = $toeflTest;
    
    if (!empty($advYearTest) && (!preg_match("/^[0-9]+$/i",$advYearTest) || !isValidYear($advYearTest))) {
      $advYearErr = "Not a valid date";
      $dataReady = false;
    }
    else if (empty($advYear)) $advYear = "NULL";
    else $advYear = $advYearTest;
    
    if (!empty($aoiTest) && !preg_match("/[A-Za-z0-9 ]+/", $aoiTest)) {
      $aoiErr = "Only letters, numbers, and white space allowed";
      $dataReady = false;
    }
    else if (empty($aoiTest)) {
      $aoi = "N/A";
    }
    else $aoi = $aoiTest;
    
    if (!empty($experienceTest) && !preg_match("/[A-Za-z0-9 ]+/", $experienceTest)) {
      $experienceErr = "Only letters, numbers, and white space allowed";
      $dataReady = false;
    }
    else if (empty($experienceTest)){
        $experience = "N/A";
    }
    else $experience = $experienceTest;
    
    if (!empty($gpaTest) && (!is_numeric($gpaTest) || !isValidGPA($gpaTest))) {
      $gpaErr = "Not a valid gpa";
      $dataReady = false;
    }
    else if (empty($gpaTest)){
        $gpaErr = "GPA required";
        $dataReady = false;
    }
    else $gpa = $gpaTest;
    
    if (!empty($dYearTest) && (!preg_match("/^[0-9]+$/i",$dYearTest) || !isValidYear($dYearTest))) {
      $dYearErr = "Not a valid year";
      $dataReady = false;
    }
    else if (empty($dYearTest)){
      $dYearErr = "Degree year required";
      $dataReady = false;
    }
    else $dYear = $dYearTest;
    
    if (!empty($universityTest) && (!preg_match("/^[a-zA-Z ]+$/i",$universityTest))) {
      $universityErr = "Only letters, and white space allowed";
      $dataReady = false;
    } 
    else if (empty($universityTest)){
      $universityErr = "Degree university required";
      $dataReady = false;
    }
    else $university = $universityTest;
    
    if (!empty($majorTest) && (!preg_match("/^[a-zA-Z ]+$/i",$majorTest))) {
      $majorErr = "Only letters, and white space allowed";
      $dataReady = false;
    } 
    else if (empty($majorTest)){
      $majorErr = "Degree major required";
      $dataReady = false;
    }
    else $major = $majorTest;
    
    //optional degrees checks
    if (!empty($gpa2Test) && (!is_numeric($gpa2Test) || !isValidGPA($gpa2Test))) {
      $gpa2Err = "Not a valid gpa";    
    } 
    else $gpa2 = $gpa2Test;
    
    if (!empty($dYear2Test) && (!preg_match("/^[0-9]+$/i",$dYear2Test) || !isValidYear($dYear2Test))) {
      $dYear2Err = "Not a valid year";  
    } 
    else $dYear2 = $dYear2Test;
    
    if (!empty($university2Test) && !preg_match("/^[a-zA-Z ]+$/i",$university2Test)) {
      $university2Err = "Only letters, and white space allowed";
    } 
    else $university2 = $university2Test;
    
    if (!empty($major2Test) && (!preg_match("/^[a-zA-Z ]+$/i",$major2Test))) {
      $major2Err = "Only letters, and white space allowed";
      $dataReady = false;
    } 
    else $major2 = $major2Test;
    
    if (!empty($gpa3Test) && (!is_numeric($gpa3Test) || !isValidGPA($gpa3Test))) {
      $gpa3Err = "Not a valid gpa";    
    }
    else $gpa3 = $gpa3Test;
    
    if (!empty($dYear3Test) && (!preg_match("/^[0-9]+$/i",$dYear3Test)  || !isValidYear($dYear3Test))) {
      $dYear3Err = "Not a valid year";  
    } 
    else $dYear3 = $dYear3Test;
    
    if (!empty($university3Test) && !preg_match("/^[a-zA-Z ]+$/i",$university3Test) ) {
      $university3Err = "Only letters, and white space allowed";
    }
    else $university3 = $university3Test;
    
    if (!empty($major3Test) && (!preg_match("/^[a-zA-Z ]+$/i",$major3Test))) {
      $major3Err = "Only letters, and white space allowed";
      $dataReady = false;
    }
    else $major3 = $major3Test;


    //rec checks
    if (!empty($fnameRecTest) && (!preg_match("/^[a-zA-Z ]+$/i",$fnameRecTest))) {
      $fnameRecErr = "Only letters, and white space allowed";
      $dataReady = false;
    } 
    else if(empty($fnameRecTest)){
      $fnameRecErr = "Recommender name required";
      $dataReady = false;
    }
    else $fnameRec = $fnameRecTest;
    
    if (!empty($lnameRecTest) && (!preg_match("/^[a-zA-Z ]+$/i",$lnameRecTest))) {
      $lnameRecErr = "Only letters, and white space allowed";
      $dataReady = false;
    }
    else if(empty($lnameRecTest)){
      $lnameRecErr = "Recommender name required";
      $dataReady = false;
    } 
    else $lnameRec = $lnameRecTest;
    
    if (!empty($institutionTest) && !preg_match("/^[a-zA-Z ]+$/i",$institutionTest)) {
      $institutionErr = "Only letters, and white space allowed";
      $dataReady = false;
    }
    else if (empty($institutionTest)){
      $institutionErr = "Recommender institution required";
      $dataReady = false;
    }
    else $institution = $institutionTest;
    
    if (!empty($emailTest) && !filter_var($emailTest, FILTER_VALIDATE_EMAIL) ) {
      $emailErr = "Invalid email";
      $dataReady = false;
    } 
    else if(empty($emailTest)){
      $emailErr = "Recommender email required";
      $dataReady = false;
    }
    else $email = $emailTest;
    

    if (!empty($fnameRec2Test) && (!preg_match("/^[a-zA-Z ]+$/i",$fnameRec2Test))) {
      $fnameRec2Err = "Only letters, and white space allowed";
      $dataReady = false;
    } 
    else $fnameRec2 = $fnameRec2Test;
    
    if (!empty($lnameRec2Test) && (!preg_match("/^[a-zA-Z ]+$/i",$lnameRec2Test))) {
      $lnameRec2Err = "Only letters, and white space allowed";
      $dataReady = false;
    }
    else $lname2Rec = $lnameRec2Test;
    
    if (!empty($institution2Test) && !preg_match("/^[a-zA-Z ]+$/i",$institution2Test)) {
      $institution2Err = "Only letters, and white space allowed";
      $dataReady = false;
    }
    else $institution2 = $institution2Test;
    
    if (!empty($email2Test) && !filter_var($email2Test, FILTER_VALIDATE_EMAIL) ) {
      $email2Err = "Invalid email";
      $dataReady = false;
    } 
    else $email2 = $email2Test;
    

    if (!empty($fnameRec3Test) && (!preg_match("/^[a-zA-Z ]+$/i",$fnameRec3Test))) {
      $fnameRec3Err = "Only letters and white space allowed";
      $dataReady = false;
    } 
    else $fnameRec3 = $fnameRec3Test;
    
    if (!empty($lnameRec3Test) && (!preg_match("/^[a-zA-Z ]+$/i",$lnameRec3Test))) {
      $lnameRec3Err = "Only letters and white space allowed";
      $dataReady = false;
    }
    else $lname3Rec = $lnameRec3Test;
    
    if (!empty($institution3Test) && !preg_match("/^[a-zA-Z ]+$/i",$institution3Test)) {
      $institution3Err = "Only letters and white space allowed";
      $dataReady = false;
    }
    else $institution3 = $institution3Test;
    
    if (!empty($email3Test) && !filter_var($email3Test, FILTER_VALIDATE_EMAIL) ) {
      $email3Err = "Invalid email";
      $dataReady = false;
    } 
    else $email3 = $email3Test;

////////////////////////////////////////////////////////////////////////

    //Insert into database
    if ($dataReady == true) {
        // use session id to extract fname and last name.
        $sql = "SELECT fname, lname FROM user WHERE uid = " . $_SESSION['uid'];
        $result = mysqli_query($conn, $sql) or die("Could not find user: " . mysqli_error($conn));
        $value = mysqli_fetch_object($result);
        $fname = $value->fname;
        $lname = $value->lname;

        /* GRE INSERT */
        $sql = "SELECT uid FROM gre WHERE uid = " . $_SESSION['uid'];
        $result = mysqli_query($conn, $sql) or die ("Could not find student: ".mysqli_error($conn));

        if (mysqli_num_rows($result) == 0) {
            $sql = "INSERT INTO gre VALUES(".$verbal.", ".$quantitative.", ".$year.", ".$advScore.", '" . $subject."', ".$toefl.", ".$advYear.", ".$_SESSION['uid'].")";
            $result = mysqli_query($conn, $sql) or die("Insert GRE failed: " . mysqli_error($conn));
        } else { // if already something there, need to update
            $sql = "UPDATE gre SET verbal=".$verbal.", quant=".$quantitative.", year=".$year.", advScore=".$advScore.", subject='".$subject."', toefl=".$toefl.", advYear=".$advYear." WHERE uid=".$_SESSION['uid'];
            $result = mysqli_query($conn, $sql) or die("Update GRE failed: " . mysqli_error($conn));
        }

        /* ACADEMIC INFO INSERT */
        $sql = "SELECT uid FROM academic_info WHERE uid = " . $_SESSION['uid'];
        $result = mysqli_query($conn, $sql) or die ("Could not find student: ".mysqli_error($conn));

        if (mysqli_num_rows($result) == 0) {
            $sql = "INSERT INTO academic_info (uid, dated, degreeType, AOI, experience, semester, year) VALUES(" . $_SESSION['uid'] . ", '" . $date . "', '" . $degreeType . "', '" . $aoi . "', '" . $experience . "', '" . $semester . "', " . $appYear . ")";
            $result = mysqli_query($conn, $sql) or die("Insert academic info failed: " . mysqli_error($conn));
        } else {
            $sql = "UPDATE academic_info SET dated='" . $date . "', degreeType='" . $degreeType . "', AOI='" . $aoi . "', experience='" . $experience . "', semester='" . $semester . "', year=" . $appYear . " WHERE uid=" . $_SESSION['uid'];
            $result = mysqli_query($conn, $sql) or die("Update academic info failed: " . mysqli_error($conn));
        }

        /* PRIOR DEGRESS INSERT */
        $sql = "INSERT INTO prior_degrees VALUES (" . $gpa . ", " . $dYear . ", '" . $university . "', '" . $major . "', " . $_SESSION['uid'] . ", '" . $type . "')";
        $result = mysqli_query($conn, $sql) or die("Insert prior degrees error: " . mysqli_error($conn));

        if (!empty($_POST["type2"]) && !empty($_POST["gpa2"]) && !empty($_POST["dYear2"]) && !empty($_POST["university2"]) && !empty($_POST["major2"])) {
            $sql = "INSERT INTO prior_degrees VALUES (" . $gpa2 . ", " . $dYear2 . ", '" . $university2 . "', '" . $major2 . "', " . $_SESSION['uid'] . ", '" . $type2 . "')";
            $result = mysqli_query($conn, $sql) or die("Insert prior degrees error: " . mysqli_error($conn));
        }
        if (!empty($_POST["type3"]) && !empty($_POST["gpa3"]) && !empty($_POST["dYear3"]) && !empty($_POST["university3"]) && !empty($_POST["major3"])) {
            $sql = "INSERT INTO prior_degrees VALUES (" . $gpa3 . ", " . $dYear3 . ", '" . $university3 . "', '" . $major3 . "', " . $_SESSION['uid'] . ", '" . $type3 . "')";
            $result = mysqli_query($conn, $sql) or die("Insert prior degrees error: " . mysqli_error($conn));
        }

        /* REC LETTER INSERTS */
        $sql = "INSERT INTO rec_letter (fname, lname, email, institution, uid) VALUES('".$fnameRec."', '".$lnameRec."', '".$email."', '".$institution."', ".$_SESSION['uid'].")";
        $result = mysqli_query($conn, $sql) or die("1st rec letter failed: " . mysqli_error($conn));

        if ($fnameRec2 != NULL) {
            $sql = "INSERT INTO rec_letter (fname, lname, email, institution, uid) VALUES('".$fnameRec2."', '".$lname2Rec."', '".$email2."', '".$institution2."', " . $_SESSION['uid'] . ")";
            $result = mysqli_query($conn, $sql) or die ("2nd rec failed: ".mysqli_error($conn));
        }

        if ($fnameRec3 != NULL) {
            $sql = "INSERT INTO rec_letter (fname, lname, email, institution, uid) VALUES('".$fnameRec3."', '".$lname3Rec."', '".$email3."', '".$institution3."', " . $_SESSION['uid'] . ")";
            $result = mysqli_query($conn, $sql) or die ("3rd rec failed: ".mysqli_error($conn));
        }


        /* Get the recID for each recommendation */
        $recs = mysqli_query($conn, "SELECT recID FROM rec_letter WHERE uid=".$_SESSION['uid']." AND email=".$email);
        $row = $recs->fetch_assoc();
        $_SESSION['rec1'] = $row['recID'];
        $_SESSION['rec2'] = $_SESSION['rec1'] + 1;
        $_SESSION['rec3'] = $_SESSION['rec2'] + 1;

        //email rec
        $msg = '<html>
				<head>
					<title>Invitation To Write Recommendation Letter</title>
				</head>
				<body>
					<p>'.$fname.' '.$lname.' has requested a letter of recommendation from you. If you are interested, please copy the UID and follow the link below.<br>
						UID: '.$_SESSION["uid"].'<br><br>
						<a href="http://gwupyterhub.seas.gwu.edu/~sp19DBp2-ARGv/ARGv/rec_letter.php "> http://gwupyterhub.seas.gwu.edu/~sp19DBp2-ARGv/ARGv/rec_letter.php </a>
					</p>
				</body>
				</html>';
        $subject = "Recommendation Letter for ".$fname." ".$lname;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // set status and make default reviewer the CAC 
        $sql = "INSERT INTO app_review (uid, reviewer, status) VALUES (".$_SESSION['uid'].", 9, 2)";
        $result = mysqli_query($conn, $sql) or die("Status update failed: " . mysqli_error($conn));

        mail($email, $subject, $msg, $headers) or die("1st rec email failed");
        mail($email2, $subject, $msg, $headers) or die("2nd rec email failed");
        mail($email3, $subject, $msg, $headers) or die("3rd rec email failed");
        // If we made it here,  we're done
        $done = true;
    }

    //If the data was successfuly added to database, move to page 2
    if ($done) {
        header("Location:home.php");
        die();
    }
}
?>	

<html>
  <head>
	  <title>Application Form</title>
	  <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
	  <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
	  <link rel = "stylesheet" type="text/css" href="style.css"/>

	  <style>
	    .field {
	      position: absolute;
	      left: 140px;
	    }
	    body{line-height: 1.6;}
	    .bottomCentered{
	       position: fixed;
	       text-align: center;
	       bottom: 30px;
	       width: 100%;
	    }
	    .error {color: #FF0000;}
	  </style>
  </head>

  <body>
    <h1> Application Form </h1>
    <form id="mainform" method="post">

      <h3> Academic Information </h3>
      What degree are you applying for?
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="error"><?php echo " " . $degreeTypeErr; ?></span><br>
      <input type="radio" name="degreeType" value="MS" > MS<br>
      <input type="radio" name="degreeType" value="PHD"> PhD<br><br>
      Year <span class="field"><input type="text" name="appYear">
      <span class="error"><?php echo " " . $appYearErr; ?></span></span><br>
      Semester <span class="error">
      	<?php echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	&nbsp;&nbsp;&nbsp;&nbsp; " . $semesterErr; ?> </span></span> <br>
      <input type="radio" name="semester" value="FA"> Fall<br>
      <input type="radio" name="semester" value="SP"> Spring<br>
      <input type="radio" name="semester" value="SU"> Summer<br><br>
      GRE: <br>
      Verbal <span class="field"><input type="text" name="verbal">
      <span class="error"><?php echo " " . $verbalErr; ?></span></span><br>
      Quantitative <span class="field"><input type="text" name="quantitative">
      <span class="error"><?php echo " " . $quantitativeErr; ?></span></span><br>
      Year of exam <span class="field"><input type="text" name="year">
      <span class="error"><?php echo " " . $yearErr; ?></span></span><br><br>
      GRE advanced: <br>
      Score <span class="field"><input type="text" name="advScore">
      <span class="error"><?php echo " " . $advScoreErr; ?></span></span><br>

     Subject <span class="field">
      <select name="subject">
      	<option disabled selected value> -- select an option -- </option>
        <option value="Biology">Biology</option>
        <option value="Chemistry">Chemistry</option>
        <option value="English">English</option>
        <option value="Physics">Physics</option>
        <option value="Psychology">Pyschology</option>
      </select> </span><br>

      TOEFL Score <span class="field"><input type="text" name="toefl">
      <span class="error"><?php echo " " . $toeflErr; ?></span></span><br>
      Year of exam <span class="field"><input type="text" name="advYear">
      <span class="error"><?php echo " " . $advYearErr; ?></span></span><br><br>
      Areas of Interest <span class="field"><input type="text" name="aoi">
      <span class="error"><?php echo " " . $aoiErr; ?></span></span><br>
      Experience <span class="field"><input type="text" name="experience">
      <span class="error"><?php echo " " . $experienceErr; ?></span></span><br>
      <hr>

      <h3>Prior Degrees </h3>
      <b>Degree One (required)</b><br>
      Degree Type <br>
      <input type="radio" name="type" value="MS"> MS<br>
      <input type="radio" name="type" value="BS"> BS<br>
      <input type="radio" name="type" value="BA"> BA <br>
      GPA <span class="field"><input type="text" name="gpa">
      <span class="error"><?php echo " " . $gpaErr; ?></span></span><br>
      Year <span class="field"><input type="text" name="dYear">
      <span class="error"><?php echo " " . $dYearErr; ?></span></span><br>
      University <span class="field"><input type="text" name="university">
      <span class="error"><?php echo " " . $universityErr; ?></span></span><br>
      Major <span class="field"><input type="text" name="major">
      <span class="error"><?php echo " " . $majorErr; ?></span></span><br><br>

      <b>Degree Two (optional)</b><br>
      Degree Type <br>
      <input type="radio" name="type2" value="MS"> MS<br>
      <input type="radio" name="type2" value="BS"> BS<br>
      <input type="radio" name="type2" value="BA"> BA <br>
      GPA <span class="field"><input type="text" name="gpa2">
      <span class="error"><?php echo " " . $gpa2Err; ?></span></span><br>
      Year <span class="field"><input type="text" name="dYear2">
      <span class="error"><?php echo " " . $dYear2Err; ?></span></span><br>
      University <span class="field"><input type="text" name="university2">
      <span class="error"><?php echo " " . $university2Err; ?></span></span><br>
      Major <span class="field"><input type="text" name="major2">
      <span class="error"><?php echo " " . $major2Err; ?></span></span><br><br>

      <b>Degree Three (optional)</b><br>
      Degree Type <br>
      <input type="radio" name="type3" value="MS"> MS<br>
      <input type="radio" name="type3" value="BS"> BS<br>
      <input type="radio" name="type3" value="BA"> BA <br>
      GPA <span class="field"><input type="text" name="gpa3">
      <span class="error"><?php echo " " . $gpa3Err; ?></span></span><br>
      Year <span class="field"><input type="text" name="dYear3">
      <span class="error"><?php echo " " . $dYear3Err; ?></span></span><br>
      University <span class="field"><input type="text" name="university3">
      <span class="error"><?php echo " " . $university3Err; ?></span></span><br>
      Major <span class="field"><input type="text" name="major3">
      <span class="error"><?php echo " " . $major3Err; ?></span></span><br><br>
      <hr>

      <h3> Recomendation Letter </h3>
      <i>Enter the contact information of the person who will provide your recommendation letter.<br>
      We will reach out to this person and ask for their letter. <br>
      You can see the status of your recommendation letter on your homepage.</i> <br><br/>
      First name <span class="field"><input type="text" name="fnameRec">
      <span class="error"><?php echo " " . $fnameRecErr; ?></span></span><br>
      Last name <span class="field"><input type="text" name="lnameRec">
      <span class="error"><?php echo " " . $lnameRecErr; ?></span></span><br>
      Institution <span class="field"><input type="text" name="institution">
      <span class="error"><?php echo " " . $institutionErr; ?></span></span><br>
      Email <span class="field"><input type="text" name="email">
      <span class="error"><?php echo " " . $emailErr; ?></span></span><br><br>

      <h3> Rec Letter Two (Optional)</h3>
      First name <span class="field"><input type="text" name="fnameRec2">
      <span class="error"><?php echo " " . $fnameRec2Err;?></span></span><br>
      Last name <span class="field"><input type="text" name="lnameRec2">
      <span class="error"><?php echo " " . $lnameRec2Err;?></span></span><br>
      Institution <span class="field"><input type="text" name="institution2">
      <span class="error"><?php echo " " . $institution2Err;?></span></span><br>
      Email <span class="field"><input type="text" name="email2">
      <span class="error"><?php echo " " . $email2Err;?></span></span><br><br/>

      <h3> Rec Letter Three (Optional)</h3>
      First name <span class="field"><input type="text" name="fnameRec3">
      <span class="error"><?php echo " " . $fnameRec3Err;?></span></span><br>
      Last name <span class="field"><input type="text" name="lnameRec3">
      <span class="error"><?php echo " " . $lnameRec3Err;?></span></span><br>
      Institution <span class="field"><input type="text" name="institution3">
      <span class="error"><?php echo " " . $institution3Err;?></span></span><br>
      Email <span class="field"><input type="text" name="email3">
      <span class="error"><?php echo " " . $email3Err;?></span></span><br><br/>

      <div class="bottomCentered"><input type="submit" name="submit" value="Submit">
      <span class="error"><?php echo $somethingEmpty; ?></span></div>

    </form>
  </body>
</html>