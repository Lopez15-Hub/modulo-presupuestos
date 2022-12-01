<?php
class Budget{
    private $client_name;
    private $client_email;
    private $client_phone;
    private $vehicle_capacity;
    private $vehicle_materials;
    private $vehicle_optionals;
    private $vehicle_equipment;
    private $vehicle_installs;
    private $vehicle_model;
    private $budget_price;
    private $budget_contract;
    private $created_at;
    private $expires_in;
    private $budget_id;
    
    public function __construct(
        $client_name,
        $client_email,
        $client_phone,
        $vehicle_capacity,
        $vehicle_materials,
        $vehicle_optionals,
        $vehicle_equipment,
        $vehicle_installs,
        $vehicle_model,
        $budget_price,
        $budget_contract,
        $created_at,
        $expires_in,
        $budget_id
        ){
        $this->client_name = $client_name;
        $this->client_email = $client_email;
        $this->client_phone = $client_phone;
        $this->vehicle_capacity = $vehicle_capacity;
        $this->vehicle_materials = $vehicle_materials;
        $this->vehicle_optionals = $vehicle_optionals;
        $this->vehicle_equipment = $vehicle_equipment;
        $this->vehicle_installs = $vehicle_installs;

        $this->vehicle_model = $vehicle_model;
        $this->budget_price = $budget_price;
        $this->budget_contract = $budget_contract;
        $this->created_at = $created_at;
        $this->expires_in = $expires_in;
        $this->budget_id = $budget_id;


    }
    public function get_client_name(){
        return $this->client_name;
    }
    public function get_client_email(){
        return $this->client_email;
    }
    public function get_client_phone(){
        return $this->client_phone;
    }
    public function get_vehicle_capacity(){
        return $this->vehicle_capacity;
    }
    public function get_vehicle_materials(){
        return $this->vehicle_materials;
    }
    public function get_vehicle_optionals(){
        return $this->vehicle_optionals;
    }
    public function get_vehicle_equipment(){
        return $this->vehicle_equipment;
    }
    public function get_vehicle_installs(){
        return $this->vehicle_installs;
    }
    public function get_vehicle_model(){
        return $this->vehicle_model;
    }
    public function get_budget_price(){
        return $this->budget_price;
    }
    public function get_budget_contract(){
        return $this->budget_contract;
    }
    public function get_created_at(){
        return $this->created_at;
    }
    public function get_expires_in(){
        return $this->expires_in;
    }
    public function get_budget_id(){
        return $this->budget_id;
    }

}