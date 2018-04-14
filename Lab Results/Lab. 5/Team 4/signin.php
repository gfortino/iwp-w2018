<?php
    // INCLUDE
    include("connexion.php");
    
    //session_start();      
        $conn = connexion(); 
			
		$username = $_POST['userName'];
		$email = $_POST['mail'];
		$password = md5($_POST['password']);	
		
			

		$check="SELECT Username FROM lab5 WHERE Username = '".$username."' ";
		$result = mysqli_query($conn, $check);
        $test = mysqli_num_rows($result);
		if($test >= 1) 
		{
    		echo "Username already exists, please go back to the first page <br/>" ;
	
    	}
		else {
			$sql = "INSERT INTO lab5 (Username, Password,EMail) VALUES ('$username', '$password', '$email')";
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
