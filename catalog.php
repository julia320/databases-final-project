<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<!-- This code is the main page and provides the dropdown button and search button -->
<head>
<title>Course Catalog</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>

</head>

<?php

    require_once('config.php');
    // to verify and see if it exist and is not empty.
    /* if(!isset($_SESSION['uid']) ){
     header("Location: login.php");
     } */
    // this is to import the file that will enable me to connect to the database
    //require_once('config.php');
    // Global variable declaration
    //$sessionID = 11111111;
    // declaring variables
    ?>

<body>
    <div style="display: inline-block;" class="menu-button">
      <form action="menu.php"><input type="submit" value="Menu"/></form>
    </div>

<!-- ############################################################################################################################################  -->
<!-- This is where i have the main table declaration-->

<h2> Course Catalog </h2>
<hr>
<table style="width:100%">
<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
<thead>
<tr>
<th colspan="3">Course </th>
<th rowspan="2"> Credits </th>
<th colspan="2"> Prerequisites </th>
</tr>
<tr>
<th>Title</th>
<th>Dept</th>
<th>Number</th>
<th>PreReq1</th>
<th>PreReq2</th>
</tr>
</thead>
<tbody>


<?php
    $sql = "SELECT distinct name,courseno,credits,dept,prereq1,prereq2 FROM course";
    // Prepare a select statement
    $result = $mysqli->query($sql);
    if($result->num_rows > 0) {
        //read all product data
        // output data of each row
        while($row = $result->fetch_assoc()) {
            //$totalCredit = $totalCredit+ $row["credit"];

            ?>

<!--<table style="width:100%" id ="productList">-->
<!--<tr>-->
<!-- this is the line that is used to read each line of the student id. Reading directly the value of student_courses .-->



<tr>
<td><?php echo $row['name'] ; ?></td>
<td><?php echo $row["dept"] ; ?></td>
<td><?php echo $row["courseno"] ; ?></td>
<td><?php echo $row["credits"] ; ?></td>
<td><?php echo $row["prereq1"] ; ?></td>
<td><?php echo $row["prereq2"] ; ?></td>

</tr>
</form>


<?php
    }
    }
    ?>
</tbody>

</table>
</body>

</html>

