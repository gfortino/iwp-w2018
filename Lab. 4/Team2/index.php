<?php

abstract class Vehicule{
	/*
	*@return string, type of the object
	*/
	public abstract function getType();
}

class Car extends Vehicule implements RoadCapable{
	var $make;
	var $model;
	var $year;
	var $type;
	
	public function __construct($make, $model, $year, $type){  
		$this->make = $make;  
		$this->model = $model; 
		$this->year = $year; 
		$this->type = $type; 
	}
	
	public function __destruct(){
		//$this->connection->destroy();
		echo("Destroy");
	}
	public function StartEngine(){
		echo ("Start to drive");
	}
	public function Accelerate(){
		echo ("Accelerate");
	}
	public function Brake(){
		echo ("Brake");
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
	public function StartEngine();
	public function Accelerate();
	public function Brake();
}

interface Floating{
	
}

$plane = new Plane("BOEING",2,200,2000);
$plane->StartEngine(1);



?>