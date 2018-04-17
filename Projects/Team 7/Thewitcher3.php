<html>
   <head>
      <title>The Witcher 3</title>
   </head>
 	
   <body background='fond_jaune.png'>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/commande.php','main')">Aller au panier</button><br><br>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/test.php','main')">Retour à l'accueil</button><br><br>
	<center><h1><font size="7" face="georgia" color="red">Welcome to Jeu Videal</font></h1></center>
	<img
	class="ff12"
    src="TW.jpg" 
    height="280px" 
    width="192px" 
	border="3px"
	hspace="150px"
/>
<br>
<p>
The Witcher 3: Wild Hunt (en polonais : Wiedźmin 3: Dziki Gon) est un jeu vidéo en monde ouvert de type action-RPG développé par le studio polonais CD Projekt RED.
Il est sorti le 19 mai 2015 sur PC sous système Windows, PlayStation 4 et Xbox One, et fait suite narrativement à The Witcher, sorti en 2007, et The Witcher 2: Assassins of Kings, sorti en 2011.
 Il est ainsi le troisième jeu vidéo à prendre place dans l'univers littéraire de The Witcher, créé par l'écrivain polonais Andrzej Sapkowski, mais aussi le dernier à présenter les aventures de Geralt de Riv.
<br>
Le jeu suit les traces du sorceleur Geralt de Riv, un chasseur de monstres dont la fille adoptive Ciri est en danger et qui se lance à sa recherche dans un monde médiéval fantastique.
 Le joueur contrôle Link, le protagoniste de la série The Legend of Zelda. Lorsque la soeur de Link est enlevée par un oiseau géant, celui ci part à l'aventure pour la délivrer.</p>
<h2><font size="4" face="georgia" color="black">Prix 40$</font></h2>


<button onClick="window.open('http://localhost/dashboard/Myfolder/ajout id4.php','main')">Ajouter au panier</button><br><br>
<button onClick="window.open('http://localhost/dashboard/Myfolder/remove id4.php','main')">Enlever du panier</button><br><br>
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
		 
         mysqli_close($conn);
      ?>
   </body>
   
</html>