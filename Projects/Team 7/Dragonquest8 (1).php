<html>
   <head>
      <title>Dragon Quest 8</title>
   </head>
 	
   <body background='fond_jaune.png'>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/commande.php','main')">Aller au panier</button><br><br>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/test.php','main')">Retour à l'accueil</button><br><br>
	<center><h1><font size="7" face="georgia" color="red">Welcome to Jeu Videal</font></h1></center>
	<img
	class="ff12"
    src="dq8.jpg" 
    height="280px" 
    width="192px" 
	border="3px"
	hspace="150px"
/>
<br>
<p>Dragon Quest VIII : L'Odyssée du roi maudit est un jeu vidéo de rôle de Square Enix développé par Level-5 sur PlayStation 2, 
publié en 2004 au Japon, en 2005 en Amérique du Nord et en 2006 en Europe.</p>
<p>Le héros est le seul habitant d'un village à ne pas avoir été transformé par le sorcier Dhoulmagus, un bouffon maléfique qui s'est emparé du trésor du château, un sceptre magique. 
Le héros est sur les traces de Dhoulmagus avec son roi, Trode (transformé en monstre vert), et la princesse, Médéa (transformée en cheval), pour essayer d'inverser les transformations.</p>
<h2><font size="4" face="georgia" color="black">Prix 25$</font></h2>


<button onClick="window.open('http://localhost/dashboard/Myfolder/ajout id2.php','main')">Ajouter au panier</button><br><br>
<button onClick="window.open('http://localhost/dashboard/Myfolder/remove id2.php','main')">Enlever du panier</button><br><br>
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