<html>
	<head>
		<title>Sign In Form</title>
		<meta charset = "utf-8">
		<link rel = "stylesheet" href = "bckgrdform.css">
		<div class ="pres1">
				<div class = "pres2">
					<h1 class="top">Beauty Store</h1>
				</div>
			</div>
	</head>
	
	<body>
		<h1>Please sign in </h1>
		<div class="block-page">
		<form action = "connexion.php" id = "signInForm" name = "signInForm" enctype = "multipart/from-data" method="post" >
			<p>
				<label>Pseudo</label> : <input type="text" id = "pseudoUser" name="pseudoUser" autocomplete="on" required />
				</br>
				<label>Password</label> : <input type="password" id = "passwordUser" name="passwordUser" required />
				</br>
			</p>
		<!--<input type="submit" value ="Log in"> <!-- rajouter l action sur le button pour renvoyer a logInconf-->

		<input id="login" class ="button" onclick="Action" value = "Log In" type="submit" />
		</form>
		</div>
	</body>
	
	<footer>
		<div class="bottom">
				       <p>Copyright Nathalie RIVOHERINJAKANAVALONA - Anne-Laure Bocquet - © Tous droits réservés </p>
		</div>

    </footer>
</html>