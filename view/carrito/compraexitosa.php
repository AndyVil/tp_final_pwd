<?php
require_once("../structure/Header.php");
$datos = data_submited();
$sesion = new Session();
$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);

$carrito = new Carrito();
$resultado = $carrito->compraExitosa($datos);

$arreglo = $resultado['arreglo'];
$idcompra = $resultado['idcompra'];
$coprecio = $resultado['coprecio'];
$cofecha = $resultado['cofecha'];

//HEADER============================================================================
?>
<div class="container">


    <!-- Titulo pagina -->
    <div align="center">
        
    </div>
    <form id="carrito" name="carrito" method="POST" action="../cuenta/detalleCompra.php">
        <div class="row">
            <?php    
            echo "<div class='alert alert-success mt-5' role='alert'>";

            foreach ($arreglo as $item) {

                $proprecio = $item["proprecio"];
                $idproducto = $item["idproducto"];
                $cicantidad = $item["cicantidad"];
                $nombre = $item["pronombre"];
                $link = $item["link"];
                $ciprecio = $item["ciprecio"];
                $procantstock = $item["procantstock"];
                $detalle = $item["prodetalle"];                

                echo "<h2 class='mt-5' align='center'>Compraste: $nombre </h2>";
                echo "
                <div class='row px-2 my-4 justify-content-center'>               
                <div class='col-lg-7 col-xl-8'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px;'>
                </div>";
                echo "<input type='hidden' name='idcompra' id='idcompra' value='$idcompra'>";
                echo "<div class='col-lg-7 col-xl-8'>Precio unitario: $proprecio</div>";
                echo "<div class='col-lg-7 col-xl-8'>Cantidad: $cicantidad</div>";
                echo "<div class='col-lg-7 col-xl-8'> Precio total: $$ciprecio</div>";
                echo "<input type='hidden' name='ciprecio' id='ciprecio' value='$ciprecio'>";
                echo ' '; 
                }
                ################################################################################################################################################################
                echo "<br><div class='container' align='center'><hr></div>";
                echo '<div align="center">';
                echo "<h4 class='col-lg-7 col-xl-8'> Precio total de compra: $$coprecio</h4>";
                echo "<h5 class='col-lg-7 col-xl-8'> Lo compraste el: $cofecha</h5>";
                echo "<input type='submit'  name='$idcompra' id='Seleccion:$idcompra' class='btn btn-light' value='Ver detalles'>";
                echo " ";
                echo "<input type='submit' formaction='../inicio_cliente/index.php' name='$idcompra' id='Seleccion:$idcompra' class='btn btn-light' value='Volver al catalogo'>";
                echo '</div>';
                echo "</div>";
                echo " ";
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