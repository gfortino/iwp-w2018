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
	public function moveForward();
	public function park();
}

interface Floating{
	
}



?>