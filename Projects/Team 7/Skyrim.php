<html>
   <head>
      <title>Skyrim</title>
   </head>
 	
   <body background='fond_jaune.png'>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/commande.php','main')">Aller au panier</button><br><br>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/test.php','main')">Retour à l'accueil</button><br><br>
	<center><h1><font size="7" face="georgia" color="red">Welcome to Jeu Videal</font></h1></center>
	<img
	class="ff12"
    src="ES.jpg" 
    height="280px" 
    width="192px" 
	border="3px"
	hspace="150px"
/>
<br>
<p>The Elder Scrolls V: Skyrim (souvent abrégé en Skyrim) est un jeu vidéo de rôle et d'action développé par Bethesda Game Studios et édité par Bethesda Softworks, sorti le 11 novembre 2011 sur PlayStation 3, Xbox 360 et Microsoft Windows.
 C'est le cinquième opus de la série de jeux The Elder Scrolls, après Arena, Daggerfall, Morrowind et Oblivion.
 <br>
 Le jeu met le joueur dans la peau d'un nouveau venu dans la contrée de Bordeciel, alors déchirée par une guerre civile qu'une invasion de dragons belliqueux ne fait qu'empirer.</p>
 <h2><font size="4" face="georgia" color="black">Prix 32$</font></h2>


<button onClick="window.open('http://localhost/dashboard/Myfolder/ajout id6.php','main')">Ajouter au panier</button><br><br>
<button onClick="window.open('http://localhost/dashboard/Myfolder/remove id6.php','main')">Enlever du panier</button><br><br>
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