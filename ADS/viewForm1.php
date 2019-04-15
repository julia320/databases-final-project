<!DOCTYPE html>
<?php
// Start the session
session_start();
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <?php
    $server = "localhost";
    $username = "visheshj123";
    $password = "Viswa123!";
    $servername = "visheshj123";
    $mysqli = new mysqli($server,$username,$password,$servername);
    if($mysqli->connect_error) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

   $uid = $_SESSION["uid"];
   echo $uid;
   $query = "SELECT * FROM form1 WHERE u_id = '$uid'";
   $result = mysqli_query($conn, $query);
   if ($result){
       ?>
       <span class="addSuccess">
         Form1
       </span>
       <?php

   }
   else{
     echo "Failed to view Form1 ";
    echo "Error: " . $query . "<br/>" . mysqli_error($conn);
   }

   while ($row = mysqli_fetch_assoc($result)){
     ?>
     <br>
       <div class="form1-info">


     <?php
       echo "CRN: " . $row["crn"] . " Department:" . $row["dept"] . " SemYear:" . $row["semYear"] . "<br/>";
       ?>
         </div>
       <?php
   }


     ?>

  </body>
</html>

