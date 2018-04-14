<?php
    // INCLUDE
    include("connexion.php");
    

    if (!empty($_POST["userNamelogin"]) && (!empty($_POST["passwordlogin"]))) 
    {
        $id = $_POST["userNamelogin"];
        $mdp = md5($_POST["passwordlogin"]);
        
        $conn = connexion(); 
		
        $SQLrequest="SELECT Username, Password FROM lab5 WHERE Username='".$id."' AND Password='".($mdp)."'";
        $check = mysqli_query($conn, $SQLrequest);
        $test = mysqli_num_rows($check);

		echo $test ;
			 
        if ($test != 0)
        {
            header("Location:sucesslogin.php");
        }else {
            echo "Erreur de connexion ! ".$mdp;
        }
        
    }else {
			echo "VIDE";    
    }

?>