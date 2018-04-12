<?php

// Find regular expression online to match any e-mail address.
// Use it to validate an array of 5 strings.
// Make 3 of these 5 strings invalid email adresses (e.g. missing TLD, missing @, illegal characters, etc...)


$emails[]="sqef@";
$emails[]="sqef.com";
$emails[]="sqeéé'ùf@gmail.com";
$emails[]="zheruiiii@gmail.com";
$emails[]="biblibi@gmail.com";

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