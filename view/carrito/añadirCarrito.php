<?php
require_once("../structure/Header.php");
$datos = data_submited();
$sesion = new Session();
$ambCompra = new AbmCompra();
$ambitem = new AbmCompraItem();
$carrito = new Carrito();
$Abmproducto = new AbmProducto();
$ambCompraEstado = new AbmCompraEstado();
$ambCompraEstadoTipo = new AbmCompraEstadoTipo();
//var_dump($datos);
$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);
    $datos["idusuario"] = $sesion->getIdUser();
    $compras = $ambCompra->buscar($datos);
    $objcarrito = array();
    if (count($compras) > 0) {
        foreach ($compras as $compra) {
            $where['idcompra'] = $compra->getidcompra();
            $where['idcompraestadotipo'] = 1;
            //var_dump($where);            
            $objcarrito = $ambCompraEstado->buscar($where);
            
            if (count($objcarrito) > 0) {
                break;
            }
        }
    }
    //var_dump($objcarrito);
    if (count($compras) == 0 || count($objcarrito) == 0) {
        echo "creo la compra";
        list($idcompra, $iditem, $resp) = $carrito->crearcompra($datos, 1);
    } elseif (count($objcarrito) > 0) {
        //echo "entro a añadir nuevo item";
        $idcompra = $objcarrito[0]->getidcompra();
        $whereitem = array();
        $whereitem["idcompra"] = $idcompra;
        $whereitem["idproducto"] = $datos["idproducto"];
        $items =  $ambitem->buscar($whereitem);
        if (count($items) == 0) {
            $datos["idcompra"] = $idcompra;
            $datos["idcompraitem"] = "DEFAULT";
            $resp = $carrito->sumarItem($datos);
        } else {
            $datos["idcompra"] = $idcompra;
            $datos["idcompraitem"] = $items[0]->getidcompraitem();
            $stock = $items[0]->getidproducto()->getprocantstock();
            $idproducto = $items[0]->getidproducto()->getidproducto();
            if (($items[0]->getcicantidad() + $datos["cicantidad"]) > $stock) {
                header("Location: ../inicio_cliente/index.php?stock=". urlencode($idproducto));
                $datos["cicantidad"] = $stock;
            }
            //var_dump($datos);
            $datos["cicantidad"] = $items[0]->getcicantidad() + $datos["cicantidad"];
            $datos["ciprecio"] = $items[0]->getciprecio();
            $ambitem->modificacion($datos);
        }

        //echo $resp;
    }

//cargo la informacion que cargo en el formulario cuando ingreso un carrito
$obj = new Formulario;
$infoArchivo = $obj->obtenerArchivosPorId($datos["idproducto"]);
$respuesta = $infoArchivo["Descripcion"];
$link = $infoArchivo["link"];
//var_dump($infoArchivo);
//var_dump($link);
$id = $datos["idproducto"];
$where = ['idproducto' => $id];
$productos = $Abmproducto->buscar($where);
$precio = $productos[0]->getproprecio();
$precio = $productos[0]->getproprecio();
$nombre = $productos[0]->getpronombre();
$stock = $productos[0]->getprocantstock();
$detalle = $productos[0]->getprodetalle();


//HEADER============================================================================
?>
<div class="container">
    <!-- Titulo pagina -->
    <div align="center">
        <div class='alert alert-success mt-5' role='alert' align=center>
            ¡Añadiste <?= $nombre ?> a tu carrito!
        </div>
    </div>
    <form id="carrito" name="carrito" method="POST" action="index.php">
        <div class="row mx-6">
            <?php
            echo "<div class='alert alert-success' role='alert' >
                  <div class='row px-2 my-4 justify-content-center'>

                <div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px';>
                </div>";
            echo "<div align='center'>";
            echo "<input type='hidden' name='idproducto' id='idproducto' value='$id' >";

            echo "<input type='hidden' name='ciprecio' id='ciprecio' value='$precio'>";
            echo ' ';
            //echo "<input type='submit' formaction='$actionCarrito' name='$id' id='Seleccion:$id' class='btn btn-warning' value='Agregar al carrito'>";
            //echo "<input type='number' name='cicantidad' id='cicantidad' value='1'>";
            echo "<input type='submit' formaction='../inicio_cliente/index.php' class='btn btn-light' value='Seguir comprando'>";
            echo " ";
            echo "<input type='submit' name='$id' id='Seleccion:$id' class='btn btn-light' value='Ver el carrito'>";



            echo "</div>";
            echo "
            <div class='alert alert-warning mt-3' role='alert' align=center>
            Precio: $$precio
            </div>";
            echo "<div class='col-lg-7 col-xl-8'>Stock: $stock</div>
            <div class='col-lg-7 col-xl-8'>Descripcion: $detalle</div>";
            echo "</div>
            </div>";
            ?>
        </div>
    </form>

</div>



<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>