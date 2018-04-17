namename<html>
	<head>
		<title>Credit Card</title>
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
							<li class="shop">
								<a href="shop.php">Shop</a>
									<ul class="items">
										<li><a href="#">Shampoo</a></li>
										<li><a href="#">Shower gel</a></li>
										<li><a href ="#">Lotion</a></li>
										<li><a href ="#">Make up</a></li>
										<li><a href ="#">Accessories</a></li>
									</ul>
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
		<h1> Please complete the informations about your credit card. </h1>
		
		<form action = " cb_bd.php" id = "cbForm" name = "cbForm" enctype = "multipart/from-data" method="post" >
			<div class="block-page">
				<p>
					<label>Cardholder Name : </label> <input type="text" id = "cardHolderName" name="cardHolderName" placeholder="Ex : John Smith" required />
					</br>
					<label>Expiration Date : </label> <input type="date" id = "expirationDate" name="expirationDate" required />
					</br>
					
					<label>Credit Card Number : </label> <input type="number" id = "cbNumber" name="cbNumber" required />
					</br>
					<label>Cryptogram :</label> <input type = "number" id="crypto" name="crypto" maxlength ="3" required />
					</br>
					<label>Type : </label> <input type="radio" name="typeCB" value="Visa"/>Visa <input type="radio" name="typeCB" value="MasterCard"/>MasterCard <input type ="radio" name ="typeCB" value ="Amarican Express"/>American Express
					</br>
				
				</p>
			</div>
								<input type="submit" value="Submit" action="Action" class ="button"> <!-- rajouter action sur le button qui va renvoyer a une page disant an email has been send to you, now log in.-->
		</form>
	</body>
	
	<footer>
        <p>Copyright Nathalie RIVOHERINJAKANAVALONA - Anne-Laure Bocquet - © Tous droits réservés </p>
    </footer>
</html>