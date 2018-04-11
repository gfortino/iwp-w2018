

<!DOCTYPE html>
<html>
<body>

<?php
// Find regular expression online to match any e-mail address.
// Use it to validate an array of 5 strings.
// Make 3 of these 5 strings invalid email adresses (e.g. missing TLD, missing @, illegal characters, etc...)


// Variable to check
$email = array("test@gmail.com", "toto.gmail.com", "Test@gmail","tést@gmail.com","Totu.amre@ge@eza.re");

// Validate email

foreach ($email as &$value) {
	if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
		echo("$value is a valid email address");
		echo '<br>';
	} else {
		echo("$value is not a valid email address");
		echo '<br>';
	}
}

?>

</body>
</html>