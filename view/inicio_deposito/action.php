<?php
require_once("../structure/header.php");
$url = data_submited();
$dir = "../inicio_cliente/index.php";
$rol = "Deposito";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);
//HEADER=================================================================================
$datos = data_submited();
$control = new Formulario();
$respuesta = $control->actionProducto($datos);
header($respuesta);
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>