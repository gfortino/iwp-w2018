<?php
// Find regular expression online to match any e-mail address.
$exp = "/^[\w.-]+@[\w.-]+\.[a-z]{2,6}$/";
// Use it to validate an array of 5 strings.
$array = array("toto.titi@tata.com", "toto.titi.tata@o.net", "toto.titi.tata@onetor", "totoo.netor@", "toto.titi.tata@net");
// Make 3 of these 5 strings invalid email adresses (e.g. missing TLD, missing @, illegal characters, etc...)
foreach($array as $email){
	if(preg_match($exp,$email)){
		echo(preg_match_all($exp,$email));
		echo ("$email is valid email <br>");
	}
	else{
		echo ("$email is not valid email <br>");
	}
}