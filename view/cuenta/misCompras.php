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
                    array_push($aceptadas, $estado[0]);
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
                    $filtro = ['idcompra' => $idcompra];
                    $items = $ambitems->buscar($filtro);

                    //var_dump($items);
                    foreach ($items as $item) {
                        $idproducto = $item->getidproducto()->getidproducto();
                        //var_dum($idproducto);
                        $archivos = $obj->obtenerArchivosPorId($idproducto);
                        //var_dum($archivos["link"]);
                        $arreglo[$i]["link"] = $archivos["link"];
                        $arreglo[$i]["idproducto"] = $idproducto;
                        $arreglo[$i]["proprecio"] = $item->getidproducto()->getproprecio();
                        $arreglo[$i]["ciprecio"] = $item->getciprecio();
                        $arreglo[$i]["idcompraitem"] = $item->getidcompraitem();
                        $arreglo[$i]["cicantidad"] = $item->getcicantidad();
                        $arreglo[$i]["idcompra"] = $idcompra;

                        //$arreglo["idproducto"] = $idproducto;
                    }
                    $i++;
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
                        No tienes nada en tu aceptadas aún.
                        </div>";
    } else {
        $compraExitosa = data_submited(); #Redireccion desde compraexitosa.php
        if ($compraExitosa != null) {
            echo "<div class='alert alert-success' role='alert' align=center>
                ¡La compra fue exitosa!
            </div>";
        }

        echo "<form id='aceptadas' name='catalogo' method='POST' action='../inicio_cliente/detallesproducto.php'>
            <div class='row'> ";
        foreach ($arreglo as  $archivo) {
            $idcompra = $archivo["idcompra"];
            $link = $archivo["link"];            
            $idproducto = $arreglo[$i]["idproducto"];
            $proprecio = $arreglo[$i]["proprecio"];
            $ciprecio = $arreglo[$i]["ciprecio"];
            $idcompraitem = $arreglo[$i]["idcompraitem"];
            $cicantidad = $arreglo[$i]["cicantidad"];   

            //var_dum($archivo);
            echo
            "<div id='pelis' class='d-grid col-lg-2 col-sm-4 mb-4'>
                        <img class='img-fluid' alt='$link' src='$link' width='100%'>
                        <div class='d-grid align-items-end'>
                        <input type='hidden' name='imagen' id='proprecio' value='$archivo'> 
                        <input type='hidden' name='proprecio' id='proprecio' value='$proprecio'> 
                        <input type='hidden' name='ciprecio' id='v' value='$ciprecio'> 
                        <input type='hidden' name='idcompraitem' id='idcompraitem' value='$idcompraitem'> 
                        <input type='hidden' name='cicantidad' id='cicantidad' value='$cicantidad'> 
                        <input type='hidden' name='idproducto' id='idproducto' value='$idproducto'> 
                        <input type='hidden' name='idcompra' id='idcompra' value='$idcompra'>                            
                        <input type='submit' name='Seleccion:$idcompra' id='Seleccion:$idcompra' class='btn btn-primary' value='Ver Detalles'>";
            echo "</div>
                    </div>";
        }
    }
    ?>
    </form>

    <?php
    //FOOTER============================================================================
    require_once("../structure/footer.php");
    ?>