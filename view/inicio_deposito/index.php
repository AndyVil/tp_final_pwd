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

            <form action="" method="POST" name="" id="">

                <div class="row align-items-center">

                    <div class="col-sm-2" align="center">
                        <!-- Seleccionar tipo de producto -->
                        <select name="tipoProducto" id="tipoProducto">
                            <option value=" remera">Remera</option>
                            <option value="pantalon">Pantalon</option>
                            <option value="interior">Interior</option>
                            <option value="zapatos">Zapatos</option>
                            <option value="otro">Otros...</option>
                        </select>
                    </div>

                    <div class="col-sm-3" align="center">
                        <!-- Cantidad de stock -->
                        <input type="text" name="stock" id="stock" placeholder="Stock">
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
                        <input type="file" name="nuevoProducto" id="nuevoProducto">
                    </div>

                    <!-- Submit -->
                    <br>
                    <input type="submit" value="Cargar" name="btn-form" id="btn-form" class="btn btn-dark">
                </div>
            </form>
        </div>

        <div class="row" id="prodcutosCargados" align="center">
            <div class="col" style="border: 2px solid red;">
                Producto 1
            </div>
            <div class="col" style="border: 2px solid red;">
                Producto 2
            </div>
            <div class="col" style="border: 2px solid red;">
                Producto 3
            </div>
            <div class="col" style="border: 2px solid red;">
                Producto 4
            </div>
            <div class="col" style="border: 2px solid red;">
                Producto 5
            </div>
            <div class="col" style="border: 2px solid red;">
                Producto 6
            </div>
            <div class="col" style="border: 2px solid red;">
                Producto 7
            </div>
            <div class="col" style="border: 2px solid red;">
                Producto 8
            </div>
            <div class="col" style="border: 2px solid red;">
                Producto 9
            </div>
            <div class="col" style="border: 2px solid red;">
                Producto 10
            </div>
            <div class="col" style="border: 2px solid red;">
                Producto 11
            </div>
        </div>
        <span>
            La idea aca es que el prodcuto no tenga nombre, sino que se seleccione un tipo, y luego a eso le agregamos
            un numero para identificarlo
        </span>
    </div>
    <br>
    <br>






</main>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>