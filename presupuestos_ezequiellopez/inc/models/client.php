<?php
class Client{
 
    
    private $client_name;
    private $client_email;



    public function __construct($client_name,$client_email){
            $this->client_name  = $client_name;
            $this->client_email = $client_email;

    }
    public function client_name(){
        return $this->client_name;
    }
    public function client_email(){
        return $this->client_email;
    }



}

?>