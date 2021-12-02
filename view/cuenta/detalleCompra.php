<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$datos = data_submited();
$obj = new Formulario();
$sesion = new Session();

$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);

$resultado = $obj->detalleCompra($datos);
$idcompraitem = $resultado['idcompraitem'];
$idcompra = $resultado['idcompra'];
$arreglo = $resultado['arreglo'];
$colcompras = $resultado['colcompras'];
$compra = $resultado['compra'];
$fecha = $resultado['fecha'];
$coprecio = $resultado['coprecio'];

//HEADER=============================================================================
?>

<div class="container">
    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5">Detalle de la compra</h2>
        <hr>
    </div>
    <?php
    if ($arreglo === false) {
        echo "<div class='alert alert-warning' role='alert' align=center>
                        No tienes nada en tu carrito aún.
                        </div>";
    } else {
        echo "<form id='carrito' name='catalogo' method='POST' action='misCompras.php'>
            <div class='row'> ";
        //echo '<div align="center">';
        echo "<input type='hidden' name='idcompra' id='idcompra'  value='$idcompra'>";
        echo "<input type='submit' name='Seleccion:$idcompraitem' id='Seleccion:$idcompraitem' class='btn btn-dark' value='Volver a mis compras'>";
        echo '</div>';
        foreach ($arreglo as $item) {
            $idproducto = $item->getidproducto()->getidproducto();
            $proprecio = $item->getidproducto()->getidproducto();
            $cicantidad = $item->getcicantidad();
            $nombre = $item->getidproducto()->getpronombre();
            $archivos = $obj->obtenerArchivosPorId($idproducto);
            $link = $archivos["link"];
            $detallesResultado =
                "<div class='d-grid col-lg-2 col-sm-4 mb-4'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px';>
            </div>" .
                "<div>$nombre</div>" .
                "<div>c/u: $$proprecio</div>" .
                "<div>Productos: x$cicantidad</div>" .
                "<div>Precio: $$proprecio</div>" .
                "<input type='submit' formaction='../inicio_cliente/detallesProducto.php' name='idproducto:$idproducto' id='idproducto:$idproducto' class='btn btn-danger' value='Comprar de nuevo'>";
            echo $detallesResultado;
        }
        echo "<input type='hidden'  name='idcompra' id='idcompra' value='$idcompra'>";
        echo "<h4>Lo compraste el $fecha</h4>";
        echo "<div>Precio total $$coprecio</div>";
        echo "</div>
        </form>";
    }
    ?>
</div>
</div>
<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>