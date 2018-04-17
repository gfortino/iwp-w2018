<?php
session_start();
?>
<html>
	<head>
		<title> Successfull inscription </title>
		<link rel="stylesheet" href="pagestyle.css" />
	</head>
	<body class="SucessfullInscription">
		<form action = "Web_projectfini.php" id = "inscripsucess" name = "inscripsucess" enctype = "multipart/from-data" method ="post">
				<p>
					<label>You are now register on the website</label><br></br>
					<label>Click on "Homepage" to go to the login </label><br></br>
				</p>
			<input type ="submit" value ="Homepage"> 
			</form>
	</body>
</html>