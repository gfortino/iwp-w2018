<?php

// Print this project directory's file listing to screen

$dir="../";
$handler = opendir($dir);
while (($filename = readdir($handler)) !== false) {//务必使用!==，防止目录下出现类似文件名“0”等情况
    if ($filename != "." && $filename != "..") {
        $files[] = $filename ;
    }
}

closedir($handler);

foreach ($files as $value) {
    echo $value."<br />";
}