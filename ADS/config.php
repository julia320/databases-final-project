<?php
/* Database credentials. */
$server = "localhost";
$username = "larissab1";
$password = "Divertissement1$";
$servername = "larissab1";

//alter user 'larissab1'@'localhost' identified with mysql_native_password by '';
 //echo "Connexion fails................";
// Create connection
$mysqli = new mysqli($server,$username,$password,$servername);
if($mysqli->connect_error) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//echo "Connected successfully";
?>

