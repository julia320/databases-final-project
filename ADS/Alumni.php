<!DOCTYPE html>
<?php
    session_start();
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Alumni Page</title>
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
 
    echo $_SESSION['uid'];
    
   $server = "localhost";
   $username = "visheshj123";
   $password = "Viswa123!";
   $servername = "visheshj123";
  $conn = mysqli_connect($server, $username, $password, $servername);



  ?>

  <div class="title">Welcome Alumni</div>

  <?php

    if($mysqli->connect_error) {
     die("Connection failed: " . mysqli_connect_error());
   }


    $query = "SELECT * FROM alumni WHERE u_id = '$_SESSION[uid]'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)){
                  ?>


    <div class="alumni-info">
        <div class="fname"> <?php echo $row["fname"] . " " . $row["lname"]; ?>  </div>

        <div class="addr"> <?php echo $row["addr"]; ?>  </div>
        <div class="pnumber"> <?php echo $row["pnumber"]; ?>  </div>
        <div class="program"> <?php echo $row["program"]; ?>  </div>
        <div class="gradYear"> <?php echo $row["gradYear"]; ?>  </div>
    </div>

    

    <form class="updateform" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
      <input type="submit" name="edit" value="Edit Information">
        <div class="signout">
      <input type="submit" name="signout" value="Sign out">
    </div>
    </form>


    <?php
                  }
  ?>
  <form class="donateform" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
      <div class="donate">  <input type="submit" name="Donate" value="Make a Donation">  </div>
  </form>
  <?php
      if(isset($_POST['edit'])){
        ?>
        <br>
          <div class="student-info">

              <form class="submitupdate" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <input type="text" name="newPassword" placeholder="New Password" required /><br />
            <input type="text" name="newAddress" placeholder="Address" required /><br />
            <input type="text" name="PhoneNumber" placeholder="Phone Number" required /><br />
              <input type="submit" name = "submitChange" value="Update Information"/>

            </form>

          </div>

        <?php

      }



      if (isset($_POST['Donate'])){
           ?>

        <form class="submitform" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
          <div class="amount"> Donation Amount: <input type="number" name="donateAmount" min = '1' max = '1000000'>   </div>
            <input type="submit" name="submit" value="Submit">

        </form>


        <?php
      }

      if(isset($_POST['signout'])){
        session_unset();
        session_destroy();
        header("Location: homepage.php");
      }

      if(isset($_POST['submitChange'])){
          $newPswd = $_POST['newPassword'];
          $newAddr = $_POST['newAddress'];
          $phoneNumber = $_POST['PhoneNumber'];

        $query = "UPDATE alumni SET pswd = '$newPswd', addr = '$newAddr', pnumber = '$phoneNumber' WHERE u_id = '$_SESSION[uid]'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        ?>
          <span class = "updateComplete">Update Complete</span>
        <?php
          header("Location: Alumni.php");
      }

      if(isset($_POST['submit'])){
        $amount = $_POST['donateAmount'];
        $query = "UPDATE alumni SET donation = donation + $amount WHERE u_id = '$_SESSION[uid]'";
        $result = mysqli_query($conn, $query);
        echo "Thank you for your donation";
      }



   ?>


  </body>
</html>

