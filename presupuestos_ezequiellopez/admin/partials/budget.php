<?php 
global $bussiness_phone, $bussiness_address,$total_materials_price, $total_installs_price,$total_optionals_price,$price_mano_obra;
$bussiness_address =  do_shortcode('[social_link type="bussiness_address"]');
$bussiness_phone =  do_shortcode('[social_link type="phone_number"]');
$bussiness_email = do_shortcode('[social_link type="email"]');
$formatted_bussiness_phone = sprintf("%s %s %s %s %s",substr($bussiness_phone,0,3),substr($bussiness_phone,3,1),substr($bussiness_phone,4,3),substr($bussiness_phone,7,3),substr($bussiness_phone,10,6));


function order_asc($a, $b)
{
if ($a['type'] == $b['type']) {
    return 0;
}
return ($a['type'] < $b['type']) ? -1 : 1;
}

$materials = json_decode($presupuesto->vehicle_materials,true);
usort ($materials, 'order_asc');


// foreach ($mat as $key => $value) {
//     echo $key . ' ' . $value['type'] . '<br>';
// }


?>
<!DOCTYPE html>
<html lang="en">
<head>
        <style>

            body{
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin:50px;
            line-height: 1.5;
            }
            h1{
                font-size:20pt;
                font-family: 'Anton', sans-serif;
            }
            p{
                font-size:12pt;
            }
            h6{
                font-size:8pt;
            }

        
            /* striped table */
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th {
                text-align: left;
                padding: 8px;
                font-size: 10pt;
            }
            td {
                text-align: left;
                padding: 8px;
                margin: 10px;
                font-size: 10pt;
            }
            tr:nth-child(even){background-color: #f2f2f2}
            
            hr{
            color:black;
            }

            header{
                color:grey;
            }
        </style>
</head>
<body>
    

<div id="sheet_paper" class="container bg-light">


<header>
                                      
                          
                                    <div style="float:right">
                                             
                                    <h6> Presupuesto N°: <?php echo $presupuesto->budget_id ?> </h6>
                                    <h6 style="text-align:justify"> 
                                                                    Emitido:        <?php echo date('d/m/Y' ,strtotime($presupuesto->created_at))  ?> <br>
                                                                    Vencimiento:    <?php echo date('d/m/Y' ,strtotime($presupuesto->budget_expire_date))?> 
                                    </h6> 
                                    </div>
                                     <div style="width:100%;height:80px;">
                                            <img src="<?php echo $dompdf->getOptions()->getChroot()[0] .'assets/pdf-logo.png'; ?>" width="60%"  alt="Logo">
                                           
                                           

                                    </div>
                                    <br>
                                    <div>
                                            <div  style=" float:left;width: 50% ;border-right:solid 1px grey;padding:2% ">
                                                
                                                <div >
                                                    <h5>Datos de la empresa</h5>
                                                    <h6>Dirección: <?php echo $bussiness_address ?><br>
                                                    Teléfono: <?php echo $formatted_bussiness_phone ?> <br>
                                                    Email: <?php echo $bussiness_email ?> 
                                                    </h6>
                                             

                                                    </h6>
                                                   
                                    
                                                </div>
                                            </div>

                                        
                                            <div style="padding:2%" >
                                 
                                                <h5 >Datos del cliente</h5>
                                                <h6>
                                                Nombre: <?php echo $presupuesto->client_name; ?><br>
                                                Teléfono: <?php $phone_number =$presupuesto->client_phone;echo  sprintf("%s %s %s %s %s",substr($phone_number,0,3),substr($phone_number,3,1),substr($phone_number,4,3),substr($phone_number,7,3),substr($phone_number,10,6));?><br>  
                                                Email: <?php echo $presupuesto->client_email; ?> <br>
                                                </h6>

                                              
                                            </div>
                                            <div style="padding:2%">
                                            <h5 >Datos del vehiculo</h5>
                                                <h6>
                                                Modelo: <?php echo $presupuesto->vehicle_model; ?><br>
                                                Capacidad del vehiculo: <?php echo $presupuesto->vehicle_capacity?>  (Personas)<br>
                                                </h6>
                                            </div>    
                                   
                                           

                                    </div>
                              
                               
</header> 
    <div style="border-top: solid 1px grey;">
        <?php $main_table_name = 'wp_budgets'; $presupuesto = $queries->get_budget_by_id( $_POST['budget_id']);?>
                                                                                    
    
        <div>
                        <h3>Acuerdos del presupuesto</h3>
                        <p style="text-align:justify;">
                                                                    
                        <?php echo nl2br($presupuesto->budget_contract);?>
                        </p>
                        <div style="border-top: solid 1px grey">
                            <h3>Equipamiento general</h3>
                                                                            
                                    <?php 
                                    
                                    $decode = json_decode($presupuesto->vehicle_equipment);
                                    foreach ($decode as $key => $value) {
                                ?>
                                        <ul>
                                            <li> <?php  echo $value->name; ?></li>
                                        </ul>

                                <?php } ?>
                        </div>

                        <div style="border-top: solid 1px grey">
                            <h3>Materiales</h3>
                                                                            
                                <table id="container" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="manage-column column-name column-primary">Material</th>
                                            <th class="manage-column column-name column-primary">Cantidad</th>
                                            <th class="manage-column column-name column-primary">Tipo</th>
                                            <th class="manage-column column-name column-primary">Precio por unidad</th>
                                            <th class="manage-column column-name column-primary">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php 
                            
                                                foreach ($materials as $key => $value) {
                                                    $total_materials_price +=  ($value['quantity'] * $value['price']);
                                            ?>
                                                    <tr>
                                                        <td> <?php  echo $value['name']; ?></td>
                                                        <td> <?php  echo $value['quantity']; ?></td>
                                                        <td><?php echo $value['type']; ?></td>

                                                        <?php if(intval($value['price']) == 0) { ?>
                                                            <td> Consultar </td>  
                                                        <?php }
                                                        
                                                        else{
                                                        ?>
                                                            <td>$<?php echo  number_format(floatval($value['price']),2) ?></td>
                                                            
                                                        <?php } ?>

                                                        <?php if(intval($value['price'] * $value['price']) == 0) { ?>
                                                            <td> Consultar </td>  
                                                        <?php }
                                                        
                                                        else{
                                                        ?>
                                                               <td>$<?php echo  number_format(floatval($value['price'] * $value['quantity']),2) ?></td>
                                                            
                                                        <?php } ?>
                                                     
                                                       
                                                    </tr>

                                            <?php } ?>
                                    </tbody>
                                </table>
                        </div>
                        <div style="border-top: solid 1px grey">
                            <h3>Instalaciones</h3>
                                                                            
                                <table id="container" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="manage-column column-name column-primary">Detalle</th>
                                            <th class="manage-column column-name column-primary">Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                            <?php 
                            
                                                $decode = json_decode($presupuesto->vehicle_installs);
                                                foreach ($decode as $key => $value) {
                                                    $total_installs_price +=  $value->price;
                                                    if($value->name != ""){
                                            ?>
                                                 
                                                    <tr>
                                                        <td> <?php  echo $value->name; ?></td>
                                                        <?php if(floatval($value->price) == 0) { ?>
                                                            <td> Consultar </td>  
                                                        <?php }
                                                        
                                                        else{
                                                        ?>
                                                            <td>$<?php echo  number_format(floatval($value->price),2) ?></td>
                                                            
                                                        <?php } ?>
                                                       
                                                    </tr>

                                            <?php }else{ ?>
                                                <tr>
                                                    <td> No hay opcionales añadidos </td>
                                                </tr>
                                            <?php }} ?>
                                    </tbody>
                                </table>
                        </div>
                        <div style="border-top: solid 1px grey">
                            <h3>Opcionales</h3>
                                                                            
                                <table id="container" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="manage-column column-name column-primary">Nombre</th>
                                            <th class="manage-column column-name column-primary">Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                            <?php 
                            
                                                $decode = json_decode($presupuesto->vehicle_optionals);

                                                foreach ($decode as $key => $value) {
                                                    $total_optionals_price +=  ($value->price);
                                                    if($value->name != ""){

                                            ?>
                                                 
                                                    <tr>
                                                        <td> <?php  echo $value->name; ?></td>
                                                        <?php if(floatval($value->price) == 0) { ?>
                                                            <td> Consultar </td>  
                                                        <?php }
                                                        
                                                        else{
                                                        ?>
                                                            <td>$<?php echo  number_format(floatval($value->price),2) ?></td>
                                                            
                                                        <?php } ?>
                                                       
                                                    </tr>

                                            <?php }else{ ?>
                                                <tr>
                                                    <td> No hay opcionales añadidos </td>
                                                </tr>
                                            <?php }} ?>
                                    </tbody>
                                </table>
                        </div>
                       <div style="border-top: solid 1px grey;text-align:right;">
                                                   
                        <h4>Importe de materiales: $<?php echo number_format($total_materials_price, 2)?></h4>
                        <h4>Opcionales: $<?php echo number_format($total_optionals_price, 2)?></h4>
                        <h4>Instalaciones: $<?php echo number_format($total_installs_price, 2)?></h4>
                        <h4>Mano de obra: $<?php $price_mano_obra = $presupuesto->budget_price; echo number_format( $price_mano_obra, 2)?></h4>
                        <h2>Importe total: $<?php echo number_format($presupuesto->budget_price + $price_mano_obra,2)?></h2>
                       </div>
        </div>
                                                            
    </div>
                                        



</div>
</body>
</html>





