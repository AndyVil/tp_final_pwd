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

if (!$sesion->activa()) {
    header('Location: ../inicio_cliente/index.php');
} else {
    if (array_key_exists('usnombre', $_SESSION) and array_key_exists('uspass', $_SESSION)) {
        list($sesionValidar, $error) = $sesion->validar();
        if ($sesionValidar) {
            $roles = $sesion->obtenerRol();
            $escliente = $sesion->arrayRolesUser($roles);
            if ($escliente['Cliente'] == true) {
                if (array_key_exists("idcompra", $datos)) {
                    echo "entro compra carrito";
                    $idcompra =$datos["idcompra"];
                    $resp = $carrito->confirmarcarrito($datos);
                    $items = $ambitem->buscar($datos);
                    $i = 0;
                    var_dump($items);
                    foreach ($items as $item) {
                        $obj = new Formulario;
                        $infoArchivo = $obj->obtenerArchivosPorId($datos["idproducto"]);
                        $respuesta = $infoArchivo["Descripcion"];
                        $link = $infoArchivo["link"];
                        //var_dump($infoArchivo);
                        //var_dump($link);
                        $id = $item->getidproducto();
                        $where = ['idproducto' => $id];
                        $productos = $Abmproducto->buscar($where);                                             
                        $arreglo[$i]["idproducto"] =$id; 
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
                    list($idcompra,$iditem, $resp) = $carrito->crearcompra($datos, 2);
                    //echo "Exito al carga de la compra: " . $resp;
                    $obj = new Formulario;
                    $infoArchivo = $obj->obtenerArchivosPorId($datos["idproducto"]);
                    $respuesta = $infoArchivo["Descripcion"];
                    $link = $infoArchivo["link"];
                    //var_dump($infoArchivo);
                    //var_dump($link);
                    $whereitem = ['idusuario' => $iditem];
                    $items = $ambitem->buscar($whereitem);
                    $item= $items[0];
                    $id = $datos["idproducto"];
                    $where = ['idproducto' => $id];
                    $productos = $Abmproducto->buscar($where);
                    $arreglo[$i]["idproducto"] =$id; 
                    $arreglo[$i]["prodetalle"] = $productos[0]->getprodetalle();
                    $arreglo[$i]["procantstock"] = $productos[0]->getprocantstock();
                    $arreglo[$i]["pronombre"] = $productos[0]->getpronombre();
                    $arreglo[$i]["cicantidad"] = $item->getcicantidad();
                    $arreglo[$i]["proprecio"] = $productos[0]->getproprecio(); 
                    $arreglo[$i]["ciprecio"] = $item->getciprecio();
                    $arreglo[$i]["link"] = $link;
                }
            }
        } else {
            header('Location: ../inicio_cliente/index.php');
        }
    }
}
//HEADER============================================================================
?>
<div class="container">


    <!-- Titulo pagina -->
    <div align="center">
        
    </div>
    <form id="carrito" name="carrito" method="POST" action="../cuenta/misCompras.php">
        <div class="row">
            <?php    
            //var_dump($arreglo);            
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
                <div class='alert alert-success mt-5' role='alert'>
                <div class='row px-2 my-4 justify-content-center'>
                <div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px';>
                </div>";
                
                echo "<div>";
                echo "<input type='hidden' name='idcompra' id='idcompra' value='$idcompra' >";
                echo "<div class='alert alert-warning mt-5' role='alert' align=center>
                Precio total: $$ciprecio
                </div>";
                echo "<div class='col-lg-7 col-xl-8'>Precio unitario: $proprecio</div>                    
                <div class='col-lg-7 col-xl-8'>Descripcion: $detalle</div>";
                echo "<div class='col-lg-7 col-xl-8'>Cantidad: $cicantidad</div>
                <div class='col-lg-7 col-xl-8'>Stock actualizado: $procantstock</div>                    
                <div class='col-lg-7 col-xl-8'>Descripcion: $detalle</div>";
                echo "<input type='hidden' name='ciprecio' id='ciprecio' value='$ciprecio'>";
                echo ' ';            
                }
                echo '<div align="center">';
                echo "<input type='submit'  name='$idcompra' id='Seleccion:$idcompra' class='btn btn-light' value='Mis compras'>";
                echo " ";
                echo "<input type='submit' formaction='../inicio_cliente/index.php' name='$idcompra' id='Seleccion:$idcompra' class='btn btn-light' value='Volver al catalogo'>";
                echo '</div>';
                echo "</div>";
                echo "";
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