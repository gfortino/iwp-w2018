<!DOCTYPE html>
<html>
<body>

<?php

// Find regular expression online to match any e-mail address.
// Use it to validate an array of 5 strings.
// Make 3 of these 5 strings invalid email adresses (e.g. missing TLD, missing @, illegal characters, etc...)

// test code from : http://php.net/manual/fr/filter.examples.validation.php
$mail = array("jean@gmail.fr","jeanàconcordia@gmail.fr","jean@sardoy@gmail.fr", "jean.gmail.fr", "jean@gmail");
foreach ($mail as $test){
if (filter_var($test, FILTER_VALIDATE_EMAIL)) {
    echo $test;
	echo " has not problem";
	echo "<br>";
}
else {
	echo "$mail is not valid , please enter a valid e-mail address ";
}
}

?>
</body>
</html>