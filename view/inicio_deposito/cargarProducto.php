<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$url = data_submited();
$dir = "../inicio_cliente/index.php";
$rol = "Deposito";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);
//HEADER============================================================================
?>
<!-- INICIO DEPOSITO -->
<div align="center">
    <h2 class="mt-5">Depósito</h2>
</div>

<div align="center">
    <!-- Botones -->
    <button onclick="location.href='index.php'" class="btn btn-dark">Volver</button>
</div>

<div class="container">
    <br>
    <h3 align="center">Cargar nuevo Producto</h3>
    <hr>
    <div class="row" align="center">

        <div align="center" id="columnaCarga">

            <form action="action.php" method="POST" name="cargaProducto" id="cargaProducto" enctype="multipart/form-data">

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
                        <input type="text" name="procantstock" id="procantstock" placeholder="Stock">
                    </div>

                    <div class="col-sm-3" align="center">
                        <!-- Descripcion -->
                        <textarea name="descripcion" id="descripcion" cols="30" rows="2" placeholder="Descripción del producto"></textarea>
                    </div>

                    <div class="col-sm-3" align="center" id="talles">
                        <!-- Seleccion de talles -->
                        <span>Talles:</span>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-s' value='S'>
                        <label for="talle">S</label>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-m' value='M'>
                        <label for="talle">M</label>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-l' value='L' checked>
                        <label for="talle">L</label>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-xl' value='XL'>
                        <label for="talle">XL</label>
                    </div>

                    <div class="col-sm-12" align="center" style="padding-bottom: 15px;">
                        <input type="text" name="proprecio" id="proprecio" placeholder="Ingrese precio">
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                        <input type="file" name="productoImagen" id="productoImagen" style="padding-top: 5px;">
                    </div>

                    <!-- Submit -->
                    <br>
                    <input type="hidden" value="DEFAULT" name="idproducto" id="idproducto">
                    <input type="submit" value="cargar" name="accion" id="accion" class="btn btn-dark">
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