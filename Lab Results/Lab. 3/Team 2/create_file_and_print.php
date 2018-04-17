<?php
// Print this project directory's file listing to screen.
// If you find a directory, enter it recursively.
// Using a function can be useful for recursion.

	$nameFile = 'test.txt';
	$fileName = fopen($nameFile,"w");

	$myName = "AJA BDW" . PHP_EOL;

	fwrite($fileName, $myName);

	$readName = file_get_contents($nameFile); 

	echo $readName;

	fclose($fileName);


// Create a file by putting your name in it
// Read the newly created file's content and print it to screen
?> 