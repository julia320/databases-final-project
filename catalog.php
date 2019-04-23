<?php
// Start the session
session_start();
?>

<style>
html {
    font-family:arial;
    font-size: 18px;
}
td {
border: 1px solid #726E6D;
padding: 15px;
}
thead{
    font-weight:bold;
    text-align:center;
background: #625D5D;
color:white;
}
table {
    border-collapse: collapse;
}
.footer {
    text-align:right;
    font-weight:bold;
}
tbody >tr:nth-child(odd) {
background: #D1D0CE;
}
</style>



<!DOCTYPE html>
<html>
<!-- This code is the main page and provides the dropdown button and search button -->
<head>
<title>The Advisor</title>
    <!-- <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/> -->

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

<!-- ############################################################################################################################################  -->
<!-- This is where i have the main table declaration-->
<head>
<h2 align = "center"> Course Catalog </h2>
</head>
<table style="width:100%">
<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
<thead>
<tr>
<td colspan="4">Course </td>
<td rowspan="2"> Credits </td>
<td colspan="3"> Prerequisites </td>
</tr>
<tr>
<td>Dept</td>
<td>Course Number</td>
<td colspan="2">Title </td>
<td> PreReq1</td>
<td> PreReq2</td>
</tr>
</thead>
<tbody>


<?php
    $sql = "SELECT title,credit,dept,crn,pre_req1,pre_req2 FROM course_catalog";
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
<td colspan="2"><?php echo $row['title'] ; ?></td>
<td><?php echo $row["dept"] ; ?></td>
<td><?php echo $row["crn"] ; ?></td>
<td><?php echo $row["credit"] ; ?></td>
<td><?php echo $row["pre_req1"] ; ?></td>
<td><?php echo $row["pre_req2"] ; ?></td>

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

