
<html>
   <head>
      <title>Jeu Videal</title>
   </head>
 	
   <body background='fond_jaune.png'>
   
   <div align="left"><button onClick="window.open('http://localhost/dashboard/Myfolder/connect.php','main')">Register</button></div>
   <div align="left"><button onClick="window.open('http://localhost/dashboard/Myfolder/connect.php','main')">Login</button><br><br></div>
   <button onClick="window.open('http://localhost/dashboard/Myfolder/commande.php','main')">Aller au panier</button><br><br>
	<center><h1><font size="7" face="georgia" color="red">Welcome to Jeu Videal</font></h1></center>
	<h2><font size="3" face="georgia" color="red">click on any item to see more details ;)</font></h2>
	<A href="http://localhost/dashboard/Myfolder/Finalfantasy12.php"><img
	class="ff12"
    src="ff12.jpg" 
   
    height="280px" 
    width="192px" 
	border="3px"
	hspace="150px"
/></A>
<A href="http://localhost/dashboard/Myfolder/Dragonquest8.php"><img
	class="refei"
    src="dq8.jpg" 
    height="269px" 
    width="192px" 
	border="3px"
	hspace="150px"
/></A>
<A href="http://localhost/dashboard/Myfolder/Windwaker.php"><img
	class="ff12"
    src="ww.jpg" 
    height="271px" 
    width="192px" 
	border="3px"
	hspace="150px"
/></A>
<br/>
<A href="http://localhost/dashboard/Myfolder/Skyrim.php"><img
	class="ff12"
    src="ES.jpg" 
    height="270px" 
    width="192px" 
	border="3px"
	hspace="150px"
/></A>
<A href="http://localhost/dashboard/Myfolder/Thewitcher3.php"><img
	class="ff12"
    src="TW.jpg" 
    height="270px" 
    width="192px" 
	border="3px"
	hspace="150px"
/></A>
<A href="http://localhost/dashboard/Myfolder/Fireemblem.php"><img
	class="ff12"
    src="FE.jpg" 
    height="267px" 
    width="192px" 
	border="3px"
	hspace="150px"
/></A>
	

      <?php
	
         $dbhost = 'localhost';
         $dbuser = 'root';
         $dbpass = 'guest123';
         $conn = mysqli_connect($dbhost, $dbuser);
   
         if(! $conn ){
            die('Could not connect: ' . mysqli_error());
         }
         echo 'Connected successfully';
         
		 mysqli_select_db($conn, 'yoyoyo' );
		 $request='SELECT * FROM produits';
		 $result=mysqli_query ($conn,$request);
		 
		
         /*if (mysqli_num_rows($result) > 0) {
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

