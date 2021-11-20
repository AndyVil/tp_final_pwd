<?php
include_once '../../config.php';

$sesion = new Session();
$datos = data_submited();
if(array_key_exists("mensaje",$datos))
$mensaje=$datos["mensaje"];
//var_dump($mensaje);

if (!$sesion->activa()) {
    header('Location: login.php');
} else {
    list($sesionValidar, $error) = $sesion->validar();
    if ($sesionValidar) {        
        header("Location: ../inicio_cliente/index.php?mensaje=". urlencode($mensaje));
   
    } else {
        header('Location: cerrarSesion.php');
        
    }
}
?>

