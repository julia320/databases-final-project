
<?php
  session_start(); 
  //connect to database
  $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  

  $dataReady = true;
  if (isset($_POST['submit'])){

    $uidTest = $_POST["uid"];
    $recIDTest = $_POST['recID'];
    $recTest = $_POST["rec"];

    // UID validation
    if(empty($uidTest)){
    	$uidErr = "Applicant uid is required";
    	$dataReady = false;
    }
    else{
    	$sql = "SELECT * FROM user WHERE uid = " .$uidTest. "";
    	$result = mysqli_query($conn, $sql) or die ("************* Select query failed *************");
    	if (mysqli_num_rows($result) == 0){
	        $uidErr = "There are no applicants with this uid.";
	        $dataReady = false;
        }
        else
    		  $uid = $uidTest;
    }

    // RecID validation
    if(empty($recIDTest)){
      $recIDErr = "RecID is required";
      $dataReady = false;
    }
    else{
      $sql = "SELECT * FROM rec_letter WHERE recID=".$recIDTest;
      $result = mysqli_query($conn, $sql) or die ("************* Select query failed *************");
      if (mysqli_num_rows($result) == 0){
          $recIDErr = "This an invalid recommendation ID.";
          $dataReady = false;
        }
        else
          $recID = $recIDTest;
    }

    // Rec text validation
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


    // Update status based on what they already have
    $result = mysqli_query($conn, "SELECT transcript FROM academic_info WHERE uid=".$uid);
    if (!$result) 
      echo "Error retrieving application info: ".mysqli_error();
    $row = $result->fetch_assoc();
    $transcript = $row['transcript'];

    // if they have the transcript, then it is now complete
    if ($row['transcript'] == 1) {
      mysqli_query($conn, "UPDATE app_review SET status=5 WHERE uid=".$uid) or die ("Update status failed: ".mysqli_error($conn));
    }
    // if transcript is missing, status is now 3
    else {
      mysqli_query($conn, "UPDATE app_review SET status=3 WHERE uid=".$uid) or die ("Update status failed: ".mysqli_error($conn));
    }

    // put the result itself in if statement instead of queries 
    mysqli_query($conn, "UPDATE academic_info SET recletter=1 WHERE uid=".$uid);


    if ($dataReady) {
      $sql = "UPDATE rec_letter SET recommendation = '".$rec."' WHERE uid=".$uid." AND recID=".$recID; 
      $result = mysqli_query($conn, $sql) or die ("Update query failed: ".mysqli_error($conn));
      die("<br><h2> Recommendation Letter Sent. Please Exit This Page </h2>");
    }
  }
?>

<html>
  
  <title>Recomendation Letter</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
  
  <style>
    .field {
      position: absolute;
      left: 140px;
    }
    body{line-height: 1.6;}
    .error {color: #FF0000;}
  </style>
   
  <body>

    <h2> Write Your Recommendation </h2>
    
    <form id="mainform" method="post">
      Enter the student's uid that was supplied in the email: <br>
      <input type="number" name="uid">
      <span class="error"><?php echo " " . $uidErr;?></span></span>
      <br><br>

      Enter the recID that was supplied in the email: <br>
      <input type="number" name="recID">
      <span class="error"><?php echo " ".$recIDErr;?></span></span>
      <br><br>
      
      <h3> Write recommendation below </h3>
      <h5>(250 words maximum)</h5>
      <textarea rows="50" cols="100" name="rec" form="mainform"></textarea> <br>
      <span class="error"><?php echo " " . $recErr;?></span></span>

      <input type="submit" name="submit" value="Submit Recommendation">

    </form>
      
    </form>

  </body>
</html>