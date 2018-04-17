<?php

$emails[]="heyy@";
$emails[]="yooo.com";
$emails[]="salutation@gmail.com";
$emails[]="rowan.thomas@live.fr";
$emails[]="mathis.Urard@gmail.com";

echo "List email: </br>";
foreach ($emails as $value){
    /*if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value)) {
        echo $value.": invalide..</br>";
    }*/
    echo $value."</br>";
}
echo "</br>";
echo "invalide email: </br>";
foreach ($emails as $value){
    /*if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value)) {
        echo $value.": invalide..</br>";
    }*/
    if (!preg_match("/^[a-z]([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i",$value)){
        echo $value.": invalide..</br>";
    }
}