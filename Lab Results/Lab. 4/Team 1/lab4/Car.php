<?php
include "Vehicle.php";
class Car extends Vehicle
{
    private $make;
    private $model;
    private $year;
    private $type;

    function __construct($make,$model,$year,$type) {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
        $this->type = $type;
    }

    function GetType(){
        //return parent::GetType();
        return get_class();
    }
    function show_info(){
        echo "make: ".$this->make." model: ".$this->model." year: ".$this->year." type: ".$this->type."</br>";
    }
}

$obj=new Car("benz","c200","2007","coupe");
echo $obj->GetType()."</br>";
$obj->show_info();