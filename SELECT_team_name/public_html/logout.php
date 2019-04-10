<!DOCTYPE html>

<head>
    <title>Redirecting...</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body>
    <?php
        //change the session loggedin variable to false and send user back to login page
        session_start();
        $_SESSION["loggedin"] = FALSE;
        header("Location: login.php");
        die();
    ?>
</body>

</html>