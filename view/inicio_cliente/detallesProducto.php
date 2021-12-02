<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$obj = new Formulario();
$arreglo = $obj->obtenerArchivos();
$sesion = new Session();
$datos = data_submited();


if (array_key_exists('stock', $datos)) {
    $datos["idproducto"] = $datos["stock"];
    echo "<div class='alert alert-danger' role='alert' align=center>
    ¡La cantidad ingresada del item de tu carrito supera el stock intenta nuevamente!
    </div>";
}

$resultado = $obj->detallesProducto($datos);
$link = $resultado['link'];
$id = $resultado['id'];
$precio = $resultado['precio'];
$nombre = $resultado['nombre'];
$stock = $resultado['stock'];
$detalle = $resultado['detalle'];


$resultado = $obj->permisoCompra();
$actionCarrito = $resultado['actionCarrito'];
$actionComprar = $resultado['actionComprar'];
$comprar = $resultado['comprar'];




//HEADER============================================================================
?>

<div class="container">


    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5"><?= $nombre ?></h2>
    </div>
    <form id="carrito" name="carrito" method="POST" action="<?= $actionCarrito ?>">
        <div class="row">
            <input type="hidden" name="compraHabilitada" id="compraHabilitada" value="<?= $comprar?>">
            <?php
            echo "<div class='alert alert-success mt-5' role='alert'>
                  <div class='row px-2 my-4 justify-content-center'>

                <div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px';>
                </div>";
            echo "<div align='center'>";
            echo "<input type='hidden' name='idproducto' id='idproducto' value='$id' >";
            echo "<input type='hidden' name='procantstock' id='procantstock' value='$stock' >";
            echo "<input type='hidden' name='pronombre' id='nombre' value='$nombre' >";
            echo "<input type='hidden' name='prodetalle' id='prodetalle' value='$detalle' >";
            echo "<input type='hidden' name='proprecio' id='idproducto' value='$precio' >";

            echo "<input type='hidden' name='ciprecio' id='ciprecio' value='$precio'>";
            echo ' ';
            //echo "<input type='submit' formaction='$actionCarrito' name='$id' id='Seleccion:$id' class='btn btn-warning' value='Agregar al carrito'>";

            if ($stock > 0) {
                echo '<div id="botonesCompra">';
                echo "<input min='1' max='$stock' type='number' name='cicantidad' id='cicantidad' value='1'>";
                echo "
                <button formaction='$actionCarrito' name='$id' id='Seleccion:$id' class='btn btn-warning' style='width:40; height:40;'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cart-plus-fill' viewBox='0 0 16 16'>
                        <path d='M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z' />
                    </svg>
                </button>";
                echo " ";
                echo "<input type='submit' formaction='$actionComprar' name='$id' id='Seleccion:$id' class='btn btn-success' value='Comprar'>";
                echo "</div>";
            } else {
                echo "
                <div class='alert alert-danger mt-3' role='alert' align=center>
                Stock agotado
                </div>";
            }


            echo "</div>";
            echo "
            <div class='alert alert-warning mt-3' role='alert' align=center>
            Precio: $$precio
            </div>";
            echo "<div class='col-lg-7 col-xl-8'>Stock: $stock</div>
                
            <div class='col-lg-7 col-xl-8'>Descripcion: $detalle</div>";
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