<!DOCTYPE html>
<html>
  <head>
    <title> Form1 </title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
  </head>
  <body>
    <div style="display: inline-block;" class="menu-button">
      <form action="menu.php"><input type="submit" value="Menu"/></form>
    </div>
    <h3> Form1 </h3>
    <?php /* Note: currently returns empty results from query as a result of empty transcript table */
        session_start();
        // Send to login page if user is not logged in
        if (!$_SESSION['loggedin']) 
        {
            header("Location: login.php");
            die();
        }

        $tempErr = "";

        // Connect to database
        $servername = "localhost";
        $username = "ARGv";
        $password = "CSCI2541_sp19";
        $dbname = "ARGv";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
      
        if (!$conn) 
        {
          die("Connection failed: " . mysqli_connect_error());
        }

        // Search database for courses that match with input uid
        $query = "select C.credits, C.courseno, C.crn, C.dept FROM course C, form1 F where '".$_SESSION['studuid']."'=T.uid AND F.crn=C.crn;";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) 
        {
            echo "<table>";
            echo "<thead><tr><th>Dept</th><th>Course Number</th><th>CRN</th><th>Credits</th></tr></thead>";

            while ($row = mysqli_fetch_assoc($result)) 
            {
                echo "<tr>";
                echo "<td>" . $row["dept"] . "</td>";
                //echo "<td>" . $row["section"] . "</td>";
                echo "<td>" . $row["courseno"] . "</td>";
                echo "<td>" . $row["crn"] . "</td>";
                echo "<td>" . $row["credits"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
          
    ?>

  </body>
</html>
