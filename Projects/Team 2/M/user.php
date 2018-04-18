<?php
function login($login_user, $password){
	/*
	$host = "localhost";
	$user = "root";
	$pwd = "";
	$db = "labphp";
	$link = mysqli_connect($host, $user, $pwd, $db);
	*/
	//echo($login_user . PHP_EOL);
	//echo($password);
	//echo(crypt($password,"rl"));
	$link = connect();
	//echo($login_user);
	$req = "select id_user, login_user, pass, admin from user where login_user='$login_user'";
	//echo($req);
	$res = mysqli_query($link, $req);

	if($data = mysqli_fetch_assoc($res)){
		//echo("password: " . $data['pwd'] . "<br>");
		//echo("post pwd: " . crypt($password, "rl") . "<br>");
		if($data > 0){
			if($data['pass'] == crypt($password, "rl")){

				$_SESSION['user'] = $data['id_user'];
				if($data['admin']!=null)
					$_SESSION['admin']=$data['admin'];
				else
					$_SESSION['admin']="";
				//echo ("Welcome ". $data['admin']);
				if(isset($_SESSION['nextPath']) && $_SESSION['nextPath'] != ""){
					$path = $_SESSION['nextPath'];
					$_SESSION['nextPath'] = "";
					require('V/' . $path . '.html');
				}
				else{
					require('V/accueil.html');
				}
			}
			else{
				//echo ("Wrong password");
				require('V/connexion.html');
			}
		}
	}
	else{
		//echo ("Name or password invalid");
		require('V/connexion.html');
	}
}

function connect(){
	$host = "localhost";
	$user = "root";
	$pwd = "";
	$db = "bdd";
	$link = mysqli_connect($host, $user, $pwd, $db);
	return $link;
}

function reserveBDD($id_user,$id_travel,$datebeg,$dateend){
	$link = connect();
	$req = "insert into reserve(id_user,id_travel,datebeg,dateend) values ('" .$id_user ."','" .$id_travel  . "','". $datebeg."','" .$dateend . "')";
	$res = mysqli_query($link,$req);
}

function registerUser($Lastname,$Firstname, $password, $email, $login){

	$link = connect();
	$newpass =crypt($password,"rl");

	$req = "insert into user (Lastname,Firstname,email,login_user,pass) values ('" . $Lastname . "', '" . $Firstname . "', '". $email . "', '". $login . "', '". $newpass . "')";
	//echo($req);
	$res = mysqli_query($link, $req);

}
function verifUniqueLogin($login){
	$link = connect();
	$req = "select login_user from user where login_user='". $login ."'";
	$res = mysqli_query($link,$req);
	if(mysqli_fetch_assoc($res)){
		//There is already the sale ID
		return false;
	}else{
		
		return true;
	}
}

function getPage($country){
	$host = "localhost";
	$user = "root";
	$pwd = "";
	$db = "bdd";
	$link = mysqli_connect($host, $user, $pwd, $db);
	$req = "select id_travel, title, description, price from travel where title='" . $country . "'";
	//echo($req);
	$res = mysqli_query($link, $req);
	if($data = mysqli_fetch_assoc($res)){
		$title = $data['title'];
		$price = $data['price'];
		$description = $data['description'];
		$_SESSION['id_travel'] = $data['id_travel'];
	}
	$_SESSION['currentTravel'] = $title;
	$pictures = getPictures($country);
	require('V/circuitCountry.html');
}

function getPictures($country){
	$host = "localhost";
	$user = "root";
	$pwd = "";
	$db = "bdd";
	$link = mysqli_connect($host, $user, $pwd, $db);
	$req = "select path from picture natural join travel where title='" . $country . "'";
	//echo($req);
	$res = mysqli_query($link, $req);
	$pictures = array();
	$i=0;
	while($data = mysqli_fetch_assoc($res)){
		//echo($data['path']);
		$pictures[$i] = $data['path'];
		//$country = 'fjord';
		$i++;
	}
	$_SESSION['travelPicture'] = $pictures[0];
	return $pictures;
}

function getUserReservation(){
	$link = connect();
	$req = "select id_res, login_user, title, datebeg, dateend from reserve natural join travel natural join user";
	$res = mysqli_query($link, $req);
	$reserve = array();
	$i=0;
	while($data = mysqli_fetch_assoc($res)){
		$reserve[$i] = $data;
		$i++;
	}
	return $reserve;
}

function deleteUserReservation($idres){
	$link = connect();
	$req = "delete from reserve where id_res=" . $idres;
	//echo($req);
	$res = mysqli_query($link, $req);
}
?>
