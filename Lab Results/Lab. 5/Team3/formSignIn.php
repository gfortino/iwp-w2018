<html>
	<head>
		<title>Sign In Form</title>
		<meta charset = "utf-8">
		<link rel = "stylesheet" href = "bckgrdform.css">
	</head>
	
	<body>
		<h1>Please sign in </h1>
		
		<form action = "connexion.php" id = "signInForm" name = "signInForm" enctype = "multipart/from-data" method="post" >
			<p>
				<label>Pseudo</label> : <input type="text" id = "pseudoUser" name="pseudoUser" autocomplete="on" required />
				</br>
				<label>Password</label> : <input type="password" id = "passwordUser" name="passwordUser" required />
				</br>
			</p>
		<!--<input type="submit" value ="Log in"> <!-- rajouter l action sur le button pour renvoyer a logInconf-->

		<input id="login" onclick="Action" value = "Log In" type="submit" />
		</form>
		<!--<script>
		function logInFonc(){
			document.getElementById("login").document.location.href="logInConf.php";
		}
		</script>-->
	</body>
</html>