<?php
  session_start();
  /*Important variable that will be used later to determine 
  if we're ready to move to the next page of the application */
  $done = false;

  // connect to mysql
  $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }


  /* RETRIEVE INFORMATION */
  // get the applicant the GS wants to update
  $applicants = mysqli_query($conn, "SELECT * FROM user WHERE type='App'");
  while ($row = $applicants->fetch_assoc()) {
    if (isset($_POST[$row['uid']])) {
      $_SESSION['applicantID'] = $row['uid'];
      $fname = $row['fname'];
      $lname = $row['lname'];
      $name = $fname." ".$lname;
    }
  }
  if (!$_SESSION['applicantID'])
    echo "Error: Applicant not found</br>";


  /* IF THIS STUDENT HAS ALREADY BEEN REVIEWED BY THIS REVIEWER, DON'T ALLOW ANOTHER */
  $q = "SELECT status, rating FROM app_review WHERE reviewer=".$_SESSION['uid']." AND uid=".$_SESSION['applicantID'];
  $result = mysqli_query($conn, $q);
  $value = mysqli_fetch_object($result);
  if ($value->rating != NULL){
    $_SESSION['error'] = "<p style='color:red; text-align:center;'>You have already reviewed this student.</p><br/>";
    header("Location: home.php");
    die();
  }
  $status = $value->status;

  
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


  // View other reviews
  $view = "<br/>";
  $q = "SELECT user.uid, lname, reviewer, rating FROM user, app_review WHERE user.uid=reviewer AND app_review.uid=".$_SESSION['applicantID'];
  $reviews = mysqli_query($conn, $q) or die ("Error: line 120");
  while ($row = $reviews->fetch_assoc()) {
    // if a review has been made, show the button
    if ($row['rating'] != NULL) {
      $view .= "<form action='view_faculty_review.php' method='post'>
            <input type='submit' name=".$row['uid']." value=\"View ".$row['lname']."'s Review\">
            </form>";
    }
  }


  /* Validation and SQL inserts/updates */
  $somethingEmpty = "";
  $greenlight = 1;;
  if (isset($_POST['submit'])){

    if(empty($_POST["recRating"]) || empty($_POST["generic"]) || empty($_POST["credible"]) || empty($_POST["rating"]) || empty($_POST["advisor"])){
      if ($_POST["rating"] == 1 && !empty($_POST["recRating"]) && !empty($_POST["generic"]) && !empty($_POST["credible"])){

      }
      else{
        $greenlight = 0;
        $somethingEmpty = "One or more required fields are missing";
      }
    } 
    
    if ($greenlight == 1){

      // Get the date
      $date = date("Y/m/d");

      // set up foreign key reference between rec_letter and rec_review
      $recID;
      $sql = "SELECT recID FROM rec_letter WHERE uid = " . $_SESSION['applicantID'];
      $result = mysqli_query($conn, $sql) or die ("************* GET recID FAILED*************");
      if (mysqli_num_rows($result) != 0){
        $value = mysqli_fetch_object($result);
        $recID = $value->recID;
      }
      else{
        echo "<p style='color:red;'>Error: This applicant does not have a recommendation letter</p>";
      }


      // Update final decision IF the reviewer is the CAC
      if (in_array("cac", $_SESSION['types'])) {
        // Calculate status
        $action = $_POST['rating'];
        if ($action == 1) {
          $status = 8;
        }
        if ($action == 2 || $action == 3) {
          $status = 6;
        }
        if ($action == 4) {
          $status = 7;
        }

        // Update all instances of the applicant's reviews
        mysqli_query($conn, "UPDATE app_review SET status=".$status." WHERE uid=".$_SESSION['applicantID']);
      }


      /* Load general review info into datase */
      // these are such ugly queries, I'm so sorry
      $sql = "INSERT INTO app_review (uid, reviewer, comments, deficiency, rating, advisor, status, dated) VALUES (".$_SESSION['applicantID'].", ".$_SESSION['uid'].", '".$_POST['comments']."', '".$_POST['defCourse']."', ".$_POST['rating'].", '".$_POST['advisor']."', ".$status.", '".$date."') ON DUPLICATE KEY UPDATE comments='".$_POST['comments']."', deficiency='".$_POST['defCourse']."', rating=".$_POST['rating'].", advisor='".$_POST['advisor']."', status=".$status.", dated='".$date."'";
      $result = mysqli_query($conn, $sql) or die ("Insert into app_review failed: ".mysqli_error($conn));

      /* Load rec review info into database */
      $sql = "INSERT INTO rec_review VALUES(".$_SESSION['applicantID'].", ".$_SESSION['uid'].", ".$_POST['recRating'].", ".$_POST['generic'].", ".$_POST['credible'].", ".$recID.") ON DUPLICATE KEY UPDATE rating=".$_POST['recRating'].", generic=".$_POST['generic'].", credible=".$_POST['credible'];
      $result = mysqli_query($conn, $sql) or die ("Insert into rec_review failed: ".mysqli_error($conn));


      // if reject, require reason
      if ($_POST["rating"] == 1){
        header("Location:reason_for_reject.php"); 
        exit;
      }

      header("Location:home.php"); 
      exit;
    }
  }
?>

<html>
  
  <title>Review Form</title>
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
    table, th, td {
      text-align: left;
    }
  </style>
  
  <h1> Graduate Admissions Review Form </h1>

  <body>
    <b>Name: </b> <u> <?php echo $name; ?> </u> <br><br>
    <b>Student Number: </b> <u> <?php echo $_SESSION['applicantID']; ?> </u> <br><br>
    <b>Semester and Year of Application: </b> <u> <?php echo $semester." ".$year; ?> </u> <br><br>
    <b>Applying for Degree: </b> <u> <?php echo $degreeType; ?> </u> <br>
    <hr>

    <h2>Application</h2>
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
        echo "<th>Year</th>";
        echo "<th>University</th>";
        echo "<th>Major</th>";
        echo "</tr>";
        while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['deg_type'] . "</td>";
          echo "<td>" . $row['gpa'] . "</td>";
          echo "<td>" . $row['year'] . "</td>";
          echo "<td>" . $row['university'] . "</td>";
           echo "<td>" . $row['major'] . "</td>";
          echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
      }
    ?>

    <br/>
    <b>Areas of Interest: </b> <u> <?php echo $aoi; ?> </u> <br>
    <b>Experience: </b> <u> <?php echo $experience; ?> </u> <br><br>

    <?php echo $view; ?>
    <br/><hr>

    <h2>Review Form:</h2>
    <h3>Recommendation Letter </h3>
    <b>From: </b> <u> <?php echo $university; ?> </u> <br>
    <form id="mainform" method="post">
      Rating: &nbsp;&nbsp;&nbsp;&nbsp; 
      1<input type="radio" name="recRating" value=1 > &nbsp;&nbsp;&nbsp;&nbsp;
      2<input type="radio" name="recRating" value=2 > &nbsp;&nbsp;&nbsp;&nbsp;
      3<input type="radio" name="recRating" value=3 > &nbsp;&nbsp;&nbsp;&nbsp;
      4<input type="radio" name="recRating" value=4 > &nbsp;&nbsp;&nbsp;&nbsp;
      5<input type="radio" name="recRating" value=5 > <br>
      Generic: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      Yes<input type="radio" name="generic" value=true> &nbsp;&nbsp;&nbsp;&nbsp;
      No<input type="radio" name="generic" value=false> <br>
      Credible: &nbsp;&nbsp;&nbsp;&nbsp; 
      Yes<input type="radio" name="credible" value=true> &nbsp;&nbsp;&nbsp;&nbsp;
      No<input type="radio" name="credible" value=false>

      <h3> Grad Admissions Commitee Review Rating </h3>

      1. <input type="radio" name="rating" value=1 > Reject <br>
      2. <input type="radio" name="rating" value=2 > Borderline Admit <br>
      3. <input type="radio" name="rating" value=3 > Admit without Aid <br>
      4. <input type="radio" name="rating" value=4 > Admit with aid <br>
      
      <b>Deficiency Courses if Any: </b><input type="text" name="defCourse"><br>
      <b>Recommended Advisor: </b><input type="text" name="advisor"><br>

      <div class="bottomCentered"><input type="submit" name="submit" value="Submit Review">
      <span class="error"><?php echo $somethingEmpty;?></span></div>

    </form>

     <b>GAS Reviewer Comments: </b><br>
     <textarea rows="5" cols="50" name="comments" form="mainform"></textarea>

  </body>
</html>
