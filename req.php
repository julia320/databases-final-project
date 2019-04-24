<!DOCTYPE html>

<head>
    <title>JARS Main Menu</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>
<style>
        input[type=submit] {
            background-color: #76b852;
            border: none;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            margin: 4px 2px;
            width: 70%;
        }

        input[type=submit]:hover {
            background-color: #76b852;
            border: none;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
            width: 80%;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
    </style>
<body class="gray-bg">
    <?php

        session_start();

        //connect to database
        $connection = mysqli_connect("localhost", "ARGv", "CSCI2541_sp19", "ARGv");

        //If they somehow got here without logging in, politely send them away
        if (!$_SESSION['loggedin']) {
            header("Location: login.php");
            die();
        }

        echo "<div style=\"text-align: center;\"><div style=\"display: inline-block; width: 80%;\">";
        echo "Welcome, " . $_SESSION['fname'] . ". This is the requirements page.<br><br>";
        $nextItem = true;



        //MS REQUIREMENTS
        echo "<div class=\"main-menu\"><form action=\"managereqs.php\"><input type=\"submit\" name=\"MS\" value=\"MS Requirements\"/></form></div>";

        //PHD REQUIREMENTS
        echo "<div class=\"main-menu\"><form ><input type=\"submit\" name=\"PHD\" value=\"PhD Requirements\"/></form></div>";

        //CORE REQUIRMENTS
        echo "<div class=\"main-menu\"><form ><input type=\"submit\" name=\"core\" value=\"Core Requirements\"/></form></div>";

        //CATAlOG 
        echo "<div class=\"main-menu\"><form ><input type=\"submit\" name=\"catalog\" value=\"Course Catalog\"/></form></div>";

        //BACK
        echo "<div class=\"main-menu\"><form action=\"menu.php\"><input type=\"submit\" value=\"Back\"/></form></div>";

        //LOGOUT
        echo "<div class=\"main-menu\"><form action=\"logout.php\"><input type=\"submit\" value=\"Logout\"/></form></div>";

        echo "</div></div>";

    ?>
</body>

</html>
