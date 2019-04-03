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
  $somethingEmpty = "";

  $addressErr = "";
  $ssnErr = "";

  $appYearErr = "";
  $verbalErr = "";
  $quantitativeErr = "";
  $yearErr = "";
  $advScoreErr = "";
  // $subjectErr = "";
  $toeflErr = "";
  $advYearErr = "";
  $aoiErr = "";
  $experienceErr = "";

  $gpaErr = "";
  $dYearErr = "";
  $universityErr = "";
  $gpa2Err = "";
  $dYear2Err = "";
  $university2Err = "";
  $gpa3Err = "";
  $dYear3Err = "";
  $university3Err = "";
  $gpa4Err = "";
  $dYear4Err = "";
  $university4Err = "";

  $fnameRecErr = "";
  $lnameRecErr = "";
  $institutionErr = "";
  $emailErr = "";

  if (isset($_POST['submit'])){
    $dataReady = true;
    
    ////////////////////////////////////////////////////////////////////////
    //FORM VALIDATIONS
    ////////////////////////////////////////////////////////////////////////
    //make sure nothing's empty
    if(
      empty($_POST["address"]) ||
      empty($_POST["ssn"]) ||
      empty($_POST["degreeType"]) ||
      empty($_POST["semester"]) ||
      empty($_POST["appYear"]) ||
      empty($_POST["verbal"]) ||
      empty($_POST["quantitative"]) ||
      empty($_POST["year"]) ||
      empty($_POST["advScore"]) ||
      empty($_POST["subject"]) ||
      empty($_POST["toefl"]) ||
      empty($_POST["advYear"]) ||
      empty($_POST["aoi"]) ||
      empty($_POST["experience"]) ||
      empty($_POST["gpa"]) ||
      empty($_POST["dYear"]) ||
      empty($_POST["university"]) ||
      empty($_POST["type"]) ||
      empty($_POST["fnameRec"]) ||
      empty($_POST["lnameRec"]) ||
      empty($_POST["institution"]) ||
      empty($_POST["email"])){
       $somethingEmpty = "One or more required fields are missing";
       $dataReady = false;
    }
    else{
    
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
	    $gpa2Test = $_POST["gpa2"];
	    $dYear2Test = $_POST["dYear2"];
	    $university2Test = $_POST["university2"];
	    $gpa3Test = $_POST["gpa3"];
	    $dYear3Test = $_POST["dYear3"];
	    $university3Test = $_POST["university3"];
	    $gpa4Test = $_POST["gpa4"];
	    $dYear4Test = $_POST["dYear4"];
	    $university4Test = $_POST["university4"];
	    
	    $fnameRecTest = $_POST["fnameRec"];
	    $lnameRecTest = $_POST["lnameRec"];
	    $institutionTest = $_POST["institution"];
	    $emailTest = $_POST["email"];
	    
	    $address= "";
	    $ssn = "";
	    
	    $appYear= "";
	    $verbal= "";
	    $quantitative= "";
	    $year= "";
	    $advScore= ""; 
	    $subject= $_POST["subject"]; 
	    $toefl= ""; 
	    $advYear= ""; 
	    $aoi= ""; 
	    $experience= "";
	    $degreeType = $_POST["degreeType"];
	    $semester = $_POST["semester"];

	    $gpa = "";
	    $dYear = "";
	    $university = "";
	    $type = $_POST["type"];
	    $gpa2 = "";
	    $dYear2 = "";
	    $university2 = "";
	    $type2 = $_POST["type2"];
	    $gpa3 = "";
	    $dYear3 = "";
	    $university3 = "";
	    $type3 = $_POST["type3"];
	    $gpa4 = "";
	    $dYear4 = "";
	    $university4 = "";
	    $type4 = $_POST["type4"];
	    
	    $fnameRec = "";
	    $lnameRec = "";
	    $institution = "";
	    $email = "";
	     
	    function isValidYear($value, $low = 1950, $high = 2020){
	    	$value = (int)$value;
	    	if ( $value > $high || $value < $low ) {
	   		  // return false (not a valid value)
	    	  return false;
	    	}
	    	//otherwise the year is valid so return true
	    	return true;
	    }
	    function isValidAppYear($value, $low = 2019, $high = 2021){
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
	    function isValidScore($value, $low = 0, $high = 100){
	    	$value = (int)$value;
	    	if ( $value > $high || $value < $low ) {
	   		  // return false (not a valid value)
	    	  return false;
	    	}
	    	//otherwise the year is valid so return true
	    	return true;
	    }

	    if (!preg_match("/^[a-zA-Z0-9 ]+$/i",$addressTest)) {
	      $addressErr = "Only letters, numbers, and white space allowed";
	      $dataReady = false;
	    } else{
	      $address = $addressTest;
	    }
	    if (!preg_match("/^[0-9]+$/i",$ssnTest)) {
	      $ssnErr = "Not a valid social security number";
	      $dataReady = false;
	    } else{
	      $ssn = $ssnTest;
	    }
	    if (!preg_match("/^[0-9]+$/i",$appYearTest) || !isValidAppYear($appYearTest)) {
	      $appYearErr = "Not a valid date";
	      $dataReady = false;
	    } else{
	      $appYear = $appYearTest;
	    }
	    if (!preg_match("/^[0-9]+$/i",$verbalTest) || !isValidScore($verbalTest)) {
	      $verbalErr = "Not a valid score";
	      $dataReady = false;
	    } else{
	      $verbal = $verbalTest;
	    }
	    if (!preg_match("/^[0-9]+$/i",$quantitativeTest) || !isValidScore($quantitativeTest)) {
	      $quantitativeErr = "Not a valid score";
	      $dataReady = false;
	    } else{
	      $quantitative = $quantitativeTest;
	    } 
	    if (!preg_match("/^[0-9]+$/i",$yearTest) || !isValidYear($yearTest)) {
	      $yearErr = "Not a valid date";
	      $dataReady = false;
	    } else{
	      $year = $yearTest;
	    }
	    if (!preg_match("/^[0-9]+$/i",$advScoreTest) || !isValidScore($advScoreTest)) {
	      $advScoreErr = "Not a valid score";
	      $dataReady = false;
	    } else{
	      $advScore = $advScoreTest;
	    }
	    // if (!preg_match("/^[a-zA-Z0-9 ]+$/i",$subjectTest)) {
	    //   $subjectErr = "Not a valid subject - only letters, numbers, and white space allowed";
	    //   $dataReady = false;
	    // } else{
	    //   $subject = $subjecTest;
	    // }
	    if (!preg_match("/^[0-9]+$/i",$toeflTest) || !isValidScore($toeflTest)) {
	      $toeflErr = "Not a valid score";
	      $dataReady = false;
	    } else{
	      $toefl = $toeflTest;
	    }
	    if (!preg_match("/^[0-9]+$/i",$advYearTest) || !isValidYear($advYearTest)) {
	      $advYearErr = "Not a valid date";
	      $dataReady = false;
	    } else{
	      $advYear = $advYearTest;
	    }
	    if (!empty($_POST["aoi"])) {
	      $aoi = $aoiTest;
	    }
	    if (!empty($_POST["experience"])) {
	      $experience = $experienceTest;
	    }

	    if (!is_numeric($gpaTest) || !isValidGPA($gpaTest)) {
	      $gpaErr = "Not a valid gpa";
	      $dataReady = false;
	    } else{
	      $gpa = $gpaTest;
	    }
	    if (!preg_match("/^[0-9]+$/i",$dYearTest) || !isValidYear($dYearTest)) {
	      $dYearErr = "Not a valid year";
	      $dataReady = false;
	    } else{
	      $dYear = $dYearTest;
	    }
	    if (!preg_match("/^[a-zA-Z ]+$/i",$universityTest)) {
	      $universityErr = "Only letters, and white space allowed";
	      $dataReady = false;
	    } else{
	      $university = $universityTest;
	    }
	    //optional degrees
	    if (!empty($gpa2Test) && (!is_numeric($gpa2Test) || !isValidGPA($gpa2Test))) {
	      $gpa2Err = "Not a valid gpa";    
	    } else{
	      $gpa2 = $gpa2Test;
	    }
	    if (!empty($dYear2Test) && (!preg_match("/^[0-9]+$/i",$dYear2Test) || !isValidYear($dYear2Test))) {
	      $dYear2Err = "Not a valid year";  
	    } else{
	      $dYear2 = $dYear2Test;
	    }
	    if (!empty($universiy2Test) && (!preg_match("/^[a-zA-Z ]+$/i",$university2Test))) {
	      $university2Err = "Only letters, and white space allowed";
	    } else{
	      $university2 = $university2Test;
	    }
	    if (!empty($gpa3Test) && (!is_numeric($gpa3Test) || !isValidGPA($gpa3Test))) {
	      $gpa3Err = "Not a valid gpa";    
	    } else{
	      $gpa3 = $gpa3Test;
	    }
	    if (!empty($dYear3Test) && (!preg_match("/^[0-9]+$/i",$dYear3Test)  || !isValidYear($dYear3Test))) {
	      $dYear3Err = "Not a valid year";  
	    } else{
	      $dYear3 = $dYear3Test;
	    }
	    if (!empty($universiy3Test) && (!preg_match("/^[a-zA-Z ]+$/i",$university3Test)) ) {
	      $university3Err = "Only letters, and white space allowed";
	    } else{
	      $university3 = $university3Test;
	    }
	    if (!empty($gpa4Test) && (!is_numeric($gpa4Test) || !isValidGPA($gpa4Test))) {
	      $gpa4Err = "Not a valid gpa";    
	    } else{
	      $gpa4 = $gpa4Test;
	    }
	    if (!empty($dYear4Test) && (!preg_match("/^[0-9]+$/i",$dYear4Test) || !isValidYear($dYear4Test))) {
	      $dYear4Err = "Not a valid year";  
	    } else{
	      $dYear4 = $dYear4Test;
	    }
	    if (!empty($universiy4Test) &&( !preg_match("/^[a-zA-Z ]+$/i",$unversity4Test)) ) {
	      $university4Err = "Only letters, and white space allowed";
	    } else{
	      $university4 = $university4Test;
	    }


	    if (!preg_match("/^[a-zA-Z ]+$/i",$fnameRecTest) ) {
	      $fnameRecErr = "Only letters, and white space allowed";
	      $dataReady = false;
	    } else{
	      $fnameRec = $fnameRecTest;
	    }
	    if (!preg_match("/^[a-zA-Z ]+$/i",$lnameRecTest) ) {
	      $lnameRecErr = "Only letters, and white space allowed";
	      $dataReady = false;
	    } else{
	      $lnameRec = $lnameRecTest;
	    }
	    if (!preg_match("/^[a-zA-Z ]+$/i",$institutionTest)) {
	      $institutionErr = "Only letters, and white space allowed";
	      $dataReady = false;
	    } else{
	      $institution = $institutionTest;
	    }
	    if (!filter_var($emailTest, FILTER_VALIDATE_EMAIL) ) {
	      $emailErr = "Invalid email";
	      $dataReady = false;
	    } else{
	      $email = $emailTest;
	    }
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

      //fill in personal_info table
      $sql1 = "INSERT INTO personal_info VALUES('".$fname."', '".$lname."', ".$_SESSION['id'].", '".$address."', ".$ssn.")";
      $result1 = mysqli_query($conn, $sql1) or die ("**********2nd MySQL Error***********");

      //fill in GRE table
      $sql2 = "INSERT INTO gre VALUES(".$verbal.", ".$quantitative.", ".$year.", ".$advScore.", '".$subject."', " .$toefl.", ".$advYear.", ".$_SESSION['id'].")";
      $result2 = mysqli_query($conn, $sql2) or die (mysqli_error());

      //fill in academic_info table
      $sql3 = "INSERT INTO academic_info (uid, degreeType, AOI, experience, semester, year) 
              VALUES(".$_SESSION['id'].", '".$degreeType."', '".$aoi."', '".$experience."', '".$semester."', ".$year.")";
      $result3 = mysqli_query($conn, $sql3) or die ("**********3rd MySQL Error***********");
      
      //fill in prior degrees table
      $sql4 = "INSERT INTO prior_degrees VALUES (".$gpa.", " .$dYear.", '".$university."', " .$_SESSION['id']. ", '".$type."')"; 
      $result4 = mysqli_query($conn, $sql4) or die ("**********4th MySQL Error***********");

      if(!empty($_POST["type2"]) && !empty($_POST["gpa2"]) && !empty($_POST["dYear2"]) && !empty($_POST["university2"])){
      	$sql4 = "INSERT INTO prior_degrees VALUES (".$gpa2.", " .$dYear2.", '".$university2."', " .$_SESSION['id']. ", '".$type2."')"; 
        $result4 = mysqli_query($conn, $sql4) or die ("**********5.1 MySQL Error***********");
      }
      if(!empty($_POST["type3"]) && !empty($_POST["gpa3"]) && !empty($_POST["dYear3"]) && !empty($_POST["university3"])){
      	$sql4 = "INSERT INTO prior_degrees VALUES (".$gpa3.", " .$dYear3.", '".$university3."', " .$_SESSION['id']. ", '".$type3."')"; 
        $result4 = mysqli_query($conn, $sql4) or die ("**********5.2 MySQL Error***********");
      }
      if(!empty($_POST["type4"]) && !empty($_POST["gpa4"]) && !empty($_POST["dYear4"]) && !empty($_POST["university4"])){
      	$sql4 = "INSERT INTO prior_degrees VALUES (".$gpa4.", " .$dYear4.", '".$university4."', " .$_SESSION['id']. ", '".$type4."')"; 
        $result4 = mysqli_query($conn, $sql4) or die ("**********5.3 MySQL Error***********");
      }

      //fill in rec_letter table
      $sql5 = "INSERT INTO rec_letter (fname, lname, email, institution, uid) VALUES('".$fnameRec."', '".$lnameRec."', '".$email."', '".$institution."', " . $_SESSION['id'] . ")";
      $result5 = mysqli_query($conn, $sql5) or die ("**********6th MySQL Error***********");
      
      $sql = "UPDATE app_review SET status = 2 WHERE uid = " .$_SESSION['id']. "";
      $result = mysqli_query($conn, $sql) or die ("**********UPDATE STATUS MySQL Error***********");
      // If we made it here,  we're done
      $done = true;
    }

    
    //If the data was successfuly added to database, move to page 2
    if ($done){
      echo "done";
      header("Location:home.php"); 
      exit;
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
      What degree are you applying for? <br>
      <input type="radio" name="degreeType" value="Mas" > MS<br>
      <input type="radio" name="degreeType" value="PhD"> PhD<br><br>
      Year <span class="field"><input type="text" name="appYear">
      <span class="error"><?php echo " " . $appYearErr;?></span></span><br> 
      Semester <br>
      <input type="radio" name="semester" value="Fa"> Fall<br>
      <input type="radio" name="semester" value="Sp"> Spring<br>
      <input type="radio" name="semester" value="Su"> Summer<br><br>
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
      Areas of Interest <span class="field"><input type="text" name="aoi"></span><br>
      Experience <span class="field"><input type="text" name="experience"></span><br>
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
      <span class="error"><?php echo " " . $universityErr;?></span></span><br><br>
    
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
      <span class="error"><?php echo " " . $university2Err;?></span></span><br><br>
      
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
      <span class="error"><?php echo " " . $university3Err;?></span></span><br><br>

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
      <span class="error"><?php echo " " . $university4Err;?></span></span><br><br>
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
