<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/header.php");
//HEADER============================================================================
$url = data_submited();
$dir = "../inicio_cliente/index.php";
$rol = "Deposito";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);

$datos = data_submited();
$formulario = new Formulario();
$producto = $formulario->actualizarProducto($datos);
#Enviando datos a otra pagina
$_SESSION['actualizarProducto'] = $producto;
header('Location:formActualizarProducto.php');
//FOOTER============================================================================
require_once("../structure/footer.php");
?>