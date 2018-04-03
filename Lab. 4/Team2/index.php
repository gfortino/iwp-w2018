<?php

abstract class Vehicule{
	/*
	*@return string, type of the object
	*/
	public abstract function getType();
}

class Car extends Vehicule{
	public function getType(){
		echo ("I'm a car");
	}
}

class Plane extends Vehicule implements FlyingMachine{
	var $Model;
	var $NbEngines;
	var $NbPassengers;
	var $MaxAltittude;
	public function __construct($model, $nbEngines, $nbPassengers, $maxAltittude){
		$this->Model = $model;
		$this->NbEngines = $nbEngines;
		$this->NbPassengers = $nbPassengers;
		$this->MaxAltittude = $maxAltittude;
		echo ("Creation of the plane ".$this->Model.PHP_EOL);
	}
	public function __destruct(){
		echo ("Destruction of the plane ".$this->Model.PHP_EOL);
	}
	public function getType(){
		echo ("I'm a Plane");
	}
	public function TakeOff(){
		echo ("All engines off".PHP_EOL);
	}
	public function Land(){
		echo ("Landing".PHP_EOL);
	}
	public function StartEngine($engineNumber){
		echo ("Engine $engineNumber on".PHP_EOL);
	}
	public function SetThrottle(){
		echo ("??".PHP_EOL);
	}
}

class Boat extends Vehicule{
	public function getType(){
		echo ("I'm a boat");
	}
}

interface FlyingMachine{
	public function TakeOff();
	public function Land();
	public function StartEngine($engineNumber);
	public function SetThrottle();
}

interface RoadCapable{
	public function moveForward();
	public function park();
}

interface Floating{
	
}

$plane = new Plane("BOEING",2,200,2000);
$plane->StartEngine(1);



?>