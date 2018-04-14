<?php

// Create a file by putting your name in it
$file = 'file.txt';
$fichier = fopen($file, 'w+');

$donnees = 'Jean SARDOY/Clement BASTIEN ';
fwrite($fichier,$donnees);

$fichier = fopen($file, 'r');
// Read the newly created file's content and print it to screen
$donnee2 = fread($fichier,filesize($file));
echo $donnee2;
fclose ($fichier);
?>

