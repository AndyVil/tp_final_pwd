<?php
require_once("../structure/Header.php");
//HEADER============================================================================
$obj = new Formulario();
$arreglo = $obj->obtenerArchivos();
$sesion = new Session();
$datos = data_submited();

$resultado = $obj->detallesProducto($datos);
$permisos = $obj->permisoCompra();
$_SESSION['detallesProducto'] = $resultado;
$_SESSION['datosDetalleProducto'] = $datos;
$_SESSION['permisos'] = $permisos;

header('Location: detallesProducto.php');
//FOOTER============================================================================
require_once("../structure/footer.php");
?>