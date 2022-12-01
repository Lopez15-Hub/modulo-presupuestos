<?php

class DatabaseQueries{

    public function create_main_tables(){
        self::create_budget_table();
    }

    private function create_budget_table(){
        global $wpdb;
        $main_table_name = $wpdb->prefix . "budgets";

        $budget_table_sql = "CREATE TABLE IF NOT EXISTS $main_table_name (
            
            budget_id mediumint(9) NOT NULL AUTO_INCREMENT,
            created_at datetime DEFAULT '0000-00-00 00:00:00'         NOT NULL,
            budget_expire_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            
            client_name        varchar(255)                   NOT NULL,
            client_email       varchar(255)                   NOT NULL,
            client_phone       varchar(255)                   NOT NULL,


            vehicle_capacity   varchar(255)                   NOT NULL,
            vehicle_model      varchar(255)                   NOT NULL,
            
            vehicle_materials  TEXT                           NOT NULL,
            vehicle_optionals  TEXT                           NOT NULL,
            vehicle_equipment  TEXT                           NOT NULL,
            vehicle_installs   TEXT                           NOT NULL,

            budget_price       varchar(255)                   NOT NULL,

            budget_contract    TEXT                           NOT NULL,




            PRIMARY KEY (budget_id)
            )";
        
        $wpdb->query($budget_table_sql);
      
    }

    public function insert_budget($budget){
        global $wpdb;
        $main_table_name = $wpdb->prefix . "budgets";


        $wpdb->insert(
            $main_table_name,
            array(
                
                'client_name'        =>  $budget->get_client_name(),
                'client_email'       =>  $budget->get_client_email(),
                'client_phone'       =>  $budget->get_client_phone(),
                'vehicle_capacity'   =>  $budget->get_vehicle_capacity(),
                'vehicle_model'      =>  $budget->get_vehicle_model(),
                'vehicle_materials'  =>  $budget->get_vehicle_materials(),
                'vehicle_optionals'  =>  $budget->get_vehicle_optionals(),
                'vehicle_equipment'  =>  $budget->get_vehicle_equipment(),
                'vehicle_installs'   =>  $budget->get_vehicle_installs(),
                'budget_price'       =>  $budget->get_budget_price(),
                'budget_contract'    =>  $budget->get_budget_contract(),
                'created_at'         =>  $budget->get_created_at(),
                'budget_expire_date' =>  $budget->get_expires_in()
    
        ));

    }
    public function edit_budget($newBudgetData,$id){
        global $wpdb;
        $main_table_name = $wpdb->prefix . "budgets";
        
        $wpdb->update(
            $main_table_name,
            array(
                'client_name'        => $newBudgetData->get_client_name(),
                'client_email'       => $newBudgetData->get_client_email(),
                'client_phone'       => $newBudgetData->get_client_phone(),
                'vehicle_capacity'   => $newBudgetData->get_vehicle_capacity(),
                'vehicle_model'      => $newBudgetData->get_vehicle_model(),
                'vehicle_materials'  => $newBudgetData->get_vehicle_materials(),
                'budget_price'       => $newBudgetData->get_budget_price(),
                'budget_contract'    => $newBudgetData->get_budget_contract(),
                'created_at'         => $newBudgetData->get_created_at(),
                'budget_expire_date' => $newBudgetData->get_expires_in()
    
            ),
            array(
                $id
            )
        );
    }
    public function get_all_budgets(){
        global $wpdb;
        $main_table_name = $wpdb->prefix . "budgets";
        $all_budgets = $wpdb->get_results("SELECT * FROM $main_table_name");
        return $all_budgets;
    }
    public function get_budget_by_id($budget_id){
        global $wpdb;
        $main_table_name = $wpdb->prefix . "budgets";
        $budget = $wpdb->get_row("SELECT * FROM $main_table_name WHERE budget_id = $budget_id ");
        return $budget;
    }

    public function delete_budget($budget_id){
        global $wpdb;
        $main_table_name = $wpdb->prefix . "budgets";
        $wpdb->delete($main_table_name, array('budget_id' => $budget_id));
        
        $wpdb->query( "ALTER TABLE $main_table_name AUTO_INCREMENT=$budget_id -1" );


    }

}

?>