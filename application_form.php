<?php
  session_start(); 
  /*Important variable that will be used later to determine 
  if we're ready to move to the next page of the application */
  $done = false;
  // connect to mysql
  $conn = mysqli_connect("localhost", "TheSpookyLlamas", "TSL_jjy_2019", "TheSpookyLlamas");
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  //HANDLE FORM VALIDATION
  if (isset($_POST['submit'])) {

  	// set the date
  	$date = date("H:i:s, m/d/Y");
  	echo $date;

    $dataReady = true;
    
    //make sure nothing's empty
    if (
      empty($_POST["address"]) ||
      empty($_POST["ssn"]) ||
      empty($_POST["degreeType"]) ||
      empty($_POST["semester"]) ||
      empty($_POST["appYear"]) ||
      empty($_POST["gpa"]) ||
      empty($_POST["dYear"]) ||
      empty($_POST["university"]) ||
      empty($_POST["major"]) ||
      empty($_POST["type"]) ||
      empty($_POST["fnameRec"]) ||
      empty($_POST["lnameRec"]) ||
      empty($_POST["institution"]) ||
      empty($_POST["email"])){
       $somethingEmpty = "One or more required fields are missing";
       $dataReady = false;
    }
    
	    $addressTest = $_POST["address"];
	    $ssnTest = $_POST["ssn"];
	    
	    $appYearTest = $_POST["appYear"];
	    $verbalTest = $_POST["verbal"];
	    $quantitativeTest = $_POST["quantitative"];
	    $yearTest =  $_POST["year"];
	    $advScoreTest = $_POST["advScore"];
	    // $subjectTest = $_POST["subject"];
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
	    $gpa4Test = $_POST["gpa4"];
	    $dYear4Test = $_POST["dYear4"];
	    $university4Test = $_POST["university4"];
	    $major4Test = $_POST["major4"];
	    
	    $fnameRecTest = $_POST["fnameRec"];
	    $lnameRecTest = $_POST["lnameRec"];
	    $institutionTest = $_POST["institution"];
	    $emailTest = $_POST["email"];
	    
	    $degreeType = $_POST["degreeType"];
	    $semester = $_POST["semester"];
	    $type = $_POST["type"];
	    $type2 = $_POST["type2"];
	    $type3 = $_POST["type3"];
	    $type4 = $_POST["type4"];

	    
	    function isValidSSN($value, $low = 0, $high = 999999999){
	    	$value = (int)$value;
	    	if ( $value > $high || $value < $low ) {
	   		  // return false (not a valid value)
	    	  return false;
	    	}
	    	//otherwise the year is valid so return true
	    	return true;
	    }
	    function isValidYear($value, $low = 1950, $high = 2019){
	    	$value = (int)$value;
	    	if ( $value > $high || $value < $low ) {
	   		  // return false (not a valid value)
	    	  return false;
	    	}
	    	//otherwise the year is valid so return true
	    	return true;
	    }
	    function isValidAppYear($value, $low = 2019, $high = 2030){
	    	$value = (int)$value;
	    	if ( $value > $high || $value < $low ) {
	   		  // return false (not a valid value)
	    	  return false;
	    	}
	    	//otherwise the year is valid so return true
	    	return true;
	    }
	    function isValidGPA($value, $low = 0, $high = 5.0){
	    	$value = (double)$value;
	    	if ( $value > $high || $value < $low ) {
	   		  // return false (not a valid value)
	    	  return false;
	    	}
	    	//otherwise the year is valid so return true
	    	return true;
	    }
	    function isValidScore($value, $low = 130, $high = 170){
	    	$value = (int)$value;
	    	if ( $value > $high || $value < $low ) {
	   		  // return false (not a valid value)
	    	  return false;
	    	}
	    	//otherwise the year is valid so return true
	    	return true;
	    }
	    function isValidTOEFL($value, $low = 0, $high = 120){
	    	$value = (int)$value;
	    	if ( $value > $high || $value < $low ) {
	   		  // return false (not a valid value)
	    	  return false;
	    	}
	    	//otherwise the year is valid so return true
	    	return true;
	    }
	   
	    if (!empty($addressTest) && !preg_match("/^[a-zA-Z0-9 ]+$/i",$addressTest)) {
	      $addressErr = "Only letters, numbers, and white space allowed";
	      $dataReady = false;
	    } 
	    else if (empty($addressTest)){
	      $addressErr = "Address is required";
	      $dataReady = false;
	    }
	    else{
	      $address = $addressTest;
	    }
	    if (!empty($ssnTest) && (!preg_match("/^[0-9]+$/i",$ssnTest) || !isValidSSN($ssnTest))) {
	      $ssnErr = "Not a valid social security number";
	      $dataReady = false;
	    }
	    else if (empty($ssnTest)){
	      $ssnErr = "SSN is required";
	      $dataReady = false;
	    } 
	    else{
	      $ssn = $ssnTest;
	    }
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
	    else{
	      $appYear = $appYearTest;
	    }
	    if (empty($semester)){
	    	$semesterErr = "Application semester required";
	    	$dataReady = false;
	    }
	    //test checks
	    if (!empty($verbalTest) && (!preg_match("/^[0-9]+$/i",$verbalTest) || !isValidScore($verbalTest))) {
	      $verbalErr = "Not a valid GRE score (130-170)";
	      $dataReady = false;
	    }
	    else if (empty($verbalTest)){
	    	$verbal = "NULL";
	    }
	    else{
	      $verbal = $verbalTest;
	    }
	    if (!empty($quantitativeTest) && (!preg_match("/^[0-9]+$/i",$quantitativeTest) || !isValidScore($quantitativeTest))) {
	      $quantitativeErr = "Not a valid GRE score (130-170)";
	      $dataReady = false;
	    }
	    else if (empty($quantitativeTest)){
	    	$quantitative = "NULL";
	    } 
	    else{
	      $quantitative = $quantitativeTest;
	    } 
	    if (!empty($yearTest) && (!preg_match("/^[0-9]+$/i",$yearTest) || !isValidYear($yearTest))) {
	      $yearErr = "Not a valid date";
	      $dataReady = false;
	    }
	    else if (empty($yearTest)){
	    	$year = "NULL";
	    } 
	    else{
	      $year = $yearTest;
	    }
	    if (!empty($advScoreTest) && (!preg_match("/^[0-9]+$/i",$advScoreTest) || !isValidScore($advScoreTest))) {
	      $advScoreErr = "Not a valid GRE score (130-170)";
	      $dataReady = false;
	    } 
	    else if (empty($advScoreTest)){
	    	$advScore = "NULL";
	    }
	    else{
	      $advScore = $advScoreTest;
	    }
	    if (!empty($_POST['subject'])){
	    	$subject = $_POST["subject"]; 
	    }
	    else{
	    	$subject = "NULL";
	    }
	    if (!empty($toeflTest) && (!preg_match("/^[0-9]+$/i",$toeflTest) || !isValidTOEFL($toeflTest))) {
	      $toeflErr = "Not a valid TOEFL score (0-120)";
	      $dataReady = false;
	    } 
	    else if (empty($toeflTest)){
	    	$toefl = "NULL";
	    }
	    else{
	      $toefl = $toeflTest;
	    }
	    if (!empty($advYearTest) && (!preg_match("/^[0-9]+$/i",$advYearTest) || !isValidYear($advYearTest))) {
	      $advYearErr = "Not a valid date";
	      $dataReady = false;
	    }
	    else if (empty($advYearTest)){
	    	$advYear = "NULL";
	    } 
	    else{
	      $advYear = $advYearTest;
	    }
	    if (!empty($aoiTest) && !preg_match("/[A-Za-z0-9 ]+/", $aoiTest)) {
	      $aoiErr = "Only letters, numbers, and white space allowed";
	      $dataReady = false;
	    }
	    else if (empty($aoiTest)) {
	      $aoi = "N/A";
	    }
	    else{
	    	$aoi = $aoiTest;
	    }
	    if (!empty($experienceTest) && !preg_match("/[A-Za-z0-9 ]+/", $experienceTest)) {
	      $experienceErr = "Only letters, numbers, and white space allowed";
	      $dataReady = false;
	    }
	    else if (empty($experienceTest)){
	    	$experience = "N/A";
	    }
	    else{
	      $experience = $experienceTest;
	    }
	    if (!empty($gpaTest) && (!is_numeric($gpaTest) || !isValidGPA($gpaTest))) {
	      $gpaErr = "Not a valid gpa";
	      $dataReady = false;
	    }
	    else if (empty($gpaTest)){
	    	$gpaErr = "GPA required";
	        $dataReady = false;
	    }
	    else{
	      $gpa = $gpaTest;
	    }
	    if (!empty($dYearTest) && (!preg_match("/^[0-9]+$/i",$dYearTest) || !isValidYear($dYearTest))) {
	      $dYearErr = "Not a valid year";
	      $dataReady = false;
	    }
	    else if (empty($dYearTest)){
	      $dYearErr = "Degree year required";
	      $dataReady = false;
	    }
	    else{
	      $dYear = $dYearTest;
	    }
	    if (!empty($universityTest) && (!preg_match("/^[a-zA-Z ]+$/i",$universityTest))) {
	      $universityErr = "Only letters, and white space allowed";
	      $dataReady = false;
	    } 
	    else if (empty($universityTest)){
	      $universityErr = "Degree university required";
	      $dataReady = false;
	    }
	    else{
	      $university = $universityTest;
	    }
	    if (!empty($majorTest) && (!preg_match("/^[a-zA-Z ]+$/i",$majorTest))) {
	      $majorErr = "Only letters, and white space allowed";
	      $dataReady = false;
	    } 
	    else if (empty($majorTest)){
	      $majorErr = "Degree major required";
	      $dataReady = false;
	    }
	    else{
	      $major = $majorTest;
	    }
	    //optional degrees checks
	    if (!empty($gpa2Test) && (!is_numeric($gpa2Test) || !isValidGPA($gpa2Test))) {
	      $gpa2Err = "Not a valid gpa";    
	    }
	    else if (empty($gpa2Test)){} 
	    else{
	      $gpa2 = $gpa2Test;
	    }
	    if (!empty($dYear2Test) && (!preg_match("/^[0-9]+$/i",$dYear2Test) || !isValidYear($dYear2Test))) {
	      $dYear2Err = "Not a valid year";  
	    } 
	    else if (empty($dYear2Test)){} 
	    else{
	      $dYear2 = $dYear2Test;
	    }
	    if (!empty($university2Test) && !preg_match("/^[a-zA-Z ]+$/i",$university2Test)) {
	      $university2Err = "Only letters, and white space allowed";
	    } 
	    else if (empty($university2Test)){} 
	    else{
	      $university2 = $university2Test;
	    }
	    if (!empty($major2Test) && (!preg_match("/^[a-zA-Z ]+$/i",$major2Test))) {
	      $major2Err = "Only letters, and white space allowed";
	      $dataReady = false;
	    } 
	    else if (empty($major2Test)){}
	    else{
	      $major2 = $major2Test;
	    }
	    if (!empty($gpa3Test) && (!is_numeric($gpa3Test) || !isValidGPA($gpa3Test))) {
	      $gpa3Err = "Not a valid gpa";    
	    }
	    else if (empty($gpa3Test)){}  
	    else{
	      $gpa3 = $gpa3Test;
	    }
	    if (!empty($dYear3Test) && (!preg_match("/^[0-9]+$/i",$dYear3Test)  || !isValidYear($dYear3Test))) {
	      $dYear3Err = "Not a valid year";  
	    } 
	    else if (empty($dYear3Test)){} 
	    else{
	      $dYear3 = $dYear3Test;
	    }
	    if (!empty($university3Test) && !preg_match("/^[a-zA-Z ]+$/i",$university3Test) ) {
	      $university3Err = "Only letters, and white space allowed";
	    }
	    else if (empty($university3Test)){} 
	    else{
	      $university3 = $university3Test;
	    }
	    if (!empty($major3Test) && (!preg_match("/^[a-zA-Z ]+$/i",$major3Test))) {
	      $major3Err = "Only letters, and white space allowed";
	      $dataReady = false;
	    } 
	    else if (empty($major3Test)){}
	    else{
	      $major3 = $major3Test;
	    }
	    if (!empty($gpa4Test) && (!is_numeric($gpa4Test) || !isValidGPA($gpa4Test))) {
	      $gpa4Err = "Not a valid gpa";    
	    } 
	    else if (empty($gpa4Test)){} 
	    else{
	      $gpa4 = $gpa4Test;
	    }
	    if (!empty($dYear4Test) && (!preg_match("/^[0-9]+$/i",$dYear4Test) || !isValidYear($dYear4Test))) {
	      $dYear4Err = "Not a valid year";  
	    }
	    else if (empty($dYear4Test)){} 
	    else{
	      $dYear4 = $dYear4Test;
	    }
	    if (!empty($university4Test) && !preg_match("/^[a-zA-Z ]+$/i",$unversity4Test) ) {
	      $university4Err = "Only letters, and white space allowed";
	    }
	    else if (empty($university4Test)){} 
	    else{
	      $university4 = $university4Test;
	    }
	    if (!empty($major4Test) && (!preg_match("/^[a-zA-Z ]+$/i",$major4Test))) {
	      $major4Err = "Only letters, and white space allowed";
	      $dataReady = false;
	    } 
	    else if (empty($major4Test)){}
	    else{
	      $major4 = $major4Test;
	    }
	    //rec checks
	    if (!empty($fnameRecTest) && (!preg_match("/^[a-zA-Z ]+$/i",$fnameRecTest))) {
	      $fnameRecErr = "Only letters, and white space allowed";
	      $dataReady = false;
	    } 
	    else if(empty($fnameRecTest)){
	      $fnameRecErr = "Recommender name required";
	      $dataReady = false;
	    }
	    else{
	      $fnameRec = $fnameRecTest;
	    }
	    if (!empty($lnameRecTest) && (!preg_match("/^[a-zA-Z ]+$/i",$lnameRecTest))) {
	      $lnameRecErr = "Only letters, and white space allowed";
	      $dataReady = false;
	    }
	    else if(empty($lnameRecTest)){
	      $lnameRecErr = "Recommender name required";
	      $dataReady = false;
	    } 
	    else{
	      $lnameRec = $lnameRecTest;
	    }
	    if (!empty($institutionTest) && !preg_match("/^[a-zA-Z ]+$/i",$institutionTest)) {
	      $institutionErr = "Only letters, and white space allowed";
	      $dataReady = false;
	    }
	    else if (empty($institutionTest)){
	      $institutionErr = "Recommender institution required";
	      $dataReady = false;
	    }
	    else{
	      $institution = $institutionTest;
	    }
	    if (!empty($emailTest) && !filter_var($emailTest, FILTER_VALIDATE_EMAIL) ) {
	      $emailErr = "Invalid email";
	      $dataReady = false;
	    } 
	    else if(empty($emailTest)){
	      $emailErr = "Recommender email required";
	      $dataReady = false;
	    }
	    else{
	      $email = $emailTest;
	    }
    
    ////////////////////////////////////////////////////////////////////////
    
    
    //Insert into database 
    if ($dataReady == true){
      //use session id to extract fname and last name.
      $sql = "SELECT fname, lname FROM users WHERE userID = " .$_SESSION['id'];
      $result = mysqli_query($conn, $sql) or die ("**********1st MySQL Error***********");
      $value = mysqli_fetch_object($result);
      $fname = $value->fname;
      $lname = $value->lname;
      //personal info
      $sql = "SELECT uid FROM personal_info WHERE uid = " . $_SESSION['id'];
      $result = mysqli_query($conn, $sql) or die ("**Check for existing personal info Error**");
      if (mysqli_num_rows($result) == 0){
	    //fill in personal_info table iniially
	    $sql1 = "INSERT INTO personal_info VALUES('".$fname."', '".$lname."', ".$_SESSION['id'].", '".$address."', ".$ssn.")";
	    $result1 = mysqli_query($conn, $sql1) or die ("**********insert personal_info MySQL Error***********");
	  }
	  else{
	  	//upadate personal_info table
	    $sql1 = "UPDATE personal_info SET fname = '" .$fname. "', lname = '" .$lname. "', address = '" .$address. "', ssn = " .$ssn." WHERE uid = " .$_SESSION['id'];
	    $result1 = mysqli_query($conn, $sql1) or die ("**********update personal_info MySQL Error***********");
	  }
      //GRE
      if($subject != NULL){
	    $sql2 = "INSERT INTO gre VALUES(".$verbal.", ".$quantitative.", ".$year.", ".$advScore.", '".$subject."', " .$toefl.", ".$advYear.", ".$_SESSION['id'].")";
	    $result2 = mysqli_query($conn, $sql2) or die ("**********gre subject!=NULL MySQL Error***********");
	  }
	  else{
	  	$sql2 = "INSERT INTO gre VALUES(".$verbal.", ".$quantitative.", ".$year.", ".$advScore.", NULL, " .$toefl.", ".$advYear.", ".$_SESSION['id'].")";
	    $result2 = mysqli_query($conn, $sql2) or die ("**********gre subject==NULL MySQL Error***********");
	  }
	  //academic info
	  $sql = "SELECT uid FROM academic_info WHERE uid = " . $_SESSION['id'];
      $result = mysqli_query($conn, $sql) or die ("**Check for existing academic info failed**");
      if (mysqli_num_rows($result) == 0){
	    $sql3 = "INSERT INTO academic_info (uid, degreeType, AOI, experience, semester, year) VALUES(".$_SESSION['id'].", '".$degreeType."', '".$aoi."', '".$experience."', '".$semester."', ".$appYear.")";
	    $result3 = mysqli_query($conn, $sql3) or die ("**********insert into academic info failed***********");
      }
      else{
      	$sql3 = "UPDATE academic_info SET degreeType = '" .$degreeType. "', AOI = '" .$aoi. "', experience = '" .$experience. "', semester = '" .$semester. "', year = " .$appYear. " WHERE uid = " .$_SESSION['id'] ."";
      	$result3 = mysqli_query($conn, $sql3) or die ("**********update academic info failed***********");
      }
      //fill in prior degrees table
      $sql4 = "INSERT INTO prior_degrees VALUES (".$gpa.", " .$dYear.", '".$university."', '" .$major. "', " .$_SESSION['id']. ", '".$type."')"; 
      $result4 = mysqli_query($conn, $sql4) or die ("**********4th MySQL Error***********");
      if(!empty($_POST["type2"]) && !empty($_POST["gpa2"]) && !empty($_POST["dYear2"]) && !empty($_POST["university2"]) && !empty($_POST["major2"])){
      	$sql4 = "INSERT INTO prior_degrees VALUES (".$gpa2.", " .$dYear2.", '".$university2."', '" .$major2. "', " .$_SESSION['id']. ", '".$type2."')"; 
        $result4 = mysqli_query($conn, $sql4) or die ("**********5.1 MySQL Error***********");
      }
      if(!empty($_POST["type3"]) && !empty($_POST["gpa3"]) && !empty($_POST["dYear3"]) && !empty($_POST["university3"]) && !empty($_POST["major3"])){
      	$sql4 = "INSERT INTO prior_degrees VALUES (".$gpa3.", " .$dYear3.", '".$university3."', '" .$major3. "', " .$_SESSION['id']. ", '".$type3."')"; 
        $result4 = mysqli_query($conn, $sql4) or die ("**********5.2 MySQL Error***********");
      }
      if(!empty($_POST["type4"]) && !empty($_POST["gpa4"]) && !empty($_POST["dYear4"]) && !empty($_POST["university4"]) && !empty($_POST["major4"])){
      	$sql4 = "INSERT INTO prior_degrees VALUES (".$gpa4.", " .$dYear4.", '".$university4."', '" .$major4. "', " .$_SESSION['id']. ", '".$type4."')"; 
        $result4 = mysqli_query($conn, $sql4) or die ("**********5.3 MySQL Error***********");
      }
      //fill in rec_letter table
      $sql5 = "INSERT INTO rec_letter (fname, lname, email, institution, uid) VALUES('".$fnameRec."', '".$lnameRec."', '".$email."', '".$institution."', " . $_SESSION['id'] . ")";
      $result5 = mysqli_query($conn, $sql5) or die ("**********6th MySQL Error***********");


      //email rec
	  $msg = '<html>
				<head>
					<title>Invitation To Write Recommendation Letter</title>
				</head>
				<body>
					<p>
						'.$fname.' '.$lname.' has requested a letter of recommendation from you. If you <br>
						are interested, please copy the uid and follow the link below.<br>
						uid: ' .$_SESSION["id"].'<br><br>
						<a href="http://gwupyterhub.seas.gwu.edu/~sp19DBp1-TheSpookyLlamas/TheSpookyLlamas/rec_letter.php "> http://gwupyterhub.seas.gwu.edu/~sp19DBp1-TheSpookyLlamas/TheSpookyLlamas/rec_l0etter.php </a>

					</p>
				</body>
				</html>';
	  $subject = "Recommendation Letter for " .$fname." ".$lname."";
	  $headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      mail($email, $subject, $msg, $headers) or die ("rec email failed");
      
      $sql = "UPDATE app_review SET status = 2 WHERE uid = " .$_SESSION['id']. "";
      $result = mysqli_query($conn, $sql) or die ("**********UPDATE STATUS MySQL Error***********");
      // If we made it here,  we're done
      $done = true;
    }
    
    //If the data was successfuly added to database, move to page 2
    if ($done){
      echo "done";
      //header("Location:home.php"); 
      die();
    }
    
  }
?>

<html>
  
  <title>
    Application Form
  </title>
  
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
  
   <h1> Application Form </h1>
   
  
  <body>
    
    <form id="mainform" method="post">
      <h3> Personal Information </h3>
      Address <!--(If you are and international student, enter country name. Otherwise, enter city, state, zip) <br> -->
      <span class="field"><input type="text" name="address">
      <span class="error"><?php echo " " . $addressErr;?></span></span><br>
      SSN <span class="field"><input type="text" name="ssn">
      <span class="error"><?php echo " " . $ssnErr;?></span></span><br> 
      <hr>
      
      <h3> Academic Information </h3>
      What degree are you applying for? 
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="error"><?php echo " " . $degreeTypeErr;?></span><br>
      <input type="radio" name="degreeType" value="Mas" > MS<br>
      <input type="radio" name="degreeType" value="PhD"> PhD<br><br>
      Year <span class="field"><input type="text" name="appYear">
      <span class="error"><?php echo " " . $appYearErr;?></span></span><br> 
      Semester <span class="error">
      	<?php echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	&nbsp;&nbsp;&nbsp;&nbsp; " . $semesterErr;?> </span></span> <br>
      <input type="radio" name="semester" value="FA"> Fall<br>
      <input type="radio" name="semester" value="SP"> Spring<br>
      <input type="radio" name="semester" value="SU"> Summer<br><br>
      GRE: <br>
      Verbal <span class="field"><input type="text" name="verbal">
      <span class="error"><?php echo " " . $verbalErr;?></span></span><br>
      Quantitative <span class="field"><input type="text" name="quantitative">
      <span class="error"><?php echo " " . $quantitativeErr;?></span></span><br>
      Year of exam <span class="field"><input type="text" name="year">
      <span class="error"><?php echo " " . $yearErr;?></span></span><br><br>
      GRE advanced: <br>
      Score <span class="field"><input type="text" name="advScore">
      <span class="error"><?php echo " " . $advScoreErr;?></span></span><br>

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
      <span class="error"><?php echo " " . $toeflErr;?></span></span><br>
      Year of exam <span class="field"><input type="text" name="advYear">
      <span class="error"><?php echo " " . $advYearErr;?></span></span><br><br>
      Areas of Interest <span class="field"><input type="text" name="aoi">
      <span class="error"><?php echo " " . $aoiErr;?></span></span><br>
      Experience <span class="field"><input type="text" name="experience">
      <span class="error"><?php echo " " . $experienceErr;?></span></span><br>
      <hr>

      <h3>Prior Degrees </h3>
      <b>Degree One (required)</b><br>
      Degree Type <br>
      <input type="radio" name="type" value="MS"> MS<br>
      <input type="radio" name="type" value="BS"> BS<br>
      <input type="radio" name="type" value="BA"> BA <br>
      GPA <span class="field"><input type="text" name="gpa">
      <span class="error"><?php echo " " . $gpaErr;?></span></span><br>
      Year <span class="field"><input type="text" name="dYear">
      <span class="error"><?php echo " " . $dYearErr;?></span></span><br>
      University <span class="field"><input type="text" name="university">
      <span class="error"><?php echo " " . $universityErr;?></span></span><br>
      Major <span class="field"><input type="text" name="major">
      <span class="error"><?php echo " " . $majorErr;?></span></span><br><br>
    
      <b>Degree Two (optional)</b><br>
      Degree Type <br>
      <input type="radio" name="type2" value="MS"> MS<br>
      <input type="radio" name="type2" value="BS"> BS<br>
      <input type="radio" name="type2" value="BA"> BA <br>
      GPA <span class="field"><input type="text" name="gpa2">
      <span class="error"><?php echo " " . $gpa2Err;?></span></span><br>
      Year <span class="field"><input type="text" name="dYear2">
      <span class="error"><?php echo " " . $dYear2Err;?></span></span><br>
      University <span class="field"><input type="text" name="university2">
      <span class="error"><?php echo " " . $university2Err;?></span></span><br>
      Major <span class="field"><input type="text" name="major2">
      <span class="error"><?php echo " " . $major2Err;?></span></span><br><br>
      
      <b>Degree Three (optional)</b><br>
      Degree Type <br>
      <input type="radio" name="type3" value="MS"> MS<br>
      <input type="radio" name="type3" value="BS"> BS<br>
      <input type="radio" name="type3" value="BA"> BA <br>
      GPA <span class="field"><input type="text" name="gpa3">
      <span class="error"><?php echo " " . $gpa3Err;?></span></span><br>
      Year <span class="field"><input type="text" name="dYear3">
      <span class="error"><?php echo " " . $dYear3Err;?></span></span><br>
      University <span class="field"><input type="text" name="university3">
      <span class="error"><?php echo " " . $university3Err;?></span></span><br>
      Major <span class="field"><input type="text" name="major3">
      <span class="error"><?php echo " " . $major3Err;?></span></span><br><br>

      <b>Degree Four (optional)</b><br>
      Degree Type <br>
      <input type="radio" name="type4" value="MS"> MS<br>
      <input type="radio" name="type4" value="BS"> BS<br>
      <input type="radio" name="type4" value="BA"> BA <br>
      GPA <span class="field"><input type="text" name="gpa4">
      <span class="error"><?php echo " " . $gpa4Err;?></span></span><br>
      Year <span class="field"><input type="text" name="dYear4">
      <span class="error"><?php echo " " . $dYear4Err;?></span></span><br>
      University <span class="field"><input type="text" name="university4">
      <span class="error"><?php echo " " . $university4Err;?></span></span><br>
      Major <span class="field"><input type="text" name="major4">
      <span class="error"><?php echo " " . $major4Err;?></span></span><br><br>
      <hr>

      <h3> Recomendation Letter </h3>
      <i>Enter the contact information of the person who will provide your recommendation letter.<br>
      We will reach out to this person and ask for their letter. <br>
      You can see the status of your recommendation letter on your homepage.</i> <br><br>
      First name <span class="field"><input type="text" name="fnameRec">
      <span class="error"><?php echo " " . $fnameRecErr;?></span></span><br>
      Last name <span class="field"><input type="text" name="lnameRec">
      <span class="error"><?php echo " " . $lnameRecErr;?></span></span><br>
      Institution <span class="field"><input type="text" name="institution">
      <span class="error"><?php echo " " . $institutionErr;?></span></span><br>
      Email <span class="field"><input type="text" name="email">
      <span class="error"><?php echo " " . $emailErr;?></span></span><br>
      <br><br>
      
      <div class="bottomCentered"><input type="submit" name="submit" value="Submit">
      <span class="error"><?php echo $somethingEmpty;?></span></div>
      
    </form>
  </body>
</html>