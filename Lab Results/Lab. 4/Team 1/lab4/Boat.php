<?php
include "Vehicle.php";
class Boat extends Vehicle
{
    private $name;

    function __construct($name) {
        $this->name = $name;
    }

    function GetType(){
        return get_class();
    }
    function getName(){
        return $this->name;
    }
}

$obj=new Boat("boat1");
echo $obj->GetType();