<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
$obj = new Formulario();
$abmCompra = new AbmCompra();
$sesion = new Session();
$ambCompraEstado = new AbmCompraEstado();
$datos = data_submited();
$ambitems = new AbmCompraItem();
if (!$sesion->activa()) {
    //header('Location: ../login/index.php'); DESCOMENT
} else {
    list($sesionValidar, $error) = $sesion->validar();
    $escliente = $sesion->validarRol($sesion->getIdUser());
    if ($sesionValidar) {

        if ($escliente) {
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
                if ($carrito == null) {
                    echo "no tienes nada en tu carrito aun";
                } else {
                    $idcompra = $carrito[0]->getidcompra();
                    $filtro = ['idcompra' => $idcompra];
                    $items = $ambitems->buscar($filtro);
                    $arreglo = array();
                    foreach ($items as $item) {
                        $idproducto = $item->getidproducto()->getidproducto();
                        //var_dump($idproducto);
                        $archivos = $obj->obtenerArchivosPorId($idproducto);

                        array_push($arreglo, $archivos["link"]);
                    }
                    //var_dump($arreglo);
                }
            }
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
        <h2 class="mt-5">Bienvenido al catalogo prro</h2>
        <hr>
    </div>

    <form id="carrito" name="catalogo" method="POST" action="detallesProducto.php">
        <div class="row">
            <?php
            if ($arreglo !== false) {
                foreach ($arreglo as $archivo) {
                    if (strlen($archivo) > 2 && strpos($archivo, "txt") <= 0  && strpos($archivo, "pdf") <= 0) {
                        echo
                        "<div id='pelis' class='d-grid col-lg-2 col-sm-4 mb-4'>
                            <img class='img-fluid' alt='$archivo' src='$archivo' width='100%'>
                            <div class='d-grid align-items-end'>
                            <input type='hidden' name='nombre' id='Seleccion:$archivo' class='btn btn-primary' value='$archivo'>                            
                            <input type='submit' name='Seleccion:$archivo' id='Seleccion:$archivo' class='btn btn-primary' value='Eliminar'>";
                        echo "</div>
                        </div>";
                    }
                }
            }
            ?>
        </div>
    </form>