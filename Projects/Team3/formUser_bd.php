<?php
    // INCLUDE
    include("connexion_bd.php");
    
    //session_start();      
        $bsCont = new beautyShopController();
			
		$name = $_POST['nomUser'];
		$lastName = $_POST['prenomUser'];
		$email = $_POST['emailUser'];
		$pseudo = $_POST['pseudoUser'];
		$mdp = md5($_POST['passwordUser']);	
		$birthdayUser = $_POST["birthdayUser"];
		$phone = $_POST["phonenumberUser"];
		$gender = $_POST["gender"];
			
		$streetName = $_POST['streetName'];
		$city = $_POST['city'];
		$region = $_POST['region'];
		$postal = $_POST['postal'];
			
		

		

		$check="SELECT street, city, region, postalCode FROM address WHERE street = '".$streetName."' AND city = '".$city."' AND region = '".$region."' AND postalCode = '".$postal."' ";
       $test = $bsCont->numRows($check);
		if($test >= 1) {
    		//echo "Address already exists<br/>".$test;
    		
    		$checkUser = "SELECT email FROM user WHERE firstName = '".$name."'";
			$testUser = $bsCont->numRows($checkUser);
    		
    		if($testUser >=1) {
				?>
    			<script language="JavaScript">
        				alert("Erreur email already exists 1.");
        				window.location.replace("formUser.php");
    			</script>
    			<?php
    		}else {
    			$sql = "INSERT INTO user (firstName, lastName,pseudo,mdp,email,birthday,gender,numTel,status,address) VALUES ('$name', '$lastName', '$pseudo', '$mdp', '$email','$birthdayUser','$gender','$phone','user',(SELECT idAd FROM address WHERE street='".$streetName."'))";
				
				if($bsCont->queryFunc($sql)){
					  header("Location: index.html");
					  exit();
				} else{
    				echo "ERROR: Could not able to execute $sql. " . mysqli_error($bsCont->conn);
    			}
			}    		
    		
		}else {
			$addAddress = "INSERT INTO address (street, city,region,postalCode) VALUES ('$streetName', '$city', '$region', '$postal')";
			if($bsCont->queryFunc($addAddress)){
				
 	  		$checkUser2 = "SELECT email FROM user WHERE firstName = '".$name."'";

			$testUser2 = $bsCont->numRows($checkUser2);
    		
    		if($testUser2>=1) {
    			?>
    			<script language="JavaScript">
        				alert("Erreur email already exists 2.");
        				window.location.replace("formUser.php");
    			</script>
    			<?php
    		}else {
    			$sql = "INSERT INTO user (firstName, lastName,pseudo,mdp,email,birthday,gender,numTel,status,address) VALUES ('$name', '$lastName', '$pseudo', '$mdp', '$email','$birthdayUser','$gender','$phone','user',(SELECT idAd FROM address WHERE street='".$streetName."'))";
				
				if($bsCont->queryFunc($sql)){
		    		header("Location : index.html");
		    		exit();
				} else{
    				echo "ERROR: Could not able to execute $sql. " . mysqli_error($bsCont->conn);
    			}
			}    	
		}
		
	}
			
		
			
?>