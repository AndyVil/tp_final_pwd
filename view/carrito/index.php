<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$obj = new Formulario();
$arreglo = $obj->obtenerArchivos();
$sesion = new Session();
$datos = data_submited();

if (!$sesion->activa()) {
    //header('Location: ../login/index.php'); DESCOMENT
} else {
    list($sesionValidar, $error) = $sesion->validar();
    $escliente = $sesion->validarRol($sesion->getIdUser());
    if ($sesionValidar ) {
        include_once("../../estructura/cabeceraBT.php");
        if($escliente){

        }

    } else {
        header('Location: cerrarSesion.php');
    }
}
//HEADER============================================================================
?>
<div class="container">
    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5">Bienvenido al catalogo prro</h2>
        <hr>
    </div>

    <form id="catalogo" name="catalogo" method="POST" action="detallesProducto.php">
        <div class="row">
            <?php
            if($arreglo!==false) {
                foreach ($arreglo as $archivo) {
                    if (strlen($archivo) > 2 && strpos($archivo, "txt") <= 0  && strpos($archivo, "pdf") <= 0) {
                        echo    
                            "<div id='pelis' class='d-grid col-lg-2 col-sm-4 mb-4'>
                            <img class='img-fluid' alt='$archivo' src='../../uploads/$archivo' width='100%'>
                            <div class='d-grid align-items-end'>
                            <input type='hidden' name='nombre' id='Seleccion:$archivo' class='btn btn-primary' value='$archivo'>                            
                            <input type='submit' name='Seleccion:$archivo' id='Seleccion:$archivo' class='btn btn-primary' value='Ver detalles'>";
                        echo "</div>
                        </div>";
                    }
                }
            }
            ?>
        </div>
    </form>