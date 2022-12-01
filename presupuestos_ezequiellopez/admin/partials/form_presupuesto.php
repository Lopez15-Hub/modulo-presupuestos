

<?php


global $wpdb;
global $client_name;
global $client_email;
global $client_phone;
global $vehicle_capacity  ;
global $vehicle_model ;
global $vehicle_materials ;

global $budget_contract;
global $budget_price;
global $queries; 
global $budget_obj;
function getDatetimeNow() {
    $tz_object = new DateTimeZone('Brazil/East');
    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ h:i:s');
}
$queries = new DatabaseQueries;

$main_table_name = "wp_budgets";
if(isset($_POST['submit'])){
    $add_to_final_price = $_POST['add_to_final_price'] ?? null;
    $add_to_final_price_installs = $_POST['add_to_final_price_installs'] ?? null;
    $client_name = $_POST['client_name'];
    $client_email = $_POST['client_email'];
    $client_phone = $_POST['client_phone'];
    $created_at =  getDatetimeNow();
    $expires_in = $_POST['expires_in'];
    $vehicle_capacity = $_POST['vehicle_capacity'];
    $vehicle_model = $_POST['vehicle_model'];
    $material_name = $_POST['material_name'];
    $material_price = $_POST['material_price'] ?? 0;
    $material_type = $_POST['material_type'];
    $material_quantity = $_POST['material_quantity'] ?? 0;

    $optional_name = $_POST['optional_name'] ?? null;
    $optional_price = $_POST['optional_price'] ?? 0;

    $install_name = $_POST['install_name'] ?? null;
    $install_price = $_POST['install_price'] ?? 0;

    $equipment_name = $_POST['equipment_name'] ?? null;


    $materials = array();
    $optionals = array();
    $equipments = array();
    $installs = array();
    $budget_price = 0;
    $budget_contract = $_POST['budget_contract'];


    foreach ($material_name as $key=>$value){

            $materials[] = array(
                'material_id'=>  $key,
                'name' => $value,
                'price' => floatval($material_price[$key]),
                'type' => $material_type[$key],
                'quantity' => $material_quantity[$key]
            );
            $budget_price += floatval($material_price[$key]) * intval( $material_quantity[$key]);
      

;
    }


    foreach ($optional_name as $key=>$value){
        if($add_to_final_price)  $budget_price = $budget_price + floatval( $optional_price[$key]);  
        array_push(
            $optionals,
            [
            'optional_id'=>  $key,
            'name'       =>  $value,
            'price'      =>  floatval($optional_price[$key]),
            
            ]
        );
    }

    foreach ($install_name as $key=>$value){
        if($add_to_final_price_installs)  $budget_price = $budget_price + floatval( $install_price[$key]);  
        array_push(
            $installs,
            [
            'install_id'=>  $key,
            'name'       =>  $value,
            'price'      =>  floatval($install_price[$key]),
            
            ]
        );
    }

    foreach ($equipment_name as $key=>$value){
        array_push(
            $equipments,
            [
            'equipment_id'=>  $key,
            'name'       =>  $value,
            
            ]
        );
    }
        

    $budget_obj = new Budget(
        $client_name,
        $client_email,
        $client_phone,
        $vehicle_capacity,
        json_encode($materials),
        json_encode($optionals),
        json_encode($equipments),
        json_encode($installs),
        $vehicle_model,
        $budget_price,
        $budget_contract,
        $created_at,
        $expires_in,
        ''
        
    );

    $queries->insert_budget($budget_obj);

        //print bootstrap alert
        echo '<div class="alert alert-success" role="alert">
       El presupuesto ha sido guardado <strong>correctamente.</strong>
        </div>';
   
}

?>

<div class="container">
    
    <h1 class="text-center">Generar presupuesto</h1>
<form id="form" name="form" method="post">
    <label for="" class="text-danger">Los campos con un "*" son requeridos.</label>
    <div class="form-group">
    <label for="nombre">Fecha de Vencimiento</label><label for="" class="text-danger">*</label>
        <input type="date" class="form-control"" name="expires_in" required>
    </div>

    <h2>Datos del solicitante</h2>
    <div class="form-group">
        <label for="nombre">Nombre completo del solicitante</label><label for="" class="text-danger">*</label>
        <input type="text" class="form-control"" name="client_name" placeholder="Ingrese el nombre del cliente" required>
        <label for="email">Correo electrónico</label><label for="" class="text-danger">*</label>
        <input type="text" class="form-control"" name="client_email" placeholder="Correo electrónico" required>
        <label for="phone">Telefono</label><label for="" class="text-danger">*</label>
        <input type="tel" class="form-control"" name="client_phone" placeholder="Número de teléfono" required>
        
    </div>
    <hr>
    <h2>Datos del vehiculo</h2>
    <div class="form-group">
    <label for="carrozado">Capacidad del carrozado</label><label for="" class="text-danger">*</label>
        <input type="number" class="form-control"" name="vehicle_capacity" placeholder="Ingrese la capacidad del vehiculo" required>
        <label for="carrozado">Modelo</label><label for="" class="text-danger">*</label>
        <input type="text" class="form-control"" name="vehicle_model" placeholder="Ingrese el modelo del vehiculo" required>
    </div>
    <hr>
    <h2> Términos y condiciones </h2>
    <div class="form-group">
        
        <label for="contrato">Contrato</label>
       <textarea name="budget_contract" id="" class="form-control" cols="30" rows="10" placeholder="Ingrese aquí los acuerdos del contrato"></textarea>
    </div>
    <hr>

    
    <h2>Equipamiento</h2>
    <div  id="inputContainer_equipment" class="form-group ">
        <button name="add" id="btn_add_input_equipment" class="btn btn-success" style="margin-left:15px">Agregar + </button>  
        <div id="input_div_equipment" class="d-flex m-2 p-2">
        <label for="equipment" class="p-2 m-2">Nombre</label> <label for="" class="text-danger">*</label>
        <input type="text" class="form-control" name="equipment_name[]" placeholder="Ingrese el nombre" required > 
        </div>
    </div>

    
    <hr>
    <h2>Materiales</h2>
    
    <div  id="inputContainer" class="form-group ">
        <button name="add" id="btn_add_input" class="btn btn-success" style="margin-left:15px">Agregar + </button>  
        <div id="input_div" class="d-flex m-2 p-2">
        <label for="material" class="p-2 m-2">Nombre</label> <label for="" class="text-danger">*</label>
        <input type="text" class="form-control" name="material_name[]" placeholder="Ingrese el material" required > 
        
        <label for="precio"  class="p-2 m-2">Precio</label> 
        <input type="number" class="form-control" name="material_price[]" placeholder="Ingrese el precio por unidad" > 

        <label for="precio"  class="p-2 m-2">Cantidad</label> 
        <input type="number" class="form-control" name="material_quantity[]" placeholder="Ingrese la cantidad" > 
        
        <label for="tipo"  class="p-2 m-2">Tipo</label> 
        <select name="material_type[]" required><label for="" class="text-danger">*</label>
            <option value="">Seleccione un tipo</option>
            <option value="Eléctricos">Eléctricos</option>
            <option value="Herrería">Herrería</option>
            <option value="Madera">Madera</option>
            <option value="Accesorios">Accesorios</option>
            <option value="Tapicería">Tapicería</option>
            <option value="Otro">Otro</option>

        </select>
        
        <button id="disabled-btn" onclick="delete_element(this)" class="btn btn-secondary" disabled>Eliminar</button>
        </div>
    </div>

    <hr>
    <h2>Instalaciones</h2>
    <div class="form-group">
        <label for="add to price">Añadir al precio final</label>
    <input type="checkbox" name="add_to_final_price_installs" value="false" class="form-control p-2">
    </div>
    
    <div  id="inputContainer_installs" class="form-group ">
        <button name="add" id="btn_add_input_install" class="btn btn-success" style="margin-left:15px">Agregar + </button>  
        <div id="input_div_installs" class="d-flex m-2 p-2">
        <label for="install" class="p-2 m-2">Detalle</label> 
        <input type="text" class="form-control" name="install_name[]" placeholder="Ingrese el nombre"  > 
        
        <label for="precio"  class="p-2 m-2">Valor</label> 
        <input type="number" class="form-control" name="install_price[]" placeholder="Ingrese el precio" > 

        <button id="disabled-btn_installs" onclick="delete_element(this)" class="btn btn-secondary" disabled>Eliminar</button>
        </div>
    </div>




    <h2>Opcionales</h2>
    <div class="form-group">
        <label for="add to price">Añadir al precio final</label>
    <input type="checkbox" name="add_to_final_price" value="false" class="form-control p-2">
    </div>
    <div  id="inputContainer_optionals" class="form-group ">
        <button name="add" id="btn_add_input_optional" class="btn btn-success" style="margin-left:15px">Agregar + </button>  
        <div id="input_div_optionals" class="d-flex m-2 p-2">
        <label for="optional" class="p-2 m-2">Nombre</label> 
        <input type="text" class="form-control" name="optional_name[]" placeholder="Ingrese el nombre"  > 
        
        <label for="precio"  class="p-2 m-2">Precio</label> 
        <input type="number" class="form-control" name="optional_price[]" placeholder="Ingrese el precio" > 

        <button id="disabled-btn_optionals" onclick="delete_element(this)" class="btn btn-secondary" disabled>Eliminar</button>
        </div>
    </div>


    <button id="submit" name="submit" class="btn btn-outline-primary mt-4" >Generar presupuesto</button>
</form>
</div>



<script>

//MATERIALS



    const container = document.querySelector('#inputContainer');
    document.getElementById("btn_add_input").addEventListener("click",add_element);


 


    let index = 1;

    function add_element(event){
        
        event.preventDefault();
    
        let input_div = document.createElement("div");
        input_div.id="input_div";
        input_div.className="d-flex m-2 p-2";
        input_div.innerHTML=` 
        
        <label for="material" class="p-2 m-2">Nombre</label> 
        <input type="text" class="form-control" name="material_name[]" placeholder="Ingrese el material" required > 
        
        <label for="precio"  class="p-2 m-2">Precio</label> 
        <input type="number" class="form-control" name="material_price[]" placeholder="Precio por unidad" > 
        <label for="precio"  class="p-2 m-2">Cantidad</label> 
        <input type="number" class="form-control" name="material_quantity[]" placeholder="Ingrese la cantidad" required > 
        <label for="tipo"  class="p-2 m-2">Tipo</label> 
        <select name="material_type[]" required>
            <option value="">Seleccione un tipo</option>
            <option value="Eléctricos">Eléctricos</option>
            <option value="Herrería">Herrería</option>
            <option value="Madera">Madera</option>
            <option value="Accesorios">Accesorios</option>
            <option value="Tapicería">Tapicería</option>
            <option value="Otro">Otro</option>

        </select>
        <button onclick="delete_element(this)" class="btn btn-danger">Eliminar</button>
        
        `;
        
        
        
        index = index++;
        container.appendChild(input_div);
    }

 
     
    function delete_element (event) {
            const daddy_div = event.parentNode;
            container.removeChild(daddy_div);
            index = index-1;
    } 

</script>

<script>

//OPTIONALS




    const container_optionals = document.querySelector('#inputContainer_optionals');
    document.getElementById("btn_add_input_optional").addEventListener("click",add_element_optional);

    let index_optional = 1;

    function add_element_optional(event){
        
        event.preventDefault();
    
        let input_div_optionals = document.createElement("div");
        input_div_optionals.id="input_div_optionals";
        input_div_optionals.className="d-flex m-2 p-2";
        input_div_optionals.innerHTML=` 
        
        <label for="material" class="p-2 m-2">Nombre</label> 
        <input type="text" class="form-control" name="optional_name[]" placeholder="Ingrese el nombre" required > 
        
        <label for="precio"  class="p-2 m-2">Precio</label> 
        <input type="number" class="form-control" name="optional_price[]" placeholder="Ingrese el precio"> 
        <button onclick="delete_element_optional(this)" class="btn btn-danger">Eliminar</button>
        
        `;
        
        
        
        index_optional = index_optional++;
        container_optionals.appendChild(input_div_optionals);
    }

 
     
    function delete_element_optional (event) {
            const daddy_div_optional = event.parentNode;
            container_optionals.removeChild(daddy_div_optional);
              index_optional =   index_optional-1;
    } 

</script>



<script>

//INSTALLS

    const container_installs = document.querySelector('#inputContainer_installs');
    document.getElementById("btn_add_input_install").addEventListener("click",add_element_install);

    let index_install = 1;

    function add_element_install(event){
        
        event.preventDefault();
    
        let input_div_installs = document.createElement("div");
        input_div_installs.id="input_div_installs";
        input_div_installs.className="d-flex m-2 p-2";
        input_div_installs.innerHTML=` 
        
        <label for="material" class="p-2 m-2">Nombre</label> 
        <input type="text" class="form-control" name="install_name[]" placeholder="Ingrese el nombre" required > 
        
        <label for="precio"  class="p-2 m-2">Precio</label> 
        <input type="number" class="form-control" name="install_price[]" placeholder="Ingrese el precio"> 
        <button onclick="delete_element_install(this)" class="btn btn-danger">Eliminar</button>
        
        `;
        
        
        
        index_install = index_install++;
        container_installs.appendChild(input_div_installs);
    }

 
     
    function delete_element_install (event) {
            const daddy_div_install = event.parentNode;
            container_installs.removeChild(daddy_div_install);
              index_install =   index_install-1;
    } 

</script>


<script>

//EQUIPMENT

    const container_equipment = document.querySelector('#inputContainer_equipment');
    document.getElementById("btn_add_input_equipment").addEventListener("click",add_element_equipment);

    let index_equipment = 1;

    function add_element_equipment(event){
        
        event.preventDefault();
    
        let input_div_equipment = document.createElement("div");
        input_div_equipment.id="input_div_equipment";
        input_div_equipment.className="d-flex m-2 p-2";
        input_div_equipment.innerHTML=` 
        
        <label for="material" class="p-2 m-2">Nombre</label> 
        <input type="text" class="form-control" name="equipment_name[]" placeholder="Ingrese el nombre" required > 
        <button onclick="delete_element_equipment(this)" class="btn btn-danger">Eliminar</button>
        
        `;
        
        
        
        index_equipment = index_equipment++;
        container_equipment.appendChild(input_div_equipment);
    }

 
     
    function delete_element_equipment (event) {
            const daddy_div_equipment = event.parentNode;
            container_equipment.removeChild(daddy_div_equipment);
              index_equipment =   index_equipment-1;
    } 

</script>
