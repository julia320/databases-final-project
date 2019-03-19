<html>
  
  <title>
    Application Form
  </title>
  
  <style>
    span {
      position: absolute;
      left: 160px;
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
   <h2> Page 3: Recommendation Letter </h2>
   Enter the contact information of the person who will provide your recommendation letter.<br>
   We will reach out to this person and ask for their letter. <br>
   You can see the status of your recommendation letter on your homepage.
  
  <body>
    
    <form id="mainform" action="application_form_end.php" method="post">
      <h3>Recommendation Letter One(required)</h3>
      First name <span><input type="text" name="fname"></span><br>
      Last name <span><input type="text" name="lname"></span><br>
      Institution/affiliation <span><input type="text" name="institution"></span><br>
      email <span><input type="text" name="email"></span><br>
      
      <hr>     
      <h3>Recommendation Letter Two(optional)</h3>
      First name <span><input type="text" name="fname2"></span><br>
      Last name <span><input type="text" name="lname2"></span><br>
      Institution/affiliation <span><input type="text" name="institution2"></span><br>
      email <span><input type="text" name="email2"></span><br>
      
      <hr>     
      <h3>Recommendation Letter Three(optional)</h3>
      First name <span><input type="text" name="fname3"></span><br>
      Last name <span><input type="text" name="lname3"></span><br>
      Institution/affiliation <span><input type="text" name="institution3"></span><br>
      email <span><input type="text" name="email3"></span><br><br>
      
      <div class="bottomCentered"><input type="submit" name="submit" value="Submit"></div> 
    </form>
      
  </body>
</html>
