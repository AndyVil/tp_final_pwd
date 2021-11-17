<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
//HEADER============================================================================
?>


<!--BODY============================================================================-->
<!-- INICIO DEPOSITO -->
<main role="main" class="container">
    <div class="row" align="center">
        <div align="center" id="columnaCarga">

            <form action="abmProducto.php" method="POST" name="cargaProducto" id="cargaProducto">

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
                        <label for="futbol">S</label>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-m' value='M'>
                        <label for="futbol">M</label>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-l' value='L'>
                        <label for="futbol">L</label>
                        <input type="checkbox" name='talle[]' class="talle" id='talle-xl' value='XL'>
                        <label for="futbol">XL</label>
                    </div>

                    <div class="col-sm-12" align="center">
                        <input type="text" name="proprecio" id="proprecio" placeholder="Ingrese precio">
                        <input type="file" name="nuevoProducto" id="nuevoProducto">
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

</main>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>