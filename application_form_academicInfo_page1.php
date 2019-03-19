<?php
  session_start(); 
  /*Important variable that will be used later to determine 
  if we're ready to move to the next page of the application */
  $done = false;

  // connect to mysql
  $servername = "localhost";
  $user = "TheSpookyLlamas";
  $pass = "TSL_jjy_2019";
  $dbname = "TheSpookyLlamas";
  $conn = mysqli_connect($servername, $user, $pass, $dbname);
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  //HANDLE FORM VALIDATION
  $somethingEmpty = "";
  $appYearErr = "";
  $verbalErr = "";
  $quantitativeErr = "";
  $yearErr = "";
  $advScoreErr = "";
  $subjectErr = "";
  $toeflErr = "";
  $advYearErr = "";
  $aoiErr = "";
  $experienceErr = "";

  if (isset($_POST['submit'])){
    $dataReady = true;
    
    //make sure all the data was entered properly
    if(count(array_filter($_POST))!=count($_POST)){
      $somethingEmpty = "One or more fields are missing";
      $dataReady = false;
    }
    
    //field validations:
    $appYearTest = $_POST["appYear"];
    $verbalTest = $_POST["verbal"];
    $quantitativeTest = $_POST["quantitative"];
    $yearTest =  $_POST["year"];
    $advScoreTest = $_POST["advScore"];
    $subjectTest = $_POST["subject"];
    $toeflTest = $_POST["toefl"];
    $advYearTest = $_POST["advYear"];
    $aoiTest = $_POST["aoi"];
    $experienceTest = $_POST["exerience"];
    
    $appYear= "";
    $verbal= "";
    $quantitative= "";
    $year= "";
    $advScore= ""; 
    $subject= ""; 
    $toefl= ""; 
    $advYear= ""; 
    $aoi= ""; 
    $experience= "";
    $degreeType = $_POST["degreeType"];
    $semester = $_POST["semester"];
      
    if (!preg_match("/^[0-9]+$/i",$appYearTest) && !empty($_POST["appYear"])) {
      $appYearErr = "Not a valid date";
      $dataReady = false;
    } else{
      $appYear = $appYearTest;
    }
    if (!preg_match("/^[0-9]+$/i",$verbalTest) && !empty($_POST["verbal"])) {
      $verbalErr = "Not a valid score";
      $dataReady = false;
    } else{
      $verbal = $verbalTest;
    }
    if (!preg_match("/^[0-9]+$/i",$quantitativeTest) && !empty($_POST["quantitative"])) {
      $quantitativeErr = "Not a valid score";
      $dataReady = false;
    } else{
      $quantitative = $quantitativeTest;
    } 
    if (!preg_match("/^[0-9]+$/i",$yearTest) && !empty($_POST["year"])) {
      $yearErr = "Not a valid date";
      $dataReady = false;
    } else{
      $year = $yearTest;
    }
    if (!preg_match("/^[0-9]+$/i",$advScoreTest) && !empty($_POST["advScore"])) {
      $advScoreErr = "Not a valid score";
      $dataReady = false;
    } else{
      $advScore = $advScoreTest;
    }
    if (!preg_match("/^[a-zA-Z0-9 ]+$/i",$subjectTest) && !empty($_POST["subject"])) {
      $subjectErr = "Not a valid subject - only letters, numbers, and white space allowed";
      $dataReady = false;
    } else{
      $subject = $subjecTest;
    }
    if (!preg_match("/^[0-9]+$/i",$toeflTest) && !empty($_POST["toefl"])) {
      $toeflErr = "Not a valid score";
      $dataReady = false;
    } else{
      $toefl = $toeflTest;
    }
    if (!preg_match("/^[0-9]+$/i",$advYearTest) && !empty($_POST["advYear"])) {
      $advYearErr = "Not a valid date";
      $dataReady = false;
    } else{
      $advYear = $advYearTest;
    }
    if (!preg_match("/^[a-zA-Z0-9 ]+$/i",$aoiTest) && !empty($_POST["aoi"])) {
      $aoiErr = "Only letters, numbers, and white space allowed";
      $dataReady = false;
    } else{
      $aoi = $aoiTest;
    }
    if (!preg_match("/^[a-zA-Z0-9 ]+$/i",$experienceTest) && !empty($_POST["experience"])) {
      $experienceErr = "Only letters, numbers, and white space allowed";
      $dataReady = false;
    } else{
      $experience = $experienceTest;
    }
    
    //Insert into database 
    if ($dataReady == true){
      $sql = "INSERT INTO academic_info (uid, degreeType, AOI, experience, semester, year) 
              VALUES('-1', $degreeType', '$aoi', '$experience', '$semester', '$year')";
      $result = mysqli_query($conn, $sql) or die ("************* SQL FAILED *************");
      //Check	if query was successful	
      if ($result)	{	
        //Account created - we are ready back to webstore and be logged in
        $done = true;
        echo "DATA ADDED";
      }    
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
   <h2> Page 1: Academic Info </h2><br>
  
  <body>
    <!--action="application_form_priorDegrees_page2.php"-->
    <form id="mainform" method="post">
     
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
      Subject <span class="field"><input type="text" name="subject">
      <span class="error"><?php echo " " . $subjectErr;?></span></span><br><br>
      TOEFL Score <span class="field"><input type="text" name="toefl">
      <span class="error"><?php echo " " . $toeflErr;?></span></span><br>
      Year of exam <span class="field"><input type="text" name="advYear">
      <span class="error"><?php echo " " . $advYearErr;?></span></span><br><br>

      Areas of Interest <span class="field"><input type="text" name="aoi">
      <span class="error"><?php echo " " . $aoiErr;?></span></span><br>
      Experience <span class="field"><input type="text" name="experience">
      <span class="error"><?php echo " " . $experienceErr;?></span></span><br>
      
      <div class="bottomCentered"><input type="submit" name="submit" value="Submit">
      <span class="error"><?php echo $somethingEmpty;?></span></div>
      
    </form>
      
  </body>
</html>
