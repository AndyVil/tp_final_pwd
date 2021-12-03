<?php
include_once '../../config.php';
$data = data_submited();
$respuesta = false;
if (isset($data['menombre'])) {
    $objC = new AbmMenu();
    $respuesta = $objC->alta($data);
    if (!$respuesta) {
        $mensaje = " La accion  ALTA No pudo concretarse";
    }
} else {
    $sms_error = " La accion  ALTA No pudo concretarse";
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
