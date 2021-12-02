<?php
require_once("../structure/header.php");
$dir = "../inicio_cliente/index.php";
$rol = "Administrador";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);
//HEADER================================================================================
$datos = data_submited();
$formulario = new Formulario();
$formulario->controlUsuario($datos);
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>