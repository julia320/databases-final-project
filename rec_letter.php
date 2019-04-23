<?php
  session_start(); 
  //connect to database
  $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  //FORM VALIDATION
  function isValidUID($value){
  	if (strlen($value) != 8){
  		return false;
  	}
  	if (!is_numeric($value)){
  		return false;
  	}
	return true;
  }

  $dataReady = true;
  if (isset($_POST['submit'])){

    $uidTest = $_POST["uid"];
    $uidErr = "";
    $uid = "";
    $recTest = $_POST["rec"];
    $recErr = "";
    $rec = "";

    if(empty($uidTest)){
    	$uidErr = "Applicant uid is required";
    	$dataReady = false;
    }
    else if (!isValidUID($uidTest)){
    	$uidErr = "Invalid uid";
    	$dataReady = false;
    }
    else{
    	$sql = "SELECT * FROM rec_letter WHERE uid = " .$uidTest. "";
    	$result = mysqli_query($conn, $sql) or die ("************* Select query failed *************");
    	if (mysqli_num_rows($result) == 0){
	        $uidErr = "There is no applicant with this uid";
	        $dataReady = false;
        }
        else
    		$uid = $uidTest;
    }

    if(strlen($recTest) > 10000){
    	$recErr = "Your recommendation letter is too long";
    	$dataReady = false;
    }
    else if (empty($recTest)){
    	$recErr = "Please write your recommendation";
    	$dataReady = false;
    }
    else{
    	$rec = $recTest;
    }


    if ($dataReady){
    	$sql = "UPDATE rec_letter SET recommendation = '" .$rec. "' WHERE uid = " .$uid; 
    	$result = mysqli_query($conn, $sql) or die ("************* Update query failed *************");
    	die("<br><h2> Recommendation Letter Sent. Please Exit This Page </h2>");
    }
  }
?>

<html>
  
  <title>
    Recomendation Letter
  </title>
  <!-- <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/> -->
  
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
  
   <h1> Write Your Recommendation </h1>
   
  <body>
    
    <form id="mainform" method="post">
      Enter the student's uid that was supplied in the email: <br>
      <input type="text" name="uid">
      <span class="error"><?php echo " " . $uidErr;?></span></span>
      <br><br>
      
      <h3> Write recommendation below </h3>
      <textarea rows="50" cols="100" name="rec" form="mainform"> Enter Recommendation (250 words max)</textarea> <br>
      <span class="error"><?php echo " " . $recErr;?></span></span>

      <div class="bottomCentered"><input type="submit" name="submit" value="Submit Recommendation"> </div>

    </form>
      
    </form>

  </body>
</html>