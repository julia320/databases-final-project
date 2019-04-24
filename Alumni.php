<!DOCTYPE html>
<?php
    session_start();
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Alumni Page</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
  </head>
  <body class="gray-bg">
    <div style="display: inline-block;" class="menu-button">
      <form action="menu.php">
        <input type="submit" value="Menu"/>
      </form>
    </div>

    <?php
 
    // echo $_SESSION['uid'];
    
    //connect to database
    $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");


  ?>

  <div style="text-align: center;"><h2>Welcome Alumni</h2></div>

  <?php

    if($mysqli->connect_error) {
     die("Connection failed: " . mysqli_connect_error());
   }
  ?>

    

  <form class="donateform" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
      <div class="donate">  <input type="submit" name="Donate" value="Make a Donation">  </div>
  </form>

        <?php



      if (isset($_POST['Donate'])){
           ?>

        <form class="submitform" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="amount"> Donation Amount: <input type="number" name="donateAmount" min = '1' max = '1000000'>   </div>
            <input type="submit" name="submit" value="Submit">

        </form>


        <?php
      }


      if(isset($_POST['submit'])){
        $amount = $_POST['donateAmount'];
        $query = "update user set donation = donation + ".$amount." where uid = ".$_SESSION['uid'];
        $result = mysqli_query($conn, $query);
        echo "Thank you for your donation!";
      }



   ?>


  </body>
</html>

