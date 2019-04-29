<!DOCTYPE html>
<html>

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
    div.title {
        font-family: Tahoma, Geneva, sans-serif;
        font-size: 3em;
        text-align: center;
        color: white;
        background-color: #76b852;
    }
</style>


<!-- This code is the main page and provides the dropdown button and search button -->
<head>
    <title>The Advisor</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body class="gray-bg">
    <?php
    $mysqli = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");
    if($mysqli->connect_error) 
        die("Connection failed: " . mysqli_connect_error());
    ?>


    <div class="title">Course Catalog</div>
    </br></br>

    <!-- This is where i have the main table declaration-->
    <table style="width:100%">
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
            <thead>
                <tr>
                    <td colspan="6">Course </td>
                    <td colspan="2"> Prerequisites </td>
                </tr>
                <tr>
                    <td colspan="2">Title </td>
                    <td>Dept</td>
                    <td>Course Number</td>
                    <td>CRN</td>
                    <td>Credits</td>
                    <td> PreReq1</td>
                    <td> PreReq2</td>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT name,credits,dept,courseno, crn, prereq1, prereq2 FROM course";
                // Prepare a select statement
                $result = $mysqli->query($sql);
                //read all product data
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    ?>
                    <!-- this is the line that is used to read each line of the student id. Reading directly the value of student_courses .-->
                    <tr>
                        <td colspan="2"><?php echo $row['name'] ; ?></td>
                        <td><?php echo $row["dept"] ; ?></td>
                        <td><?php echo $row["courseno"] ; ?></td>
                        <td><?php echo $row["crn"] ; ?></td>
                        <td><?php echo $row["credits"] ; ?></td>
                        <td><?php echo $row["prereq1"] ; ?></td>
                        <td><?php echo $row["prereq2"] ; ?></td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </form>
    </table>
</body>

</html>