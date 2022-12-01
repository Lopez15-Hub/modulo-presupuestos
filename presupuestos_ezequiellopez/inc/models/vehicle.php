<?php 
class Vehicle {

    private $vehicle_capacity;
    private $vehicle_model;




    public function __construct($vehicle_capacity,$vehicle_model){
        $this->vehicle_capacity = $vehicle_capacity;
        $this->vehicle_model = $vehicle_model;

    }
    public function vehicle_capacity(){
        return $this->vehicle_capacity;
    }
    public function vehicle_model(){
        return $this->vehicle_model;
    }


}