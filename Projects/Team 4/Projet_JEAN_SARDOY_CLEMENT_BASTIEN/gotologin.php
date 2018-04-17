<?php
session_start();
?>
<html>
	<head>
		<title>tete</title>
		<link rel="stylesheet" href="popup.css" />
	</head>
	
	<body>
		
	<!-- Button to open the modal login form -->
	

	<!-- The Modal -->
	<div id="login" class="modallogin">
	  <span onclick="document.getElementById('login').style.display='none'" class="closelogin" title="Close Modal">&times;</span>

	  <!-- Modal Content -->
		<form class="modallogin-content" action="logintry.php" enctype = "multipart/from-data" method = "post">
	 

			<div class="containerlogin">
				<label for="uname"><b>Username</b></label>
				<input type="text" id="MailLogin" name ="MailLogin" >

				<label for="psw"><b>Password</b></label>
				<input type="password"  id="PasswordLogin" name ="PasswordLogin">

				<button type="submit">Login</button>
			</div>

			<div class="containerlogin" style="background-color:#f1f1f1">
				<button type="button" onclick="document.getElementById('login').style.display='none'" class="cancelbtn">Cancel</button>
			</div>
		 </form>
	</div>
	

	<!-- Button to open the modal -->
	

	<!-- The Modal (contains the Sign Up form) -->
	<div id="signup" class="modalsignup">
		<form class="modalsignup-content" action="signin.php" enctype = "multipart/from-data" method = "post">
			<div class="containersignup">
				<h1>Sign Up</h1>
				<p>Please fill in this form to create an account.</p>
			<hr>
				<label for="LastName"><b>LastName</b></label>
				<input type ="text" id="LastName" name ="LastName"><br></br>

				<label for="Firstname"><b>FirstName</b></label>
				<input type ="text" id="FirstName" name ="FirstName"><br></br>

				<label for="Birth"><b>Birth date</b></label>
				<input type ="date" id="Birth" name ="Birth"><br></br>
				
				<label for="Mail"><b>Mail</b></label>
				<input type ="text" id="Mail" name ="Mail"><br></br>

				<label for="Password"><b>Password</b></label>
				<input type ="password" id="Password" name ="Password"><br></br>

				<label for="Country"><b>Country</b></label>
				<input type ="text" id="Country" name ="Country"><br></br>
				
				<label for="City"><b>City</b></label>
				<input type ="text" id="City" name ="City"><br></br>

				<label for="Address"><b>Address</b></label>
				<input type="text" id="Address" name="Address"><br></br>

				<label for="CardNumbert"><b>Card Number</b></label>
				<input type="text" id="CardNumber" name="CardNumber"><br></br>

				<label for="NameOwnerCard"><b>Name Owner Card</b></label>
				<input type="text" id="NameOwnerCard" name = "NameOwnerCard"><br></br>

				<label for="EndDate"><b>Date of the end of the card</b></label>
				<input type="date" id="EndDate" name="EndDate"><br></br>

				<label for="SecurityCode"><b>Security Code</b></label>
				<input type="password" id="SecurityCode" name="SecurityCode"><br></br>			  					  
									 
				 					 

			<div class="clearfix">
			<button type="button" onclick="document.getElementById('signup').style.display='none'" class="cancelbtn">Cancel</button>
			<button type="submit" class="signup">Sign Up</button>

		  </div>
		</div>
	  </form>
	</div>
	</body>
</html>