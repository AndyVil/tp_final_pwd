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
if (!$sesion->activa()) {
    header('Location: ../inicio_cliente/index.php');
} else {
    if (array_key_exists('usnombre', $_SESSION) and array_key_exists('uspass', $_SESSION)) {
        list($sesionValidar, $error) = $sesion->validar();
        if ($sesionValidar) {
            $roles = $sesion->obtenerRol();
            $escliente = $sesion->arrayRolesUser($roles);
            if ($escliente['Cliente'] == true) {
                $datos["idusuario"] = $sesion->getIdUser();
                if($carrito->eliminarItem($datos)){
                    echo "se elimino";
                    header('Location: index.php');
                }
                else{
                    echo "error al eliminar";
                }
            }

        } else {
            header('Location: ../inicio_cliente/index.php');
        }
    }
}
//HEADER============================================================================
?>



<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>