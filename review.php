<!DOCTYPE html>
<html lang="en">
<head>
    <title>Review Page</title>
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
    ?>
    
    <h1>Info for applicant: <?php echo $_GET['uid']?></h1>
    <h3>Recommendation Letters</h3>
    
    //checking if recommendation letters were submitted
    
    <?php
    $q = "SELECT * FROM rec_letter WHERE uid=?";
    if(!inDb($q,[$_GET['uid']])) {
        ?>
        <p>
            Recommendation Not Letter received
        </p>
        <?php
    }else{
        $qr = "SELECT * FROM rec_letter WHERE uid=?";
        ?>
        <p>
            Recommendation Letter received
        </p>
        
        // review recommendation letters
        
        <?php
        if(!inDb($qr,[$_GET['uid']])) {
            ?>
            <p>
                <a href="rec_review.php?uid=<?php echo $_GET['uid']; ?>"> Review Recommendation Letter</a>
            </p>
            <?php
        }else{
            ?>
            <p>
                Recommendation letter has been review
            </p>
            <?php
        }
    }
    ?>
    <h3>Transcripts</h3>

//display scores

    <?php
    $query="SELECT * FROM gre WHERE uid=?";
    if(inDb($query,[$_GET['uid']])) {
        echo "
        <table border="1" style="border-collapse: collapse;">
            <tr>
                <th>Year</th>
                <th>Verbal</th>
                <th>Quantity</th>
                <th>AdvScore</th>
                <th>toefl</th>
                <th>advYear</th>
            </tr>"
            
            $rows = fetchRows($query,[$_GET['uid']]);
            foreach ($rows as $row){
                echo "
                <tr>
                    <td><?php echo $row['advyear'];?></td>
                    <td><?php echo $row['verbal'];?></td>
                    <td><?php echo $row['quant'];?></td>
                    <td><?php echo $row['advScore'];?></td>
                    <td><?php echo $row['toefl'];?></td>
                    <td><?php echo $row['advYear'];?></td>
                </tr>"
            }
        
        echo "</table>"
        
    }else{
        echo "<p>No Transcript received</p>"
    }

    if(inDb("SELECT * FROM gre WHERE uid=?",[$_GET['uid']])&&inDb("SELECT * FROM rec_review WHERE uid=?",[$_GET['uid']])){
        echo "<p><a href='results.php?uid=<?php echo $_GET['uid'];?>''>Record application results</a></p>"
    }
    ?>

</body>
</html>