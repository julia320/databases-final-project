<?php
// Start the session
session_start();
?>

<!DOCTYPE html>

<html>        <!-- This code is the main page and provides the dropdown button and search button -->
  <head>
    <title>The Advisor</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
    <!-- <style>
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
      #apply,
      #search,
      #bar,
      #type,
      #catalog {
          display: inline;
          height: 40px;
          color: black;
          font-size: 25px;
          text-decoration: none;
          line-height: 36px;
          box-sizing: border-box;
          padding: 1px 0 0 0;
          text-align: center;
          background-color: #FFA319;
          border-radius: 4px;
          margin-top: 30px;
      }
    </style> -->
  </head>

            <?php
//alter user 'larissab1'@'localhost' identified with mysql_native_password by '';
 //echo "Connexion fails................";
// Create connection
        //connect to database
$mysqli = new mysqli("localhost","ARGv","CSCI2541_sp19","ARGv");
if($mysqli->connect_error) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
            // to verify and see if it exist and is not empty.
        /* if(!isset($_SESSION['uid']) ){
            header("Location: login.php");
        } */
          // this is to import the file that will enable me to connect to the database
        //require_once('config.php');
        // Global variable declaration
        $sessionID = $_SESSION['uid'];
        // declaring variables
        $totalCredit = $weightedGpa = $totalNumGrade= $GPA=0;
                $createFrom1Count = 0;
        ?>

        <body>
        <div style="display: inline-block;" class="menu-button">
          <form action="menu.php"><input type="submit" value="Menu"/></form>
        </div>
        <h2>Student Report</h2>

                        <!-- This is to deal with the header bar button which enables the user to do a lot of stuffs-->
                    <div id="buttonzone">
                             <form action="catalog.php" method="post" >
                                <!-- <input type="submit" name="applyToGraduate" value="Apply To graduate" id="apply"> -->
                                <input type="submit" name="courseCatalog" value="Course Catalog" id="catalog">
                                <!-- <input type="text" placeholder="Search.." name="searchProduct" id = "bar" > -->
				                            <!-- <input type="submit" name="signout" value="Sign out"> -->
                                        <!-- <input type="submit" name="Search" value="Search" id="search"> -->
                                        <?php
                                          $query = "SELECT * FROM form1 WHERE u_id = $sessionID";
                                          $result = $mysqli->query($query);
                                            if ($result->num_rows == 0) {
                                              header("Location: form1.php");
                                              exit();

                                                // <!-- <input type="submit" name="createForm1" value="Create Form1"> -->
      

                                            }

                                         ?>
                                <!-- Select is used to handle the dropdown and option values are the names of the different options-->

				<!-- <select name="category" id="type" class = "categoryList" > -->




                                      <?php
                                      // $groupChoice = "SELECT  DISTINCT lettergrade FROM student_courses where u_id = $sessionID";
                                      // $result = $mysqli->query($groupChoice);
                                      //     if ($result->num_rows > 0) {
                                      //           while($row = $result->fetch_assoc()){
                                      //              echo '<option value='.$row["lettergrade"].'>'.$row["lettergrade"].'</option>';
                                      //           }
                                      //      }else {
                                      //           echo "0 results";
                                      //     }
                                      ?>
                             <!-- </select> -->
                             <!-- <input type="submit" name="s1" value="Submit" id = "dropdown" /> -->
                             <!-- <input type="submit" name="signout" value="Sign out"> -->
                             <!--
                                  <option value="empty"></option>
                                  <option value="IP">InProgress</option>
                                  <option value="LetterGrade">LetterGrade</option>
                                  <option value="Department">dept</option>
                                </select> -->
                          </form>
                 <!-- <form class="updateform" action="<?php //echo $_SERVER["PHP_SELF"];?>" method="post"> -->
                <!-- <input type="submit" name="edit" value="Edit Information"> -->
                <!-- </form> -->

                    </div>


                        <!--If the user would like to go to the course catalog, this is what transfers the user to that page-->

                        <!--Now, this is to deal with the dropdown options, whether the user only wants certain information included in the dropdown-->


<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       -->
<?php

if(isset($_POST['viewForm1']) || true){
  ?>
    <!-- <style type = "text/css">
      div.w3-container{
        display: none;
      }
	    table.headers{
	    display: none;
	    }
    </style> -->

  <?php
  $query = "SELECT * FROM form1 WHERE u_id = '$_SESSION[uid]'";
  $result = $mysqli->query($query);
  if ($result->num_rows == 0) {
    echo "You don't have a form1";
  } else{
     while($row = $result->fetch_assoc()) {
       ?>
        <span class = "formdata"> <?php echo "Dept: " . $row["dept"] . " semYear: " . $row["crn"] . "<br/>"; ?> </span>
       <?php
     }
  }


    }

// if(isset($_POST['createForm1'])){
//         if($createFrom1Count<1){
//             $createFrom1Count = $createFrom1Count +1;
//             header("Location: form1.php");

//         }
//         else{
//             echo "Sorry You already created form1 and can't create more than two Form 1";
//         }
//     }
//This is to deal with the buttons that are clicked
// if(isset($_POST['signout'])){
//       session_unset();
//       session_destroy();
//       header("Location: homepage.php");
//     }

// if(isset($_POST['applyToGraduate'])){
//   header("Location: Profile.php");
//             exit;
// }
// if(isset($_POST['courseCatalog'])){
//   header("Location: catalog.php");
//             exit;
// }

?>
<!-- ****************************************************************************************************************************************************************************************************************-->
                        <!-- This is the somehow header table(small one) printed in the screen-->



                        <?php
				// $studentData = "SELECT u_id,students.fname as studentsFname,students.minit as studentsMinit ,students.lname as studentsLname,program,major,gradYear,faculty.fname as facultyFname,faculty.minit as facultyMinit,faculty.lname as facultyLname FROM students  INNER JOIN faculty  ON a_id = f_id  WHERE u_id =$sessionID ";
        //                   // Prepare a select statement
				// //echo "after the sql statement";
				// //echo $sessionID;
        //                   $result = $mysqli->query($studentData);
        //                   if ($result->num_rows > 0) {
				//                 while($row = $result->fetch_assoc()) {
			 ?>

                        <!-- <div class="w3-container"> -->
                          <!--<h2 align ="center">RiseUp DegreeMap</h2> -->

                          <!-- <table class="w3-table w3-striped w3-border" style="width: 100%">

                            <tr>
                              <td>Student</td>
                        <td><?php //echo $row["studentsFname"] . ' ' . $row["studentsMinit"] . ' ' . $row["studentsLname"] ; ?></td>
                              <td>Program</td>
                        	<td><?php //echo $row["program"] ; ?></td>
			    </tr>
                            <tr>
                              <td>ID</td>
                              <td><?php //echo $row["u_id"] ; ?></td>
                              <td>Major</td>
                              <td><?php //echo $row["major"] ; ?></td>
                            </tr>
                            <tr>
                              <td>Expected Graduation Year</td>
                              <td><?php //echo $row["gradYear"] ; ?></td>
                              <td>Advisor</td>
                              <td><?php //echo $row["facultyFname"] . ' ' . $row["facultyMinit"] . ' ' . $row["facultyLname"] ; ?></td>

                            </tr>
                          </table>
                        </div> -->
                        <!-- Close the parenthesis for if-->
                        <?php //}
			//}
			?>
                        <!-- <br>
                        <br>
                        <br> -->
<!-- ###################################################################################################################################################################################################################-->
                        <!-- This is where i have the main table declaration-->

                        <!-- <table class = "headers" style="width:100%">
                            <form method="post" action="<?php //echo htmlentities($_SERVER['PHP_SELF']); ?>">
                            <thead>
                                <tr>
                                  <td colspan="4">Course </td>
                                  <td rowspan="2"> SemesterYear </td>
                                  <td rowspan="2"> Credits </td>
                                  <td colspan="3"> Grade </td>
                                </tr>
                                <tr>
                                  <td>Dept</td>
                                  <td>Course Number</td>
                                  <td colspan="2">Title </td>
                                  <td> LetterGrade </td>
                                  <td> NumberGrade</td>
                                </tr>
                          </thead>
                          <tbody> -->

          <?php
                // if(!isset($_POST['category']) && !isset($_POST['searchInfo']) && !isset($_POST['signout']) && !isset($_POST['edit']) && !isset($_POST['submitChange'])){
                //                 $sql = "SELECT * FROM student_courses where u_id = $sessionID";
                //                     // Prepare a select statement
                //                     $result = $mysqli->query($sql);
                //                     if ($result->num_rows > 0) {
                //                         //read all product data
                //                         // output data of each row
                //                         while($row = $result->fetch_assoc()) {
                //               //$totalCredit = $totalCredit+ $row["credit"];
                //               if($row["lettergrade"]!= "IP"){
                //                 $totalCredit = $totalCredit + $row["credit"];
                //                              //	echo  $totalCredit;
                //                       $totalNumGrade = $totalNumGrade + $row["numgrade"];
                //                 $weightedGpa = $weightedGpa + $row["credit"] * $row["numgrade"] ;
                //                 $GPA= $weightedGpa/$totalCredit;
                //              }
                            ?>

                        <!--<table style="width:100%" id ="productList">-->
                                <!--<tr>-->
                        <!-- this is the line that is used to read each line of the student id. Reading directly the value of student_courses .-->

                                <!-- <tr>
                                  <td><?php //echo $row["dept"] ; ?></td>
                                  <td><?php //echo $row["crn"] ; ?></td>
                                  <td colspan="2"><?php //echo $row['title'] ; ?></td>
                                  <td><?php //echo $row["semYear"] ; ?></td>
                                  <td><?php //echo $row["credit"] ; ?></td>
                                  <td><?php //echo $row["lettergrade"] ; ?></td>
                                  <td><?php //echo $row["numgrade"] ; ?></td>

                                </tr>
                              </form> -->

                                <?php
                                            //             }
                                            // }
                                ?>
                            <!-- </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="5" class="footer">Total</td>
                                <td><?php //echo $totalCredit; ?></td>
                                <td colspan="3" align = 'center' ><?php //echo $totalNumGrade; ?></td>
                              </tr>
                              <tr>
                                <td colspan="5" class="footer">GPA</td>
                                <td colspan="3"><?php //echo (round($GPA,2)); ?>/ 4.0 </td>
                              </tr> -->

        <?php //} ?>



        <?php


                        // if($_POST['signout']){
                        //    session_unset();
                        //    session_destroy();
                        //    header("Location: homepage.php");
                        // }

                               ?>

        <?php
      //if(isset($_POST['edit'])){
        ?>
        <!-- <br> -->
          <!-- <div class="student-info">

              <form class="submitupdate" action="<?php //echo $_SERVER["PHP_SELF"];?>" method="post">
            <input type="text" name="newPassword" placeholder="New Password" required /><br />
            <input type="text" name="newAddress" placeholder="Address" required /><br />
            <input type="text" name="PhoneNumber" placeholder="Phone Number" required /><br />
              <input type="submit" name = "submitChange" value="Update Information"/>

            </form>

          </div> -->

        <?php
      // }
      // if(isset($_POST['submitChange'])){
      //   $newPswd = $_POST['newPassword'];
      //   $newAddr = $_POST['newAddress'];
      //   $phoneNumber = $_POST['PhoneNumber'];
      // $query = "UPDATE alumni SET pswd = '$newPswd', addr = '$newAddr', pnumber = '$phoneNumber' WHERE u_id = '$_SESSION[uid]'";
      // $result = mysqli_query($conn, $query);
      // $row = mysqli_fetch_assoc($result);
      ?>
        <!-- <span class = "updateComplete">Update Complete</span> -->
      <?php
    // }
//#################################################################################################################################################################################################################
                        //--backend code for category submit button

//    if(isset($_POST['s1'])){
//      // echo " inside of the topy of the category selected";
//      // Prepare a select statement
// 							$sql = "SELECT * FROM student_courses  WHERE lettergrade = ? ";
// 							// Prepare a select statement
// 							$stmt = $mysqli->prepare($sql);
// 						//	echo "before bind";
// 							//echo $_POST['category'];
// 							$stmt->bind_param("s",$_POST['category']);
// 							//	echo $_POST['category'];
// //echo '>>>> sucess' . $_POST['category'];
// 							$stmt->execute();
// 							//	echo "afetr the statement has been executed";
// 							$result = $stmt->get_result();
// 							if($result->num_rows === 0) echo "no course exists for this category in the database";
// 							else{
// 								//echo "inside of the else statement of the category";
// 								while(($row = $result->fetch_assoc()) ){
     ?>
                                                    <!-- <tr>
                                                      <td><?php //echo $row["dept"] ; ?></td>
                                                      <td><?php //echo $row["crn"] ; ?></td>
                                                      <td colspan="2"><?php //echo $row['title'] ; ?></td>
                                                      <td><?php //echo $row["semYear"] ; ?></td>
                                                      <td><?php //echo $row["credit"] ; ?></td>
                                                      <td><?php //echo $row["lettergrade"] ; ?></td>
                                                      <td><?php //echo $row["numgrade"] ; ?></td>

                                                  </tr> -->
                                              <!--  </form>  -->


                                          <?php
                                                // }
                                            // }
                        //}
                                          ?>
                                <!-- </tbody>
                            </form>
                         </table> -->
                         <?php //} ?>


        </body>

</html>

