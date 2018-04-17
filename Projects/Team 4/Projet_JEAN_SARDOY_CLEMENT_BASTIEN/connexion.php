<?php
session_start();
?>
<?php
function connexion() {
$servername = "localhost";
$username = "root";
$password = "";
$dbname="foodorder";

// Create connection
global $conn;
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully to the db <br></br>";
return $conn;
}

?>