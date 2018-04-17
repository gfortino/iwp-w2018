<?php
session_start();
?>
<?php
    // INCLUDE
    include("connexion.php");
    
    //session_start();      
        $conn = connexion(); 
		
		
		$lastname = $_POST['LastName'];
		$firstname = $_POST['FirstName'];
		$birth = ($_POST['Birth']);
		$mail = $_POST['Mail'];		
		$password = md5($_POST['Password']);
		$country = $_POST['Country'];
		$city = $_POST['City'];
		$address = $_POST['Address'];	
		$cardnumber = md5($_POST['CardNumber']);
		$nameownercard = $_POST['NameOwnerCard'];
		$enddate = md5($_POST['EndDate']);
		$securitycode = md5($_POST['SecurityCode']);		

		$checkCard="SELECT CardNumber FROM inscription WHERE CardNumber = '".$cardnumber."' ";
		$checkMail="SELECT Mail FROM inscription WHERE Mail = '".$mail."' ";
		$resultMail= mysqli_query($conn,$checkMail);
		$testMail=mysqli_num_rows($resultMail);
		$resultCard = mysqli_query($conn, $checkCard);
        $testCard = mysqli_num_rows($resultCard);
		if($testMail >= 1) 
		{
    		echo "This mail is already used, please find your last used account <br/>" ;
	
    	}
		
		elseif($testCard >=1)
		{
			echo" This card is already used by an account, please find the account connected to your card <br></br>";
		
		}
		else {
			$sql = "INSERT INTO inscription (LastName,FirstName,Birth,Mail,Password,Country,City,Address,CardNumber,NameOwnerCard,EndDate,SecurityCode)
			VALUES ('$lastname', '$firstname', '$birth','$mail','$password', '$country', '$city','$address','$cardnumber', '$nameownercard', '$enddate','$securitycode')";
			if(mysqli_query($conn, $sql))
			{
				echo "Records added successfully ";
				header("Location:sucessinscription.php");
			}
			else{
    			echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    			} 
		}		
?>
