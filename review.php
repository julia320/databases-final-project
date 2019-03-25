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
    

	<?php
		// check if recommendation letter was submitted	
    	$q = "SELECT * FROM rec_letter WHERE uid=?";
	    if(!inDb($q,[$_GET['uid']])) 
			echo "<p>Recommendation Not Letter received</p>";

	    else {
    	    $qr = "SELECT * FROM rec_letter WHERE uid=?";
        	echo "<p>Recommendation Letter received</p>";
        
	        // review recommendation letters
    	    if(!inDb($qr,[$_GET['uid']])) 
	    	   	echo "<p><a href='rec_review.php?uid=".$_GET['uid']."'>Review Recommendation Letter</a></p>";
	        else
    	        echo "<p>Recommendation letter has been reviewed</p>";
    	}
	?>


    <h3>Transcripts</h3>

	<?php
   		// display scores
		$query="SELECT * FROM gre WHERE uid=?";

		// if scores have been entered, display them
    	if(inDb($query,[$_GET['uid']])) {
        	echo "<table border='1' style='border-collapse: collapse;'>
            	<tr>
                	<th>Year</th>
	                <th>Verbal</th>
    	            <th>Quantity</th>
        	        <th>AdvScore</th>
            	    <th>toefl</th>
                	<th>advYear</th>
				</tr>";
		        
            $rows = fetchRows($query,[$_GET['uid']]);
            foreach ($rows as $row){
                echo "<tr>
                    	<td>".$row['advyear']."</td>
	                    <td>".$row['verbal']."/td>
    	                <td>".$row['quant']."</td>
        	            <td>".$row['advScore']."</td>
            	        <td>".$row['toefl']."</td>
                	    <td>".$row['advYear']."</td>
	                </tr>";
            }
        
        	echo "</table>";
        
		}
		else {
        	echo "<p>No Transcript received</p>";
   		}

    	if(inDb("SELECT * FROM gre WHERE uid=?",[$_GET['uid']])&&inDb("SELECT * FROM rec_review WHERE uid=?",[$_GET['uid']])){
        	echo "<p><a href='results.php?uid=".$_GET['uid']."'>Record application results</a></p>";
		}
    ?>

</body>
</html>
