<!DOCTYPE html>
<html>
  <head>
    <title> Records </title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
  </head>
  <body>
    <div style="display: inline-block;" class="menu-button">
      <form action="menu.php">
        <input type="submit" value="Menu"/>
      </form>
    </div>
    <h3> Records & Information </h3>
    <hr>
    <form action="edit-info-reg.php" method="post">
      <input type="submit" name="edit" value="Edit">
    </form>
      <?php
        session_start();

        // Send to login page if user is not logged in
        if(!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        }

        // Connect to database
        $servername = "localhost";
        $username = "SELECT_team_name";
        $password = "Password123!";
        $dbname = "SELECT_team_name";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if(!$conn){
          die("Connection failed: " . mysqli_connect_error());
        }

        $query = "select * FROM user where uid='".$_SESSION['uid']."';";
        $result = mysqli_query($conn, $query);

        // If there are results
        if(mysqli_num_rows($result)>0){
          // Display edit options if edit button is hit
          if(isset($_POST['edit'])){

          $row = mysqli_fetch_assoc($result);
          echo '<form action="edit-info-reg.php" method="post"><br>';
          echo 'First name: <input type="text" name="fname" value="'.$row['fname'].'"><br>';
          echo 'Last name: <input type="text" name="lname" value="'.$row['lname'].'"><br>';
          echo 'Street: <input type="text" name="street" value="'.$row['street'].'"><br>';
          echo 'City: <input type="text" name="city" value="'.$row['city'].'"><br>';
          echo 'State: <input type="text" name="state" value="'.$row['state'].'"><br>';
          echo 'Zipcode: <input type="number" name="zip" value="'.$row['zip'].'"><br>';
          echo 'Phone: <input type="number" name="phone" value="'.$row['phone'].'"><br>';
          echo 'Email: <input type="text" name="email" value="'.$row['email'].'"><br>';
          echo 'Password: <input type="text" name="password"><br>';
          echo '<input type="submit" name="update" value="Update">';
          echo "</form>";
        }
        else if(isset($_POST['update'])){
          if(!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
            echo 'The email address you provided is invalid.';
          } else {
            // If update button is hit, update all fields
            $updateQuery = "update user SET fname='".$_POST['fname']."', lname='".$_POST['lname']."',
            street='".$_POST['street']."', city='".$_POST['city']."', state='".$_POST['state']."', zip='".$_POST['zip']."',
            phone='".$_POST['phone']."', email='".$_POST['email']."' where uid='".$_SESSION['uid']."';";
            $updateResult = mysqli_query($conn, $updateQuery);

            if(!empty($_POST["password"])){
              $updatePassword = "update user SET password='".$_POST['password']."' where uid='".$_SESSION['uid']."';";
              $passResult = mysqli_query($conn, $updatePassword);

              echo 'Password successfully changed <br>';
            }
            echo 'Update complete';
          }
          echo '<br><br>';
          echo '<form><input type="submit" value="View Profile">';
          echo "</form>";
        }
        else{ // Otherwise, show view mode by default
          echo "<table>";
          while($row = mysqli_fetch_assoc($result)){
            echo "<tr><td>First Name</td><td>".$row["fname"]."</td></tr>";
            echo "<tr><td>Last Name</td><td>".$row["lname"]."</td></tr>";
            echo "<tr><td>UID</td><td>".$row["uid"]."</td></tr>";
            echo "<tr><td>Street</td><td>".$row["street"]."</td></tr>";
            echo "<tr><td>City</td><td>".$row["city"]."</td></tr>";
            echo "<tr><td>State</td><td>".$row["state"]."</td></tr>";
            echo "<tr><td>ZIP</td><td>".$row["zip"]."</td></tr>";
            echo "<tr><td>Phone Number</td><td>".$row["phone"]."</td></tr>";
            echo "<tr><td>Email</td><td>".$row["email"]."</td></tr>";
            echo "<tr><td>Active</td><td>".$row["active"]."</td></tr>";
            echo "<tr><td>Account Type</td><td>".$row["type"]."</td></tr>";
          }
          echo "</table>";
        }
        }

        // Function to validate uid input
        function test_value($input) {
            $input = htmlspecialchars($input);
            $input = stripslashes($input);
            $input = trim($input);
            return $input;
        }
      ?>

  </body>
</html>
