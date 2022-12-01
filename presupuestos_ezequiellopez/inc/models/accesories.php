<?php
class Accesorie{
    private $accesorie_name;
    private $accesorie_price;

    public function __construct($accesorie_name,$accesorie_price){
        $this->accesorie_name = $accesorie_name;
        $this->accesorie_price = $accesorie_price;
    }
    
    public function accesorie_name(){
        return $this->accesorie_name;
    }
    public function accesorie_price(){
        return $this->accesorie_price;
    }

}