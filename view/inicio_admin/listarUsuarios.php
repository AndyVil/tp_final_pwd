<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$objAbmTabla = new AbmUsuario();
$listaTabla = $objAbmTabla->buscar(null);
//HEADER============================================================================
?>

<!--BODY============================================================================-->
<main role="main">

    <div align="center">
        <h2 class="mt-5">Administración</h2>
        <!-- Botones -->
        <button onclick="location.href='nuevoUsuario.php'" class="btn btn-dark">Nuevo Usuario</button>
        <button onclick="location.href='listarRoles.php'" class="btn btn-dark">Roles</button>
    </div>

    <h2 class="mt-5">Lista de Usuarios</h2>

    <div class="card mb-4">
    </div>

    <div class="row mb-5">
        <form id="listarUsuarios" name="listarUsuarios" action="actualizarLogin.php" method="post">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Mail</th>
                            <th scope="col" class="text-center">Deshabilitado</th>
                            <th scope="col" class="text-center">Editar</th>
                        </tr>
                    </thead>
                    <?php

                    if (count($listaTabla) > 0) {
                        $i = 1;
                        echo '<tbody>';
                        foreach ($listaTabla as $objUsuario) {
                            $nombre = $objUsuario->getusnombre();
                            $mail = $objUsuario->getusmail();
                            $des = $objUsuario->getusdeshabilitado();
                            $id = $objUsuario->getidusuario();
                            echo '<tr class="align-middle">';
                            echo '<th scope="row">' . $i . '</th>';
                            echo '<td>' . $nombre .    '</td>';

                            echo '<td>' . $mail .  '</td>';
                            //echo '<td>' . $des .  '</td>';
                            if ($des) {
                                echo "<td class='text-center text-success'><i class='fas fa-check'></i></td>";
                            } else {
                                echo "<td class='text-center text-danger'><i class='fas fa-times'></i></td>";
                            }
                            echo '<td class="text-center"><button class="btn btn-success btn-sm" type="submit" value="' . $id . '" id="userEdit" name="userEdit" role="button"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-danger btn-sm" type="submit" value="' . $id . '" formaction="eliminarLogin.php" id="userDelete" name="userDelete" role="button"><i class="fas fa-trash-alt"></i></button></td>';
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
</main>

<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>