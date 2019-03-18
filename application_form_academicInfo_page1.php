<?php
  // connect to mysql
  $servername = "localhost";
  $user = "TheSpookyLlamas";
  $pass = "TSL_jjy_2019";
  $dbname = "TheSpookyLlamas";
  $conn = mysqli_connect($servername, $user, $pass, $dbname);
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $somethingEmpty = "";
  
  if (isset($_POST['submit'])){
    //make sure all the data was entered properly
    if(count(array_filter($_POST))!=count($_POST)){
      $somethingEmpty = "One or more fields are missing";
    }
  }
  

?>

<html>
  
  <title>
    Application Form
  </title>
  
  <style>
    span {
      position: absolute;
      left: 140px;
    }
    body{line-height: 1.6;}
    .bottomCentered{
       position: fixed;   
       text-align: center;
       bottom: 30px;
       width: 100%;
    }
    .error {color: #FF0000;}
  </style>
  
   <h1> Application Form </h1>
   <h2> Page 1: Academic Info </h2><br>
  
  <body>
    <!--action="application_form_priorDegrees_page2.php"-->
    <form id="mainform" method="post">
     
      What degree are you applying for? <br>
      <input type="radio" name="degreeType" value="MS" > MS<br>
      <input type="radio" name="degreeType" value="PhD"> PhD<br><br>
  
      Year <span><input type="text" name="appYear"></span><br>
      Semester <br>
      <input type="radio" name="semester" value="fall"> Fall<br>
      <input type="radio" name="semester" value="spring"> Spring<br>
      <input type="radio" name="semester" value="summer"> Summer<br><br>
      
      GRE: <br>
      Verbal <span><input type="text" name="verbal"></span><br>
      Quantitative <span><input type="text" name="quantitative"></span><br>
      Year of exam <span><input type="text" name="year"></span><br><br>
      GRE advanced: <br>
      Score <span><input type="text" name="advScore"></span><br>
      Subject <span><input type="text" name="subject"></span><br><br>
      TOEFL Score <span><input type="text" name="toefl"></span><br>
      Year of exam <span><input type="text" name="advYear"></span><br><br>

      Areas of Interest <span><input type="text" name="aoi"></span><br>
      Experience <span><input type="text" name="experience"></span><br>
      
      <div class="bottomCentered"><input type="submit" name="submit" value="Submit">
      <span class="error"><?php echo $somethingEmpty;?></span></div>
      
    </form>
      
  </body>
</html>
