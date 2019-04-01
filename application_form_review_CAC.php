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

  ////////////////////////////////////////////////////
  //RETRIEVE INFORMATION
  ////////////////////////////////////////////////////
  // get the applicant the GS wants to update
  $applicants = mysqli_query($conn, "SELECT * FROM users WHERE role='A'");
  while ($row = $applicants->fetch_assoc()) {
    if (isset($_POST[$row['userID']])) {
      $_SESSION['applicantID'] = $row['userID'];
      $fname = $row['fname'];
      $lname = $row['lname'];
      $name = $fname." ".$lname;
    }
  }
  if (!$_SESSION['applicantID'])
    echo "Error: Applicant not found</br>";

  $sql = "SELECT degreeType, AOI, experience, semester, year FROM academic_info WHERE uid= " .$_SESSION['applicantID'];
  $result = mysqli_query($conn, $sql) or die ("************* ACADEMIC INFO SQL FAILED *************");
  $value = mysqli_fetch_object($result);
  $degreeType = $value->degreeType;
  $aoi = $value->AOI;
  $experience = $value->experience;
  $semester = $value->semester;
  $year = $value->year;

  $sql = "SELECT verbal, quant, year, advScore, subject, toefl, advYear FROM gre WHERE uid= " .$_SESSION['applicantID'];
  $result = mysqli_query($conn, $sql) or die ("************* GRE SQL FAILED *************");
  $value = mysqli_fetch_object($result);
  $verbal = $value->verbal;
  $quant = $value->quant;
  $greYear = $value->year;
  $advScore = $value->advScore;
  $subject = $value->subject;
  $toefl = $value->toefl;
  $advYear = $value->advYear;

  $sql = "SELECT institution FROM rec_letter WHERE uid = " .$_SESSION['applicantID'];
  $result = mysqli_query($conn, $sql) or die ("************* REC LETTER SQL FAILED *************");
  $value = mysqli_fetch_object($result);
  $university = $value->institution;
  /////////////////////////////////////////////////////////////

  $somethingEmpty = "";
  if (isset($_POST['submit'])){
   if(
     empty($_POST["rating"]) ||
     empty($_POST["generic"]) ||
     empty($_POST["credible"]) ||
     empty($_POST["action"]) ||
     empty($_POST["advisor"]))
      $somethingEmpty = "One or more required fields are missing";
    else{
      $rating = $_POST["rating"];
      $generic = $_POST["generic"];
      $credible = $_POST["credible"];
      $action = $_POST["action"];
      $advisor = $_POST["advisor"];
      
     
      //set up foreign key reference between rec_letter and rec_review
      $recID;
      $sql = "SELECT recID FROM rec_letter WHERE uid = " . $_SESSION['applicantID'];
      $result = mysqli_query($conn, $sql) or die ("************* GET recID FAILED*************");
      if (mysqli_num_rows($result) != 0){
        $value = mysqli_fetch_object($result);
        $recID = $value->recID;
      }
      else{
        die("Cannot Review: This applicant does not have a recommendation letter");
      }
      //set up foreign key reference between rec_review and app_review
      $sql = "SELECT reviewID FROM app_review WHERE uid = " . $_SESSION['applicantID'] . " AND reviewerRole = 'CAC'";
      $result = mysqli_query($conn, $sql) or die ("************* GET reviewID FAILED*************");
      if (mysqli_num_rows($result) != 0){
        $value = mysqli_fetch_object($result);
        $reviewID = $value->reviewID;
      }
      else{
        die("Cannot Review: This applicant has not been initialized properly int the database");
      }
      
      //Calculate final status (THIS WILL INDICATE THE FINAL DECISION) cooresonding to the "final decision section" )
      $status = 3;
      if ($action == 1){
        $status = 6;
      }
      if ($action == 2){
        $status = 4;
      }
      if ($action == 3){
        $status = 4;
      }
      if ($action == 4){
        $status = 5;
      }

      //load general review info into datase
      $sql = "UPDATE app_review  SET reviewerRole = '" .$_SESSION['role']. "', rating = " .$action.", advisor = '" .$advisor. "', status = 3 WHERE reviewID = " .$reviewID. "";
      $result = mysqli_query($conn, $sql) or die ("************* INSERT INTO app_review SQL FAILED *************");

      //load rec review info into database
      $sql = "INSERT INTO rec_review VALUES(" .$reviewID. ", '" .$_SESSION['role']. "', " .$rating.", " .$generic. ", " .$credible. ", " . $_SESSION['applicantID'].", ". $recID . ")";
      $result = mysqli_query($conn, $sql) or die ("************* INSERT INTO rec_review SQL FAILED *************");

      //update status for all instances of applicant
      $sql = "UPDATE app_review SET status = " .$status. " WHERE uid = " .$_SESSION['applicantID']. "";
      $result = mysqli_query($conn, $sql) or die ("************* UPDATE ALL STATUS'S SQL FAILED************");
       
      //check if defiency is empty. If not, update app review
      if (!empty($_POST["defCourse"])){
        $sql = "UPDATE app_review SET deficiency = '" . $_POST["defCourse"]. "' WHERE uid = " .$_SESSION['applicantID']. " AND reviewID = " .$reviewID . "";
        $result = mysqli_query($conn, $sql) or die ("************* UPDATE app_review WITH dificiency SQL FAILED *************");

      }

      //if comments is not empty, update app review
      if (!empty($_POST["comments"])){
        $sql = "UPDATE app_review SET comments = '" . $_POST["comments"]. "' WHERE uid = " .$_SESSION['applicantID']. " AND reviewID = " .$reviewID . "";
        $result = mysqli_query($conn, $sql) or die ("************* UPDATE app_review WITH comments SQL FAILED *************");
      }
      
      //check if defiency is empty. If not, update app review
      if (!empty($_POST["defCourse"])){
        $sql = "UPDATE app_review SET deficiency = '" . $_POST["defCourse"]. "' WHERE uid = " .$_SESSION['applicantID']. " AND reviewerRole = '" .$_SESSION['role'] . "'";
        $result = mysqli_query($conn, $sql) or die ("************* UPDATE app_review WITH dificiency SQL FAILED *************");
      }

      //if comments is not empty, update app review
      if (!empty($_POST["comments"])){
        $sql = "UPDATE app_review SET comments = '" . $_POST["comments"]. "' WHERE uid = " .$_SESSION['applicantID']. " AND reviewerRole = '" .$_SESSION['role'] . "'";
        $result = mysqli_query($conn, $sql) or die ("************* UPDATE app_review WITH comments SQL FAILED *************");

      }

      //if reject, require reason, and load reason into database
      if ($_POST["action"] == 1){
        $_SESSION['reviewID'] = $reviewID;
        header("Location:reason_for_reject.php"); 
        exit;
      }

       header("Location:home.php"); 
       exit;
    }
  }
?>

<html>
  
  <title>
    CAC Review Form
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
    table, th, td {
      text-align: left;
    }
  </style>
  
  <h1> Chair of Admissions Committee - Graduate Admissions Review Form </h1>

  <body>
    <b>Name: </b> <u> <?php echo $name; ?> </u> <br><br>
    <b>Student Number: </b> <u> <?php echo $_SESSION['applicantID']; ?> </u> <br><br>
    <b>Semester and Year of Application: </b> <u> <?php echo $semester." ".$year; ?> </u> <br><br>
    <b>Applying for Degree: </b> <u> <?php echo $degreeType; ?> </u> <br>
    <hr>

    <h3>Summary of Credentials </h3>
    <b>GRE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Verbal: </b>
    <u> <?php echo $verbal; ?> </u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Quantitative: </b>
    <u> <?php echo $quant; ?> </u><br>
    <b>Year of Exam: </b> <u> <?php echo $greYear; ?> </u> <br>
    <b>GRE Advanced &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Score: </b>
    <u> <?php echo $advScore; ?> </u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Subject: </b>
    <u> <?php echo $subject; ?> </u><br>
    <b>TOEFL Score: </b> <u> <?php echo $toefl; ?> </u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <b>Year of Exam: </b> <u> <?php echo $advYear; ?> </u> <br><br>

    <h3>Prior Degrees </h3> 
    <?php
      //display prior degree info in a table format
      $sql = "SELECT * FROM prior_degrees WHERE uid= " .$_SESSION['applicantID'];
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0){
        echo "<table style=width:40%>";
        echo "<tr>";
        echo "<th>Degree</th>";
        echo "<th>GPA </th>";
        //Add Major
        echo "<th>Year</th>";
        echo "<th>University</th>";
        echo "</tr>";
        while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['deg_type'] . "</td>";
          echo "<td>" . $row['gpa'] . "</td>";
          echo "<td>" . $row['year'] . "</td>";
          echo "<td>" . $row['university'] . "</td>";
          echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
      }
    ?>

    <b>Areas of Interest: </b> <u> <?php echo $aoi; ?> </u> <br>
    <b>Experience: </b> <u> <?php echo $experience; ?> </u> <br><br>

    <h3>Recommendation Letter </h3>
    <b>From: </b> <u> <?php echo $university; ?> </u> <br>
    <form id="mainform" method="post">
      Rating: &nbsp;&nbsp;&nbsp;&nbsp; 
      1<input type="radio" name="rating" value=1 > &nbsp;&nbsp;&nbsp;&nbsp;
      2<input type="radio" name="rating" value=2 > &nbsp;&nbsp;&nbsp;&nbsp;
      3<input type="radio" name="rating" value=3 > &nbsp;&nbsp;&nbsp;&nbsp;
      4<input type="radio" name="rating" value=4 > &nbsp;&nbsp;&nbsp;&nbsp;
      5<input type="radio" name="rating" value=5 > <br>
      Generic: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      Yes<input type="radio" name="generic" value=true> &nbsp;&nbsp;&nbsp;&nbsp;
      No<input type="radio" name="generic" value=false> <br>
      Credible: &nbsp;&nbsp;&nbsp;&nbsp; 
      Yes<input type="radio" name="credible" value=true> &nbsp;&nbsp;&nbsp;&nbsp;
      No<input type="radio" name="credible" value=false> <hr>

      <h2> Final Decision </h2>

      1. <input type="radio" name="action" value=1 > Reject <br>
      2. <input type="radio" name="action" value=2 > Borderline Admit <br>
      3. <input type="radio" name="action" value=3 > Admit without Aid <br>
      4. <input type="radio" name="action" value=4 > Admit with aid <br>
      
      <b>Deficiency Courses if Any: </b><input type="text" name="defCourse"><br>
      <b>Recommended Advisor: </b><input type="text" name="advisor"><br>

      <div class="bottomCentered"><input type="submit" name="submit" value="Submit Review">
      <span class="error"><?php echo $somethingEmpty;?></span></div>

    </form>

     <b>CAC Comments: </b><br>
     <textarea rows="5" cols="50" name="comments" form="mainform"></textarea>

  </body>
</html>
