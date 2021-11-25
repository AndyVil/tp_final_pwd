<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$datos = data_submited();
$id = $datos['roldelete'];
//HEADER============================================================================
?>
<div align="center">
    <h2 class="mt-5">Administración</h2>
    <h3>Eliminar LOG IN</h3>
    <!-- Botones -->
    <div class="mb-5">
        <a class="btn btn-dark" href="listarUsuarios.php" role="button"><i class="fas fa-angle-double-left"></i>Regresar a lista de usuarios</a>
    </div>
</div>

<div class="row my-5">
    <form class="mb-5" id="eliminarLogin" method="POST" action="abmUsuario.php">
        <div class="d-flex justify-content-center">
            <?php
            echo "<input class='d-none' id='idusuario' name='idusuario' type='hidden' value='" . $id . "'>";
            echo "<div class='container' style='width: 25rem;' align='center'>
                <div class='card-body'>
                    <h4 class='mt-4'>¿Realmente desea eliminar este Usuario?</h4>
                    <button href='#' formaction='listarUsuarios.php' class='btn btn-primary' id='accion' name='accion' type='submit' value='noAccion' style='width: 3rem;'>No</button>
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