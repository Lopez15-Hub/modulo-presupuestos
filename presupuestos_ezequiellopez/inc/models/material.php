<?php
class Material{
    private $material_name;
    private $material_price;
    private $material_type;

    public function __construct($material_name,$material_price,$material_type){
        $this->material_name = $material_name;
        $this->material_price = $material_price;
        $this->material_type = $material_type;
    }

    public function material_name(){
        return $this->material_name;
    }
    public function material_price(){
        return $this->material_price;
    }
    public function material_type(){
        return $this->material_type;
    }

}
