<?php

abstract class Vehicle {
	abstract protected GetType(){
	}
}

protected class Car extends Vehicle{
	private $Make;
	private $Model;
	private $Year;
	private $Type
	
	protected function __constructor($Make,$Model,$Year,$Type){
	$this->Make  =$Make;
	$this->Model =$Model;
	$this->Year  =$Year;
	$this->Type  =$Type;
	}
	protected function GetType{
		return 'Car';
	}
}


protected class Plane extends Vehicle {
	private $NbEngines;
	private $Model;
	private $NbPassengers;
	private $MaxAltitude;
	
	protected function __constructor($NbEngines,$Model,$NbPassengers,$MaxAltitude){
	$this->NbEngines  =$NbEngines;
	$this->Model =$Model;
	$this->NbPassengers  =$NbPassengers;
	$this->MaxAltitude  =$MaxAltitude;
	}
	protected function GetType{
		return 'Plane';
}


protected class Boat extends Vehicle {
	protected function GetType{
		return 'Boat';
}


interface Flyingmachine{
	protected function TakeOff();
	protected function Land();
	protected function StartEngine($engineNumber);
	protected function SetThrottle();
}

interface RoadCapable{
	protected function StartEngine();
	protected function Accelerate();
	protected functionBrake();
}


interface Floating{
	protected function LiftAnchor();
	protected function DropAnchoer();
}



?>