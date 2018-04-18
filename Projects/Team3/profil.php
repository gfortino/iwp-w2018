<?php
    session_start();
    // on verifie l'existence des sessions
    if(isset($_SESSION['lastName']) and ($_SESSION['firstName']))
    {
?>
<html>

<head>
		<title>Sign in page confirm</title>
		<meta charset = "utf-8">
		<meta name="viewreport" content="width=device-width, initial-scale=1.0">
		<link rel = "stylesheet" href = "bckgrdform.css">
			
			<div class ="pres1">
				<div class = "pres2">
					<h1 class="top">Beauty Store</h1>
				</div>
			</div>
			<nav>
					<div class="table"> 
						<ul>
							<li class="profil">
								<a href="userSession.php">Home</a>
							</li>
							<li class="shop">
								<a href="shop.php">Shop</a>
									<ul class="items">
										<li><a href="#">Shampoo</a></li>
										<li><a href="#">Shower gel</a></li>
										<li><a href ="#">Lotion</a></li>
										<li><a href ="#">Make up</a></li>
										<li><a href ="#">Accessories</a></li>
									</ul>
							</li>
							<li class="profil">
								<a href="profil.php">Profil</a>
									<ul class="items">
										<li><a href ="profil.php">My profil</a></li>
										<li><a href ="deconnexion.php">Loge out</a></li>
									</ul>
							</li>
						</ul>
					</div>
			</nav>
</head>

<body>
    	<div class="myBody">
    			<h1>  
					<?php 
						echo $_SESSION['firstName'];
						echo " ";
						echo $_SESSION['lastName']; 
					?> 
				</h1>
				
				<h2>Profile</h2>
				<div class="block-page">
				
					<label>Name : </label> <label><?php echo $_SESSION['firstName'];  ?></label>
					</br>
            		<label>Last Name : </label> <label><?php echo $_SESSION['lastName'];  ?></label>
					</br>
					<label>Pseudo : </label> <label><?php echo $_SESSION['pseudo'];  ?></label>
					</br>
					<label>E-mail : </label> <label><?php echo $_SESSION['email'];  ?></label>
					</br>
					<label>Phone number :  </label> <label><?php echo $_SESSION['numTel']; ?></label>
					</br>
					<label>Birthday : </label> <label><?php echo $_SESSION["birthday"];  ?></label>
					</br>
					
				</div>
				
				<h2>Address </h2>
				<div class="block-page">

					<label>Street : </label> <label ><?php echo $_SESSION['street'];  ?></label>
					</br>
            		<label>City : </label> <label><?php echo $_SESSION['city'];  ?></label>
					</br>
					<label>Region : </label> <label><?php echo $_SESSION['region'];  ?></label>
					</br>
					<label>Postal Code : </label> <label><?php echo $_SESSION['postalCode'];  ?></label>
					</br>

				</div>
				<div class ="groupe">
					<form method="post" action="#">
						<div>
							<input  type="submit" class ="button" id="Edit" value="Edit" />
						</div>	
					</form>				
				
									
				
				</div>
		</div>
    </body>

    <footer>
        <p>Copyright Nathalie RIVOHERINJAKANAVALONA - Anne-Laure Bocquet - © Tous droits réservés </p>
    </footer>

</html>
<?php
    } 
else {
	
	?>
    			<script language="JavaScript">
        				alert("Erreur");
        				window.location.replace("index.html");
    			</script>
    <?php
} 
?>