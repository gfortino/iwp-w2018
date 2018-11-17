<?php

function accueil(){

	//require ("V/accueil.html");
	//header('Location: V/accueil.html');
	require('V/accueil.html');
  //exit();

}

function displayReservation(){
	//$_SESSION['user']="";
	if(!isset($_SESSION['user']) || $_SESSION['user']==""){
		$_SESSION['nextPath'] = "ResGeorge";
		displayConnection();
	}
	else
		require('V/ResGeorge.html');
}

function displayConnection(){
	require('V/connexion.html');
}

function displayPayment(){
	require('V/payment.html');
}

function register(){
	require("M/user.php");
	//foreach($_POST as $key => $val) echo '$_POST["'.$key.'"]='.$val.'<br />';
	$Lastname = isset($_POST['Lastname'])?$_POST['Lastname']:"";
	$Firstname = isset($_POST['Firstname'])?$_POST['Firstname']:"";
	$email = isset($_POST['email'])?$_POST['email']:"";
	$login = isset($_POST['login'])?$_POST['login']:"";
	$pwd = isset($_POST['password'])?$_POST['password']:"";
	$vpwd = isset($_POST['validatePassword'])?$_POST['validatePassword']:"";
	if($pwd==$vpwd && verifUniqueLogin($login)){

		registerUser($Lastname,$Firstname,$pwd,$email,$login);
		require('V/connexion.html');
	}else{
		require('V/registration.html');
	}
}
function logout(){
	$_SESSION['user']="";
	$_SESSION['admin']="";
	require('V/accueil.html');
}

function displayPage($path){
	require('V/' . $path . '.html');
}

function displayCountry(){
	$country = $_GET['country'];
	require('M/user.php');
	getPage($country);
	//require('V/circuitCountry.html');
}


function verifUtilisateur(){
	$login=isset($_POST['Login'])?$_POST['Login']:"tapez votre login";
	$passe=isset($_POST['Password'])?$_POST['Password']:"tapez votre passe";
	require ("M/Ok.php");
	if (verifLoginBd($login, $passe))
		echo ("ok");
	else
		echo ("ko");
}

function test(){
	//echo("It finally works");
	require("M/user.php");
	//foreach($_POST as $key => $val) echo '$_POST["'.$key.'"]='.$val.'<br />';
	$name = isset($_POST['name'])?$_POST['name']:"";
	$pwd = isset($_POST['password'])?$_POST['password']:"";
	login($name, $pwd);
}

function reserve(){
	require("M/user.php");
	//echo("reservation en cours");
	//var_dump( $_SESSION);
	$id_user = $_SESSION['user'];
	$id_travel=$_SESSION['id_travel'];
	$datebeg =$_POST['datebeg'];
	$dateend = $_POST['dateend'];;

	reserveBDD($id_user,$id_travel,$datebeg,$dateend);


	//require("V/payment.html");
	require("V/ResGeorge_confirmation.html");
}

function confirme(){
	require("M/user.php");
	//echo("reservation en cours");
	//var_dump( $_SESSION);
	/*$id_user = $_SESSION['user'];
	$id_travel=$_SESSION['id_travel'];
	$datebeg =$_POST['datebeg'];
	$dateend = $_POST['dateend'];;

	reserveBDD($id_user,$id_travel,$datebeg,$dateend);*/


	require("V/payment.html");
	//require("V/ResGeorge_confirmation.html");
}

function payment(){
	require("M/user.php");
	//echo("reservation en cours");
	//var_dump( $_SESSION);
	/*$id_user = $_SESSION['user'];
	$id_travel=$_SESSION['id_travel'];
	$datebeg =$_POST['datebeg'];
	$dateend = $_POST['dateend'];;

	reserveBDD($id_user,$id_travel,$datebeg,$dateend);*/


	require("V/accueil.html");
	//require("V/ResGeorge_confirmation.html");
}

function getReservation(){
	require("M/user.php");
	$reserve = getUserReservation();
	require("V/admin.html");
}

function deleteReservation($path){
	//echo("PATH=" . $path);
	require("M/user.php");
	//$idres = isset($_POST['id'])?$_POST['id']:"";
	deleteUserReservation($path);
	require("V/accueil.html");
}

?>
