<?php
    // INCLUDE
    include("connexion_bd.php");
    
    //session_start();      
        $co = connexion(); 
			
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
		$result = mysqli_query($co, $check);
       $test = mysqli_num_rows($result);
		if($test >= 1) {
    		//echo "Address already exists<br/>".$test;
    		$sql = "INSERT INTO user (firstName, lastName,pseudo,mdp,email,birthday,gender,numTel,status,address) VALUES ('$name', '$lastName', '$pseudo', '$mdp', '$email','$birthdayUser','$gender','$phone','admin',(SELECT idAd FROM address WHERE street='".$streetName."'))";
				
			if(mysqli_query($co, $sql)){
		    		echo "Records added successfully (address already exists.";
				} else{
    				echo "ERROR: Could not able to execute $sql. " . mysqli_error($co);
    			}
		}else {
			$addAddress = "INSERT INTO address (street, city,region,postalCode) VALUES ('$streetName', '$city', '$region', '$postal')";
			if(mysqli_query($co, $addAddress) || $test>=1){
				
 	  		$sql = "INSERT INTO user (firstName, lastName,pseudo,mdp,email,birthday,gender,numTel,status,address) VALUES ('$name', '$lastName', '$pseudo', '$mdp', '$email','$birthdayUser','$gender','$phone','admin',(SELECT idAd FROM address WHERE street='".$streetName."'))";
				
			if(mysqli_query($co, $sql)){
		    		echo "Records added successfully (with new address).";
				} else{
    				echo "ERROR: Could not able to execute $sql. " . mysqli_error($co);
    			}
			}else{
    			echo "ERROR: Could not able to execute $sql. " . mysqli_error($co);
			}
		}
		
		
			
?>