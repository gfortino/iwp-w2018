<html>
	<head>
		<title>For New Users</title>
		<meta charset = "utf-8">
		<link rel = "stylesheet" href = "bckgrdform.css">
		<div class ="pres1">
				<div class = "pres2">
					<h1 class="top">Beauty Store</h1>
				</div>
			</div>
	</head>
	<body>
		<h1>Please complete the following form </h1>
		
		<h2> Identity </h2>

		<form action = "formUser_bd.php" id = "userForm" name = "userForm" enctype = "multipart/from-data" method="post" >
					<div class="block-page">
			<p>
				<label>Name : </label> <input type="text" id = "nomUser" name="nomUser" placeholder="Ex : Smith" required />
				</br>
				<label>Last Name : </label> <input type="text" id = "prenomUser" name="prenomUser" placeholder="Ex : John" required />
				</br>
				<label>Pseudo : </label> <input type="text" id = "pseudoUser" name="pseudoUser" required />
				</br>
				<label>Date of birth : </label> <input type="date" id = "birthdayUser" name="birthdayUser"/>
				</br>
				<label>E-mail : </label> <input type="email" id = "emailUser" name="emailUser" placeholder="Ex : blabla@email.com" required />
				</br>
				<label>Password : </label> <input type="password" id = "passwordUser" name="passwordUser" required />
				</br>
				
				<label>Phone number : </label> <input type="tel" id = "phonenumberUser" name="phonenumberUser" max="10" />
				</br>
				
				<label>Gender : </label> <input type="radio" name="gender" value="Female"/>Female <input type="radio" name="gender" value="Male"/>Male </br>
				</br>
			</p>
			</div>
					
			
			<h2>Address</h2>
			<div class="block-page">
			<p>
				<label>Street </label> : <input type="text" id = "streetName" name="streetName" placeholder="Ex : Boulevard Robert Bourassa" required />
				</br>
				<label>City </label> : <input type="text" id = "city" name="city" placeholder="Ex :  Canada" required />
				</br>
				<label> Region </label> : <input type="text" id = "region" name="region" placeholder="Ex :  QC" required />
				</br>
				<label>Postal Code </label> : <input type="text" id = "postal" name="postal" placeholder="Ex :  H3C 3Z7" required />
				</br>
			
			</p>
			</div>
			<input type="submit" value="Submit" action="Action" class ="button"> <!-- rajouter action sur le button qui va renvoyer a une page disant an email has been send to you, now log in.-->
						<input class="button" type="button" onclick='cancel()' value="Cancel" />
		</form>

	<script>
		function cancel() {
				window.location = "index.html";
			
		}
	
	</script>
	</body>
	
	<footer>
        <p>Copyright Nathalie RIVOHERINJAKANAVALONA - Anne-Laure Bocquet - © Tous droits réservés </p>
    </footer>

	</html>
	