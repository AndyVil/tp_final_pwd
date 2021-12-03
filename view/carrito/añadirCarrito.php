<?php
require_once("../structure/Header.php");
//HEADER============================================================================
$sesion = new Session();
$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);

$datos = data_submited();
$carrito = new Carrito();
$carrito -> aniadirCarrito($datos);
header('Location: index.php?message=Se agrego al carrito!');
//FOOTER============================================================================
require_once("../structure/footer.php");
?>