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
      <form action="menu.php"><input type="submit" value="Menu"/></form>
    </div>
    <h3> Records & Information </h3>
    <hr>
    <form action="edit-info-admin.php" method="post">
      Enter UID: <input type="text" name="uid">
      <input type="submit" name="search" value="Search">
    </form>
      <?php
        session_start();
        // Send to login page if user is not logged in
        if(!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        }

        //send to menu page if they don't have sufficient permissions
        if(!($_SESSION['type']=="admin")) {
          header("Location: menu.php");
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

        // Declare empty variables for uid validation
        $uidErr = "";

        if($_SERVER["REQUEST_METHOD"] == "POST"){
          if (empty($_POST["uid"])) {
                $uidErr = "Please enter a UID";
                // echo $uidErr; TODO: echo error msg only on first empty search...
            } else {
                $_SESSION["searchID"] = test_value($_POST["uid"]);
            }
        }

        if(empty($_POST["uid"])){
          $userQuery = "select * from user order by lname";
          $userResult = mysqli_query($conn, $userQuery);
          if (mysqli_num_rows($userResult) > 0) {
              echo "<table>";
              //Display a table of all the students
              echo "<thead><tr><th>First Name</th><th>Last Name</th><th>UID</th><th>Street</th><th>City</th><th>State</th><th>Zip</th><th>Email</th><th> Type</th><th>Active</th></tr></thead>";
              while ($row = mysqli_fetch_assoc($userResult)) {
                  echo "<tr>";
                  echo "<td>" . $row["fname"] . "</td>";
                  echo "<td>" . $row["lname"] . "</td>";
                  echo "<td>" . $row["uid"] . "</td>";
                  echo "<td>" . $row["street"] . "</td>";
                  echo "<td>" . $row["city"] . "</td>";
                  echo "<td>" . $row["state"] . "</td>";
                  echo "<td>" . $row["zip"] . "</td>";
                  echo "<td>" . $row["email"] . "</td>";
                  echo "<td>" . $row["type"] . "</td>";
                  echo "<td>" . $row["active"] . "</td>";
                  echo "<td>";
                  echo "<form action=\"edit-info.php\" method=\"post\">";
                  echo "<input type=\"hidden\" name=\"studuid\" value=\"" . $row["uid"] . "\">";
                  echo "<input type=\"submit\" value=\"Edit\"/>";
                  echo "</form>";
                  echo "</td>";
                  echo "</tr>";
              }
              echo "</table>";

              }else {
                  //If nothing came back from the query, there was a problem
                  die("Bad query: ".mysqli_error());
              }
        } else {
          $query = "select * FROM user where uid='".$_SESSION["searchID"]."';";
          $result = mysqli_query($conn, $query);

          // If there are results
          if(mysqli_num_rows($result)>0){
            // Simply echos personal info corresponding with input uid
            echo "<table>";
            echo "<thead><tr><th>First Name</th><th>Last Name</th><th>UID</th><th>Street</th><th>City</th><th>State</th><th>Zip</th><th>Email</th><th> Type</th><th>Active</th></tr></thead>";
            while($row = mysqli_fetch_assoc($result)){
              echo "<tr>";
              echo "<td>" . $row["fname"] . "</td>";
              echo "<td>" . $row["lname"] . "</td>";
              echo "<td>" . $row["uid"] . "</td>";
              echo "<td>" . $row["street"] . "</td>";
              echo "<td>" . $row["city"] . "</td>";
              echo "<td>" . $row["state"] . "</td>";
              echo "<td>" . $row["zip"] . "</td>";
              echo "<td>" . $row["email"] . "</td>";
              echo "<td>" . $row["type"] . "</td>";
              echo "<td>" . $row["active"] . "</td>";
              echo "<td>";
              echo "<form action=\"edit-info.php\" method=\"post\">";
              echo "<input type=\"hidden\" name=\"studuid\" value=\"" . $row["uid"] . "\">";
              echo "<input type=\"submit\" value=\"Edit\"/>";
              echo "</form>";
              echo "</td>";
              echo "</tr>";
            }
            echo "</table>";
          } else {
            echo "Please enter a valid UID!";
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
