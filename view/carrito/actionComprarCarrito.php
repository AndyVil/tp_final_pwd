<?php
require_once("../structure/header.php");
//HEADER=================================================================================
$datos = data_submited();
$control = new cargaDatos();
$resultado = $control->cargarCarrito($datos);
$_SESSION['cargarCarrito'] = $resultado;
header('Location: comprarCarrito.php');
//FOOTER=================================================================================
require_once("../structure/footer.php");