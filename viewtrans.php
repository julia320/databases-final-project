<!DOCTYPE html>
<html>
  <head>
    <title> Transcript </title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
  </head>
  <body>
    <div style="display: inline-block;" class="menu-button">
      <form action="menu.php"><input type="submit" value="Menu"/></form>
    </div>
    <h3> Transcript </h3>
    <?php /* Note: currently returns empty results from query as a result of empty transcript table */
      session_start();
      // Send to login page if user is not logged in
      if (!$_SESSION['loggedin']) {
        header("Location: login.php");
        die();
      }

      $tempErr = "";

      // Connect to database
      $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

      // Check connection
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      // Search database for courses that match with input uid
      $query = "select C.credits, C.section, C.name, C.courseno, C.day, C.tme, C.instructor, C.crn, C.location, T.grade FROM course C, transcript T where '".$_SESSION['studuid']."'=T.uid AND T.crn=C.crn;";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0) {
              echo "<table>";
              echo "<thead><tr><th>Credits</th><th>Name</th><th>Course Number</th><th>CRN</th><th>Grade</th></tr></thead>";

              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . $row["credits"] . "</td>";
                  //echo "<td>" . $row["section"] . "</td>";
                  echo "<td>" . $row["name"] . "</td>";
                  echo "<td>" . $row["courseno"] . "</td>";
                  echo "<td>" . $row["crn"] . "</td>";
                  echo "<td>" . $row["grade"] . "</td>";
                  echo "</tr>";
              }
              echo "</table>";
          }
        $sum = 0;
        $query2 = "select t.grade, c.credits from course c, transcript t where '".$_SESSION['studuid']."'=t.uid AND t.crn=c.crn;";
        $credit_sum = "select sum(c.credits) from course c, transcript t where '".$_SESSION['studuid']."'=t.uid AND t.crn=c.crn;";
        $result2 = mysqli_query($conn, $query2);
        $result_sum = mysqli_query($conn, $credit_sum);
        $final_sum = mysqli_fetch_assoc($result_sum)["sum(c.credits)"];
         if (mysqli_num_rows($result2) > 0) {
         	while($row = mysqli_fetch_assoc($result2)){
              if($row["grade"] == "A"){
              	$sum += (4.0 * $row["credits"]);
              }
              if($row["grade"] == "A-"){
              	$sum += (3.7 * $row["credits"]);
              }
              if($row["grade"] == "B+"){
              	$sum += (3.3 * $row["credits"]);
              }
              if($row["grade"] == "B"){
              	$sum += (3.0 * $row["credits"]);
              }
              if($row["grade"] == "B-"){
              	$sum += (2.7 * $row["credits"]);
              }
              if($row["grade"] == "C+"){
              	$sum += (2.3 * $row["credits"]);
              }
              if($row["grade"] == "C"){
              	$sum += (2.0 * $row["credits"]);
              }
              if($row["grade"] == "F"){
              	$sum += (0 * $row["credits"]);
              }
              if($row["grade"] == "IP"){
              	$sum += 0;
              }
            }
            $gpa = ($sum/$final_sum);
            echo "GPA: " .round($gpa, 2);
          }
    ?>

  </body>
</html>
