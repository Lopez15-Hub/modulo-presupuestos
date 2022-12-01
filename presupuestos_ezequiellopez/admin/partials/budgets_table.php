<?php

global $wpdb;
global $queries;
global $bucket_id;
$queries = new DatabaseQueries;
function get_budget_id($id){
    $bucket_id = $id;
}

if(isset($_POST['delete-budget'])){
    $queries->delete_budget($_POST['budget_id']);
}
?>
 <script src="https://kit.fontawesome.com/c4053a7e20.js" crossorigin="anonymous"></script>

<div>
    <div class="allBudgets">
    <h1>Todos los presupuestos</h1>
            <table id="container" class="table table-striped">
                <thead>
                    <tr>
                        <th class="manage-column ">Presupuesto n°</th>
                        <th class="manage-column column-name column-primary">Cliente</th>
                        <th class="manage-column column-name column-primary">Fecha de creación</th>
                        <th class="manage-column column-name column-primary">Fecha de vencimiento</th>
                        <th class="manage-column column-name column-primary">Valor del presupuesto</th>
                        <th class="manage-column column-name column-primary">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $main_table_name = 'wp_budgets';
                    $presupuestos = $queries->get_all_budgets();
                    foreach ($presupuestos as $presupuesto) {
                        ?>
                        <tr>
                            <td><?php echo $presupuesto->budget_id; ?></td>
                            <td><?php echo $presupuesto->client_name; ?></td>
                            <td><?php echo date('d/m/Y' ,strtotime($presupuesto->created_at))  ?></td>
                            <td><?php echo date('d/m/Y' ,strtotime($presupuesto->budget_expire_date))?></td>
                            <td> $<?php echo number_format($presupuesto->budget_price,2)?></td>
                            <td class="d-flex"> 
                                <form  method="post" action="<?php plugin_dir_path(__FILE__) . 'budget_process.php'?>">
                                <input type="hidden" name="budget_id"  value="<?php  echo $presupuesto->budget_id;   ?>" />
                                <button type="submit" id="print-pdf" name="print-pdf" class="btn btn-outline-primary btn-sm" ><i class="fa-solid fa-print"></i>Imprimir</button>
                                
                            </form>
                            <form method="post" >
                                    <input type="hidden" name="budget_id"  value="<?php  echo $presupuesto->budget_id;   ?>" />
                                    <button type="submit" id="delete-budget" name="delete-budget" class="btn btn-outline-danger btn-sm" ><i class="fa-solid fa-trash-alt"></i>Eliminar</button>
                                </form>
                               
                            </td>
                           
                        </tr>

                    <?php }?>
                </tbody>
            </table> 

    </div>
    </div>

    <?php require 'budget_process.php'?>
