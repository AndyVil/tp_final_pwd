<?php
$Titulo = "Deposito";
require_once("../structure/header.php");

$objAbmTabla = new AbmProducto();
$listaTabla = $objAbmTabla->buscar(null);
?>

<div class="row mb-5" id="tp4_eje3">
    <!-- Boton Agregar Producto -->
    <div align="center">
        <h2 class="mt-5">Deposito</h2>
        <button onclick="location.href='cargarProducto.php'" class="btn btn-dark">Nuevo Producto</button>
    </div>

    <form id="productosCargados" name="productosCargados" action="action.php" method="POST">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Detalle</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Precio</th>
                    </tr>
                </thead>
                <?php

                if (count($listaTabla) > 0) {
                    $i = 1;
                    echo '<tbody>';
                    foreach ($listaTabla as $objProducto) {

                        $id = $objProducto->getidproducto();
                        $nombre = $objProducto->getpronombre();
                        $detalle = $objProducto->getprodetalle();
                        $des = $objProducto->getprocantstock();
                        $precio = $objProducto->getproprecio();
                        echo '<tr class="align-middle">';
                        echo '<th scope="row">' . $id . '</th>';
                        echo '<td>' . $nombre .    '</td>';

                        echo '<td>' . $detalle .  '</td>';
                        //echo '<td>' . $des .  '</td>';
                        if ($des > 0) {
                            echo "<td class='text-center text-success'>" . $des . " <i class='fas fa-check'></i></td>";
                        } else {
                            echo "<td class='text-center text-danger'>" . $des . "<i class='fas fa-times'></i></td>";
                        }
                        echo '<td>' . $precio .  '</td>';
                        echo '<td class="text-center"><button class="btn btn-success btn-sm" type="submit" value="' . $id . '" id="proEdit" name="proEdit" role="button"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-danger btn-sm" type="submit" value="' . $id . '" formaction="eliminarProducto.php" id="proBorrar" name="proBorrar" role="button"><i class="fas fa-trash"></i></button></td>';
                        echo '</tr>';
                        $i++;
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo "<div class='alert alert-danger d-flex align-items-center mt-5' role='alert'>
                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                    <div>No hay Productos registrados.</div></div>";
                }

                ?>

        </div>
    </form>
</div>

<?php
require_once("../structure/footer.php");
?>