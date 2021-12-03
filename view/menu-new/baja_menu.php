<?php
include_once '../../config.php';
$datos = data_submited();
$respuesta = false;

if (isset($datos['idmenu'])) {
    $objAbmMenu = new AbmMenu();
    $listMenu = $objAbmMenu->buscar($datos);
    $unMenu = $listMenu[0];
    $datos['menombre'] = $unMenu->getMenombre();
    $datos['idpadre'] = $unMenu->getObjMenu();
    $datos['medescripcion'] = $unMenu->getMedescripcion();
    #Si la fecha y hora seteada la convierte en 0000-00-00 00:00:00, si no es seteada coloca un timestamp
    if ($unMenu->getMedeshabilitado() != '0000-00-00 00:00:00' && $unMenu->getMedeshabilitado() != NULL) {
        $datos['medeshabilitado'] = '0000-00-00 00:00:00';
    } else {
        $datos['medeshabilitado'] = date('Y-m-d h:i:s'); #Timestamp
    }

    $respuesta = $objAbmMenu->modificacionBaja($datos);
    if (!$respuesta) {
        $mensaje = " La accion ELIMINACION No pudo concretarse";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {
    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
