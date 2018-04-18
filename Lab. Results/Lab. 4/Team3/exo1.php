<?php

abstract class Vehicule{
		abstract protected function getType();
}

class Car extends Vehicule {
	
	protected $make;
	protected $model;
	protected $year;
	protected $type;
	
	protected function getType(){
		return 'Car' . PHP_EOL;
	}
}

class Plane extends Vehicule{
	
		protected $model;
		protected $nbEngines;
		protected $nbPassengers;
		protected $maxAltittude;
		
	protected function getType(){
		return 'Plane' . PHP_EOL;
	}
}

class Boat extends Vehicule{
	
	protected function getType(){
		return 'Boat' . PHP_EOL;
	}
}


interface FlyingMachine{
	public function takeOff();
	public function land();
	public function startEngine($engineNumber);
	public function setThrottle();
}

interface RoadCapable {
	public function startEngine();
	public function accelerate();
	public function brake();
}

interface Floating {
	public function liftAnchor();
	public function dropAnchoer();
	public function brake();
}

$boat = new Boat();
echo $boat.getType();

?>



