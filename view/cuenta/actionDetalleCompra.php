<?php
require_once("../structure/Header.php");
//HEADER=============================================================================
$datos = data_submited();
$obj = new Formulario();
foreach ($datos as $clave => $valor) {
$idcompra = str_replace("Seleccion:", '', $clave);
}
$datos["idcompra"] = $idcompra;
$resultado = $obj->detalleCompra($datos);
$_SESSION['detalleCompra'] = $resultado; 
header('Location:detalleCompra.php');
//FOOTER============================================================================
require_once("../structure/footer.php");
?>