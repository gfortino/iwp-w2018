<?php
include "Vehicle.php";
include "FlyingMachine.php";


class Plane extends Vehicle implements FlyingMachine
{
    private $model;
    private $nbEngines;
    private $nbPassengers;
    private $maxAltittude;

    function __construct($model,$nbEngines,$nbPassengers,$maxAltittude) {
        $this->model = $model;
        $this->nbEngines = $nbEngines;
        $this->nbPassengers = $nbPassengers;
        $this->maxAltittude = $maxAltittude;
    }

    function getType(){
        return get_class();
    }

    function takeOff(){
        echo "Taking off !";
    }
    function land(){
        echo "landing !</br>";
    }
    function startEngine($engineNumber){
        echo "starting ".$engineNumber."eng";
    }
    function setThrottle(){
        echo "seting throttle</br>";
    }
}

$obj=new Plane("c919","4","158","10668");
echo $obj->GetType()."</br>";
$obj->TakeOff();