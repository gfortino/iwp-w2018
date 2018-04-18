<?php

	//include("connexion_bd.php");
	
	include("items.php");
    session_start();
    // on verifie l'existence des sessions
    if(isset($_SESSION['lastName']) and ($_SESSION['firstName']))
    {
  
    		$test = $_POST["item0"];
    		echo $test;

	/*<?php echo $items[0]['nameItem']?>*/
	}else {
	

 
	} 
  
                            
	?>

