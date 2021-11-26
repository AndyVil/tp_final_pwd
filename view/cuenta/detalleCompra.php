<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$obj = new Formulario();
$abmCompra = new AbmCompra();
$abmitem = new AbmCompraItem();
$sesion = new Session();
$ambCompraEstado = new AbmCompraEstado();
$datos = data_submited();
$arreglo = array();

$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);

foreach ($datos as $clave => $valor) {
    $idcompra = str_replace("Seleccion:", '', $clave);
    $idcompraitem = str_replace("idcompraitem:", '', $clave);
}

$where = ["idcompra" => $idcompra];

$arreglo = $abmitem->buscar($where);
$colcompras = $abmCompra->buscar($where);
$compra = $colcompras[0];
$fecha = $compra->getcofecha();
$coprecio = $compra->getcompraprecio();




?>

<div class="container">
    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5">Detalle de la compra</h2>
        <hr>
    </div>
    <?php
    //var_dump($arreglo);
    if ($arreglo === false) {
        echo "<div class='alert alert-warning' role='alert' align=center>
                        No tienes nada en tu carrito aún.
                        </div>";
    } else {
        //var_dump($idcompra);
        echo "<form id='carrito' name='catalogo' method='POST' action='misCompras.php'>
            <div class='row'> ";
        echo '<div align="center">';
        echo "<input type='hidden' name='idcompra' id='idcompra'  value='$idcompra'>";
        echo "<input type='submit' name='Seleccion:$idcompraitem' id='Seleccion:$idcompraitem' class='btn btn-dark' value='Volver a mis compras'>";
        echo '</div>';
        foreach ($arreglo as $item) {
            //var_dump($archivo);
            $idcompra = $item->getidcompra();

            $idproducto = $item->getidproducto()->getidproducto();
            $proprecio = $item->getidproducto()->getidproducto();
            $ciprecio = $item->getciprecio();
            $idcompraitem = $item->getidcompraitem();
            $cicantidad = $item->getcicantidad();
            $procantstock = $item->getidproducto()->getprocantstock();
            $detalle = $item->getidproducto()->getprodetalle();
            $nombre = $item->getidproducto()->getpronombre();
            $archivos = $obj->obtenerArchivosPorId($idproducto);
            $link = $archivos["link"];
            echo "<div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px';>
            </div>";
            echo "<div>$nombre</div>";
            echo "<div>c/u: $$proprecio</div>";
            echo "<div>Productos: x$cicantidad</div>";
            echo "<div>:Precio: $$proprecio</div>";
            echo "</div>";
            echo "<input type='submit' formaction='../inicio_cliente/detallesProducto.php' name='Seleccion:$idproducto' id='Seleccion:$idproducto' class='btn btn-danger' value='Comprar de nuevo'>";
        }
        echo "<input type='submit'  name='idcompra' id='idcompra' class='btn btn-danger' value='$idcompra'>";
        echo "<h4>Lo compraste el $fecha</h4>";
        echo "<div>Precio total $$coprecio</div>";
    }
    ?>
    </form>
</div>
<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>