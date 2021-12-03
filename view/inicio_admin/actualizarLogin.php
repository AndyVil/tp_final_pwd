<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$dir = "../inicio_cliente/index.php";
$rol = "Administrador";
$sesion = new Session();
$datos = data_submited();
$sesion->permisoAcceso($dir, $rol);

$esSuperuser = $_SESSION['esSuperuser'];
$respuesta = $_SESSION['actionLogin'];
$allrol = $respuesta['allrol'];
$unUsuario = $respuesta['unUsuario'];
$colrol = $respuesta['colrol'];

if(array_key_exists('roledit', $datos)){
    if ($datos["roledit"] == 1) {
        header('Location: listarUsuarios.php?mensaje=' . urldecode('No puede deshabilitar este usuario'));
    }
}


//HEADER============================================================================
?>
<div align="center">
    <h2 class="mt-5">Administración</h2>
    <a class="btn btn-dark" href="listarUsuarios.php" role="button"><i class="fas fa-angle-double-left"></i>Regresar a usuarios</a>
    <br>
    <br>
    <h3>Actualizar LOG IN</h3>
</div>

<div class="container">
    <form id="actualizarLogin" method="POST" action="actionUsuario.php">
        <?php

        if (count($unUsuario) > 0) {

            $user = $unUsuario[0];
            $nombre = $user->getusnombre();
            $mail = $user->getusmail();
            $usdeshabilitado = $user->getusdeshabilitado();
            $id = $user->getidusuario();
            $uspass = $user->getuspass();

            echo "<hr>";
            echo "<div align='center'>";
            echo '<label for="usmail">Email</label> <br>';
            echo '<input name="usmail" id="usmail" type="text" placeholder="Nuevo email" value="' . $mail . '">';
            echo '</div>';
            echo "<br>";

            echo '<tr class="align-middle">';
            echo '<input id="usnombre" name="usnombre" type="hidden" value="' . $nombre . '">';
            echo '<input id="usdeshabilitado" name="usdeshabilitado" type="hidden" value="' . $usdeshabilitado . '">';
            echo '<input id="idusuario" name="idusuario" type="hidden" value="' . $id . '">';
            echo '<input id="uspass" name="uspass" type="hidden" value="' . $uspass . '">';
            $i = 0;
            echo "<div align='center' id='roles'>        
            <span>Roles:</span><br>";

            foreach ($allrol as $rol) {
                $check = "";
                $checkeado = false;
                $descripcion = $rol->getroldescripcion();
                $id = $rol->getidrol();
                foreach ($colrol as $rolactual) {
                    $idus = $rolactual->getobjrol()->getidrol();
                    if ($id == $idus) {
                        $checkeado = true;
                    }
                }
                if ($checkeado) {
                    $check = "Checked";
                }
                if ((($id != 4)and($id!=1)) || ($esSuperuser)and ($id != 4)) {
                    echo "<input class='form-check-input' type='checkbox' name='colrol[]' class='colrol' id='colrol' value=" . $id . " " . $check . ">";
                    echo "<label for='roles'>" . $descripcion . "</label>";
                    echo ' | ';
                }
            }
            echo "<br><br>";
            echo '<div>';
            echo "
                <button class='btn btn-success btn-sm' id='accion' name='accion' value='editar' type='submit'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-hand-thumbs-up-fill' viewBox='0 0 16 16'>
                <path d='M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z'/>
                </svg>
                Modificar
                </button>";
            echo '<div>';
        }
        ?>
    </form>
</div>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>