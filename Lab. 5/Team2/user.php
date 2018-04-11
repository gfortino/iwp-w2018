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
	/*echo($_POST['name']."<br>".crypt($_POST['password'], "rl")."<br>");
	$_SESSION['user'] = $_POST['name'];
	echo ($_SESSION['user']);*/
	echo(crypt($_POST['password'], "rl"));
	echo($_POST['name']);
	$req = "select name from users where name=".$_POST['name']." and pwd=".crypt($_POST['password'], "rl");
	$res = mysqli_query($link, $req);
	echo (PHP_EOL . "req = ".$req . PHP_EOL);
	$data=mysqli_fetch_assoc($res);
	if($data > 0){
		$_SESSION['user'] = $data['name'];
		echo ("Welcome ". $_SESSION['user']);
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
		//echo(crypt($_POST['password'], "rl"));
		require("form.html");
	}
}
?>