<?php

use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();

$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isJavascriptEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->getOptions()->setChroot(plugin_dir_url( __DIR__ ));
$dompdf->setPaper('A4', 'portrait');



if( isset($_POST['print-pdf'])){


ob_start();

include "budget.php";
$html = ob_get_clean();
//dompdf options


$dompdf->loadHtml($html);


$dompdf->render();
$output = $dompdf->output();
//save pdf
$file_name = "presupuesto_". $_POST['budget_id'] .".pdf";
file_put_contents($file_name,$output);
$upload = wp_upload_bits($file_name , null, $output);




echo '<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Presupuesto generado</h4>
  <p>El presupuesto se ha generado correctamente.</p>
  <hr>
  <p class="mb-0">Puede descargarlo haciendo click en el siguiente enlace:</p>
  <a href="'.$file_name.'" target="_blank" class="btn btn-primary">Descargar</a>';

}



?>