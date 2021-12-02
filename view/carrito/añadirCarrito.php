<?php
require_once("../structure/Header.php");

$sesion = new Session();
$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);

$datos = data_submited();
$carrito = new Carrito();
$carrito -> aniadirCarrito($datos);
#Cargo la informacion que cargo en el formulario cuando ingreso un carrito
$resultado = $carrito -> ingresoCarrito($datos);

$link = $resultado["link"];
$id = $resultado["id"];
$precio = $resultado["precio"];
$nombre = $resultado["nombre"];
$stock = $resultado["stock"];
$detalle = $resultado["detalle"];


//HEADER============================================================================
?>
<div class="container">
    <!-- Titulo pagina -->
    <div align="center">
        <div class='alert alert-success mt-5' role='alert' align=center>
            ¡Añadiste <?= $nombre ?> a tu carrito!
        </div>
    </div>
    <form id="carrito" name="carrito" method="POST" action="index.php">
        <div class="row mx-6">
            <?php
            echo "<div class='alert alert-success' role='alert' >
                  <div class='row px-2 my-4 justify-content-center'>

                <div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px';>
                </div>";
            echo "<div align='center'>";
            echo "<input type='hidden' name='idproducto' id='idproducto' value='$id' >";

            echo "<input type='hidden' name='ciprecio' id='ciprecio' value='$precio'>";
            echo ' ';
            //echo "<input type='submit' formaction='$actionCarrito' name='$id' id='Seleccion:$id' class='btn btn-warning' value='Agregar al carrito'>";
            //echo "<input type='number' name='cicantidad' id='cicantidad' value='1'>";
            echo "<input type='submit' formaction='../inicio_cliente/index.php' class='btn btn-light' value='Seguir comprando'>";
            echo " ";
            echo "<input type='submit' name='$id' id='Seleccion:$id' class='btn btn-light' value='Ver el carrito'>";



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