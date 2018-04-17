<?php 

session_start ();

if ((count($_GET)!=0) && !(isset($_GET['controle']) && isset ($_GET['action']))){
		echo ('erreur 404');
		
}
else {

	if (count($_GET)==0)	{ 
		$controle = "user";  
		$action=	"display";		
	}
	else {
		if (isset($_GET['controle']) && isset ($_GET['action'])) {
			$controle = $_GET['controle'];
			$action = 	 $_GET['action'];
		}
	}
	require ($controle . '.php');
	$action ();
} 

?>
