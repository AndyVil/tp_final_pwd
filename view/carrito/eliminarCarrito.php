<?php
require_once("../structure/Header.php");
//HEADER============================================================================
$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);

$datos = data_submited();
$carrito = new Carrito();
$carrito->eliminarCarrito($datos);

//FOOTER============================================================================
require_once("../structure/footer.php");
?>