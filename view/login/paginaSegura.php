<?php
include_once '../../config.php';

$sesion = new Session();
$datos = data_submited();
if(array_key_exists("mensaje",$datos))
$mensaje=$datos["mensaje"];
if(array_key_exists("idproducto",$datos))
$mensaje=$datos["idproducto"];
//var_dump($datos);

if (!$sesion->activa()) {
    header('Location: index.php');
} else {
    list($sesionValidar, $error) = $sesion->validar();

    if ($sesionValidar && array_key_exists("idproducto",$datos)) {        
        header("Location: ../inicio_cliente/index.php?mensaje=". urlencode($mensaje));
   
    }
    elseif($sesionValidar){
        header("Location: ../inicio_cliente/index.php");
    } else {
        header('Location: cerrarSesion.php');
        
    }
}
?>

