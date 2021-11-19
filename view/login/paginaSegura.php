<?php
include_once '../../config.php';

$sesion = new Session();
$datos = data_submited();

if (!$sesion->activa()) {
    header('Location: login.php');
} else {
    list($sesionValidar, $error) = $sesion->validar();
    if ($sesionValidar) {
        
        header("Location: ../inicio_cliente/index.php");
   
    } else {
        header('Location: cerrarSesion.php');
        
    }
}
?>

