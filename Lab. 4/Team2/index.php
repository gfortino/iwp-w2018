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
	public function __construct(){
		echo("Mading the boat...");
	}
	public function __destruct(){
			echo("Destructing the boat...");
	}
		echo("Mading the boat...");
	}
	public function getType(){
		echo ("I'm a boat");
	}
	public function LiftAnchor(){
		echo("Anchor is lifted")
	}
	public function DropAnchor(){
		echo("Anchor is dropped")
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
	public function LiftAnchor();
	public function DropAnchoer();
}



?>