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
   <h2> Page 3: Recommendation Letter </h2>
   Enter the contact information of the person to provide your recommendation letter. 
   We will reach out to this person and ask for their letter. 
   See homepage to check the status of your recommendation letter.
  
  <body>
    
    <form id="mainform" action="application_form_end.php" method="post">
      <h3>Recommendation Letter One(required)</h3>
      First name <span><input type="text" name="fname"></span><br>
      Last name <span><input type="text" name="lname"></span><br>
      Institution/affiliation <input type="text" name="institution"></span><br>
      email <input type="text" name="email"></span><br>
      
      <input type="submit" name="submit" value="Submit"> 
    </form>
      
  </body>
</html>
