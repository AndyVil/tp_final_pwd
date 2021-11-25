<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");

$obj = new Formulario();
$abmCompra = new AbmCompra();
$sesion = new Session();
$ambCompraEstado = new AbmCompraEstado();
$datos = data_submited();
$arreglo = array();
$ambitems = new AbmCompraItem();
if (!$sesion->activa()) {
    //header('Location: ../login/index.php'); DESCOMENT
} else {
    list($sesionValidar, $error) = $sesion->validar();
    $roles = $sesion->obtenerRol();
    $escliente = $sesion->arrayRolesUser($roles);
    if ($sesionValidar) {
        if ($escliente['Cliente'] == true) {
            $f = array();
            $f['idusuario'] = $sesion->getIdUser();
            $compras = $abmCompra->buscar($f);
            $carrito = array();
            
            if (count($compras) > 0) {
                foreach ($compras as $compra) {
                    $where['idcompra'] = $compra->getidcompra();
                    $where['idcompraestadotipo'] = 1;
                    //var_dump($where);
                    $carrito = $ambCompraEstado->buscar($where);
                    if (count($carrito) > 0) {
                        break;
                    }
                }
                //var_dump($carrito);
                //var_dump($carrito);
                if (count($carrito) == 0) {
                    // echo "
                    //     <div class='alert alert-warning' role='alert' align=center>
                    //     No tienes nada en tu carrito aún.
                    //     </div>";
                    $arreglo = false;
                } else {
                    //echo "encontro el carrio";
                    $idcompra = $carrito[0]->getidcompra();
                    $filtro = ['idcompra' => $idcompra];
                    $items = $ambitems->buscar($filtro);
                    //var_dump($items);
                    $i = 0;
                    foreach ($items as $item) {
                        //echo "entro al item";
                        $idproducto = $item->getidproducto()->getidproducto();
                        $producto = $item->getidproducto();
                        //var_dump($idproducto);
                        $archivos = $obj->obtenerArchivosPorId($idproducto);
                        $arreglo[$i]["link"] = $archivos["link"];
                        $arreglo[$i]["idproducto"] = $idproducto;
                        $arreglo[$i]["pronombre"] = $producto->getpronombre();
                        $arreglo[$i]["prodetalle"] = $producto->getprodetalle();
                        $arreglo[$i]["procantstock"] = $producto->getprocantstock();  
                        $arreglo[$i]["proprecio"] = $item->getidproducto()->getproprecio();
                        $arreglo[$i]["ciprecio"] = $item->getciprecio();
                        $arreglo[$i]["idcompraitem"] = $item->getidcompraitem();
                        $arreglo[$i]["cicantidad"] = $item->getcicantidad();
                        $arreglo[$i]["idcompra"] = $idcompra;
                        $i++;
                    }
                    
                    //var_dump($arreglo);
                }
            }
        } else {
            $arreglo = false;
            //echo  "<p id='error'>Error en carrito index (56).</p>";
        }
    } else {
        header('Location: ../inicio_cliente/index.php');
    }
}
//HEADER============================================================================
?>
<div class="container">
    <!-- Titulo pagina -->
    <div align="center">
        <h2 class="mt-5">Carrito</h2>
        <hr>
    </div>
    <?php
     //var_dump($arreglo);
    if ($arreglo === false) {
        echo "<div class='alert alert-warning' role='alert' align=center>
                        No tienes nada en tu carrito aún.
                        </div>";
    } else {
        //var_dump($idcompra);
        echo "<form id='carrito' name='catalogo' method='POST' action='eliminarCarrito.php'>
            <div class='row'> ";
        echo "<input type='hidden' name='idcompra' id='idcompra'  value='$idcompra'>";
        echo "<input type='submit' formaction='action.php' name='compracarrito' id='compracarrito' class='btn btn-light' value='Comprar carrito' style='margin-bottom: 10px;'>";
        foreach ($arreglo as $archivo) {
            //var_dump($archivo);
            $idcompra = $archivo["idcompra"];
            $link = $archivo["link"];
            $idproducto = $archivo["idproducto"];
            $proprecio = $archivo["proprecio"];
            $ciprecio = $archivo["ciprecio"];
            $idcompraitem = $archivo["idcompraitem"];
            $cicantidad = $archivo["cicantidad"];
            $procantstock = $archivo["procantstock"];
            $detalle = $archivo["prodetalle"];
            $nombre = $archivo["pronombre"];
            
                echo
                "<div id='pelis' class='d-grid col-lg-2 col-sm-4 mb-4'>
                        <img class='img-fluid' alt='$link' src='$link' width='100%'>
                        <div class='d-grid align-items-end'>
                        
                        <input type='hidden' name='imagen' id='imagen' value='$link'> 
                        <input type='hidden' name='proprecio' id='proprecio' value=$proprecio'> 
                        <input type='hidden' name='ciprecio' id='v' value='$ciprecio'> 
                        <input type='hidden' name=''idcompraitem' id='idcompraitem' value='$idcompraitem'> 
                        <input type='hidden' name='cicantidad' id='cicantidad' value='$cicantidad'> 
                        <input type='hidden' name='idproducto' id='idproducto' value='$idproducto'> 
                        <input type='hidden' name='idcompra' id='idcompra' value='$idcompra'>
                        <input type='hidden' name='nombre' id='Seleccion:$link' class='btn btn-primary' value='$link'>                            
                        <input type='submit' name='Seleccion:$idcompraitem' id='Seleccion:$idcompraitem' class='btn btn-danger' value='Eliminar'>";
                echo "</div>";
                echo "</div>";
            
        }
    }
    ?>
    </form>

    <?php
    //FOOTER============================================================================
    require_once("../structure/footer.php");
    ?>