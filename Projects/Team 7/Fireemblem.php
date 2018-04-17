<html>
   <head>
      <title>Fire Emblem</title>
   </head>
 	
   <body background='fond_jaune.png'>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/commande.php','main')">Aller au panier</button><br><br>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/test.php','main')">Retour à l'accueil</button><br><br>
	<center><h1><font size="7" face="georgia" color="red">Welcome to Jeu Videal</font></h1></center>
	<img
	class="ff12"
    src="FE.jpg" 
    height="280px" 
    width="192px" 
	border="3px"
	hspace="150px"
/>
<br>
<p>Fire Emblem: Radiant Dawn, est un Tactical-RPG développé par Intelligent Systems et édité par Nintendo.
 C'est le dixième opus de la série et le premier à sortir sur la Wii.
 sorti le 22 Février 2007 à Japon, aux USA le 5 Novembre 2007, en Europe le 14 Mars 2008, et en Australie le 10 Avril 2008.
 <br>Radiant Dawn est la suite de Path of Radiance.
 Dorénavant les citoyens de Daein sont oppressés par l'armée d'occupation de Begnion et la Brigade de l'Aube, conduite par Micaiah, se démène pour les libérer.</p>
<h2><font size="4" face="georgia" color="black">Prix 25$</font></h2>


<button onClick="window.open('http://localhost/dashboard/Myfolder/ajout id3.php','main')">Ajouter au panier</button><br><br>
<button onClick="window.open('http://localhost/dashboard/Myfolder/remove id3.php','main')">Enlever du panier</button><br><br>
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