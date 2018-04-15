<?php

/*
1. Create a Vehicle abstract class
	a. For implementation of GetType() method (returns the actual type: car, plane, boat)

2. Create concrete classes derived from Vehicle
	a. Car
		Make
		Model
		Year
		Type
	b. Plane
		Model
		NbEngines
		NbPassengers
		MaxAltittude
	c. Boat

3. Create interfaces with the following methods:
	a. FlyingMachine
		TakeOff();
		Land();
		StartEngine($engineNumber);
		SetThrottle();
	b. RoadCapable
		StartEngine();
		Accelerate();
		Brake();
	c. Floating
		LiftAnchor();
DropAnchoer();
*/

abstract class Vehicle
{
    abstract protected function getType();
}

class Car extends Vehicle implements RoadCapable
{
  public $make;
  public $model;
  public $year;
  public $type;

  public function getType() {
  return "Car";
  }
  public function StartEngine(){
    print("StartEngine()");
  }
  public function Accelerate(){
    print("Accelerate()");
  }
  public function Brake(){
    print("Brake()");
  }
}
class Plane extends Vehicle implements FlyingMachine
{
  public $model;
  public $nbEngines;
  public $nbPassengers;
  public $maxAltittude;

  public function getType() {
  return "Plane";
  }
  public function TakeOff(){
    print("TakeOff()");
  }
  public function Land(){
    print("Land()");
  }
  public function StartEngine($engineNumber){
    print("StartEngine(".$engineNumber.")");
  }
  public function SetThrottle(){
    print("SetThrottle()");
  }
}
class Boat extends Vehicle implements Floating
{
  public function getType() {
  return "Boat";
  }
  public function LiftAnchor(){
    print("LiftAnchor()");
  }
  public function DropAnchoer(){
    print("DropAnchoer()");
  }
}

interface FlyingMachine
{
    public function TakeOff();
		public function Land();
		public function StartEngine($engineNumber);
    public function SetThrottle();
}

interface RoadCapable
{
    public function StartEngine();
    public function Accelerate();
    public function Brake();
}

interface Floating
{
    public function LiftAnchor();
    public function DropAnchoer();
}


$boat = new Boat;
$typeB = $boat->getType();
$car = new car;
$typeC = $car->getType();
$plane = new Plane;
$typeP = $plane->getType();
echo "Type: ".$typeB.", ";
echo $boat->LiftAnchor().", <br>";
echo "Type: ".$typeC.", ";
echo $car->StartEngine().", <br>";
echo "Type: ".$typeP.", ";
echo $plane->StartEngine(5);
