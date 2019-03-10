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
  </style>
  
   <h1> Application Form </h1>
   <h3> Page 2: Prior Degrees </h3><br>
  
  <body>
    
    <form method="post">
      Degree Type <br>
      <input type="radio" name="type" value="MS" checked> MS<br>
      <input type="radio" name="type" value="BS"> BS<br>
      <input type="radio" name="type" value="BA"> BA <br>
      GPA <span><input type="text" name="gpa"></span><br>
      Year <span><input type="text" name="year"></span><br>
      University<span><input type="text" name="university"></span><br><br>
      
      <input type="submit" name="submit" value="Submit"> 
    </form>
   
    <form method="post">
      <input type="submit" name="another" value="Add Another Degree"><br>
      <?php
        if (isset($_POST["another"])){
          $form = '<hr><form method="post">
                   Degree Type <br>
                   <input type="radio" name="type" value="MS" checked> MS<br>
                   <input type="radio" name="type" value="BS"> BS<br>
                   <input type="radio" name="type" value="BA"> BA <br>
                   GPA <span><input type="text" name="gpa"></span><br>
                   Year <span><input type="text" name="year"></span><br>
                   University<span><input type="text" name="university"></span>></form>';
          echo $form;
        }
      ?>
    </form>
      
  </body>
</html>
