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
	public function getType(){
		echo ("I'm a plane");
	}
	public function fly(){
		echo ("I'm flying");
	}
	public function landing(){
		echo ("I'm landing");
	}
}

class Boat extends Vehicule{
	public function getType(){
		echo ("I'm a boat");
	}
}

interface FlyingMachine{
	public function fly();
	public function landing();
}

interface RoadCapable{
	public function StartEngine();
	public function Accelerate();
	public function Brake();
}

interface Floating{
	
}



?>