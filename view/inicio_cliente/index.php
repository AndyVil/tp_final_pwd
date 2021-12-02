<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$datos = data_submited();
$obj = new Formulario();
$arreglo = $obj->obtenerArchivos();
if (array_key_exists('message', $datos)){

    $mensaje = $datos["message"];
    echo "<div class='alert alert-danger' role='alert' align=center>
    $mensaje
  </div>
  ";
}
if (array_key_exists('mensaje', $datos)) {
    $id = $datos["mensaje"];
    header("Location: ../inicio_cliente/detallesProducto.php?mensaje=" . urlencode($id));
}


//HEADER============================================================================
?>
<div class="container">
    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5">Catalogo</h2>
        <hr>
    </div>

    <form id="catalogo" name="catalogo" method="POST" action="detallesProducto.php">
        <div class="row">
            <?php
            if ($arreglo !== false) {
                foreach ($arreglo as $archivo) {
                    if (strlen($archivo) > 2 && strpos($archivo, "txt") <= 0  && strpos($archivo, "pdf") <= 0) {
                        echo
                        "<div id='productos' class='d-grid col-lg-2 col-sm-4 mb-4' id='productosLista'>
                            <img class='img-fluid' alt='$archivo' src='../../uploads/$archivo' width='100%'>
                            <div class='d-grid align-items-end'>
                            <input type='hidden' name='nombre' id='Seleccion:$archivo' class='btn btn-light' value='$archivo'>                            
                            <input type='submit' name='Seleccion:$archivo' id='Seleccion:$archivo' class='btn btn-light' value='Ver detalles'>";
                        echo "</div>
                        </div>";
                    }
                }
            }
            ?>
        </div>
    </form>



























</div>
<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>