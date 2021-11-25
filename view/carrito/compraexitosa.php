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

if (!$sesion->activa()) {
    header('Location: ../inicio_cliente/index.php');
} else {
    if (array_key_exists('usnombre', $_SESSION) and array_key_exists('uspass', $_SESSION)) {
        list($sesionValidar, $error) = $sesion->validar();
        if ($sesionValidar) {
            $escliente = $sesion->validarRol(3);
            if ($escliente) {
                if (array_key_exists("idcompra", $datos)) {
                    $resp = $carrito->confirmarcarrito($datos);
                    $items = $ambitem->buscar($datos);
                    foreach ($items as $item) {
                        $obj = new Formulario;
                        $infoArchivo = $obj->obtenerArchivosPorId($datos["idproducto"]);
                        $respuesta = $infoArchivo["Descripcion"];
                        $link = $infoArchivo["link"];
                        //var_dump($infoArchivo);
                        //var_dump($link);
                        $id = $datos["idproducto"];
                        $where = ['idproducto' => $id];
                        $productos = $Abmproducto->buscar($where);
                        $precio = $productos[0]->getproprecio();
                        array_push($arreglo, $link);
                    }
                } else {
                    $datos["idusuario"] = $sesion->getIdUser();
                    list($idcompra, $resp) = $carrito->crearcompra($datos, 2);
                    echo "Exito al carga de la compra: " . $resp;
                    $obj = new Formulario;
                    $infoArchivo = $obj->obtenerArchivosPorId($datos["idproducto"]);
                    $respuesta = $infoArchivo["Descripcion"];
                    $link = $infoArchivo["link"];
                    //var_dump($infoArchivo);
                    //var_dump($link);
                    $id = $datos["idproducto"];
                    $where = ['idproducto' => $id];
                    $productos = $Abmproducto->buscar($where);
                    $precio = $productos[0]->getproprecio();
                    array_push($arreglo, $link);
                }
            }

        } else {
            header('Location: ../inicio_cliente/index.php');
        }
    }
}
//HEADER============================================================================
?>
<div class="container">


    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5">Compraste</h2>
    </div>
    <form id="carrito" name="carrito" method="POST" action="index.php">
        <div class="row">
            <?php
            if (count($arreglo) === false) {
                echo "<div class='alert alert-warning' role='alert' align=center>
                        No tienes nada en tu carrito aún.
                        </div>";
            } else {
                echo "<form id='carrito' name='catalogo' method='POST' action='eliminaritem.php'>
            <div class='row'> ";
                echo "<input type='submit' formaction='action.php' name='idcompra' id='idcompra' class='btn btn-primary' value='Comprar carrito'>";
                foreach ($arreglo as $archivo) {
                    if (strlen($archivo) > 2 && strpos($archivo, "txt") <= 0  && strpos($archivo, "pdf") <= 0) {
                        echo
                        "<div id='pelis' class='d-grid col-lg-2 col-sm-4 mb-4'>
                        <img class='img-fluid' alt='$archivo' src='$archivo' width='100%'>
                        <div class='d-grid align-items-end'>
                        <input type='hidden' name='nombre' id='Seleccion:$archivo' class='btn btn-primary' value='$archivo'>                            
                        <input type='submit' name='Seleccion:$archivo' id='Seleccion:$archivo' class='btn btn-primary' value='Eliminar'>";
                        echo "</div>
                    </div>";
                    }
                }
            }
            ?>
        </div>
    </form>

</div>



<?php
$compraExitosa = 'compra exitosa';
header('Location:../cuenta/miscompras.php?mensaje='. urlencode($compraExitosa));

//FOOTER============================================================================
require_once("../structure/footer.php");
?>