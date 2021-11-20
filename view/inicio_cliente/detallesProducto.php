<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$obj = new Formulario();
$arreglo = $obj->obtenerArchivos();
$sesion = new Session();
$datos = data_submited();
$obj = new Formulario();
if(array_key_exists('mensaje', $datos)){
    $infoArchivo = $obj->obtenerArchivosPorId($datos["mensaje"]);
}
else{
    $infoArchivo = $obj->obtenerInfoDeArchivo($datos);


    $respuesta = $infoArchivo["Descripcion"];
    $link = $infoArchivo["link"];
    $dot = mb_strripos($link, ".");
    
    $id = substr($link, 0, $dot);
    $slash = mb_strripos($link, "/");
    
    $id = substr($id, $slash + 1);
    //var_dump($id);
    $actionCarrito = "action.php";
    $actionComprar = "action.php";
    
    //header('Location: ../login/index.php'); DESCOMENT
    if (array_key_exists('usnombre', $_SESSION) and array_key_exists('uspass', $_SESSION)) {
        list($sesionValidar, $error) = $sesion->validar();
        if ($sesionValidar) {
            $escliente = $sesion->validarRol($sesion->getIdUser());
            if ($escliente) {
                $actionCarrito = "carrito.php";
                $actionComprar = "comprar.php";
            }
        } else {
            //header('Location: cerrarSesion.php');
        }
    }
}



//HEADER============================================================================
?>

<div class="container">


    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5">Detalles de Producto</h2>
    </div>
    <form id="carrito" name="carrito" method="POST" action="<?= $actionCarrito ?>">
        <div class="row">
            <?php
            echo "<div class='alert alert-success mt-5' role='alert'>
                  <div class='row px-2 my-3'>
                <div class='col-lg-7 col-xl-8'>$respuesta</div>
                <div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "'>
                </div>";
            echo "<input type='submit' formaction='$actionCarrito' name='$id' id='Seleccion:$id' class='btn btn-primary' value='Agregar al carrito'>";
            echo "<input type='submit' formaction='$actionComprar' name='$id' id='Seleccion:$id' class='btn btn-primary' value='Comprar'>";

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