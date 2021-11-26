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
$arreglo   = array();
$idcompra ="";
//var_dump($datos);
$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);
if (array_key_exists("idcompra", $datos)) {
    //echo "entro compra carrito";
    $idcompra = $datos["idcompra"];
    $resp = $carrito->confirmarcarrito($datos);
    $filtroitem=array();
    $filtroitem["idcompra"] = $idcompra;
    $items = $ambitem->buscar($filtroitem);
    $compras= $ambCompra->buscar($filtroitem);
    $compra = $compras[0];
    $coprecio = $compra->getcompraprecio();
    $cofecha = $compra->getcofecha();
    $i = 0;
    //var_dum($items);
    foreach ($items as $item) {
        $id = $item->getidproducto()->getidproducto();
        $obj = new Formulario;
        $infoArchivo = $obj->obtenerArchivosPorId($id);
        $respuesta = $infoArchivo["Descripcion"];
        $link = $infoArchivo["link"];
        //var_dump($infoArchivo);
        //var_dump($link);
        
        $where=array();
        $where["idproducto"] = $id;        
        $productos = $Abmproducto->buscar($where);
        $arreglo[$i]["idproducto"] = $id;
        $arreglo[$i]["pronombre"] = $productos[0]->getpronombre();
        $arreglo[$i]["prodetalle"] = $productos[0]->getprodetalle();
        $arreglo[$i]["procantstock"] = $productos[0]->getprocantstock();
        $arreglo[$i]["cicantidad"] = $item->getcicantidad();
        $arreglo[$i]["proprecio"] = $productos[0]->getproprecio();
        $arreglo[$i]["ciprecio"] = $item->getciprecio();
        $arreglo[$i]["link"] = $link;
        $i++;
    }
} else {
    $i = 0;
    $datos["idusuario"] = $sesion->getIdUser();
    list($idcompra, $iditem, $resp) = $carrito->crearcompra($datos, 2);
    //echo "Exito al carga de la compra: " . $resp;
    $obj = new Formulario;
    $infoArchivo = $obj->obtenerArchivosPorId($datos["idproducto"]);
    $respuesta = $infoArchivo["Descripcion"];
    $link = $infoArchivo["link"];    
    //var_dump($infoArchivo);
    //var_dump($link);
    $filtroitem=array();
    $filtroitem["idcompra"] = $idcompra;
    $compras= $ambCompra->buscar($filtroitem);
    $compra = $compras[0];
    $coprecio = $compra->getcompraprecio();
    $cofecha = $compra->getcofecha();
    $items = $ambitem->buscar($filtroitem);
    $item = $items[0];
    $id = $datos["idproducto"];
    $where = ['idproducto' => $id];
    $productos = $Abmproducto->buscar($where);
    $arreglo[$i]["idproducto"] = $id;
    $arreglo[$i]["prodetalle"] = $productos[0]->getprodetalle();
    $arreglo[$i]["procantstock"] = $productos[0]->getprocantstock();
    $arreglo[$i]["pronombre"] = $productos[0]->getpronombre();
    $arreglo[$i]["cicantidad"] = $item->getcicantidad();
    $arreglo[$i]["proprecio"] = $productos[0]->getproprecio();
    $arreglo[$i]["ciprecio"] = $item->getciprecio();
    $arreglo[$i]["link"] = $link;
}


//HEADER============================================================================
?>
<div class="container">


    <!-- Titulo pagina -->
    <div align="center">
        
    </div>
    <form id="carrito" name="carrito" method="POST" action="../cuenta/detalleCompra.php">
        <div class="row">
            <?php    
            //var_dump($arreglo);  
            echo "<div class='alert alert-success mt-5' role='alert'>";

            foreach ($arreglo as $item) {

                $proprecio = $item["proprecio"];
                $idproducto = $item["idproducto"];
                $cicantidad = $item["cicantidad"];
                $nombre = $item["pronombre"];
                $link = $item["link"];
                $ciprecio = $item["ciprecio"];
                $procantstock = $item["procantstock"];
                $detalle = $item["prodetalle"];                

                echo "<h2 class='mt-5' align='center'>Compraste: $nombre </h2>";
                echo "
                <div class='row px-2 my-4 justify-content-center'>               
                <div class='col-lg-7 col-xl-8'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px;'>
                </div>";
                echo "<input type='hidden' name='idcompra' id='idcompra' value='$idcompra'>";
                echo "<div class='col-lg-7 col-xl-8'>Precio unitario: $proprecio</div>";
                echo "<div class='col-lg-7 col-xl-8'>Cantidad: $cicantidad</div>";
                echo "<div class='col-lg-7 col-xl-8'> Precio total: $$ciprecio</div>";
                echo "<input type='hidden' name='ciprecio' id='ciprecio' value='$ciprecio'>";
                echo ' '; 
                }
                ################################################################################################################################################################
                echo "<br><div class='container' align='center'><hr></div>";
                echo '<div align="center">';
                echo "<h4 class='col-lg-7 col-xl-8'> Precio total de compra: $$coprecio</h4>";
                echo "<h5 class='col-lg-7 col-xl-8'> Lo compraste el: $cofecha</h5>";
                echo "<input type='submit'  name='$idcompra' id='Seleccion:$idcompra' class='btn btn-light' value='Ver detalles'>";
                echo " ";
                echo "<input type='submit' formaction='../inicio_cliente/index.php' name='$idcompra' id='Seleccion:$idcompra' class='btn btn-light' value='Volver al catalogo'>";
                echo '</div>';
                echo "</div>";
                echo " ";
                echo "</div>
                </div>";
            ?>
        </div>
    </form>

</div>



<?php
//$compraExitosa = 'compra exitosa';
//header('Location:../cuenta/miscompras.php?mensaje=' . urlencode($compraExitosa));

//FOOTER============================================================================
require_once("../structure/footer.php");
?>