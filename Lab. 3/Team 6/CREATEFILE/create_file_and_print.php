<?php
// Read the newly created file's content and print it to screen

$my_file = 'file.txt';
$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file

$data = 'TOM KLOTZ / FRANCOIS DEXEMPLE / INES ELKAOUKABI';
fwrite($handle, $data);

$handle = fopen($my_file, 'r');
$data2 = fread($handle,filesize($my_file));
echo $data2 ;
fclose($handle);

?>
