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
//var_dump($datos);

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
                $compras = $ambCompra->buscar($datos);
                $objcarrito = array();
                if (count($compras) > 0) {
                    foreach ($compras as $compra) {
                        $where['idcompra'] = $compra->getidcompra();
                        $where['idcompraestadotipo'] = 1;
                        //var_dump($where);
                        $objcarrito = $ambCompraEstado->buscar($where);
                        if (count($objcarrito) > 0) {
                            break;
                        }
                    }
                }
                if (count($compras) == 0 && count($objcarrito) == 0) {
                    list($idcompra, $resp) = $carrito->crearcompra($datos, 1);
                } elseif (count($objcarrito) > 0) {
                    //echo "entro a añadir nuevo item";
                    $idcompra = $objcarrito[0]->getidcompra();
                    $datos["idcompra"] = $idcompra;
                    $datos["idcompraitem"] = "DEFAULT";
                    $resp = $carrito->sumarItem($datos);
                    //echo $resp;
                }
            }
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
        <div class='alert alert-success mt-5' role='alert' align=center>
            ¡Añadiste a tu carrito!
        </div>
    </div>
    <form id="carrito" name="carrito" method="POST" action="index.php">
        <div class="row">
            <?php
            echo "
            <div class='alert alert-success mt-5' role='alert'>
                <div class='row px-2 my-3'>
                    <div class='col-lg-7 col-xl-8'>$respuesta</div>
                <div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "'>
                </div>";
            echo "<input type='hidden' name='idproducto' id='idproducto' value='$id' >";
            echo "<input type='hidden' name='cicantidad' id='cicantidad' value='1' >";
            echo "<input type='hidden' name='ciprecio' id='ciprecio' value='$precio' >";
            echo '<div align="center">';
            echo    "<input type='submit' class='btn btn-light' value='Ver el carrito'>";
            echo    ' ';
            echo    "<input type='submit' formaction='comprarCarrito.php' class='btn btn-light' value='Comprar carrito'>";
            echo '</div>';
            echo "</div>
            </div>";
            ?>
        </div>
    </form>

</div>



<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>