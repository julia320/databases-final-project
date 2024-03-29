<!DOCTYPE html>
<?php
    session_start();
  
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Graduation App</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>

    <style type = "text/css">
      /* body{
        background-color: grey;
      }
      div.title{
          font-family: Tahoma, Geneva, sans-serif;
          font-size: 3em;
          text-align: center;
          color: white;
          background-color: #76b852;
            }
      ul {
        color: #76b852;
        font-weight:normal;
        list-style: none;
        padding-left: 0px;
        margin: 0;
        width: 600px;
        float: left;
      }
      li {
        width: 150px;
        display: inline-block;



      }

      li.nonCScourse{
          display: inline-block;
          width: 200px;

      }

      li.bGrade{
        display: inline-block;
        width: 200px;
      }
      span.err {
        color: red;

      }
      div.suspension{
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin:auto;
        text-align: center;
        width: 200px;
        height: 200px;
        color: #76b852;
        font-weight: bold;
      }
      div.Congrats{
        position: absolute;
        top: 0px;
        bottom: 0;
        left: 0;
        right: 0;
        margin:auto;
        text-align: center;
        width: 200px;
        height: 200px;
        color: #76b852;
        font-weight: bold;
      }
      div.signout{
        float: right;
      }
      div.courseHistory{

        width: 600px;
        float: left;
        color: white;
        border: solid white;



      }
      form{
        width: 350px;
        float: left;
      } */


    </style>
  </head>
    <body class="gray-bg">
    <form class="menu-button" action="menu.php">
      <input type="submit" value="Menu" formaction="menu.php">
    </form>
    <h2>Graduation Application</h2><hr>
  <?php

	$server = "localhost";
	$username = "ARGv";
	$password = "CSCI2541_sp19";
	$servername = "ARGv";
  $conn = mysqli_connect($server, $username, $password, $servername);

  if($mysqli->connect_error) {
     die("Connection failed: " . mysqli_connect_error());
  }

$query = "SELECT * FROM user WHERE uid = '$_SESSION[uid]' AND type = 'MS' OR type ='PHD'";
  $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($result)){
    if($row["grad_status"] != NULL){
      ?>
        <style type = "text/css">
          form.GraduateForm{
            display: none;
          }
          
        </style>
      <?php
    }
  }

$query = "SELECT * FROM transcript WHERE uid = '$_SESSION[uid]'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) == 0)
{
  header("Location: menu.php");
}


  if($_POST['Graduate']){

    if($_SESSION["uid"] != $_POST["uidCheck"]){
      ?>
        <span class="err">
            Incorrect UID, try again
        </span>
      <?php
    }
      else{
    $creditErr = $GPAerr = $numCourseErr = $BlowerErr = $thesisErr = $suspension = $reqErr = $PhDreqErr = $MSreqErr = "";
    //form 1 should have already been approved

    //Checks GPA and total Credits
  /*  $query = "SELECT SUM (sc.credit), AVG(numgrade) FROM form1 f, student_courses sc, students s
            WHERE f.uid = s.uid AND f.uid = sc.uid AND f.crn = sc.crn AND f.semYear = sc.semYear;" */

        //get program type
        $query = "SELECT program FROM user WHERE uid = '$_SESSION[uid]' AND type = 'MS' OR type = 'PHD'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        /* if == masters
              then check student courses for CSCI 6212, CSCI 6221, CSCI 6461
              then check GPA >= 3.0 and total Credits >= 30
              then COUNT courses NOT in CSCI, COUNT > 2
              then CHECK COUNT grade WHERE grade = B, should be <= 2

        */
        if (!empty($_POST["MSselect"]))
        {
          //echo "You are a masters student <br/>";

          /*$query = "SELECT SUM(sc.credit) as credits FROM student_courses AS sc WHERE sc.u_id = 11111111";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);*/
          $query = "SELECT * FROM requirements WHERE program = 'MS'";
          $result = mysqli_query($conn, $query);
          	while ($row = mysqli_fetch_assoc($result)){

            if($_SESSION["credits"] < $row["NumCredits"]){
              $creditErr = "You don't have enough credits";
            }
          ?>


          <?php

          if($_SESSION["numgrade"] < $row["GPA"]){
            $GPAerr= "You do not meet the GPA requirement";
          }

          if($_SESSION["count"] > $row["nonCScourses"]){
            $numCourseErr = "You  have too many courses outside of CSCI";
          }

          if($_SESSION["lettercount"] == $row["Blower"]){
            $BlowerErr = "You have too many courses with a B or lower";
          }

          if($_SESSION["lettercount"] >= $row["suspensionCount"]){
            $BlowerErr = "You have too many courses with a B or lower";
            $suspension = "You are now under academic suspension";
            ?>
            <style "text/css">

            div.courseHistory{
              display: none;
            }

            div.suspension{
              top: 200px;
            }

            </style>
            <?php

            $query = "UPDATE user SET active = 'susp' WHERE uid = '$_SESSION[uid]'";
            $result = mysqli_query($conn, $query);
            ?>
              <div class="suspension"> <?php echo $suspension; ?>  </div>
              <?php
          }
}


          if($_SESSION["MSreq"] == 'incomplete'){
            $MSreqErr = "You have not taken all core courses for the MS program";
          }


          if($_SESSION["MSreqThesis"] == 'yes' && $_SESSION["thesis"] == "NA"){
            $thesisErr = "You need to write a thesis";
          }

          if($_SESSION["thesis"] == "In progress" && $_SESSION["MSreqThesis"] == 'yes'){
            $thesisErr = "Thesis is incomplete";
          }
        //  echo "your total credits are " . $row['credits'] .  "<br/>";
          //$_SESSION['credits'] = $row['credits'];






          //echo "You have taken " . $row['count'] . " that are not in the CS department <br/>";




          ?>


          <?php
          if($BlowerErr == "" && $suspension == "" && $numCourseErr == "" && $GPAErr == "" && $creditErr == "" && $MSreqErr == "" && $thesisErr == "") {
            ?>
            <style "text/css">
            ul {
              display: none;
            }
            div.courseHistory{
              display: none;
            }

            </style>
            <div class="Congrats"> Application Complete, your application is now under review</div>
            <?php
            $query = "UPDATE user SET grad_status = 'MS' WHERE uid = '$_SESSION[uid]'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $_SESSION["MSgranted"] = 'yes';
            $_SESSION["grad_status"] = 'MS';


          }




}




              /* if == PhD
                  then check GPA >= 3.5 and total Credits >= 36
                  $query = "SELECT SUM (sc.credit), AVG(numgrade) FROM form1 f, student_courses sc, students s
                        WHERE f.uid = s.uid AND f.uid = sc.uid AND f.crn = sc.crn AND f.semYear = sc.semYear;"
                  then check if COUNT credits >= 30 in CSCI Department
                  then check COUNT grade should be <= 1 WHERE grade = B
                  then check if passed defense
              */
              if (!empty($_POST["PhDselect"])){
                //echo "You are a masters student <br/>";

                /*$query = "SELECT SUM(sc.credit) as credits FROM student_courses AS sc WHERE sc.u_id = 11111111";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);*/


                $query = "SELECT * FROM requirements WHERE program = 'PhD'";
                $result = mysqli_query($conn, $query);
                	while ($row = mysqli_fetch_assoc($result)){
                  if($_SESSION["credits"] < $row["NumCredits"]){
                    $creditErr = "You don't have enough credits";
                  }
                ?>


                <?php

                if($_SESSION["numgrade"] < $row["GPA"]){
                  $GPAerr= "You do not meet the GPA requirement";
                }

                if($_SESSION["count"] > $row["nonCScourses"]){
                  $numCourseErr = "You  have too many courses outside of CSCI";
                }

                if($_SESSION["lettercount"] > $row["Blower"]){
                  $BlowerErr = "You have too many courses with a B or lower";
                }

                if($_SESSION["lettercount"] >= $row["suspensionCount"]){

                  $suspension = "You are now under academic suspension";
                  ?>
                  <style "text/css">

                  div.courseHistory{
                    display: none;
                  }

                  div.suspension{
                    top: 200px;
                  }

                  </style>
                  <?php

                  $query = "UPDATE user SET active = 'susp' WHERE uid = '$_SESSION[uid]'";
                  $result = mysqli_query($conn, $query);
                  ?>
                    <div class="suspension"> <?php echo $suspension; ?>  </div>
                    <?php
                }
              }

                if($_SESSION["PhDreq"] == 'incomplete'){
                  $PhDreqErr = "You have not taken all three core courses for the PhD program";
                }

                if($_SESSION["thesis"] == "NA" && $_SESSION["PhDreqThesis"] == 'yes'){
                  $thesisErr = "You need to write a thesis";
                }
                if($_SESSION["thesis"] == "In progress" && $_SESSION["PhDreqThesis"] == 'yes'){
                  $thesisErr = "Thesis is incomplete";
                }

              //  echo "your total credits are " . $row['credits'] .  "<br/>";
                //$_SESSION['credits'] = $row['credits'];






                //echo "You have taken " . $row['count'] . " that are not in the CS department <br/>";




                ?>


                <?php
                if($BlowerErr == "" && $suspension == "" && $numCourseErr == "" && $GPAErr == "" && $creditErr == "" && $thesisErr == "" && $PhDreqErr == "") {
                  ?>
                  <style "text/css">
                  ul {
                    display: none;
                  }
                  div.courseHistory{
                    display: none;
                  }

                  </style>
                  <div class="Congrats"> Application Complete, your application is now under review</div>
                  <?php
                  if(!empty($_POST["PhDselect"]) && !empty($_POST["MSselect"]) && $_SESSION["MSgranted"] == 'yes'){
                    $query = "UPDATE user SET grad_status = 'MS/PhD' WHERE uid = '$_SESSION[uid]'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION["grad_status"] = 'MS/PhD';

                  }
                  else{
                  $query = "UPDATE user SET grad_status = 'PhD' WHERE uid = '$_SESSION[uid]'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  $_SESSION["grad_status"] = 'PhD';
                }

                }




      }

      if(empty($_POST["PhDselect"]) && empty($_POST["MSselect"])){
        ?>
          <span class = err> Select a Program </span>
        <?php
      }



}

        }



        /* if == masters
              then check student courses for CSCI 6212, CSCI 6221, CSCI 6461
              then check GPA >= 3.0 and total Credits >= 30
              $query = Use INNER JOIN to match form1 and student_courses, this is to make sure student stayed consistant with schedule
              then COUNT courses NOT in CSCI, COUNT > 2
              then CHECK COUNT grade WHERE grade = B, should be <= 2

        */






  ?>
 <?php
  $query = "SELECT * FROM user WHERE uid = '$_SESSION[uid]' AND type = 'MS' OR type = 'PHD'";
  $result = mysqli_query($conn, $query);
          ?>
          <form class = "GraduateForm"action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                  <input type="radio" name="MSselect"> MS
                  <input type="radio" name="PhDselect"> PhD
                  <input type="text" name="uidCheck" placeholder="Enter uid" required>
                  <input type="submit" name="Graduate" value="Apply to Graduate">
          </form>


  

    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <div class="signout">
      <!-- <input type="submit" name="signout" value="Logout" formaction="logout.php"> -->
    </div>
    <!-- <input type="submit" name="backBttn" value="Back" formaction="menu.php"> -->
</form>




  <?php

 



if($_POST['signout']){
  session_unset();
  session_destroy();
  header("Location: logout.php");
}


?>
<br>
<br>
<ul class = "Report">
<?php
  $query = "SELECT SUM(c.credits) as credits FROM transcript t, course c WHERE t.crn = c.crn AND t.uid =  '$_SESSION[uid]' AND t.grade NOT IN('IP')";
  $result = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($result))
  {
    $_SESSION["credits"] = $row["credits"];
}
  ?>


<li class="credit"> Total Credits: <?php echo $_SESSION["credits"]; ?></li>
<span class = "err"> <?php echo $creditErr; ?> </span>


<?php
    $sum = 0;
    $final_sum = 0;
    $query2 = "select t.grade, c.credits from course c, transcript t where '".$_SESSION['uid']."'=t.uid AND t.crn=c.crn;";
    $credit_sum = "select sum(c.credits) from course c, transcript t where '".$_SESSION['uid']."'=t.uid AND t.crn=c.crn;";
    $result2 = mysqli_query($conn, $query2);
    $result_sum = mysqli_query($conn, $credit_sum);
    $final_sum = mysqli_fetch_assoc($result_sum)["sum(c.credits)"];
     if (mysqli_num_rows($result2) > 0) {
       while($row = mysqli_fetch_assoc($result2)){
          if($row["grade"] == "A"){
            $sum += (4.0 * $row["credits"]);
          }
          if($row["grade"] == "A-"){
            $sum += (3.7 * $row["credits"]);
          }
          if($row["grade"] == "B+"){
            $sum += (3.3 * $row["credits"]);
          }
          if($row["grade"] == "B"){
            $sum += (3.0 * $row["credits"]);
          }
          if($row["grade"] == "B-"){
            $sum += (2.7 * $row["credits"]);
          }
          if($row["grade"] == "C+"){
            $sum += (2.3 * $row["credits"]);
          }
          if($row["grade"] == "C"){
            $sum += (2.0 * $row["credits"]);
          }
          if($row["grade"] == "F"){
            $sum += (0 * $row["credits"]);
          }
          if($row["grade"] == "IP"){
            $sum += 0;
          }
        }
        $_SESSION["numgrade"] = ($sum/$final_sum);
        //echo "GPA: " .$gpa;
      }




?>
<br>
<li class="GPA"> GPA: <?php echo number_format((float)$_SESSION["numgrade"], 2, '.', ''); ?> </li>
<span class = "err"> <?php echo $GPAErr; ?> </span>

<?php



 $query = "SELECT COUNT(c.crn) as count FROM transcript t, course c WHERE t.crn = c.crn AND t.uid = '$_SESSION[uid]' AND c.dept != 'CSCI' AND t.grade != 'IP' AND t.numgrade > 0";
 $result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result))
{
 $_SESSION['count'] = $row['count'];
}

 ?>
 <br>
 <li class="nonCScourse"> Number of courses not in CS department: <?php echo $_SESSION["count"]; ?> </li>
 <span class = "err"> <?php echo $numCourseErr; ?> </span>

<?php
 $query = "SELECT COUNT(t.grade) as lettercount FROM transcript t WHERE t.uid = '$_SESSION[uid]' AND grade NOT IN('IP', 'A', 'B')";
 $result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){
 $_SESSION['lettercount'] = $row['lettercount'];
}

 ?>
 <br>
 <li class="bGrade"> Number of courses lower than B: <?php echo $_SESSION["lettercount"]; ?> </li>
   <span class = "err"> <?php echo $BlowerErr; ?> </span>

<?php
$query = "SELECT COUNT(*) as MStaken FROM transcript t, corereq cr, course c WHERE t.crn = c.crn AND c.courseno = cr.courseno AND cr.program = 'MS' AND t.uid = '$_SESSION[uid]' AND grade NOT IN('IP') AND numgrade > 0.0";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){
$_SESSION['MStaken'] = $row['MStaken'];
}

$query = "SELECT COUNT(*) as PhDtaken FROM transcript t, corereq cr, course c WHERE t.crn = c.crn AND c.courseno = cr.courseno AND cr.program = 'PhD' AND t.uid = '$_SESSION[uid]' AND grade NOT IN('IP') AND numgrade > 0.0";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){
$_SESSION['PhDtaken'] = $row['PhDtaken'];
}

$query = "SELECT COUNT(*) as MScount FROM corereq WHERE program = 'MS'";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){
if ($row['MScount'] > 0){
  $_SESSION['MScount'] = $row['MScount'];
}
else {$_SESSION['MScount'] = 0;}
}

$query = "SELECT COUNT(*) as PhDcount FROM corereq WHERE program = 'PhD'";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){
if ($row['PhDcount'] > 0){
  $_SESSION['PhDcount'] = $row['PhDcount'];
}
else {
  $_SESSION['PhDcount'] = 0;
}


if($_SESSION['MStaken'] < $_SESSION['MScount']){
  $_SESSION['MSreq'] = 'incomplete';
}
else{
  $_SESSION['MSreq'] = 'complete';
}
//echo $_SESSION['MStaken'] . $_SESSION['MScount'];
if($_SESSION['PhDtaken'] < $_SESSION['PhDcount']){
    $_SESSION['PhDreq'] = 'incomplete';
}
else{
  $_SESSION['PhDreq'] = 'complete';
}
}

      ?>
      <br>
      <li class ="requiredCourses"> Masters Course Check: <?php echo $_SESSION['MSreq']; ?></li>
      <span class = "err"><?php echo $MSreqErr; ?></span>
      <br>
      <li class ="requiredCourses"> PhD Course Check <?php echo $_SESSION['PhDreq']; ?></li>
      <span class = "err"><?php echo $PhDreqErr; ?></span>
      <?php



//check if thesis is yes or no
$query = "SELECT Thesis FROM requirements WHERE program = 'MS'";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){

    $_SESSION["MSreqThesis"] = $row["Thesis"];


}

$query = "SELECT Thesis FROM requirements WHERE program = 'PhD'";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){

    $_SESSION["PhDreqThesis"] = $row["Thesis"];



}

$query = "SELECT status FROM thesis_status WHERE uid = '$_SESSION[uid]'";
$result = mysqli_query($conn, $query);
$_SESSION["thesis"] = 'NA';
while($row = mysqli_fetch_assoc($result)){
if (($result->num_rows) > 0){

  if ($row["status"] == "passed"){
      $_SESSION["thesis"] = $row["status"];
  }
    if ($row["status"] == "In progress"){
      $_SESSION["thesis"] = $row["status"];

      }
    }

}

 ?>
 <br>
<li class = "thesis_stat"> Thesis Status: <?php echo $_SESSION["thesis"]; ?></li>
<span class = "err"><?php echo $thesisErr ?></span>
</ul>




  </body>
<?php

   ?>
</html>

