<html>
<head>
      <title>Ajout id 1</title>
   </head>
   <body background='fond_jaune.png'>
<button onClick="window.open('http://localhost/dashboard/Myfolder/test.php','main')">retour au menu</button><br><br>
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
		 
		$result=mysqli_query ($conn,"UPDATE produits SET quantite = quantite +1 WHERE id=1");
		$request='SELECT * FROM produits';
		$result=mysqli_query ($conn,$request);
		echo "Votre item a été ajouté";
   
        
         mysqli_close($conn);
      ?>
	  
	  </body>
   
</html>