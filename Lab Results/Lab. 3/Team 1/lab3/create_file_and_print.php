<?php

// Create a file by putting your name in it

// Read the newly created file's content and print it to screen


$myfile = fopen("test.txt", "w") or die("Unable to open file!");
$txt = "lizherui\n";
fwrite($myfile, $txt);
fclose($myfile);

$myfile = fopen("test.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("test.txt"));
fclose($myfile);


?>