<?php
abstract class Vehicle {
    public abstract function getNumWheels();

    public function getType() {
        return get_class($this);
    }
}

class Car extends Vehicle implements RoadCapable{
    var $Make;
    var $Model;
    var $year;
    var $type;
    public function getNumWheels() {
        return 4;
    }
}

class Plane extends Vehicle implements FlyingMachine {
    var $Model;
    var $NbEngines;
		var $NbPassengers;
		var $MaxAltittude;
    public function getNumWheels() {
        return 3;
    }
}

class Boat extends Vehicle implements Floating{
    public function getNumWheels() {
        return 2;
    }
}
interface FlyingMachine{
		public function TakeOff();
		public function Land();
		public function StartEngine($engineNumber);
		public function SetThrottle();
}
interface RoadCapable {
		public function StartEngine();
		public function Accelerate();
		public function Brake();
}
interface Floating {
		public function LiftAnchor();
		public function DropAnchoer();
}
function printNumWheels(Vehicle $v) {
    echo "A " . $v->getType() . " has " . $v->getNumWheels() . " wheels\n";
}

$car = new Car();
$plane = new Plane();
$boat = new Boat();

printNumWheels($car);
printNumWheels($plane);
printNumWheels($boat);
/*
output:
A Car has 4 wheels
A Bike has 2 wheels
*/
