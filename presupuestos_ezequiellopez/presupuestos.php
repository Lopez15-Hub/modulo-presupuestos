<?php
/*
    Plugin Name: Presupuestos de servicios
    Plugin URI:  https://www.ezequiellopez.ar
    Description: Plugin para crear presupuestos
    Version: 1.0.0
    Author: Ezequiel López
    Author URI: https://www.ezequiellopez.ar
    License: GPLv2 or later
    Text Domain: presupuestos-de-servicios
*/

include plugin_dir_path(__FILE__) . '/inc/includes.php';



global $wpdb;
global $queries;





    function on_activate_presupuestos()
    {
        $queries = new DatabaseQueries;
        $queries->create_main_tables();
    }
    function on_deactivate_presupuestos()
    {
        flush_rewrite_rules();
    }

    function create_admin_menu()
    {


        add_menu_page(
        
            'Presupuestos', 
            'Presupuestos', 
            'usuario_administrador', //cap
            plugin_dir_path(__FILE__) . '/admin/partials/budgets_table.php',
            null,
            'dashicons-media-document', 
            6);
        add_submenu_page( 
            plugin_dir_path(__FILE__) . '/admin/partials/budgets_table.php',
            'Añadir presupuesto', //t pagina
            'Añadir presupuesto', //t menu
            'usuario_administrador', 
            plugin_dir_path(__FILE__) . '/admin/partials/presupuestos_admin.php',
            null,
        );

    }


    function add_scripts_to_admin(){
        //insert css
        wp_enqueue_style('style', plugins_url("./style.css", __FILE__));
        wp_enqueue_style('bootstrap', plugins_url("./css/bootstrap.css", __FILE__));
    }

    
    add_action('admin_enqueue_scripts', 'add_scripts_to_admin');
    add_action('admin_menu', 'create_admin_menu');
    register_activation_hook(__FILE__, "on_activate_presupuestos");
    register_deactivation_hook(__FILE__, "on_deactivate_presupuestos");