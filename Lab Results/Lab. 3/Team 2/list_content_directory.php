
<?php
// Print this project directory's file listing to screen.
// If you find a directory, enter it recursively.
// Using a function can be useful for recursion.


$path = dirname('D:\wamp64\www\iwp-w2018\Lab Results\Lab. 3\Team 2\list_content_directory.php');

if ($handle = opendir($path)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && !is_dir($entry)) {
            $fileSize = filesize($path  . DIRECTORY_SEPARATOR .  $entry);
            $myArray = file($path . DIRECTORY_SEPARATOR . $entry);
            $numberOfLines = count($myArray);
            echo PHP_EOL;
            echo "File : $entry,";
            echo PHP_EOL;
            echo "File size : $fileSize,";
            echo PHP_EOL;
            echo "Number of lines : $numberOfLines.";
            echo PHP_EOL;
        }
		echo("<br>");
    }
    closedir($handle);
}

?> 