<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$dir = "../inicio_cliente/index.php";
$rol = "Administrador";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);

$menuRoles = new AbmMenurol();
$listaMenu = $menuRoles->buscar(null);
//HEADER============================================================================
?>

<div align="center">
    <h2 class="mt-5">Administración</h2>
</div>

<div align="center">
    <!-- Botones -->
    <button onclick="location.href='nuevoRol.php'" class="btn btn-dark">Nuevo Menu-Rol</button>
    <button onclick="location.href='listarUsuarios.php'" class="btn btn-dark">Usuarios</button>
</div>


<div class="row mb-5">

    <form id="listarRoles" name="listarRoles" action="actualizarRol.php" method="post">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <br>
                    <h3 align="center">Listar Menu Roles</h3>
                    <hr>
                    <tr>
                        <th scope="col" id="tablepadding">id Menu</th>
                        <th scope="col" id="tablepadding">id Rol</th>
                        <th scope="col" class="text-center" id="tablepadding">Editar</th>
                    </tr>
                </thead>
                <?php

                if (count($listaMenu) > 0) {
                    $i = 1;
                    echo '<tbody>';
                    foreach ($listaMenu as $menu) {  
                        $idRol = $menu -> getidrol();
                        $idMenu = $menu -> getidMenu();
                        $descripcionRol = '';
                        switch ($idRol) {
                            case '1':
                                $descripcionRol = 'Administrador';
                                break;
                            case '2':
                                $descripcionRol = 'Deposito';
                                break;
                            case '3':
                                $descripcionRol = 'Cliente';
                                break;
                            case '4':
                                $descripcionRol = 'Superusuario';
                                break;
                        }
                        $descripcionMenu = '';
                        switch ($idMenu) {
                            case '1':
                                $descripcionMenu = 'admin_ini';
                                break;
                            case '2':
                                $descripcionMenu = 'dep_ini';
                                break;
                            case '3':
                                $descripcionMenu = 'cliente_ini';
                                break;
                            case '4':
                                $descripcionMenu = 'login';
                                break;
                            case '5':
                                $descripcionMenu = 'registro';
                                break;
                            case '6':
                                $descripcionMenu = 'cuenta';
                                break;
                            case '7':
                                $descripcionMenu = 'carrito';
                                break;
                        }


                        echo '<tr class="align-middle">';
                        echo '<th scope="row" id="tablepadding">(' . $idMenu .') '. $descripcionMenu . '</th>';
                        echo '<td id="tablepadding">(' . $idRol .') '. $descripcionRol . '</td>';
                        echo '
                        <td class="text-center">
                            <button class="btn btn-success btn-sm" type="submit" value="' . $idMenu . '" id="proEdit" name="roledit" role="roledit">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>

                            </button>

                            <button class="btn btn-danger btn-sm" type="submit" value="' . $idMenu . '" formaction="eliminarProducto.php" id="roldelete" name="roldelete" role="button">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>

                            </button>
                        </td>';
                        echo '</tr>';
                        $i++;
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo "<div class='alert alert-danger d-flex align-items-center mt-5' role='alert'>
                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                    <div>No hay menus registrados.</div></div>";
                }

                ?>

        </div>
    </form>
</div>

<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>