<html>
<body>

<?php

// Create a file by putting your name in it
$file = fopen("team5.txt", "w");
$txt = "Hugo LECLERE\n";
fwrite($file, $txt);
// Read the newly created file's content and print it to screen
$file = fopen("team5.txt", "r");
echo fgets($file);

fclose($file);


echo "</body></html>";
