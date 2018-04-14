<html>
	<head>
		<title>Test</title>
	</head>
	<body> 
			<div>

			</div>
			
			<div>
		<button type="button"  onclick ="document.getElementById('FormLogin').style.display='block'"> Login </button>
		<button type="button"  onclick ="document.getElementById('FormSignup').style.display='block'"> Sign Up </button>
			</div>
			
			<form action = "logintry.php" id="FormLogin"  name="Form123" enctype = "multipart/from-data" method = "post" style="display:none";>
				Username : <input type ="text" id="userNamelogin" name ="userNamelogin">
				Password: <input type ="text" id="passwordlogin" name ="passwordlogin">
				<input type ="submit" value="Connection" onclick = "Action">
				<button type="button"  onclick ="document.getElementById('FormLogin').style.display='none'"> don't have account </button>
			</form>
			
			<form action = "signin.php" type ="form.php" id="FormSignup" name = "FormSignup" enctype = "multipart/from-data" method ="post" style="display:none";>
				
				Username :<input type ="text" id="userName" name ="userName"><br></br>
				Password :<input type ="text" id="password" name ="password"><br></br>
				Password repeat :<input type ="text" id="passwordrepeat" name ="passwordrepeat"><br></br>						
				e-mail : <input type ="text" id="mail" name ="mail"><br></br>
				e-mail repeat: <input type ="text" id="mailrepeat" name ="mailrepeat"><br></br>
				
				<input type ="submit" value="Inscription" onclick="Action">
				<button type="button"  onclick ="document.getElementById('FormSignup').style.display='none'"> Leave Signup </button>
			</form>
			

	</body>
</html>