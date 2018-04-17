<?php
session_start();
?>
<?php


    // INCLUDE
    include("connexion.php");
    

    if (!empty($_POST["MailLogin"]) && (!empty($_POST["PasswordLogin"]))) 
    {
        $id = $_POST["MailLogin"];
        $mdp = md5($_POST["PasswordLogin"]);
      
        $conn = connexion(); 
		
        $SQLrequest="SELECT Mail, Password FROM inscription WHERE Mail='".$id."' AND Password='".($mdp)."'";
        $check = mysqli_query($conn, $SQLrequest);
        $test = mysqli_num_rows($check);

		echo $test ;
			 
        if ($test != 0)
        {	
			$_SESSION["mailuser"] = $_POST["MailLogin"];
            header("Location:Web_project_connected.php");
        }else {
            echo "Erreur de connexion ! ".$mdp;
        }
        
    }else {
			echo "VIDE";    
    }
	  $_SESSION["logmail"]=$_POST["MailLogin"];
			

?>