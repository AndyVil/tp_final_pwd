<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/header.php");
$datos = data_submited();
$objAbmUsuario = new AbmProducto();
$filtro = array();
$filtro['idproducto'] = $datos['proEdit'];
$unUsuario = $objAbmUsuario->buscar($filtro);
//var_dump($unUsuario);
$user = $unUsuario[0];
$id = $user->getidproducto();
$precio = $user->getproprecio();
$stock = $user->getprocantstock();
//HEADER============================================================================
?>



<!-- INICIO DEPOSITO -->
<div align="center">
    <h2 class="mt-5">Depósito</h2>
    <h3>Actualizar Producto</h3>
</div>

<div class="container">
    <div class="row" align="center">
        <div align="center" id="columnaCarga">

            <form action="abmProducto.php" method="POST" name="cargaProducto" id="cargaProducto" enctype="multipart/form-data">

                <div class="row align-items-center">

                    <div class="col-sm-2" align="center">
                        <!-- Seleccionar tipo de producto -->
                        <select name="tipoProducto" id="tipoProducto">
                            <option value="remera">Remera</option>
                            <option value="pantalon">Pantalon</option>
                            <option value="interior">Interior</option>
                            <option value="zapatos">Zapatos</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="col-sm-3" align="center">
                        <!-- Cantidad de stock -->
                        <?php
                        echo "<input type='text' value='" . $stock . "'name='procantstock' id='procantstock'>";
                        ?>
                    </div>

                    <div class="col-sm-3" align="center">
                        <!-- Descripcion -->
                        <textarea name="descripcion" id="descripcion" cols="30" rows="2" placeholder="Descripción del producto"></textarea>
                    </div>

                    <div class="col-sm-3" align="center" id="talles">
                        <!-- Seleccion de talles -->
                        <span>Talles:</span>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-s' value='S' Checked>
                        <label for="futbol">S</label>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-m' value='M'>
                        <label for="futbol">M</label>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-l' value='L'>
                        <label for="futbol">L</label>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-xl' value='XL'>
                        <label for="futbol">XL</label>
                    </div>
                    <div class="col-sm-12" align="center" style="padding-bottom: 15px;">
                        <?php
                        echo "<input type='text' value='" . $precio . "'name='proprecio' id='proprecio'>";
                        ?>
                        <input type="hidden" name="MAX_FILE_SIZE" value="20000" />
                        <input type="file" name="productoImagen" id="productoImagen" style="padding-top: 5px;">
                    </div>
                    <!-- Submit -->
                    <br>
                    <?php
                    echo "<input type='hidden' value='" . $id . "'name='idproducto' id='idproducto'>";
                    ?>
                    <input type="submit" value="editar" name="accion" id="accion" class="btn btn-dark">
                </div>
            </form>
        </div>
        <br>
        <br>
    </div>
</div>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>