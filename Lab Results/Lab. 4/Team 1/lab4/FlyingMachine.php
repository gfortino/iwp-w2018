<?php
interface FlyingMachine
{
    public function takeOff();
    public function land();
    public function startEngine($engineNumber);
    public function setThrottle();
}