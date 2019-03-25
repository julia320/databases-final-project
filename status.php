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

        $errors = array();
        include_once "functions.php";
        
        //submit results
        if(isset($_POST['sub'])){

            $comments = trim($_POST['comments']);
            $rating = trim($_POST['rating']);
            $def = trim($_POST['deficiency']);
            $reason = trim($_POST['reason']);
            $decision = trim($_POST['decision']);
            $advisor = $_SESSION['name'];
            
            // check if all fields are filled
            
            if(!($comments&&$rating&&$def&&$reason&&$decision)){
                array_push($errors,"Please fill all the fields");
            }

            //if there are no errors
    		
            if(count($errors)==0){
                $query = "INSERT INTO app_info(uid, status, comments, rating, deficiency, reason, decision, advisor) VALUES(?,?,?,?,?,?,?,?)";
                $data = [$_GET['uid'],1,$comments,$rating,$def,$reason,$decision,$advisor];
                if(insert($query,$data)){
                    header("location:review.php?uid=".$_GET['uid']);
                }else{
                    array_push($errors,"Failed to submit.");
                }
            }
        }
    ?>
    
    <h1>Application Status for: <?php echo $_GET['uid'];?></h1>

    <?php
    if(count($errors)>0){
        foreach ($errors as $error){
            echo "<span style='color: red;'>**{$error}**</span><br>";
        }
    }
    ?>

    <form action="status.php?uid=<?php echo $_GET['uid']?>" method="post">
        <label>Comments:</label><br>
        <textarea name="comments">

        </textarea>

        <label>Rating:</label><br>
        <input type="number" name="rating" required><br>

        <label>Deficiency:</label><br>
        <input type="text" name="deficiency" required><br>

        <label>Reason:</label><br>
        <textarea name="reason">

        </textarea>

        <label>Decision:</label><br>
        <input type="text" name="decision" required><br><br>
        <input type="submit" name="sub" value="Submit">
    </form>
    
</body>
</html>