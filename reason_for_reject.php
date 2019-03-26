<?php
  session_start();
  $_SESSION['id'] = 55555555; 
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

  $somethingEmpty = "";
  if (isset($_POST['submit'])){
    if(empty($_POST["reason"])){
      $somethingEmpty = "field required";
    }
    else{
      $sql = "UPDATE app_review SET reason = '" . $_POST["reason"]. "' WHERE uid = " .$_SESSION['id']. "";
      $result = mysqli_query($conn, $sql) or die ("************* SQL FAILED *************");
    }
    die("SUCESS");
  }
?>

<html>
  
  <title>
    Reject
  </title>
  
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