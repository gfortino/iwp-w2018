<?php

$dir    = '/..';
$files = scandir($dir);

$i = 0;
foreach($files as $file){
  echo $file."<br>";
  $i++;
}

echo "There are ".$i." files in the folder.";

// Print this project directory's file listing to screen
