<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
//HEADER============================================================================
$datos = data_submited();
$id = $datos['proBorrar'];
$dir = "../inicio_cliente/index.php";
$rol = "Deposito";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);
?>
<!-- Titulo pagina -->
<div align="center">
    <h2 class="mt-5">Depósito</h2>
    <h3>Eliminar Producto</h3>
    <!-- Botones -->
    <div class="mb-5">
        <a class="btn btn-dark" href="index.php" role="button"><i class="fas fa-angle-double-left"></i>Regresar a lista de productos</a>
    </div>
</div>

<div class="row my-5">
    <form class="mb-5" method="POST" action="abmProducto.php">
        <div class="d-flex justify-content-center">
            <?php
            echo "<input class='d-none' id='idproducto' name='idproducto' type='hidden' value='" . $id . "'>";
            echo "<div class='container' style='width: 25rem;' align='center'>
                <div class='card-body'>
                    <h4 class='mt-4'>¿Realmente desea eliminar este Producto?</h4>
                        <button href='#' formaction='./index.php' class='btn btn-primary' id='accion' name='accion' type='submit' value='noAccion' style='width: 3rem;'>No</button>
                        <button href='#' class='btn btn-danger' id='accion' name='accion' type='submit' value='borrar' style='width: 3rem;'>Sí</button>
                </div>
            </div>";
            ?>
        </div>
    </form>

</div>

<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>