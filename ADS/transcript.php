<?php
// Start the session
session_start();
?>
<style>
body {
   background-color: grey;
 }
 div.buttonzone{
       font-family: Tahoma, Geneva, sans-serif;
       font-size: 3em;
       text-align: center;
       color: white;
       background-color: orange;
     }
</style>

<!DOCTYPE html>
<html>
  <?php
   $server = "localhost";
	$username = "visheshj123";
	$password = "Viswa123!";
	$servername = "visheshj123";
	$mysqli = mysqli_connect($server, $username, $password, $servername);
  if($mysqli->connect_error) {
   die("Connection failed: " . mysqli_connect_error());
  }
   $sessionID = $_SESSION["u_id"];
    
  ?>

  <head>
    <title>Welcome to the alumni page</title>
  </head>
  
<body>
			<form class="graduate" action="GradSecretary.php" method="POST"  >
					<button class="graduate-product">
					  Back
					</button>
			</form>
			
              <!-- printing out the student data -->

              <!-- This is where i have the main table declaration-->
              <!-- This is where i have the main table declaration-->

              <table style="width:100%">
                
                  <thead>
                      <tr>
                        <td>Course</td>
                        <td>Department</td>
                        <td>SemYear</td>
                        <td>Credits</td>
                        <td>Grade</td>
                        <td>Program</td>
                      </tr>
                </thead>
                <tbody>
 
    <?php
    // this is the backend part of printing all the students
            if(isset($_GET["action"])){
                          
                                    
                           //echo "the action that was selected is:" . $_GET["action"];
                
							$sql = "SELECT * FROM student_courses WHERE u_id= ? ";
							$stmt = $mysqli->prepare( $sql);
							$stmt->bind_param("i",  $_GET["u_id"]);
							   
							$stmt->execute();
							$result = $stmt->get_result();
							while(($row = $result->fetch_assoc()) ){
						   
							?>
							
                    
                                <tr>

                                        <td><?php echo $row["title"] ; ?></td>
                                        <td><?php echo $row["dept"] ; ?></td>
                                        <td><?php echo $row["semYear"] ; ?></td>
                                        <td><?php echo $row["credit"] ; ?></td>
                                        <td><?php echo $row["lettergrade"] ; ?></td>
                                        <td><?php echo $row["program"] ; ?></td>
                                  
								</tr>
                        

                          <?php
                                                  }
                                      }
                          ?>
                      </tbody>

              
</body>
</html>


