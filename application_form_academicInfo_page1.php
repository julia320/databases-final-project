<?php
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

  if (isset($_POST['submit'])){
    
    //make sure all the data was entered properly
    if(count(array_filter($_POST))!=count($_POST)){
      $somethingEmpty = "One or more fields are missing";
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
    
    if (!preg_match("/^[0-9]+$/i",$appYearTest) && !empty($_POST["appYear"])) {
      $appYearErr = "Not a valid date"; 
    }
    if (!preg_match("/^[0-9]+$/i",$verbalTest) && !empty($_POST["verbal"])) {
      $appYearErr = "Not a valid score"; 
    }
    if (!preg_match("/^[0-9]+$/i",$quantitativeTest) && !empty($_POST["quantitative"])) {
      $appYearErr = "Not a valid score"; 
    }
    if (!preg_match("/^[0-9]+$/i",$yearTest) && !empty($_POST["year"])) {
      $appYearErr = "Not a valid date"; 
    }
    if (!preg_match("/^[0-9]+$/i",$advScoreTest) && !empty($_POST["advScore"])) {
      $appYearErr = "Not a valid score"; 
    }
    if (!preg_match("/^[a-zA-Z0-9 ]+$/i",$subjectTest) && !empty($_POST["subject"])) {
      $appYearErr = "Not a valid subject - only letters, numbers, and white space allowed"; 
    }
    if (!preg_match("/^[0-9]+$/i",$toeflTest) && !empty($_POST["toefl"])) {
      $appYearErr = "Not a valid score"; 
    }
    if (!preg_match("/^[0-9]+$/i",$advYearTest) && !empty($_POST["advYear"])) {
      $appYearErr = "Not a valid date"; 
    }
    if (!preg_match("/^[a-zA-Z0-9 ]+$/i",$aoiTest) && !empty($_POST["aoi"])) {
      $aoiErr = "Only letters, numbers, and white space allowed"; 
    }
    if (!preg_match("/^[a-zA-Z0-9 ]+$/i",$experienceTest) && !empty($_POST["experience"])) {
      $experienceErr = "Only letters, numbers, and white space allowed"; 
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
      <input type="radio" name="degreeType" value="MS" > MS<br>
      <input type="radio" name="degreeType" value="PhD"> PhD<br><br>
  
      Year <span class="field"><input type="text" name="appYear">
      <span class="error"><?php echo " " . $appYearErr;?></span></span><br>
      
      Semester <br>
      <input type="radio" name="semester" value="fall"> Fall<br>
      <input type="radio" name="semester" value="spring"> Spring<br>
      <input type="radio" name="semester" value="summer"> Summer<br><br>
      
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
