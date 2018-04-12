<html>
	<head>
		<title>Test</title>
	</head>
	<body> 
			<div>
			<?php
			try
			{
				$db = new PDO('mysql:host=localhost;dbname=Lab5', 'root', '');
			}
			catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
			?>
			</div>
			
			<div>
		<button type="button"  onclick ="document.getElementById('FormLogin').style.display='block'"> Login </button>
		<button type="button"  onclick ="document.getElementById('FormSignup').style.display='block'"> Sign Up </button>
			</div>
			
			<form action = "form.php" id="FormLogin"  name="Form123" enctype = "multipart/from-data" method = "post" style="display:none";>
				Username : <input type ="text" id="userName" name ="userName">
				Password: <input type "text" id="password" name ="password">
				<button type ="button" value=" Connection" onclick = checkifexist();>
				<button type="button"  onclick ="document.getElementById('FormLogin').style.display='none'"> don't have account </button>
			</form>
			
			<form type ="form.php" id="FormSignup" name = "FormSignup" enctype = "multipart/from-data" method ="post" style="display:none";>
				$U
				Username :<input type ="text" id="userName" name ="userName"><br></br>
				Password :<input type "text" id="password" name ="password"><br></br>
				Password repeat :<input type "text" id="passwordrepeat" name ="passwordrepeat"><br></br>						
				e-mail : <input type "text" id="mail" name ="mail"><br></br>
				e-mail repeat: <input type "text" id="mailrepeat" name ="mailrepeat"><br></br>
				<?php 
				function insert()
				{
				$db->query('INSERT INTO lab5 ("EMail","Password","Username") VALUES (\''.
				$_POST["mail"].'\',\''.
				$_POST["password"].'\',\''.
				$_POST["userName"].'\')');
				}
				?>
				<input type ="button" value=" Inscription" onclick ="insert();">
				<button type="button"  onclick ="document.getElementById('FormSignup').style.display='none'"> Leave Signup </button>
			</form>
			

	</body>
</html>