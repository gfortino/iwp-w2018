<html>
<head>
      <title>Ajout id 3</title>
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
		 
		$result=mysqli_query ($conn,"UPDATE produits SET quantite = quantite +1 WHERE id=3");
		$request='SELECT * FROM produits';
		$result=mysqli_query ($conn,$request);
		echo "Votre item a été ajouté";
   
        /* if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               echo "Id: " . $row["quantite"]. "<br>";
            }
         } else {
            echo "0 results";
         }*/
         mysqli_close($conn);
      ?>
	  
	  </body>
   
</html>