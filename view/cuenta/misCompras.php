<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$obj = new Formulario();
$abmCompra = new AbmCompra();
$sesion = new Session();
$ambCompraEstado = new AbmCompraEstado();
$datos = data_submited();
$arreglo = array();

$dir = "../inicio_cliente/index.php";
$rol = "Cliente";
$sesion->permisoAcceso($dir, $rol);


$ambitems = new AbmCompraItem();
if (!$sesion->activa()) {
    header('Location: ../login/index.php');
} else {
    list($sesionValidar, $error) = $sesion->validar();
    if ($sesionValidar) {
        $roles = $sesion->obtenerRol();
        $escliente = $sesion->arrayRolesUser($roles);
        if ($escliente['Cliente'] == true) {
            $f = array();
            $f['idusuario'] = $sesion->getIdUser();
            $compras = $abmCompra->buscar($f);
            //var_dump($compras);
            $aceptadas = array();
            if (count($compras) > 0) {
                foreach ($compras as $compra) {
                    $where['idcompra'] = $compra->getidcompra();
                    $where['idcompraestadotipo'] = 2;
                    //var_dump($where);
                    $estado = $ambCompraEstado->buscar($where);
                    //var_dump($estado);
                    if (count($estado) > 0) {
                        array_push($aceptadas, $estado[0]);
                    } else {
                        //echo "no tienes compras aun";
                    }
                }
            }
            //var_dump($aceptadas);
            if (count($aceptadas) == 0) {
                echo "
                        <div class='alert alert-warning' role='alert' align=center>
                        No tienes compras aún.
                        </div>";
                $arreglo = false;
            } else {
                $i = 0;
                foreach ($aceptadas as $compraestado) {
                    //var_dump($compraestado);
                    $idcompra = $compraestado->getidcompra();
                    $filtro = Array();
                    $filtro['idcompra']=$idcompra;
                    $items = $ambitems->buscar($filtro); 
                    //var_dump(count($items));                  
                    foreach ($items as $item) {
                        $idproducto = $item->getidproducto()->getidproducto();
                        //var_dum($idproducto);
                        $archivos = $obj->obtenerArchivosPorId($idproducto);
                        //var_dum($archivos["link"]);
                        $arreglo[$i]["link"] = $archivos["link"];
                        $arreglo[$i]["idproducto"] = $idproducto;
                        $arreglo[$i]["nombre"] = $item->getidproducto()->getpronombre();
                        $arreglo[$i]["proprecio"] = $item->getidproducto()->getproprecio();
                        $arreglo[$i]["ciprecio"] = $item->getciprecio();
                        $arreglo[$i]["idcompraitem"] = $item->getidcompraitem();
                        $arreglo[$i]["cicantidad"] = $item->getcicantidad();
                        $arreglo[$i]["iditem"] = $item->getidcompraitem();
                        $arreglo[$i]["fecha"] = $compraestado->getcefechafin();
                        $arreglo[$i]["idcompra"] = $idcompra;
                        $i++;
                        //$arreglo["idproducto"] = $idproducto;
                    }
                    
                }
                //var_dump($arreglo);
            }
        } else {
            $arreglo = false;
            header('Location: ../inicio_cliente/index.php');
            //echo  "<p id='error'>Error en aceptadas index (56).</p>";
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
        <h2 class="mt-5">Compras</h2>
        <hr>
    </div>
    <?php
    if ($arreglo === false) {
        echo "<div class='alert alert-warning' role='alert' align=center>
                        No tienes ningun articulo comprado aun.
                        </div>";
    } else {
        echo "<form id='aceptadas' name='catalogo' method='POST' action='detalleCompra.php'>
            <div class='row'> ";
            //var_dump($arreglo);

        foreach ($arreglo as  $archivo) {
            $idcompra = $archivo["idcompra"];
            $link = $archivo["link"];
            $iditem = $archivo["iditem"];
            
            $idproducto = $archivo["idproducto"];
            $proprecio = $archivo["proprecio"];
            $ciprecio = $archivo["ciprecio"];
            $idcompraitem = $archivo["idcompraitem"];
            $cicantidad = $archivo["cicantidad"];
            $fecha = $archivo["fecha"];
            $nombre = $archivo["nombre"];
          
            echo
            "<div id='productos' class='col-lg-2 col-sm-4 mb-4'>
                        <h4 align='center'>$nombre</h4>
                        <img class='img-fluid' alt='$link' src='$link' width='100%'>
                        <div class='d-grid align-items-end'>

						<div>Fecha de Compra:<br>$fecha</div>
						<div>Precio Total: $$ciprecio</div>
						</div>
                        <input type='hidden' name='idcompra' id='idcompra' value='$idcompra'>
                        <input type='hidden' name='idcompraitem:$idcompraitem' id='idcompraitem:$idcompraitem' value='$idcompraitem'>                            
                        <input type='submit' name='Seleccion:$idcompra' id='Seleccion:$idcompra' class='btn btn-light' value='Ver detalles de compra'>";

            echo "</div>";
            
        }
    }
    ?>
    </form>
</div>

    <?php
    //FOOTER============================================================================
    require_once("../structure/footer.php");
    ?>