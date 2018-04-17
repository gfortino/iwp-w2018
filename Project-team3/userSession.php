<?php
    session_start();
    // on verifie l'existence des sessions
    if(isset($_SESSION['lastName']) and ($_SESSION['firstName']))
    {
?>
<html>
<div class="bckGround">
    <head>
		<title>Sign in page confirm</title>
		<meta charset = "utf-8">
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
	</div>
    <body>
    
    			<h1> Welcome 
					<?php 
						echo $_SESSION['firstName'];
						echo " ";
						echo $_SESSION['lastName']; 
					?> 
				</h1>
				

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