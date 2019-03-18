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
  <h2> Page 2: Prior Degrees </h2>
  
  <body>
    <!--change form method to page 3-->
    <form id="mainform" action="application_form_recommendation_page3.php" method="post">
      <h3>Degree One (required)</h3>
      Degree Type <br>
      <input type="radio" name="type" value="MS" checked> MS<br>
      <input type="radio" name="type" value="BS"> BS<br>
      <input type="radio" name="type" value="BA"> BA <br>
      GPA <span><input type="text" name="gpa"></span><br>
      Year <span><input type="text" name="year"></span><br>
      University<span><input type="text" name="university"></span><br>

      <hr>     
      <h3>Degree Two (optional)</h3>
      Degree Type <br>
      <input type="radio" name="type2" value="MS" checked> MS<br>
      <input type="radio" name="type2" value="BS"> BS<br>
      <input type="radio" name="type2" value="BA"> BA <br>
      GPA <span><input type="text" name="gpa2"></span><br>
      Year <span><input type="text" name="year2"></span><br>
      University<span><input type="text" name="university2"></span><br>

      <hr>
      <h3>Degree Three (optional)</h3>
      Degree Type <br>
      <input type="radio" name="type3" value="MS" checked> MS<br>
      <input type="radio" name="type3" value="BS"> BS<br>
      <input type="radio" name="type3" value="BA"> BA <br>
      GPA <span><input type="text" name="gpa3"></span><br>
      Year <span><input type="text" name="year3"></span><br>
      University<span><input type="text" name="university3"></span><br>

      <hr>
      <h3>Degree Four (optional)</h3>
      Degree Type <br>
      <input type="radio" name="type4" value="MS" checked> MS<br>
      <input type="radio" name="type4" value="BS"> BS<br>
      <input type="radio" name="type4" value="BA"> BA <br>
      GPA <span><input type="text" name="gpa4"></span><br>
      Year <span><input type="text" name="year4"></span><br>
      University<span><input type="text" name="university4"></span><br>
    </form>

    <!-- make it go at bottom of page -->
    <div class="bottomCentered"><input type="submit" name="submit" value="Submit" form="mainform"></div>
  </body>
  
</html>                                                                                    
