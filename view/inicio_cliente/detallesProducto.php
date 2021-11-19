<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$obj = new Formulario();
$arreglo = $obj->obtenerArchivos();
$sesion = new Session();
$datos = data_submited();
$obj = new Formulario();
$infoArchivo = $obj->obtenerInfoDeArchivo($_POST);
$respuesta = $infoArchivo["Descripcion"];
$link = $infoArchivo["link"];

if (!$sesion->activa()) {
    //header('Location: ../login/index.php'); DESCOMENT
} else {
    list($sesionValidar, $error) = $sesion->validar();
    if ($sesionValidar) {
        include_once("../../estructura/cabeceraBT.php");
        $escliente = $sesion->validarRol($sesion->getIdUser());
    } else {
        header('Location: cerrarSesion.php');
    }
}
//HEADER============================================================================
?>

<div class="container">


    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5">Detalles de Producto</h2>
    </div>

    <?php
    echo "
    <div class='alert alert-success mt-5' role='alert'>
        <div class='row px-2 my-3'>
            <div class='col-lg-7 col-xl-8'>$respuesta</div>
            <div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "'></div>";
            if($escliente){
                $carrito = "agregarcarrito.php";
                $comprar = "compra directa.php";
            }
            {
                $carrito = "login.php";
                $comprar = "login.php";
            }
    echo "</div>
    </div>";
    ?>

</div>
<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>