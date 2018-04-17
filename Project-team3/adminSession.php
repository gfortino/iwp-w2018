<?php
    session_start();
    // on verifie l'existence des sessions
    if(isset($_SESSION['lastName']) and ($_SESSION['firstName']))
    {
    	
    	
    	
    	
?>
 <script>
    
    	function cancelItem() {
			if (document.getElementById("addItem").style.display==="none"){

				document.getElementById("addItem").style.display="block";
			}
			else {
				document.getElementById("addItem").style.display="none";
			}
		}

		/*function addItem() {
				document.getElementById("addItem").style.display=='block';
				<?php
  						/*echo "ça marche addItem";*/
				?>
			
		}*/
		
		/*function showProfil(){
			document.getElementById("profilId").style.display=="block";
					<?php
  						/*echo "ça marche showP";*/
				?>
			
		}*/
		
		
		function cancelProfil() {
			
			if (document.getElementById("profilId").style.display==="none"){

				document.getElementById("profilId").style.display="block";
			}
			else{
				document.getElementById("profilId").style.display="none";
			}
			
		}

</script>
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
							<li class="Parameters">
								<a href="#">Settings</a>
									<ul class="items">
										<li><a href="javascript:cancelItem();">Add items</a></li>
									</ul>
							</li>
							<li class="profil">
								<a href="#">Profil</a>
									<ul class="items">
										<li><a href ="javascript:cancelProfil();">My profil</a></li>
										<li><a href ="deconnexion.php">Log out</a></li>
									</ul>
							</li>
						</ul>
					</div>
			</nav>
	</head>
    <body>
		
        	<h1> Bienvenue 
					<?php 
						echo $_SESSION['firstName'];
						echo " ";
						echo $_SESSION['lastName']; 
					?> 
			</h1>


			<div id="profilId" style="display: none;" >
								<h2>Profil</h2>
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
							<input class="button" type="button" onclick='cancelProfil()' value="Cancel" />
						</div>	
					</form>				
				
									
				
				</div>
            </div>


			<div id="addItem" style="display : none;" >
				<h2>Add Item :</h2>			
					
				<form action = "addItem.php" id = "itemForm" name = "itemForm" enctype = "multipart/form-data" method="post" >
					<div class="block-page">
						<label>Name : </label> <input type="text" id = "nameItem" name="nameItem" placeholder="Ex : Red Lipstick" required />
						</br>
						<label>Code : </label> <input type="text" id = "codeItem" name="codeItem" placeholder="Ex : redL1" required />
						</br>	
						<label>Price : </label> <input type="text" id = "priceItem" name="priceItem" placeholder="Ex : 10.00" required />
						</br>						
						<label>Image name : </label> <input type="text" id = "imageItem" name="imageItem" placeholder="Ex : image.png" required />
						</br>
						
						<div class="radioGrp">
							<label>Type : </label> 
							<input type="radio" name="typeItem" value="makeUp"/>Make Up 
							<input type="radio" name="typeItem" value="accessories"/>Accessories 
							<input type="radio" name="typeItem" value="showerGel"/>ShowerGel
							<input type="radio" name="typeItem" value="Lotion"/> Lotion 
							<input type="radio" name="typeItem" value="Lotion"/> Shampoo 
						</div>
						</br>
					</div>
			
					<input type="submit" value="Submit" action="Action" class ="button"> <!-- rajouter action sur le button qui va renvoyer a une page disant an email has been send to you, now log in.-->
					<input class="button" type="button" onclick='cancelItem()' value="Cancel" />
					
				</form>
				
			</div>


    </body>

    <footer>
        <p>Copyright Nathalie RIVOHERINJAKANAVALONA - Anne-Laure Bocquet - © Tous droits réservés </p>
    </footer>

</html>
    
   
<?php
    } 
else {
    header("Location: index.html");
} 
?>