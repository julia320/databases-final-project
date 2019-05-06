<!DOCTYPE html>
<?php
    session_start();
 ?>
<html lang="en" dir="ltr">
  <head>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
    <meta charset="utf-8">
    <title>Donation Page</title>
    <style type = "text/css">
        body{
          background-color: grey;
        }
        div.alumni-info{
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin:auto;
        text-align: center;
        width: 200px;
        height: 200px;
        color: orange;
        font-weight: bold;

        }
        div.title{
            font-family: Tahoma, Geneva, sans-serif;
            font-size: 3em;
            text-align: center;
            color: white;
            background-color: orange;

              }
        div.amount{
          color: orange;
          font-weight: bold;
        }
        div.signout{
          float: right;
        }
        form.donateform{
          float: left;

        }

        div.student-info{
          float:left;
        }

    </style>
  </head>
  <body>

    <?php
    
	$server = "localhost";
	$username = "ARGv";
	$password = "CSCI2541_sp19";
	$servername = "ARGv";
  $conn = mysqli_connect($server, $username, $password, $servername);



  ?>

  <div class="title">Make a Donation</div>

  <?php

    if($mysqli->connect_error) 
    {
     die("Connection failed: " . mysqli_connect_error());
   }

   $query = "SELECT * FROM user WHERE uid = '$_SESSION[uid]'";
   $result = mysqli_query($conn, $query);
   while($row = $result->fetch_assoc()) 
   {
    echo $row["fname"] . ", you have now donated a total of $" . $row["donation"] . "<br /><br />";
    echo "Thank you for helping to keep the university afloat! <br/><br/>";
   }
   

?>



        <form class="submitform" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="amount"> Donation Amount: <input type="number" name="donateAmount" min = '1' max = '1000000'>   </div>
            <input type="submit" name="submit" value="Submit">

        </form>


        <?php
      

      if(isset($_POST['signout'])){
        session_unset();
        session_destroy();
        header("Location: logout.php");
      }


      if(isset($_POST['submit'])){
        $amount = $_POST['donateAmount'];
        $query = "UPDATE user SET donation = donation + $amount WHERE uid = '$_SESSION[uid]'";
        $result = mysqli_query($conn, $query);
        echo "Thank you for your donation";
        header("Location: donate.php");
      }



   ?>


  </body>
</html>

