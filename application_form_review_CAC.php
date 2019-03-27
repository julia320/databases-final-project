<?php
  session_start();
  $studentID = 55555555;
  //$_SESSION['role'] = "CAC";   
  /*Important variable that will be used later to determine 
  if we're ready to move to the next page of the application */
  $done = false;

  // connect to mysql
  $servername = "localhost";
  $user = "sloanej";
  $pass = "Westland76!";
  $dbname = "sloanej";
  $conn = mysqli_connect($servername, $user, $pass, $dbname);
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  ////////////////////////////////////////////////////
  //RETRIEVE INFORMATION
  ////////////////////////////////////////////////////
  $sql = "SELECT fname, lname FROM users WHERE userID = " .$_SESSION['id'];
  $result = mysqli_query($conn, $sql) or die ("************* NAME SQL FAILED *************");
  $value = mysqli_fetch_object($result);
  $fname = $value->fname;
  $lname = $value->lname;


  $sql = "SELECT degreeType, AOI, experience, semester, year FROM academic_info WHERE uid= " .$_SESSION['id'];
  $result = mysqli_query($conn, $sql) or die ("************* ACADEMIC INFO SQL FAILED *************");
  $value = mysqli_fetch_object($result);
  $degreeType = $value->degreeType;
  $aoi = $value->AOI;
  $experience = $value->experience;
  $semester = $value->semester;
  $year = $value->year;

  $sql = "SELECT verbal, quant, year, advScore, subject, toefl, advYear FROM gre WHERE uid= " .$_SESSION['id'];
  $result = mysqli_query($conn, $sql) or die ("************* GRE SQL FAILED *************");
  $value = mysqli_fetch_object($result);
  $verbal = $value->verbal;
  $quant = $value->quant;
  $greYear = $value->year;
  $advScore = $value->advScore;
  $subject = $value->subject;
  $toefl = $value->toefl;
  $advYear = $value->advYear;

  $sql = "SELECT institution FROM rec_letter WHERE uid = " .$_SESSION['id'];
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
      
      //load review info into database
      $sql = "INSERT INTO rec_review VALUES('" .$_SESSION['role'] . "', " .$rating.", " .$generic. ", " .$credible. ", " . $_SESSION['id'].")";
      $result = mysqli_query($conn, $sql) or die ("************* INSERT INTO rec_review SQL FAILED *************");
      $sql = "INSERT INTO app_review (uid, reviewerRole, action, advisor) VALUES(".$_SESSION['id'].", '" .$_SESSION['role']. "', " .$action.", '" .$advisor. "')";
      $result = mysqli_query($conn, $sql) or die ("************* INSERT INTO app_review SQL FAILED *************");

      //update user status
      $status;
      if($action == 1){
        $status = 5;
      } else {
        $status = 4;
      }
      $sql = "UPDATE users SET appStatus = " .$status. " WHERE userID = " .$_SESSION['id']. "";
      $result = mysqli_query($conn, $sql) or die ("************* UPDATE user app status SQL FAILED *************");
      
      //check if defiency is empty. If not, update app review
      if (!empty($_POST["defCourse"])){
        $sql = "UPDATE app_review SET deficiency = '" . $_POST["defCourse"]. "' WHERE uid = " .$_SESSION['id']. " AND reviewerRole = '" .$_SESSION['role'] . "'";
        $result = mysqli_query($conn, $sql) or die ("************* UPDATE app_review WITH dificiency SQL FAILED *************");

      }

      //if comments is not empty, update app review
      if (!empty($_POST["comments"])){
        $sql = "UPDATE app_review SET comments = '" . $_POST["comments"]. "' WHERE uid = " .$_SESSION['id']. " AND reviewerRole = '" .$_SESSION['role'] . "'";
        $result = mysqli_query($conn, $sql) or die ("************* UPDATE app_review WITH comments SQL FAILED *************");

      }

      //if reject, require reason, and load reason into database
      if ($_POST["action"] == 1){
        header("Location:reason_for_reject.php"); 
        exit;
      }

      die("SUCCESS");
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
    <b>Name: </b> <u> <?php echo $fname.", ".$lname; ?> </u> <br><br>
    <b>Student Number: </b> <u> <?php echo $studentNumber; ?> </u> <br><br>
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
      $sql = "SELECT * FROM prior_degrees WHERE uid= " .$_SESSION['id'];
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
