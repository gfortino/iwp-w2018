<!DOCTYPE html>
<html>
<head>
	
 </head>

<body background='fond_jaune.png'>

<h2>Sign in</h2>

<script>      
      function ShowPassword()
      {
      	//alert(document.getElementById('password').value);
        document.getElementById('password').type= 'text';
        document.getElementById('passbutton').value = "Password Displayed";
      }
</script>
<button onClick="window.open('http://localhost/dashboard/Myfolder/commande.php','main')">Retour au panier</button><br><br>

<br>
<label for="pseudo">Login : </label><input type="text" id="name"><br>
<label for="pseudo">Password : </label><input type="password" id="password"><br>
<label for="pseudo">Card Number : </label><input type="text" id="name"><br>
<label for="pseudo">Card password : </label><input type="text" id="name"><br><br>
<input type="button" id="passbutton" onClick="ShowPassword();" value="ShowPassword">

</body>



<?php

$dbhost = 'localhost';
         $dbuser = 'root';
         $dbpass = 'guest123';
         $conn = mysqli_connect($dbhost, $dbuser);
   
         /*if(! $conn ){
            die('Could not connect: ' . mysqli_error());
         }
         echo 'Connected successfully';*/
         
		 mysqli_select_db($conn, 'yoyoyo' );
		 $request='SELECT * FROM produits';
		 $result=mysqli_query ($conn,$request);
		 
		 $existe_deja=false;
		 
/*$requete="SELECT $login from $account";
$res=mysql_query($requete);
 while($row = mysqli_fetch_assoc($result)) {
       if($row==$x){
			$requete="SELECT $password from $account where login =$x";
			$res=mysql_query($requete);
			if($row==$y){
             <a href="http://localhost/dashboard/Myfolder/test.php"</a>
       }
}
if($existe_deja){
      echo "la variable existe dans la base";
}*/
	?>
	</body>
</html> 