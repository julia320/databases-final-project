
<?php
  session_start();  
  /*Important variable that will be used later to determine 
  if we're ready to move to the next page of the application */
  $done = false;

  //connect to database
  $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
 

  /* Get the review we want to look at */
  $reviewers = mysqli_query($conn, "SELECT * FROM user WHERE type LIKE '%rev%'");
  while ($row = $reviewers->fetch_assoc()) {
    if (isset($_POST[$row['uid']])) {
      $reviewer = $row['uid'];
      $name = $row['fname']." ".$row['lname'];
    }
  }
  if (!$reviewer)
    echo "Error: Review not found</br>";

  if (!$_SESSION['applicantID']) // should be set from before
    echo "Error: Applicant not found</br>";

  // Get applicant's name
  $applicant = mysqli_query($conn, "SELECT * FROM user WHERE uid=".$_SESSION['applicantID']);
  $applicant = $applicant->fetch_assoc();
  $appname = $applicant['fname']." ".$applicant['lname'];


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

  
  $sql = "SELECT comments, deficiency, rating, advisor FROM app_review WHERE uid=".$_SESSION['applicantID']." AND reviewer=".$reviewer;
  $result = mysqli_query($conn, $sql) or die ("************* retrieve app review SQL FAILED *************");
  $value = mysqli_fetch_object($result);
  $comments = $value->comments;
  $deficiency = $value->deficiency;
  $action = $value->rating;
  $advisor = $value->advisor;
  
?>

<html>
  
  <title>Faculty Review</title>
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

  <body>

    <h1><?php echo $name;?>'s Review of <?php echo $appname;?></h1>

    <!-- General info -->
    <h2> Applicant Information </h2>
    <b>Name: </b> <u> <?php echo $appname; ?> </u> <br><br>
    <b>Student Number: </b> <u> <?php echo $_SESSION['applicantID']; ?> </u> <br><br>

    <!-- Academic Info -->
    <b>Semester and Year of Application: </b> <u> <?php echo $semester." ".$year; ?> </u> <br><br>
    <b>Applying for Degree: </b> <u> <?php echo $degreeType; ?> </u> <br>

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


    <!-- Prior Degrees -->
    <h3>Prior Degrees </h3> 
    <?php
      //display prior degree info in a table format
      $sql = "SELECT * FROM prior_degrees WHERE uid= " .$_SESSION['uid'];
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
    <hr>


    <h2> Faculty Review </h2>

    <?php
    /* Show recommendations with reviews */
    $query = "SELECT * FROM rec_letter WHERE uid = " .$_SESSION['applicantID'];
    $result = mysqli_query($conn, $query) or die ("************* REC LETTER SQL FAILED *************");
    while ($value = $result->fetch_assoc()) {
      echo "<h3>Recommendation ".($i+1)."</h3>";
      echo "<b>From:</b> ".$value['fname']." ".$value['lname'].", ".$value['institution'];
      echo"<br/><b>Recommendation: </b>\"".$value['recommendation']."\"<br/>";
      $recid = $value['recID'];

      $sql2 = "SELECT rating, generic, credible FROM rec_review WHERE uid=".$_SESSION['applicantID']." AND reviewer=".$reviewer." AND recID=".$recid;
      $result = mysqli_query($conn, $sql2) or die ("************ retrieve rec review SQL FAILED ************");
      $value = mysqli_fetch_object($result);
      $rating = $value->rating;
      $generic = $value->generic;
      $credible = $value->credible;
      if($generic == 1){
        $generic = "Yes";
      } else {
        $generic = "No";
      }
      if($credible == 1){
        $credible = "Yes";
      } else {
        $credible = "No";
      }
      echo "<b>Faculty rating:</b> <u>".$rating."</u><br>
        <b>Generic:</b> <u>".$generic."</u><br>
        <b>credible:</b> <u>".$credible."</u><br><br>";
    }// end recommendations
    ?>

    <h3>Faculty Reviewer Action </h3>
    <b>Recommended Action: </b> <u> <?php echo $action; ?> </u> <br>
    (1=Reject, 2=Borderline admit, 3=Admit without aid, 4=Admit with aid)<br>
    <b>Recommended Deficiency Courses: </b> <u> <?php echo $dificiency; ?> </u> <br>
    <b>Recommended Advisor: </b> <u> <?php echo $advisor; ?> </u> <br>
    <b>Faculty Reviewer Comments: </b> <br>
    <textarea rows="4" cols="50"><?php echo $comments; ?> </textarea>
  	

    <?php
    echo '<form id="mainform" method="post" action="application_form_review.php">
        <div class="bottomCentered"> <input type="button" value="Back" onclick="history.back()"> </div>
        </form>';
    ?>

  </body>
</html>
