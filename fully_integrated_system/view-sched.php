<!DOCTYPE html>

<head>
    <title>Schedule</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body>
  <div style="display: inline-block;" class="menu-button">
    <form action="menu.php"><input type="submit" value="Menu"/></form>
  </div>
  <h3> Schedule by Day & Time </h3>
  <hr>
    <?php
        session_start();

        if(!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        }
        //send to menu page if they don't have sufficient permissions
        if(!(in_array("secr", $_SESSION['types']) || in_array("admin", $_SESSION['types']))) {
          header("Location: menu.php");
          die();
        }
        
        // Connect to database
        $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        // Check connection
        if(!$conn){
          die("Connection failed: " . mysqli_connect_error());
        }

        // Search database for courses that match with input uid
        $query = "select C.credits, C.section, C.name, C.courseno, C.day, C.tme, C.instructor, C.crn, C.location FROM course C, transcript T where '".$_POST["searchUID"]."'=T.uid AND T.crn=C.crn AND T.grade='IP';";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
              echo "<table>";
              echo "<thead><tr><th>Credits</th><th>Name</th><th>Course Number</th><th>Day</th><th>Time</th><th>Instructor</th><th>CRN</th><th>Location</th></tr></thead>";

              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . $row["credits"] . "</td>";
                  //echo "<td>" . $row["section"] . "</td>";
                  echo "<td>" . $row["name"] . "</td>";
                  echo "<td>" . $row["courseno"] . "</td>";
                  echo "<td>" . $row["day"] . "</td>";
                  echo "<td>" . $row["tme"] . "</td>";
                  echo "<td>" . $row["instructor"] . "</td>";
                  echo "<td>" . $row["crn"] . "</td>";
                  echo "<td>" . $row["location"] . "</td>";

                  //Drop button
                  echo "<td>";
                  echo "<form action=\"dropcourse.php\" method=\"post\">";
                  echo "<input type=\"hidden\" name=\"crn\" value=\"" . $row["crn"] . "\">";
                  echo "<input type=\"submit\" value=\"Drop Course\"/>";
                  echo "</form>";
                  echo "</td>";

                  echo "</tr>";
              }
              echo "</table>";

              echo '<form action=view-schedule-admin.php method=post>';
              echo "<input type=\"submit\" value=\"Back\"/>";
        } else {
          echo "No schedule available for UID: ".$_POST["searchUID"];

          echo '<form action=view-schedule-admin.php method=post>';
          echo "<input type=\"submit\" value=\"Back\"/>";
        }
    ?>
</body>

</html>
