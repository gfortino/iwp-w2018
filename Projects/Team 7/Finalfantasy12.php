<html>
   <head>
      <title>Final Fantasy 12</title>
   </head>
 	
   <body background='fond_jaune.png'>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/commande.php','main')">Aller au panier</button><br><br>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/test.php','main')">Retour à l'accueil</button><br><br>
	<center><h1><font size="7" face="georgia" color="red">Welcome to Jeu Videal</font></h1></center>
	<img
	class="ff12"
    src="ff12.jpg" 
    height="280px" 
    width="192px" 
	border="3px"
	hspace="150px"
/>
<br>
<p>Final Fantasy XII (ファイナルファンタジーXII, Fainaru Fantajī Tuerubu?) est un jeu vidéo de rôle développé et édité par Square Enix, sorti sur PlayStation 2 le 16 mars 2006 au Japon.
Il a été édité en Amérique du Nord le 31 octobre 2006 par Square Enix, et en Europe en février 2007 par Ubisoft.
Avant sa sortie européenne, le jeu s'était déjà vendu à plus de quatre millions d'exemplaires dans le reste du monde.
</p>
<p>Final Fantasy XII se déroule dans le monde imaginaire d'Ivalice, où deux puissants empires, Rozarria et Archadia, se disputent la domination des terres.
Le jeu débute deux ans après qu'Archadia a annexé le petit royaume de Dalmasca. Dans ce contexte général, le jeu se concentre sur Vaan, un jeune aventurier dalmascan qui rejoint le mouvement de résistance de la princesse Ashe contre l'empire archadien.
</p>
<h2><font size="4" face="georgia" color="black">Prix 30$</font></h2>

<button onClick="window.open('http://localhost/dashboard/Myfolder/ajout id1.php','main')">Ajouter au panier</button><br><br>
<button onClick="window.open('http://localhost/dashboard/Myfolder/remove id1.php','main')">Enlever du panier</button><br><br>


 <?php
		 $x='0';
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