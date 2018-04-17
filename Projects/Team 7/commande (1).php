<html>
<button onClick="window.open('http://localhost/dashboard/Myfolder/test.php','main')">Retour à l'accueil</button><br><br>

<?php
ini_set('display_errors', 0); // just to remove notices



									//connection à la table
$dbhost = 'localhost';
         $dbuser = 'root';
         $dbpass = 'guest123';
         $conn = mysqli_connect($dbhost, $dbuser);
		 $x='0';//we initialize the variables for quantite
		 $y='0';
		 $z='0';
		 $w='0';
		 $v='0';
		 $u='0';
		 
		 $x1='0';//we initialize the variables for price
		 $y1='0';
		 $z1='0';
		 $w1='0';
		 $v1='0';
		 $u1='0';
		 
		 $total='0';
         /*if(! $conn ){
            die('Could not connect: ' . mysqli_error());
         }
         echo 'Connected successfully';*/
         
		 mysqli_select_db($conn, 'yoyoyo' );
		 $request='SELECT * FROM produits';
		 $result=mysqli_query ($conn,$request);
		 
	$request='SELECT quantite FROM produits WHERE id=1'; 
	$result=mysqli_query ($conn,$request);
	while ($row = $result->fetch_assoc()) { //we take the quantite from the game 1
    $x=$row['quantite']."<br>";
	$x1=30*$x;
}
$request='SELECT quantite FROM produits WHERE id=2'; 
	$result=mysqli_query ($conn,$request);
	while ($row = $result->fetch_assoc()) { //we take the quantite from the game 2
    $y=$row['quantite']."<br>";
	$y1=25*$y;
	}
	
	$request='SELECT quantite FROM produits WHERE id=3'; 
	$result=mysqli_query ($conn,$request);
	while ($row = $result->fetch_assoc()) { //we take the quantite from the game 3
    $z=$row['quantite']."<br>";
	$z1=25*$z;
	}
	
	$request='SELECT quantite FROM produits WHERE id=4'; 
	$result=mysqli_query ($conn,$request);
	while ($row = $result->fetch_assoc()) { //we take the quantite from the game 4
    $w=$row['quantite']."<br>";
	$w1=40*$w;
	}
	
	$request='SELECT quantite FROM produits WHERE id=5'; 
	$result=mysqli_query ($conn,$request);
	while ($row = $result->fetch_assoc()) { //we take the quantite from the game 5
    $v=$row['quantite']."<br>";
	$v1=25*$v;
	}
	
	$request='SELECT quantite FROM produits WHERE id=6'; 
	$result=mysqli_query ($conn,$request);
	while ($row = $result->fetch_assoc()) { //we take the quantite from the game 6
    $u=$row['quantite']."<br>";
	$u1=32*$u;
	}
	$total=$x1+$y1+$z1+$w1+$v1+$u1;

			
									//Sorties
echo "<div align=\"center\"><img border=\"0\" ></div><br>
<center><b><font size =5 color=\"#FF0000\">Recapitulatif de votre commande</font><b></center><br>
<table border=\"1\" bgcolor=\"\" width=\"\">
   <tr>
   	<td bgcolor=\"#008080\"><div align=\"center\"><b>Nom</b></div></td>
   	<td bgcolor=\"#008080\"><div align=\"center\"><b>Prix unitaire<br></b></div></td>
	<td bgcolor=\"#008080\"><div align=\"center\"><b>Quantite</b></div></td>
	<td width=\"10%\"bgcolor=\"#008080\"><div align=\"center\"><b>Prix H.T.</b></div></td>
   </tr>							
   <tr>
	<td width=\"\">Final fantasy 12</td>
   	<td width=\"\"><div align=\"center\">30$</div></td>
	
	<td width=\"\"align=\"center\">$x</td>
	<td width\"\" align=\"center\">$x1 $</td>
   </tr>   	
   <tr>
	<td width=\"\">Fire Emblem</td>		
	<td width=\"\"><div align=\"center\">25$</div></td>
	<td width=\"\" align=\"center\">$z</td>			
	<td width=\"\" align=\"center\">$z1 $</td>
   </tr>
   <tr>
	<td width=\"\">Dragon Quest 8</td>
	<td width=\"\"><div align=\"center\">25$</div></td>		
	<td width=\"\" align=\"center\">$y</td>
	<td width\"\" align=\"center\">$y1 $</td>
   </tr>
    <tr>
	<td width=\"\">The Witcher 3</td>
	<td width=\"\"><div align=\"center\">40$</div></td>		
	<td width=\"\" align=\"center\">$w</td>
	<td width\"\" align=\"center\">$w1 $</td>
   </tr>
    <tr>
	<td width=\"\">Skyrim</td>
	<td width=\"\"><div align=\"center\">32$</div></td>		
	<td width=\"\" align=\"center\">$u</td>
	<td width\"\" align=\"center\">$u1 $</td>
   </tr>
    <tr>
	<td width=\"\">Zelda The Wind Waker</td>
	<td width=\"\"><div align=\"center\">25$</div></td>		
	<td width=\"\" align=\"center\">$v</td>
	<td width\"\" align=\"center\">$v1 $</td>
   </tr>
  									

   
   <tr>
	<td align=center colspan=4 bgcolor =\"C0C0C0\">TOTAL DE LA COMMANDE : <b>$total $</b></td>						
   </tr>
</table>";
?>
</html>