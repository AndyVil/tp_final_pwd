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
            $type = "hidden";

            $usuario = new AbmUsuario();
            $idUsuario = [];
            $idUsuario['idusuario'] = $sesion->getIdUser();
            $user = $usuario->buscar($idUsuario);
            $mail = $user[0]->getusmail();

            
            if ($cliente['Cliente'] == true) {
                $ref = "actionMisCompras.php";
                $type = "button";

                echo '<form action="action.php" method="POST">';
                echo '<br><br><input type="text" id="emailCambio" name="emailCambio" placeholder="Nuevo Email" value="'.$mail. '"> '; 
                echo "<button class='btn btn-light' id='accion' name='accion' value='editar'>Cambiar email</button><br><br>";
                echo '</form>';
            }

            ?>
            <input type="<?=$type?>" value="Mis Compras" class="btn btn-dark" onclick="location.href='<?=$ref?>'">


        </div>
        <br><br>
    </div>




</div>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>