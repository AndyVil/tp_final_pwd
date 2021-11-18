<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$objAbmTabla = new AbmRol();
$listaTabla = $objAbmTabla->buscar(null);
//HEADER============================================================================
?>

<div align="center">
    <h2 class="mt-5">Administración</h2>
        <!-- Botones -->
        <button onclick="location.href='listarUsuarios.php'" class="btn btn-dark">Usuarios</button>
        <button onclick="location.href='nuevoRol.php'" class="btn btn-dark">Nuevo Rol</button>
</div>

<h2 class="mt-5">Lista de Roles</h2>
<div class="card mb-4">
</div>


<div class="row mb-5" id="tp4_eje3">
    <!-- Boton Agregar Rol -->

    <form id="listarRoles" name="listarRoles" action="actualizarRol.php" method="post">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Descripcion</th>

                    </tr>
                </thead>
                <?php

                if (count($listaTabla) > 0) {
                    $i = 1;
                    echo '<tbody>';
                    foreach ($listaTabla as $objRol) {
                        $des = $objRol->getroldescripcion();
                        $id = $objRol->getidRol();
                        echo '<tr class="align-middle">';
                        echo '<th scope="row">' . $id . '</th>';
                        echo '<td>' . $des .    '</td>';
                        echo '<td class="text-center"><button class="btn btn-success btn-sm" type="submit" value="' . $id . '" id="rolEdit" name="rolEdit" role="button"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-danger btn-sm" type="submit" value="' . $id . '" formaction="eliminarRol.php" id="rolDelete" name="rolDelete" role="button"><i class="fas fa-trash-alt"></i></button></td>';
                        echo '</tr>';
                        $i++;
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo "<div class='alert alert-danger d-flex align-items-center mt-5' role='alert'>
                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                    <div>No hay Rols registrados.</div></div>";
                }

                ?>

        </div>
    </form>
</div>

<!--BODY============================================================================-->
<main role="main" class="container">







</main>
<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>