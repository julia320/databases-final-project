<?php
  session_start();  

    // if they aren't the SA, redirect them
    if ($_SESSION['role'] != 'SA') {
          header("Location: home.php");
          die();
      }

  // connect to mysql
  $servername = "localhost";
  $user = "TheSpookyLlamas";
  $pass = "TSL_jjy_2019";
  $dbname = "TheSpookyLlamas";
  $conn = mysqli_connect($servername, $user, $pass, $dbname);
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  //create a user id for the new account by doing max+1
  $query = "SELECT MAX(userID) AS max FROM users";
  $row = mysqli_query($conn, $query)->fetch_assoc();
  $newID = $row['max'] + 1;

  //FORM VALIDATION
  $somethingEmpty = "";
  $fnameErr = "";
  $lnameErr = "";
  $usernameErr = "";
  $passwordErr = "";
  $emailErr = "";
  $addressErr = "";
  $ssnErr = "";

  if (isset($_POST['submit'])){
    $dataReady = true;
    if(count(array_filter($_POST))!=count($_POST)){
      $somethingEmpty = "Something is empty";
    }
    $fnameTest = $_POST["fname"];
    $lnameTest = $_POST["lname"];
    $usernameTest = $_POST["username"];
    $passwordTest = $_POST["password"];
    $emailTest = $_POST["email"];
    $addressTest = $_POST["address"];
    $ssnTest = $_POST["ssn"];

    $role = $_POST["role"];
    $fname = "";
    $lname = "";
    $username = "";
    $password = $_POST["password"];
    $email = "";
    $address= "";
    $ssn = "";

    if (!preg_match("/^[a-zA-Z ]+$/i",$fnameTest)) {
      $fnameErr = "Only letters, and white space allowed";
      $dataReady = false;
    } else{
      $fname = $fnameTest;
    }
    if (!preg_match("/^[a-zA-Z ]+$/i",$lnameTest)) {
      $lnameErr = "Only letters, and white space allowed";
      $dataReady = false;
    } else{
      $lname = $lnameTest;
    }
    if(!preg_match("/^[a-zA-Z0-9 ]+$/i",$usernameTest)){
      $usernameErr = "Only letter, numbers, and whitespace allowed";
      $dataReady = false;
    } else{
      $username = $usernameTest;
    }
    if (!filter_var($emailTest, FILTER_VALIDATE_EMAIL) && !empty($_POST["email"])) {
      $emailErr = "Invalid email";
      $dataReady = false;
    } else{
      $email = $emailTest;
    }
    if (!preg_match("/^[a-zA-Z0-9 ]+$/i",$addressTest) && !empty($_POST["address"])) {
      $addressErr = "Only letters, numbers, and white space allowed";
      $dataReady = false;
    } else{
      $address = $addressTest;
    }
    if (!preg_match("/^[0-9]+$/i",$ssnTest) && !empty($_POST["ssn"])) {
      $ssnErr = "Not a valid social security number";
      $dataReady = false;
    } else{
      $ssn = $ssnTest;
    }

    //Insert into database 
    if ($dataReady == true){
      $sql = "INSERT INTO users VALUES ('" .$role. "', '" .$fname . "', '" .$lname. "', '" .$username. "', '" .$password. "', '" .$email. "', " .$newID. ")";
      $result = mysqli_query($conn, $sql) or die ("**********Error: user insert query failed***********");

      $sql = "INSERT INTO personal_info VALUES ('" .$fname. "', '" .$lname. "', " .$newID. ", '" .$address. "', '" .$ssn. "')";
      $result = mysqli_query($conn, $sql) or die ("**********Error: personal_info insert query failed***********");
      header("Location:system_admin_page.php"); 
      exit;
    }
  }
?>

<html>
  
  <title>
    System Admin View
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
       border: 1px solid;
      border-collapse: collapse;
    }
  </style>
  
  <h1> User Control </h1>

  <body>

    <h2> Current Users:  </h2>

    <?php
      //displayusers in a table format
      $sql = "SELECT * FROM users";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0){
        echo "<table style=width:80%>";
        echo "<tr>";
        echo "<th>Role</th>";
        echo "<th>First Name </th>";
        echo "<th>Last Name</th>";
        echo "<th>Username</th>";
        echo "<th>Password</th>";
        echo "<th>Email</th>";
        echo "<th>ID</th>";
        echo "</tr>";
        while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['role'] . "</td>";
          echo "<td>" . $row['fname'] . "</td>";
          echo "<td>" . $row['lname'] . "</td>";
          echo "<td>" . $row['username'] . "</td>";
          echo "<td>" . $row['password'] . "</td>";
          echo "<td>" . $row['email'] . "</td>";
          echo "<td>" . $row['userID'] . "</td>";
          echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
      }
    ?>

    <h2> Create New User: </h2>
    <form id="mainform" method="post">
      Enter Role: <span class="field"> 
      <select name="role">
        <option value="SA">System Admin</option>
        <option value="GS">Grad Secratary</option>
        <option value="FR">Faculty Reviewer</option>
        <option value="CAC">Chair of Admissions Comm</option>
      </select> </span>
      <br><br>
      Enter First Name: <span class="field"><input type="text" name="fname">
      <span class="error"><?php echo " " . $fnameErr;?></span></span><br>
      Enter Last Name: <span class="field"><input type="text" name="lname">
      <span class="error"><?php echo " " . $lnameErr;?></span></span><br><br>

      Create Username: <span class="field"><input type="text" name="username">
      <span class="error"><?php echo " " . $usernameErr;?></span></span><br>
      Create Password: <span class="field"><input type="text" name="password">
      <span class="error"><?php echo " " . $passwordErr;?></span></span><br><br>

      Enter Email: <span class="field"><input type="text" name="email">
      <span class="error"><?php echo " " . $emailErr;?></span></span><br><br>

      <!--Personal Info-->
      Enter Address: <span class="field"><input type="text" name="address">
      <span class="error"><?php echo " " . $addressErr;?></span></span><br>
      Enter SSN: <span class="field"><input type="text" name="ssn">
      <span class="error"><?php echo " " . $ssnErr;?></span></span><br><br>
      <input type="submit" name="submit" value="Create User">


    </form>
    
    



  </body>
</html>
