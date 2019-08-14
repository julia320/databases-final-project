<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Submit Advising Form</title>
    <style type = "text/css">
        label {
            display:inline-block;
            width:200px;
            margin-right:30px;
            text-align:right;
        }
        #wrap {
            width:1000px;
            margin:0 auto;
        }
        #left_col {
            float:left;
            width:500px;
        }
        #right_col {
            float:right;
            width:500px;
        }
    </style>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<?php
    session_start();
    $conn = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

    //If they somehow got here without logging in, politely send them away
    if (!$_SESSION['loggedin']) {
        header("Location: login.php");
        die();
    }

    $crn1 = $_POST['crn1'];
    $crn2 = $_POST['crn2'];
    $crn3 = $_POST['crn3'];
    $crn4 = $_POST['crn4'];
    $crn5 = $_POST['crn5'];
    $crn6 = $_POST['crn6'];

    $back = false;
    $uid = $_SESSION['uid'];

    if(!is_null($crn1)) {
        $inQuery1 = 'insert into adv_form values ('.$uid.', '.$crn1.')';
        $res1 = mysqli_query($conn, $inQuery1);
        $back = true;
    }

    if(!is_null($crn2)) {
        $inQuery2 = 'insert into adv_form values ('.$uid.', '.$crn2.')';
        $res2 = mysqli_query($conn, $inQuery2);
        $back = true;
    }

    if(!is_null($crn3)) {
        $inQuery3 = 'insert into adv_form values ('.$uid.', '.$crn3.')';
        $res3 = mysqli_query($conn, $inQuery3);
        $back = true;
    }

    if(!is_null($crn4)) {
        $inQuery4 = 'insert into adv_form values ('.$uid.', '.$crn4.')';
        $res4 = mysqli_query($conn, $inQuery4);
        $back = true;
    }

    if(!is_null($crn5)) {
        $inQuery5 = 'insert into adv_form values ('.$uid.', '.$crn5.')';
        $res5 = mysqli_query($conn, $inQuery5);
        $back = true;
    }

    if(!is_null($crn6)) {
        $inQuery6 = 'insert into adv_form values ('.$uid.', '.$crn6.')';
        $res6 = mysqli_query($conn, $inQuery6);
        $back = true;
    }

    if($back) {
        header("Location: menu.php");
        die();
    }

?>

<body>
    <!-- Menu Button -->
    <div style="display: inline-block;" class="menu-button">
        <form action="menu.php"><input type="submit" value="Menu"/></form>
    </div>

    <h2>Submit Advising Form</h2>
    <hr>
    <p>Please fill out an Advising Form to lift your registration hold.</p>

    <div id="wrap">
        <div id="left_col">
            <div style="text-align: center;">
                <form method="post" action="submit-adv-form.php">
                    <input type="text" name="search" placeholder="Search by name"/>
                    <input type="submit" value="Search"/>
                </form>
            </div>
            <br>
            <div style="overflow-y: auto; height: 700px;">
<?php

    $search = $_POST['search'];

    if(is_null($search)) {
        //No search terms
        $query = "select * FROM course where semester='spring' and year=2019";
        $result = mysqli_query($conn, $query);
        echo "<table>";
        echo "<thead><tr><th>Dept</th><th>Number</th><th>Name</th><th>CRN</th></tr></thead>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["dept"] . "</td>";
            echo "<td>" . $row["courseno"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["crn"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        //there were search terms
        $query = "select * FROM course where semester='spring' and year=2019 and name like '%".$search."%'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<thead><tr><th>Dept</th><th>Number</th><th>Name</th><th>CRN</th></tr></thead>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["dept"] . "</td>";
                echo "<td>" . $row["courseno"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["crn"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            // echo "Your search returned no results.";
            echo $query;
        }
    }
?>
    </div></div>
    <div id="right_col">
        <fieldset>
        <legend>What courses will you be taking this semester?</legend>
        <div style="overflow-y: auto; height: 700px;">
        <form method="post">

            Course 1: <br/>
            <input type="text" name="dept1" placeholder="Department" />
            <input type="text" name="cno1" placeholder="Course Number"/>
            <input type="text" name="crn1" placeholder="CRN"/><br><br>

            Course 2: <br/>
            <input type="text" name="dept2" placeholder="Department" />
            <input type="text" name="cno2" placeholder="Course Number"/>
            <input type="text" name="crn2" placeholder="CRN"/><br><br>

            Course 3: <br/>
            <input type="text" name="dept3" placeholder="Department" />
            <input type="text" name="cno3" placeholder="Course Number"/>
            <input type="text" name="crn3" placeholder="CRN"/><br><br>

            Course 4: <br/>
            <input type="text" name="dept4" placeholder="Department" />
            <input type="text" name="cno4" placeholder="Course Number"/>
            <input type="text" name="crn4" placeholder="CRN"/><br><br>

            Course 5: <br/>
            <input type="text" name="dept5" placeholder="Department" />
            <input type="text" name="cno5" placeholder="Course Number"/>
            <input type="text" name="crn5" placeholder="CRN"/><br><br>

            Course 6: <br/>
            <input type="text" name="dept6" placeholder="Department" />
            <input type="text" name="cno6" placeholder="Course Number"/>
            <input type="text" name="crn6" placeholder="CRN"/><br><br>

            <input type="submit" value="Submit for Approval" name="submit" /><br/><br/>
        </form>
        </div>
        </fieldset>
        </div>
    </div>
</body>
</html>