<!DOCTYPE html>
<html>
<head>
	
 </head>

<body background='fond_jaune.png'>

<h2>Sign in</h2>

<script>      
      function request()//useless
      {
   <button onClick="window.open('http://localhost/dashboard/Myfolder/commande.php','main')">acceder au site</button><br><br>
      }
</script>
<?php 
	
?>
<br>
<form class="form-signin" action="connect.php" method="post">
<label for="pseudo">Name : </label><input type="text" name="name" id="name"><br>
<label for="pseudo">Password : </label><input type="text" name="password" id="password"><br>
<label for="pseudo">bluecard number : </label><input type="text" name="cardnum" id="cardnum"><br>
<label for="pseudo">secret code : </label><input type="text" name="secret" id="secret"><br>
<label for="pseudo">Administrator password : </label><input type="text" name="adminpass" id="adminpass"><br>
<input type="submit" name="submit" id="register" onClick="request();" value="register"><br><br>
</form>
<button onClick="window.open('http://localhost/dashboard/Myfolder/commande.php','main')">Retour au panier</button><br><br>

</body>



<?php

$dbhost = 'localhost';
         $dbuser = 'root';
         $dbpass = 'guest123';
         $conn = mysqli_connect($dbhost, $dbuser);
   
         if(! $conn ){
            die('Could not connect: ' . mysqli_error());
         }
         echo 'Connected successfully';
         
		 mysqli_select_db($conn, 'yoyoyo' );
		 $request='SELECT * FROM account';
		 $result=mysqli_query ($conn,$request);
		 
		 
		if(isset($_POST['submit'])){
			if($_POST['adminpass']=="1234"){
		$request ="INSERT INTO `account` (`Login`, `password`, `bluecard`, `cardpassword`, `level`, `adminpassword`) VALUES ('".$_POST['name']."', '".$_POST['password']."', '".$_POST['cardnum']."', '".$_POST['secret']."', '1', '1234')";
		$result=mysqli_query ($conn,$request);//create an account in our database which is admin level
			}
			else{
				$request ="INSERT INTO `account` (`Login`, `password`, `bluecard`, `cardpassword`, `level`, `adminpassword`) VALUES ('".$_POST['name']."', '".$_POST['password']."', '".$_POST['cardnum']."', '".$_POST['secret']."', '0', '1234')";
		$result=mysqli_query ($conn,$request);//create an account in our database which is user level
		}
		}
		 

	?>
	</body>
</html> 