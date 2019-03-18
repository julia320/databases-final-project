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
  </style>
  
   <h1> Application Form </h1>
   <h2> Page 1: Academic Info </h2><br>
  
  <body>
    
      <form id="mainform" action="application_form_priorDegrees_page2.php" method="post">
      What degree are you applying for? (MS/PhD) <input type="text" name="degreeType"><br><br>
      
      Semester <br>
      <input type="radio" name="semester" value="Fall" checked> MS<br>
      <input type="radio" name="semester" value="Spring"> BS<br>
      <input type="radio" name="semester" value="Summer"> BS<br>
      Year <span><input type="text" name="appYear"></span><br>
      
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
      
      <div class="bottomCentered"><input type="submit" name="submit" value="Submit"></div> 
    </form>
      
  </body>
</html>
