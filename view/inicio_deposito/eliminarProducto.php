<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
//HEADER============================================================================
$datos = data_submited();
$id = $datos['proBorrar'];
?>
<!-- Titulo pagina -->
<div align="center">
    <h2 class="mt-5">Depósito</h2>
    <h3>Eliminar Producto</h3>
</div>

<div class="row my-5">
    <form class="mb-5" method="POST" action="abmProducto.php">
        <div class="d-flex justify-content-center">
            <?php
            echo "<input class='d-none' id='idproducto' name='idproducto' type='hidden' value='" . $id . "'>";
            echo "<div class='card text-center border border-3 border-primary' style='width: 25rem;'>
                <div class='card-body'>
                    <h4 class='card-title'>¡Atención!</h4>
                    <p class='card-text'>¿Realmente desea eliminar este Producto?</p>
                    <button href='#' class='btn btn-primary' id='accion' name='accion' type='submit' value='borrar' style='width: 3rem;'>Sí</button>
                    <button href='#' class='btn btn-primary' id='accion' name='accion' type='submit' value='noAccion' style='width: 3rem;'>No</button>
                </div>
            </div>";
            ?>
        </div>
    </form>
    <!-- Botones -->
    <div class="mb-5">
        <a class="btn btn-dark" href="index.php" role="button"><i class="fas fa-angle-double-left"></i> Regresar</a>
    </div>
</div>

<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>