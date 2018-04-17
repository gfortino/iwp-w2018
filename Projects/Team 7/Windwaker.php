<html>
   <head>
      <title>Zelda The Wind Waker</title>
   </head>
 	
   <body background='fond_jaune.png'>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/commande.php','main')">Aller au panier</button><br><br>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/test.php','main')">Retour à l'accueil</button><br><br>
	<center><h1><font size="7" face="georgia" color="red">Welcome to Jeu Videal</font></h1></center>
	<img
	class="ff12"
    src="ww.jpg" 
    height="280px" 
    width="192px" 
	border="3px"
	hspace="150px"
/>
<br>
<p>The Legend of Zelda: The Wind Waker (ゼルダの伝説 風のタクト, Zeruda no densetsu: Kaze no takuto?, litt. « La légende de Zelda : La baguette des vents ») est un jeu vidéo d'action-aventure édité et développé par Nintendo et le neuvième épisode de la série The Legend of Zelda. Il est sorti le 13 décembre 2002 au Japon, le 24 mars 2003 aux États-Unis, le 2 mai 2003 en Europe, et le 7 mai 2003 en Australie sur GameCube
 The Legend of Zelda: Phantom Hourglass sorti sur la Nintendo DS est sa suite directe.
 <br>Le joueur contrôle Link, le protagoniste de la série The Legend of Zelda. Lorsque la soeur de Link est enlevée par un oiseau géant, celui ci part à l'aventure pour la délivrer.</p>
<h2><font size="4" face="georgia" color="black">Prix 25$</font></h2>


<button onClick="window.open('http://localhost/dashboard/Myfolder/ajout id5.php','main')">Ajouter au panier</button><br><br>
<button onClick="window.open('http://localhost/dashboard/Myfolder/remove id5.php','main')">Enlever du panier</button><br><br>
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