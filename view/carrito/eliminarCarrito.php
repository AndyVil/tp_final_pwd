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
                if($carrito->eliminarItem($datos)){
                    $obj = new Formulario;
                    $infoArchivo = $obj->obtenerArchivosPorId($datos["idproducto"]);
                    $respuesta = $infoArchivo["Descripcion"];
                    $link = $infoArchivo["link"];
                    //var_dump($infoArchivo);
                    //var_dump($link);
                    $cicantidad = $datos["cicantidad"];
                    $ciprecio = $datos["ciprecio"];
                    $id = $datos["idproducto"];
                    $where = ['idproducto' => $id];
                    $productos = $Abmproducto->buscar($where);
                    $precio = $productos[0]->getproprecio();
                    array_push($arreglo, $link);
                }
                else{
                    $arreglo = false;
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
    <h2 class="mt-5">Añadiste a tu carrito</h2>
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
        echo "<div>Cantidad: $cicantidad</div>";
        echo "<div>Precio unitario: $precio</div>";
        echo "<div>Precio total: $ciprecio</div>";
        echo "<input type='hidden' name='ciprecio' id='ciprecio' value='$precio' >";
        echo '<div align="center">';
        echo    "<input type='submit' class='btn btn-light' value='Ver el carrito'>";
        echo    ' ';
        echo    "<input type='submit' formaction='/inicio_cliente/index.php' class='btn btn-light' value='ver el Catalogo'>";
        echo '</div>';
        echo "</div>
        </div>";
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