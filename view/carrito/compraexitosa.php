<?php
require_once("../structure/Header.php");
//HEADER============================================================================
$datos = data_submited();
$sesion = new Session();
$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);

$carrito = new Carrito();
$resultado = $carrito->compraExitosa($datos);

$arreglo = $resultado['arreglo'];
$idcompra = $resultado['idcompra'];
$coprecio = $resultado['coprecio'];
$cofecha = $resultado['cofecha'];
//FOOTER============================================================================
require_once("../structure/footer.php");
?>