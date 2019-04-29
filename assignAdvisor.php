<?php
    // Start the session
    session_start();
?>
<head>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<!DOCTYPE html>
<html>
<?php
   // require_once('config.php');
	
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
            case "add":
                echo "user selected" . $_GET["uid"];
                echo "the action that was selected is:" . $_GET["action"];
    
                echo "Connected successfully <br/>";
                $aQuery = "SELECT uid FROM user WHERE type = 'adv' ORDER BY rand() LIMIT 1";
                $aResult = mysqli_query($mysqli, $aQuery);
              
                $adv = '';
                if(mysqli_num_rows($aResult) != 1)
                {
                    echo "Advisor not added";
                }
                else
                {	
					$aRow = mysqli_fetch_assoc($aResult);
                    $adv = $aRow['advisor'];	
                    $uid = $_GET["uid"] ;
                    echo "adv selected" . $adv;
                    $sql = "UPDATE  user SET advisor = '$adv' WHERE uid= '$uid' ";
                    $stmt = mysqli_query($mysqli, $sql);
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
                <td>ID</td>
                <td>NAME</td>
                <td>MAJOR</td>
                <td>PROGRAM</td>
                <td>Add an Advisor</td>
            </tr>
        </thead>
    <tbody>

<?php
    // this is the backend part of printing all the students
    if(!isset($_POST['s1']) && !isset($_POST['searchInfo']))
    {
        $sql = "SELECT * FROM user WHERE type = 'MS' OR type = 'PHD' ORDER BY lname";
        // Prepare a select statement
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) 
        {
            //read all product data
            // output data of each row
            while($row = $result->fetch_assoc()) 
            {
?>   
				    <tr>
                        <td><?php echo $row["uid"] ; ?></td>
                        <td><?php echo $row["lname"] . ', ' . $row["fname"] ; ?></td>
                        <td><?php echo $row["major"] ; ?></td>
                        <td><?php echo $row["program"] ; ?></td>
                        <td>
                            <form class="example" action="assignAdvisor.php?action=add&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                                <button class="Add_An_Advisor">
                                    Assign Advisor
                                </button>
                            </form>     
                        </td>
                    </tr>
<?php
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
?>   
                    <td><?php echo $row["uid"] ; ?></td>
                    <td><?php echo $row["lname"] . ', ' . $row["fname"] ; ?></td>
                    <td><?php echo $row["major"] ; ?></td>
                    <td><?php echo $row["program"] ; ?></td>
                    <td>
                        <form class="example" action="assignAdvisor.php?action=add&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                            <button class="Add_An_Advisor">
                                Assign Advisor
                            </button>
                        </form>     
                    </td>                                                  
<?php
                
            }
        }
    }
?>
    <!-- ********************************************** Back end code that deals with the search bar entered   -->

    <!-- this is the backend part of the code that actually handles the search data entered -->
<?php
    if(isset($_POST['searchInfo']))
    {
        $sql = "SELECT * FROM user WHERE uid = ? ORDER BY lname ";
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
?>   
                    <td><?php echo $row["uid"] ; ?></td>
                    <td><?php echo $row["lname"] . ', ' . $row["fname"] ; ?></td>
                    <td><?php echo $row["major"] ; ?></td>
                    <td><?php echo $row["program"] ; ?></td>
                    <td>
                        <form class="example" action="assignAdvisor.php?action=add&u_id=<?php echo $row['u_id']; ?>" method="post"  >
                            <button class="Add_An_Advisor">
                                Assign Advisor
                            </button>
                        </form>     
                    </td>
<?php
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

