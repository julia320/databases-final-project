<!DOCTYPE html>
<html>
  <head>
    <title> Grades </title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
  </head>
  <body>
    <div style="display: inline-block;" class="menu-button">
      <form action="menu.php"><input type="submit" value="Menu"/></form>
    </div>
    <h3> Edit Grades </h3>
    <hr>
    <form action="edit-grades-admin.php" method="post">
      Enter UID: <input type="text" name="uid">
      <input type="submit" name="search" value="Search"> <br>
    </form>
      <?php
        session_start();
        // Send to login page if user is not logged in
        if(!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        }
        //send to menu page if they don't have sufficient permissions
        if(!(($_SESSION['type']=="secr") || ($_SESSION['type']=="admin"))) {
          header("Location: menu.php");
          die();
        }

        // Connect to database
        $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        // Check connection
        if(!$conn){
          die("Connection failed: " . mysqli_connect_error());
        }
        // Declare empty variables for uid validation
        $uid = "";
        $uidErr = $missErr = "";

        if($_SERVER["REQUEST_METHOD"] == "POST"){
          if (empty($_POST["uid"]) && strcmp("TRUE", $_POST["hitUpdate"]) !== 0) {
                $uidErr = "Please enter a UID <br>";
                echo $uidErr;
          } else {
              $_SESSION["searchID"] = test_value($_POST["uid"]);
              // TODO: validate UID --> "no courses associated w uid"
          }
        }

        if(empty($_POST["uid"])) {
            $query = "select fname, lname, uid, email, type from user where type = 'MS' or type = 'PHD'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                //Display a table of all the students
                echo "<thead><tr><th>First Name</th><th>Last Name</th><th>UID</th><th>Email</th><th>Student Type</th></tr></thead>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["type"] . "</td>";
                    echo "<td>";
                    echo "<form action=\"set-grades.php\" method=\"post\">";
                    echo "<input type=\"hidden\" name=\"studuid\" value=\"" . $row["uid"] . "\">";
                    echo "<input type=\"submit\" value=\"Edit\"/>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                die("Bad query: ".mysqli_error());
            }
        } else {
          $searchQuery = "select fname, lname, uid, email, type from user where (type = 'MS' or type = 'PHD') and uid=".$_SESSION["searchID"];
          $searchResult = mysqli_query($conn, $searchQuery);
          if (mysqli_num_rows($searchResult) > 0) {
              echo "<table>";
              //Display a table of all the students
              echo "<thead><tr><th>First Name</th><th>Last Name</th><th>UID</th><th>Email</th><th>Student Type</th></tr></thead>";
              while ($row = mysqli_fetch_assoc($searchResult)) {
                  echo "<tr>";
                  echo "<td>" . $row["fname"] . "</td>";
                  echo "<td>" . $row["lname"] . "</td>";
                  echo "<td>" . $row["uid"] . "</td>";
                  echo "<td>" . $row["email"] . "</td>";
                  echo "<td>" . $row["type"] . "</td>";
                  echo "<td>";
                  echo "<form action=\"set-grades.php\" method=\"post\">";
                  echo "<input type=\"hidden\" name=\"studuid\" value=\"" . $row["uid"] . "\">";
                  echo "<input type=\"submit\" value=\"Edit\"/>";
                  echo "</form>";
                  echo "</td>";
                  echo "</tr>";
              }
              echo "</table>";

          } else {
              echo "No students with that UID!";
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
