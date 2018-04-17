<?php

function display(){
	require("form.html");
}

function login(){
	$host = "localhost";
	$user = "root";
	$pwd = "";
	$db = "labphp";
	$link = mysqli_connect($host, $user, $pwd, $db);
	$req = "select name, pwd from users where name='".$_POST['name']."'";
	$res = mysqli_query($link, $req);
	if($data = mysqli_fetch_assoc($res)){
		if($data > 0){
			if($data['pwd'] == crypt($_POST['password'], "rl")){
				$_SESSION['user'] = $data['name'];
				echo ("Welcome ". $_SESSION['user']);
				echo ("<br><a href='form.html'>Logout</a>");
			}
			else{
				echo ("Wrong password");
				require("form.html");
			}
		}
	}
	else{
		echo ("Name or password invalid");
		require("form.html");
	}
}

function create(){
	$host = "localhost";
	$user = "root";
	$pwd = "";
	$db = "labphp";
	$link = mysqli_connect($host, $user, $pwd, $db);
	if($_POST['password'] == $_POST['verifyPassword']){
		$req = "insert into users(name,pwd) values ('".$_POST['name']."', '".crypt($_POST['password'], "rl")."')";
		$res = mysqli_query($link, $req);
		require("form.html");
	}
	else{
		echo ("Password and verify password need to be the same");
		require("create.html");
	}
}
?>