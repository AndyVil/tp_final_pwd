<?php
require_once("../structure/Header.php");
$datos = data_submited();
$sesion = new Session();
$ambCompra = new AbmCompra();
$ambitem = new AbmCompraItem();
$carrito = new Carrito();
$Abmproducto = new AbmProducto();
$ambCompraEstado = new AbmCompraEstado();
$ambCompraEstadoTipo = new AbmCompraEstadoTipo();
$arreglo = array();
//var_dump($datos);
foreach ($datos as $clave => $valor) {
    $idcompraitem = str_replace("Seleccion:", '', $clave);
    
}
$datos["idcompraitem"] = $idcompraitem;
$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);
if($carrito->eliminarItem($datos)){    
    header('Location: index.php');
}
//HEADER============================================================================
?>



<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>