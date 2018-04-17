<?php
// Start the session
session_start();
// clear the cart
if (isset($_GET["vider"]))
{
  unset($_SESSION['list']);
}
//command validation
if (isset($_GET["Command"]))
{
	header("Location:Validationcommand.php");
}
?>
 
<!DOCTYPE html>
<html>
	<head>
		<title class="cart"> My Cart </title>
		<link rel="stylesheet" href="Stylesheet_WebPage.css">
	<head>
<body class="cart">
 
<h3>My cart</h3>
 
<a href="panier.php?vider=1">Clear the cart</a>
<a href="panier.php?Command=1">Pay </a>
<hr>
 
<?php
//print the cart
if (isset($_SESSION["list"]))
{
  foreach ($_SESSION["list"] as $value){
    print $value . "<br>";
  }
}
?>
 
<hr>
 
<a href="Web_project_connected.php">Continue shopping</a>
 
</body>
</html>