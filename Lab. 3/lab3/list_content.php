<?php


$dir="../";
$handler = opendir($dir);
while (($filename = readdir($handler)) !== false) {
    if ($filename != "." && $filename != "..") {
        $files[] = $filename ;
    }
}

closedir($handler);

foreach ($files as $value) {
    echo $value."<br />";
}