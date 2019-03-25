<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>

<body>
    <?php
        session_start();

        // if user is not a reviewer, redirect
        if ($_SESSION['role'] != "FR") {
            header("Location: redirect.php");
            die();
        }

        include_once "functions.php";

        $query="SELECT * FROM academic_info";
        $array=[];
        $rows = fetchRows($query,$array);

        $names = [];
        foreach ($rows as $row){
            $q = "SELECT * FROM users WHERE uid = ?";
            $arr = [$row['uid']];
            $nm = fetchRows($q,$arr);
            $nms = [$nm[0]['fname'],$nm[0]['lname']];
            array_push($names,$nms);
        }
    ?>
    
    <h1>Applicants</h1>
    <h2>Reviewer: <?php echo $_SESSION['userID']?></h2>
    <p>
        <a href="logout.php">Logout</a>
    </p>
    <table border="1" style="border-collapse: collapse;">
        <tr>
            <th>Uid</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Experience</th>
            <th>Degree Type</th>
            <th>Semester</th>
            <th>Year</th>
            <th>Transcript</th>
            <th>Recommendation Letter</th>
            <th>Review</th>
        </tr>
        <?php
        $i=0;
        foreach($rows as $row) {
            ?>
            <tr>
                <td><?php echo $row['uid'];?></td>
                <td><?php echo $names[$i]['fname'];?></td>
                <td><?php echo $row[$i]['lname'];?></td>
                <td><?php echo $row['experience'];?></td>
                <td><?php echo $row['degree_type'];?></td>
                <td><?php echo $row['semester'];?></td>
                <td><?php echo $row['ayear'];?></td>
                <td><?php if($row['transcript']==0) echo "Not received"; else echo "Transcript Received";?></td>
                <td><?php if($row['recLetter']==0) echo "Not received"; else echo "Recommendation Letter Received";?></td>
                <td><a href="review.php?uid=<?php echo $row['uid'];?>"></a></td>
            </tr>
            <?php
            $i++;
        }
            ?>
    </table>
</body>
</html>