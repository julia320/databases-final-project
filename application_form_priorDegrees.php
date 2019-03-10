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
      Degree Type <span><input list="degrees" name="type">
      <datalist id="degrees">
        <option value="MS">
        <option value="BS">
        <option value="BA">
      </datalist></span>
      GPA <span><input type="text" name="gpa"></span><br>
      Year <span><input type="text" name="year"></span><br>
      University<span><input type="text" name="university"></span><br><br>
      
      <input type="submit" name="submit" value="Submit"> 
    </form>
      
  </body>
</html>
