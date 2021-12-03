<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$sesion = new Session();
$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);
//HEADER============================================================================
?>

<div class="container">
    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5">Compras</h2>
        <hr>
    </div>
    <?php
    $arregloRes = $_SESSION['misCompras'];
    echo $arregloRes[1];
    $arreglo = $arregloRes[0];
    if ($arreglo === false) {
        echo "<div class='alert alert-warning' role='alert' align=center>
                        No tienes ningun articulo comprado aun.
                        </div>";
    } else {
        echo "<form id='aceptadas' name='catalogo' method='POST' action='ActionDetalleCompra.php'>
            <div class='row'> ";

        foreach ($arreglo as  $archivo) {
            $idcompra = $archivo["idcompra"];
            $link = $archivo["link"];
            $iditem = $archivo["iditem"];
            
            $idproducto = $archivo["idproducto"];
            $proprecio = $archivo["proprecio"];
            $ciprecio = $archivo["ciprecio"];
            $idcompraitem = $archivo["idcompraitem"];
            $cicantidad = $archivo["cicantidad"];
            $fecha = $archivo["fecha"];
            $nombre = $archivo["nombre"];            

          
            echo
            "<div id='productos' class='col-lg-2 col-sm-4 mb-4'>
                        <h4 align='center'>$nombre</h4>
                        <img class='img-fluid' alt='$link' src='$link' width='100%'>
                        <div class='d-grid align-items-end'>

						<div>Fecha de Compra:<br>$fecha</div>
						<div>Precio Total: $$ciprecio</div>
						</div>
                        <input type='submit' name='Seleccion:$idcompra' id='Seleccion:$idcompra' class='btn btn-light' value='Ver detalles de compra'>";

            echo "</div>";
            //<input type='hidden' name='idcompraitem:$idcompraitem' id='idcompraitem:$idcompraitem' value='$idcompraitem'>                            

        }
    }
    ?>
    </form>
</div>

    <?php
    //FOOTER============================================================================
    require_once("../structure/footer.php");
    ?>