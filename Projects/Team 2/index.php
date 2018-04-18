<?php

session_start ();
if ((count($_GET)!=0) && !(isset($_GET['controle']) && isset ($_GET['action']))){
		echo ('controle : ' . $controle . ' et <br/> action : ' . $action);
		require ('./V/erreur404.tpl');

}
else {

	if (count($_GET)==0)	{ //(! isset($_SESSION['profil'])) ||
		$controle = "userController";   
		$action=	"accueil";		
	}
	else {
		if (isset($_GET['controle']) && isset ($_GET['action'])) {
			$controle = $_GET['controle'];  
			$action = 	 $_GET['action'];	
		}
	}
	//echo ('controle : ' . $controle . ' et <br/> action : ' . $action);
	require ('C/' . $controle . '.php');
	if(isset($_GET['country'])){
		$action($_GET['country']);
	}
	else{
		$action();
	}
}

?>
