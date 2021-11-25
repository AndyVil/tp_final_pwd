<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
//HEADER============================================================================
?>

<div class="container">


    <div align="center">
        <h2 class="mt-5">Cuenta</h2>
    </div>

    <div>
        <div align="center">
            <!-- Botones -->
            <button onclick="location.href='./cerrarSesion.php'" class="btn btn-dark">Cerrar Sesion</button>

            <?php
            $sesion = new Session();
            $rol = $sesion->obtenerRol();
            $cliente = $sesion->arrayRolesUser($rol);
            if ($cliente['Cliente'] == true) {
                echo '<button  class="btn btn-dark" onclick="location.href="./cerrarSesion.php"">Mis Compras</button>'; 
            }

            ?>

        </div>
        <br><br>
    </div>




</div>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>