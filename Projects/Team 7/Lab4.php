<?php

abstract class Vehicle { 

	abstract protected function GetType();
	
}

class Car extends Vehicle {
	private $Make;
	private $Model;
	private $Year;
	
	protected function GetType(){
		return 'Car'.PHP_EOL;
	}
}

class Plane extends Vehicle {

	private $Year;
	private $nbpassengers;
	private	$length;
	
	protected function GetType(){
		return 'Plane'.PHP_EOL;
	}
}

class Boat extends Vehicle {
	private $Year;
	private $nbpassengers;
	private	$length; 
	
	protected function GetType(){
		return 'Boat'.PHP_EOL;
	}
}

interface FlyingMachine {
	
	public function takeoff();
	public function land();
	public function StartEngine($enginenumber);
	public function SetThrottle();
}

interface RoadCapable {
	
	public function accelerate();
	public function brake();
	public function StartEngine();
	
}

interface Floating {
	
	public function LiftAnchor();
	public function DropAnchor();
}

$Plane = new Plane(1,2,3);
$Boat = new Boat(1,2,3);
$Car = new Car(1,2,3);
 echo Car.GetType();


?>

















