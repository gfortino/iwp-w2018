<?php 

//session_start ();

if ((count($_GET)!=0) && !(isset($_GET['controle']) && isset ($_GET['action']))){
		echo ('erreur 404');
		
}
else {

	if (count($_GET)==0)	{ //(! isset($_SESSION['profil'])) || 
		$controle = "user";   //cas d'une personne non authentifiée
		$action=	"display";		//ou d'un appel à index.php sans paramètre
	}
	else {
		if (isset($_GET['controle']) && isset ($_GET['action'])) {
			$controle = $_GET['controle'];   //cas d'un appel à index.php 
			$action = 	 $_GET['action'];	//avec les 2 paramètres controle et action
		}
	}
	//echo ('controle : ' . $controle . ' et <br/> action : ' . $action);	
	require ($controle . '.php');
	$action ();
} 

?>
