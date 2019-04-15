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
form.back{
	float:right;
	top:100px;
	}
</style>

<!DOCTYPE html>
<html>
  <?php
   // require_once('config.php');
	
	$server = "localhost";
	$username = "visheshj123";
	$password = "Viswa123!";
	$servername = "visheshj123";
	$mysqli = mysqli_connect($server, $username, $password, $servername);
  if($mysqli->connect_error) {
   die("Connection failed: " . mysqli_connect_error());
  }
   $sessionID = $_SESSION["uid"];
    if($_SESSION['uid'] == 0)
    {?>
          <form class="back" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="submit" value="Back" formaction="admin.php">
</form>
<?php
    }
    else
    {?>
          <form class="back" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="submit" value="Back" formaction="Advisor.php">
</form>
<?php
    }
  // $sessionID = 44444444;
    // declaring variables
  ?>

  <head>
    <title>Welcome to the alumni page</title>
  </head>
  <?php if(!empty($_GET["action"])){ 
switch($_GET["action"]){ 
     
        case "clear":
                echo "user selected" . $_GET["u_id"];
                echo "the action that was selected is:" . $_GET["action"];
                $sql = "SELECT * FROM students WHERE u_id= ? ";
                $stmt = $mysqli->prepare( $sql);
                $stmt->bind_param("i",  $_GET["u_id"]);
                // Prepare a select statement
                //$result = $mysqli->query($sql);
                        
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows >0){
                   
                    while(($row = $result->fetch_assoc()) ){
                       
						
                        //insert alumni rows
                        $sql = "insert into alumni (u_id,fname,minit,lname,addr,pnumber,pswd,program,gradYear,donation,a_id) values (?,?,?,?,?,?,?,?,?,?,?)";
						$stmt = $mysqli->prepare( $sql);
						$donate ="0";
						$stmt->bind_param("isssssssiii",$row['u_id'],$row['fname'],$row['minit'],$row['lname'],$row['addr'],$row['pnumber'],$row['pswd'],$row['grad_status'],$row['gradYear'],$donate, $row['a_id']);
						$stmt->execute();
						
						//echo ">>>>".$row["u_id"];
						//delete students rows
						$sql ="DELETE FROM students WHERE u_id = ?";
						$stmt = $mysqli->prepare( $sql);
						$stmt->bind_param("i", $row["u_id"]);
						$stmt->execute();	
						
                    }
                }
                 //   echo"first name is:" .$result["firstname"];
                //   $sql1 = "INSERT INTO alumni (fname,minit,lname,addr,pnumber,u_id,pswd,program,gradYear)
                //     VALUES ('".$result["fname"]."','".$result["minit"]."','".$result["lname"]."','".$result["addr"]."','".$result["pnumber"]."','".$result["u_id"]."','".$result["pswd"]."','".$result["program"]."','".$result["gradYear"]."')";
                //     $duid = $_GET['u_id'];
                //     $sql ="DELETE FROM students WHERE u_id=$duid";
              break;
        case "viewTrans":
            echo "the action that was selected is:" . $_GET["action"];
                
                $sql = "SELECT * FROM student_courses WHERE u_id= ? ";
                $stmt = $mysqli->prepare( $sql);
                $stmt->bind_param("i",  $_GET["u_id"]);
                   
                $stmt->execute();
                $result = $stmt->get_result();
				while(($row = $result->fetch_assoc()) ){
               
                ?>
                <br>
                <div class="Transcript-info">
        
                <?php
                    echo "Course: " . $row["title"] . " Department: " . $row["dept"] . " semYear: " . $row["semYear"] . " Credits: " . $row["credit"] . " Grade:" . $row["lettergrade"] . " Program:" . $row["program"] . "<br/>";
                    ?>
                    </div>



                    <?php
                }
                case "add":
                echo "user selected" . $_GET["u_id"];
                echo "the action that was selected is:" . $_GET["action"];
    
                echo "Connected successfully <br/>";
                   $aQuery = "SELECT f_id FROM faculty WHERE adv = 'yes' ORDER BY rand() LIMIT 1";
                   $aResult = mysqli_query($mysqli, $aQuery);
              
                  $adv = '';
                   if(mysqli_num_rows($aResult) != 1)
                   {
                      echo "Advisor not added";
                  }
                  else
                  {	
					  $aRow = mysqli_fetch_assoc($aResult);
                      $adv = $aRow['f_id'];	
                      $uid = $_GET["u_id"] ;
                      echo "adv selected" . $adv;
                      $sql = "UPDATE  students SET a_id = '$adv' WHERE u_id= '$uid' ";
                      $stmt = mysqli_query($mysqli, $sql);
                     
                      
  
                  }
                  
                break;
            
}
  }   
            
?>
  <body>
        <!-- This is to deal with the header bar button which enables the user to do a lot of stuffs-->
              <div id="buttonzone">
                       <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" >
                          <input type="text" placeholder="Search.." name="searchInfo" id = "bar" >
                                  <input type="submit" name="Search" value="Search" id="search">
                          <!-- Select is used to handle the dropdown and option values are the names of the different options-->

                        <select name="category" id="type" class = "categoryList" >

                                <?php
                                $groupChoice = "SELECT DISTINCT program FROM students";
                                $result = $mysqli->query($groupChoice);
                                    if ($result->num_rows > 0) {
                                          while($row = $result->fetch_assoc()){
                                             echo '<option value='.$row["program"].'>'.$row["program"].'</option>';
                                          }
                                     }else {
                                          echo "0 results";
                                    }
                                ?>
                       </select>
                       <input type="submit" name="s1" value="Submit" id = "dropdown" />

                       <input type="submit" name="signout" value="Sign out" id="out">
                    </form>
                    
              </div>

              <!-- printing out the student data -->

              <!-- This is where i have the main table declaration-->
              <!-- This is where i have the main table declaration-->

              <table style="width:100%">
                
                  <thead>
                      <tr>
                        <td>Clear To Graduate</td>
                        <td>ID</td>
                        <td>NAME</td>
                        <td>MAJOR</td>
                        <td>PROGRAM</td>
                        <td>View viewTranscript</td>
                        <td>Add an Advisor</td>
                      </tr>
                </thead>
                <tbody>

    <?php
    // this is the backend part of printing all the students
            if(!isset($_POST['s1']) && !isset($_POST['searchInfo'])){
                          $sql = "SELECT * FROM students  ORDER BY fname";
                              // Prepare a select statement
                              $result = $mysqli->query($sql);
                              if ($result->num_rows > 0) {
                                  //read all product data
                                  // output data of each row
                                  while($row = $result->fetch_assoc()) {
                                    if($row["grad_status"] == "MS" || $row["grad_status"] == "PhD/MS" || $row["grad_status"] == "PhD"){
                                   // if(true){
                                    
                      ?>

                  <!--<table style="width:100%" id ="productList">-->
                          <!--<tr>-->
                  <!-- this is the line that is used to read each line of the student id. Reading directly the value of student_courses .-->

                         <tr>
                                        <td><form class="example" action="GradSecretary.php?action=clear&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                        <button class="clear_To_Graduate">
											ClearToGraduate
                                       
                                        </button>
                                    </form>     </td>
                                    <td><?php echo $row["u_id"] ; ?></td>
                                        <td><?php echo $row["fname"] . ' ' . $row["minit"] . ' ' . $row["lname"] ; ?></td>
                                        <td><?php echo $row["major"] ; ?></td>
                                        <td><?php echo $row["program"] ; ?></td>
                                    <td><form class="example" action="transcript.php?action=viewTrans&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                        <button class="view_Transcript">
                                        viewTranscript
                                        </button>
                                        </form> </td>
                                        <td><form class="example" action="GradSecretary.php?action=add&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                        <button class="Add_An_Advisor">
                                        Assign Advisor
                                       
                                        </button>
                                    </form>     </td>
                                    

                          </tr>
                        

                          <?php
                                                  }
                                                 else{
                            ?>   
							<tr>

                                        <td>                           </td>
                                        <td><?php echo $row["u_id"] ; ?></td>
                                        <td><?php echo $row["fname"] . ' ' . $row["minit"] . ' ' . $row["lname"] ; ?></td>
                                        <td><?php echo $row["major"] ; ?></td>
                                        <td><?php echo $row["program"] ; ?></td>
                                    <td><form class="example" action="transcript.php?action=viewTrans&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                        <button class="view_Transcript">
                                        viewTranscript
                                        </button>
                                        </form> </td>
                                        <td><form class="example" action="GradSecretary.php?action=add&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                        <button class="Add_An_Advisor">
                                        Assign Advisor
                                       
                                        </button>
                                    </form>     </td>

							</tr>

                            <?php
                                        }
                                    }
                                }
                          ?>
                      </tbody>

              <?php } ?>


              <br>
              <br>
            


          </body>

    <!-- This is to deal with the dropdown button backedn code -->
          <?php
                  if(isset($_POST['s1'])){
                    $sql = "SELECT * FROM students WHERE program = ? ORDER BY fname ";
                                  $stmt = $mysqli->prepare( $sql);
                //              echo
              $stmt->bind_param("s",  $_POST['category']);
              // Prepare a select statement
 $result = $mysqli->query($sql);
                //echo'>>>>>>>>>>result is:'.$result;
              $stmt->execute();
              $result = $stmt->get_result();
                                                        if($result->num_rows === 0) echo "no student  exists for this category in the database";
                                                        else{
                                                                while(($row = $result->fetch_assoc() ) ){
                                                                    if($row["grad_status"] == "MS" || $row["grad_status"] == "PhD/MS" || $row["grad_status"] == "PhD"){
                                    
                                                                        ?>
                                                  
                                                                    <!--<table style="width:100%" id ="productList">-->
                                                                            <!--<tr>-->
                                                                    <!-- this is the line that is used to read each line of the student id. Reading directly the value of student_courses .-->
                                                  
                                                                           <tr>
                                                                                          <td><form class="example" action="GradSecretary.php?action=clear&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                                                                          <button class="clear_To_Graduate">
                                                                                          ClearToGraduate
                                                                                         
                                                                                          </button>
                                                                                      </form>     </td>
                                                                                      <td><?php echo $row["u_id"] ; ?></td>
                                                                                          <td><?php echo $row["fname"] . ' ' . $row["minit"] . ' ' . $row["lname"] ; ?></td>
                                                                                          <td><?php echo $row["major"] ; ?></td>
                                                                                          <td><?php echo $row["program"] ; ?></td>
                                                                                      <td><form class="example" action="transcript.php?action=viewTrans&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                                                                          <button class="view_Transcript">
                                                                                          viewTranscript
                                                                                          </button>
                                                                                          </form> </td>
                                                                                          <td><form class="example" action="GradSecretary.php?action=add&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                                                                            <button class="Add_An_Advisor">
                                                                                            Assign Advisor
                                                                                        
                                                                                            </button>
                                                                                        </form>     </td>
                                                                                                    
                                                                            </tr>
                                                                          
                                                  
                                                                            <?php
                                                                                                    }
                                                  
                                                                                                   else{
                                                                              ?>   
                                                  
                                                  
                                                                                          <td>                           </td>
                                                                                          <td><?php echo $row["u_id"] ; ?></td>
                                                                                          <td><?php echo $row["fname"] . ' ' . $row["minit"] . ' ' . $row["lname"] ; ?></td>
                                                                                          <td><?php echo $row["major"] ; ?></td>
                                                                                          <td><?php echo $row["program"] ; ?></td>
                                                                                      <td><form class="example" action="transcript.php?action=viewTrans&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                                                                          <button class="view_Transcript">
                                                                                          viewTranscript
                                                                                          </button>
                                                                                          </form> </td>
                                                                                          <td><form class="example" action="GradSecretary.php?action=add&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                                                                            <button class="Add_An_Advisor">
                                                                                            Assign Advisor
                                                                                        
                                                                                            </button>
                                                                                        </form>     </td>
                                                  
                                                  
                                                  
                                                                              <?php
                                                                                          }
                                                                }
                    }
            }
          ?>
    <!-- ********************************************** Back end code that deals with the search bar entered   -->

    <!-- this is the backend part of the code that actually handles the search data entered -->
          <?php
            if(isset($_POST['searchInfo'])){
              $sql = "SELECT * FROM students WHERE u_id = ? ORDER BY fname ";
              $stmt = $mysqli->prepare( $sql);
              $stmt->bind_param("i",  $_POST['searchInfo']);
              // Prepare a select statement
              $result = $mysqli->query($sql);
              $stmt->execute();
              $result = $stmt->get_result();
              if($result->num_rows === 0) echo "no student with that u_id found";
              else{
                while(($row = $result->fetch_assoc()) ){
                    if($row["grad_status"] == "MS" || $row["grad_status"] == "PhD/MS" || $row["grad_status"] == "PhD"){
                                    
                        ?>
  
                    <!--<table style="width:100%" id ="productList">-->
                            <!--<tr>-->
                    <!-- this is the line that is used to read each line of the student id. Reading directly the value of student_courses .-->
  
                           <tr>
                                          <td><form class="example" action="GradSecretary.php?action=clear&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                          <button class="clear_To_Graduate">
                                          ClearToGraduate
                                         
                                          </button>
                                      </form>     </td>
                                      <td><?php echo $row["u_id"] ; ?></td>
                                          <td><?php echo $row["fname"] . ' ' . $row["minit"] . ' ' . $row["lname"] ; ?></td>
                                          <td><?php echo $row["major"] ; ?></td>
                                          <td><?php echo $row["program"] ; ?></td>
                                      <td><form class="example" action="transcript.php?action=viewTrans&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                          <button class="view_Transcript">
                                          viewTranscript
                                          </button>
                                          </form> </td>
                                          <td><form class="example" action="GradSecretary.php?action=add&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                        <button class="Add_An_Advisor">
                                        Assign Advisor
                                       
                                        </button>
                                    </form>     </td>
  
                            </tr>
                          
  
                            <?php
                                                    }
  
                                                   else{
                              ?>   
  
  
                                          <td>                           </td>
                                          <td><?php echo $row["u_id"] ; ?></td>
                                          <td><?php echo $row["fname"] . ' ' . $row["minit"] . ' ' . $row["lname"] ; ?></td>
                                          <td><?php echo $row["major"] ; ?></td>
                                          <td><?php echo $row["program"] ; ?></td>
                                      <td><form class="example" action="transcript.php?action=viewTrans&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                          <button class="view_Transcript">
                                          viewTranscript
                                          </button>
                                          </form> </td>
                                          <td><form class="example" action="GradSecretary.php?action=add&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                        <button class="Add_An_Advisor">
                                        Assign Advisor
                                       
                                        </button>
                                    </form>     </td>
  
  
  
                              <?php
                                          }
                                }
                    }
            }
  
            
          ?>
         
        <?php
         if($_POST['signout']){
            session_unset();
            session_destroy();
            header("Location: homepage.php");
         }
       ?>


</body>
</html>

