<?php
  session_start();
  /*Important variable that will be used later to determine 
  if we're ready to move to the next page of the application */

  //connect to database
  $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $somethingEmpty = "";
  if (isset($_POST['submit'])){
    if(empty($_POST["reason"])){
      $somethingEmpty = "field required";
    }
    else{
      $sql = "UPDATE app_review SET reason = '" . $_POST["reason"]. "' WHERE reviewID = " .$_SESSION['reviewID']. "";
      $result = mysqli_query($conn, $sql) or die ("************* SQL FAILED *************");
    }

    $_SESSION['reviewID'] = "";
    header("Location:home.php"); 
    exit;
  }
?>

<html>
  
  <title>
    Reject
  </title>
  <!-- <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" /> -->
    <link rel = "stylesheet" type="text/css" href="style.css"/>
  
  <style>
    body{
      line-height: 1.6;
    }
    .bottomCentered{
       position: fixed;   
       text-align: center;
       bottom: 30px;
       width: 100%;
    }
    .error {color: #FF0000;}
  </style>
  
  <h2> Reason for rejecting applicant: </h2>

  <body>
    <!--app entity list -->
    <form id="mainform" method="post">

      A <input type="radio" name="reason" value="A" > Incomplete record <br>
      B <input type="radio" name="reason" value="B" > Does not meet minimum requirements <br>
      C <input type="radio" name="reason" value="C" > Problems with letters <br>
      D <input type="radio" name="reason" value="D" > Not competitive <br>
      E <input type="radio" name="reason" value="E" > Other reasons <br>

      <div class="bottomCentered"><input type="submit" name="submit" value="Submit Review">
      <span class="error"><?php echo $somethingEmpty;?></span></div>
    </form>
  </body>
</html>