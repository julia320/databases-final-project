<!DOCTYPE html>

<head>
    <title>Edit User Profile</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body>
  <div style="display: inline-block;" class="menu-button">
    <form action="menu.php"><input type="submit" value="Menu"/></form>
  </div>
  <h3> Records & Information </h3>
  <hr>
    <?php
        session_start();

        if(!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        }
        
        //send to menu page if they don't have sufficient permissions
        if(!(in_array("secr", $_SESSION['types'] || in_array("admin", $_SESSION['types']))) {
          header("Location: menu.php");
          die();
        }

        //connect to database
        $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        // Check connection
        if(!$conn){
          die("Connection failed: " . mysqli_connect_error());
        }

        echo '<form action="manageusers.php" method=post>';
        echo "<input type=\"submit\" value=\"Back\"/>";

        $query = "select * FROM user where uid='".$_POST["studuid"]."';";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result)>0){

          while($row = mysqli_fetch_assoc($result)){
            echo '<form action="edit-info.php" method="post"><br>';
            echo 'First name: <input type="text" name="fname" value="'.$row['fname'].'"><br>';
            echo 'Last name: <input type="text" name="lname" value="'.$row['lname'].'"><br>';
            echo 'Street: <input type="text" name="street" value="'.$row['street'].'"><br>';
            echo 'City: <input type="text" name="city" value="'.$row['city'].'"><br>';
            echo 'State: <input type="text" name="state" value="'.$row['state'].'"><br>';
            echo 'Zipcode: <input type="number" name="zip" value="'.$row['zip'].'"><br>';
            echo 'Phone: <input type="number" name="phone" value="'.$row['phone'].'"><br>';
            echo 'Email: <input type="email" name="email" value="'.$row['email'].'"><br>';
            echo 'Active: <input type="text" name="active" value="'.$row['active'].'"><br>';
            echo 'Type: <input type="text" name="type" value="'.$row['type'].'"><br>';
            echo 'Password: <input type="text" name="password"><br>';
            echo '<input type="submit" name="update" value="Update">';
            echo "</form>";
          }
        }
        else if(isset($_POST['update'])){
          if(!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
            echo 'The email address you provided is invalid.';
          } else {
            // If update button is hit, update all fields
            $updateQuery = "update user SET fname='".$_POST[fname]."', lname='".$_POST[lname]."',
            street='".$_POST[street]."', city='".$_POST[city]."', state='".$_POST[state]."', zip='".$_POST[zip]."',
            phone='".$_POST[phone]."', email='".$_POST[email]."', active='".$_POST[active]."', type='".$_POST[type]."'
            where uid='".$_SESSION["searchID"]."';";
            $updateResult = mysqli_query($conn, $updateQuery);
            // TODO: Test successful update...
            if(!empty($_POST["password"])){
              $updatePassword = "update user SET password='".$_POST['password']."' where uid='".$_POST['uid']."';";
              $passResult = mysqli_query($conn, $updatePassword);

              echo 'Password successfully changed <br>';
            }

            echo 'Update complete';
          }
        }

    ?>
</body>

</html>
