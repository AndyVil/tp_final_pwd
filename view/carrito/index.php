<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);

$carrito = new Carrito();
$arreglo = $carrito->arregloCarrito();

//HEADER============================================================================
?>
<div class="container">
    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5">Carrito</h2>
        <hr>
    </div>
    <?php
    if ($arreglo === false) {
        echo "<div class='alert alert-warning' role='alert' align='center'>
                        No tienes nada en tu carrito aún.
                        </div>";
    } else {
        echo "<form id='carrito' name='catalogo' method='POST' action='eliminarCarrito.php'>
            <div class='row'> ";
        echo "<input type='submit' formaction='comprarCarrito.php' name='compracarrito' id='compracarrito' class='btn btn-light' value='Comprar carrito' style='margin-bottom: 10px;'>";
        foreach ($arreglo as $archivo) {
            $idcompra = $archivo["idcompra"];
            $link = $archivo["link"];
            $idproducto = $archivo["idproducto"];
            $proprecio = $archivo["proprecio"];
            $ciprecio = $archivo["ciprecio"];
            $idcompraitem = $archivo["idcompraitem"];
            $cicantidad = $archivo["cicantidad"];
            $procantstock = $archivo["procantstock"];
            $detalle = $archivo["prodetalle"];
            $nombre = $archivo["pronombre"];
            echo
            "<div id='pelis' class='d-grid col-lg-2 col-sm-4 mb-4'>
                    <img class='img-fluid' alt='$link' src='$link' width='100%'>
                    <div class='d-grid align-items-end'>
                    <div align='center'>x$cicantidad </div>
                    <input type='hidden' name='imagen' id='imagen' value='$link'> 
                    <input type='hidden' name='proprecio' id='proprecio' value=$proprecio'> 
                    <input type='hidden' name='ciprecio' id='v' value='$ciprecio'> 
                    <input type='hidden' name=''idcompraitem' id='idcompraitem' value='$idcompraitem'> 
                    <input type='hidden' name='cicantidad' id='cicantidad' value='$cicantidad'> 
                    <input type='hidden' name='idproducto' id='idproducto' value='$idproducto'> 
                    <input type='hidden' name='idcompra' id='idcompra' value='$idcompra'>
                    <input type='hidden' name='nombre' id='Seleccion:$link' class='btn btn-primary' value='$link'>                            
                    <input type='submit' name='Seleccion:$idcompraitem' id='Seleccion:$idcompraitem' class='btn btn-danger' value='Eliminar'>
            </div>
            </div>";
        }
    }
    ?>
    </form>
    </div>
    <?php
    //FOOTER============================================================================
    require_once("../structure/footer.php");
    ?>