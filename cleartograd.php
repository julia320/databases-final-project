<?php
    // Start the session
    session_start();

    //Ensure user is logged in
    $loggedin = $_SESSION['loggedin'];
    if(!$loggedin)
    {
	    header("Location: login.php");
	    die();
    }

    //send to menu page if they don't have sufficient permissions
    if(!($_SESSION['type']=="secr" || $_SESSION['type']=="admin")) {
	    header("Location: menu.php");
	    die();
    }

    //Connect to database
    $servername = "localhost";
    $username = "ARGv";
    $password = "CSCI2541_sp19";
    $dbname = "ARGv";
    $connection = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$connection) 
    {
	    die("Couldn't connect: ".mysqli_error());
    } 
?>
<head>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<!DOCTYPE html>
<html>
<?php
	
	$server = "localhost";
	$username = "ARGv";
	$password = "CSCI2541_sp19";
	$servername = "ARGv";
	$mysqli = mysqli_connect($server, $username, $password, $servername);
    
    if($mysqli->connect_error) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
   
    $sessionID = $_SESSION["uid"];
    
    if($_SESSION['uid'] == 0)
    {
?>
        <form class="menu-button" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <input type="submit" value="Back" formaction="menu.php">
        </form>
<?php
    }
    else
    {
?>
        <form class="menu-button" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <input type="submit" value="Back" formaction="menu.php">
        </form>
<?php
    }

    
?>
    <form class="menu-button" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="submit" value="Logout" formaction="logout.php">
    </form>

    <head>
        <title>Approve for Graduation</title>
    </head>
<?php 
    if(!empty($_GET["action"]))
    { 
        switch($_GET["action"])
        { 
            //CLEAR TO GRADUATE
            case "clear":
                $uid = $_GET["uid"];
                $query = "UPDATE user SET type = 'alum' WHERE uid = $uid";;
                $result = mysqli_query($connection, $query);
                if($result)
                {
                    echo $_GET["uid"] . " has been cleared and is now an alumni.";
                    $query = "SELECT * FROM user WHERE uid = $uid";
                    $result = mysqli_query($connection, $query);
                    while($row = $result->fetch_assoc()) 
                    {
    
                        $msg = "Congragulations, ". $row["fname"] . "! You are now a graduate of the " . $row["grad_status"] . " program! You are now an alumni. Your uid and password remain unchanged. You can now only view your transcript, edit your profile, and make a donation. Thank you for your hard work and attending our university!";
                        
                        $msg = wordwrap($msg, 45, false);
                        mail($row["email"],"Congrats, Grad!",nl2br($msg));
                    }
                    
                }
                else
                {
                    echo "Student was not cleared for graduation.";
                }
                break;
        }
    }   
            
?>
<body class="gray-bg">
    <!-- This is to deal with the header bar button which enables the user to do a lot of stuffs-->
    <div id="buttonzone">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" >
            <input type="text" placeholder="Search.." name="searchInfo" id = "bar" >
            <input type="submit" name="Search" value="Search" id="search">
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
            </tr>
        </thead>
    <tbody>

<?php
    // this is the backend part of printing all the students
    if(!isset($_POST['s1']) && !isset($_POST['searchInfo']))
    {
        $sql = "SELECT * FROM user WHERE (type = 'MS' OR type = 'PHD') AND (grad_status = 'MS' OR grad_status = 'PhD' OR grad_status = 'PhD/MS') ORDER BY lname";
        // Prepare a select statement
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) 
        {
            //read all product data
            // output data of each row
            while($row = $result->fetch_assoc()) 
            {
                if($row["grad_status"] == "MS" || $row["grad_status"] == "PhD/MS" || $row["grad_status"] == "PhD")
                {
?>
                    <!--<table style="width:100%" id ="productList">-->
                    <!--<tr>-->
                    <!-- this is the line that is used to read each line of the student id. Reading directly the value of student_courses .-->
                        <tr>
                            <td>
                                <form class="example" action="cleartograd.php?action=clear&uid=<?php echo $row['uid']; ?>" method="post"  >
                                    <button class="clear_To_Graduate">
										ClearToGraduate
                                    </button>
                                </form>     
                            </td>
                            <td>
                                <?php echo $row["uid"] ; ?>
                            </td>
                            <td>
                                <?php echo $row["lname"] . ', ' . $row["fname"] ; ?>
                            </td>
                            <td>
                                <?php echo $row["major"] ; ?>
                            </td>
                            <td>
                                <?php echo $row["program"] ; ?>
                            </td>
                                    

                        </tr>
                        

<?php
                }
                else
                {
?>   
				    <tr>
                        <td>                           
                        </td>
                        <td><?php echo $row["uid"] ; ?></td>
                        <td><?php echo $row["lname"] . ', ' . $row["fname"] ; ?></td>
                        <td><?php echo $row["major"] ; ?></td>
                        <td><?php echo $row["program"] ; ?></td>
                    </tr>
<?php
                }
            }
        }
?>
        </tbody>

<?php 
    } 
?>
    <br>
    <br>



<!-- This is to deal with the dropdown button backedn code -->
<?php
    if(isset($_POST['s1']))
    {
        $sql = "SELECT * FROM user WHERE type = 'MS' OR type = 'PHD' ORDER BY lname ";
        $stmt = $mysqli->prepare( $sql);
        
        $stmt->bind_param("s",  $_POST['category']);
        // Prepare a select statement
        $result = $mysqli->query($sql);
        //echo'>>>>>>>>>>result is:'.$result;
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 0) 
        {
            echo "no student  exists for this category in the database";
        }
        else
        {
            while($row = $result->fetch_assoc())
            {
                if($row["grad_status"] == "MS" || $row["grad_status"] == "PhD/MS" || $row["grad_status"] == "PhD")
                {
                                    
?>
                    <!--<table style="width:100%" id ="productList">-->
                    <!--<tr>-->
                    <!-- this is the line that is used to read each line of the student id. Reading directly the value of student_courses .-->
                    <tr>
                        <td>
                            <form class="example" action="cleartograd.php?action=clear&uid=<?php echo $row['uid']; ?>" method="post"  >
                                <button class="clear_To_Graduate">
                                    ClearToGraduate
                                </button>
                            </form>     
                        </td>
                        <td>
                            <?php echo $row["uid"] ; ?>
                        </td>
                        <td>
                            <?php echo $row["lname"] . ', ' . $row["fname"] ; ?>
                        </td>
                        <td>
                            <?php echo $row["major"] ; ?>
                        </td>
                        <td>
                            <?php echo $row["program"] ; ?>
                        </td>
                    </tr>                                                 
<?php
                }
            }
        }
    }
?>
    <!-- ********************************************** Back end code that deals with the search bar entered   -->

    <!-- this is the backend part of the code that actually handles the search data entered -->
<?php
    if(isset($_POST['searchInfo']))
    {
        $sql = "SELECT * FROM user WHERE uid = ? ORDER BY fname ";
        $stmt = $mysqli->prepare( $sql);
        $stmt->bind_param("i",  $_POST['searchInfo']);
        // Prepare a select statement
        $result = $mysqli->query($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) 
        {
            echo "no student with that uid found";
        }
        else
        {
            while(($row = $result->fetch_assoc()) )
            {
                if($row["grad_status"] == "MS" || $row["grad_status"] == "PhD/MS" || $row["grad_status"] == "PhD")
                {
?>
  
                    <!--<table style="width:100%" id ="productList">-->
                    <!--<tr>-->
                    <!-- this is the line that is used to read each line of the student id. Reading directly the value of student_courses .-->
                    <tr>
                        <td>
                            <form class="example" action="GradSecretary.php?action=clear&uid=<?php echo $row['uid']; ?>" method="post"  >
                                <button class="clear_To_Graduate">
                                          ClearToGraduate
                                </button>
                            </form>     
                        </td>
                        <td>
                            <?php echo $row["uid"] ; ?>
                        </td>
                        <td>
                            <?php echo $row["lname"] . ', ' . $row["fname"] ; ?>
                        </td>
                        <td>
                            <?php echo $row["major"] ; ?>
                        </td>
                        <td>
                            <?php echo $row["program"] ; ?>
                        </td>
                    </tr>
                          
  
<?php
                }
  
                else
                {
?>   
                    <td>                           
                    </td>
                    <td><?php echo $row["uid"] ; ?></td>
                    <td><?php echo $row["lname"] . ', ' . $row["fname"] ; ?></td>
                    <td><?php echo $row["major"] ; ?></td>
                    <td><?php echo $row["program"] ; ?></td>
<?php
                }
            }
        }
    }
    
    if($_POST['signout'])
    {
        session_unset();
        session_destroy();
        header("Location: logout.php");
    }
?>
</body>
</html>

