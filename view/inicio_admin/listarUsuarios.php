<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$url = data_submited();
$sesion = new Session();
$dir = "../inicio_cliente/index.php";
$rol = "Administrador";
$sesion->permisoAcceso($dir, $rol);

//HEADER============================================================================
?>

<div align="center">
    <h2 class="mt-5">Administración</h2>
</div>

<div>
    <div align="center">
        <!-- Botones -->
        <button onclick="location.href='nuevoUsuario.php'" class="btn btn-dark">Nuevo Usuario</button>
        <button onclick="location.href='../menu-new/menu_list.php'" class="btn btn-dark">Roles Menu</button>
    </div>

    <div class="row mb-5">
        <form id="listarUsuarios" name="listarUsuarios" action="actionActualizarLogin.php" method="post">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <br>
                        <h3 align="center">Listar Usuarios</h3>
                        <?php
                        $edicion = data_submited();
                        if (array_key_exists('mensaje', $edicion)) {
                            if ($edicion['mensaje'] == 'edicion_exitosa') {
                                echo "<div class='alert alert-success' role='alert' align=center>
                                Se actualizo usuario correctamente.
                                </div>";
                            } elseif ($edicion['mensaje'] == 'edicion_fallida') {
                                echo "<div class='alert alert-warning' role='alert' align=center>
                                No se modifico el usuario.
                                </div>";
                            } elseif ($edicion['mensaje'] == 'no puede deshabilitar este usuario') {
                                echo "<div class='alert alert-warning' role='alert' align=center>
                                no puede deshabilitar o editar este usuario.
                                </div>";
                            }
                        }
                        ?>
                        <hr>
                        <tr>
                            <th scope="col" id="tablepadding">Id</th>
                            <th scope="col" id="tablepadding">Nombre</th>
                            <th scope="col" id="tablepadding">Mail</th>
                            <th scope="col" class="text-center" id="tablepadding">Deshabilitado</th>
                        </tr>
                    </thead>
                    <?php
                    $objAbmTabla = new AbmUsuario();
                    $listaTabla = $objAbmTabla->buscar(null);
                    if (count($listaTabla) > 0) {
                        $i = 1;
                        echo '<tbody>';
                        foreach ($listaTabla as $objUsuario) {
                            $nombre = $objUsuario->getusnombre();
                            $mail = $objUsuario->getusmail();
                            $des = $objUsuario->getusdeshabilitado();
                            $id = $objUsuario->getidusuario();
                            echo '<tr class="align-middle">';
                            echo '<th scope="row" id="tablepadding">' . $i . '</th>';
                            echo '<td id="tablepadding">' . $nombre .    '</td>';
                            echo '<td id="tablepadding">' . $mail .  '</td>';
                            echo '<td id="tablepadding" align="center">' . $des .  '</td>';
                            if ($des) {
                                echo "<td class='text-center text-success'><i class='fas fa-check'></i></td>";
                            } else {
                                echo "<td class='text-center text-danger'><i class='fas fa-times'></i></td>";
                            }
                            if ($id != 1) {
                                echo '
                            <td class="text-center">
                                <button class="btn btn-success btn-sm" type="submit" value="' . $id . '" id="proEdit" name="roledit" role="roledit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                                </button>

                                <button class="btn btn-danger btn-sm" type="submit" value="' . $id . '" formaction="eliminarLogin.php" id="roldelete" name="roldelete" role="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                    </svg>
                                </button>
                            </td>';
                            }else{
                                #Tapa el corte blanco de el listar usuarios cuando es super usuario y no se puede modificar
                                echo '<td class="text-center">
                                <span></span>
                                </td>';   
                            }
                            echo '</tr>';
                            $i++;
                        }
                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo "<div class='alert alert-danger d-flex align-items-center mt-5' role='alert'>
                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                    <div>No hay usuarios registrados.</div></div>";
                    }
                    ?>

            </div>
        </form>
    </div>
</div>

<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>