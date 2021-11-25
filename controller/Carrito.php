<?php

class Carrito
{

    public function eliminarItem($datos)
    {
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $return = false;
        $ambCompra = new AbmCompra();
        $ambitem = new AbmCompraItem();
        $datos["cofecha"] = date('Y-m-d h:i:s');
        //var_dump($datos);
        echo "entro";
        $baja = $ambitem->baja($datos);
        //var_dump($baja);
        if ($baja) {
            echo "elimino item";
            //var_dump($datos);
            if ($ambCompra->modificacion($datos)) {
                $return = true;
            }
        }

        return $return;
    }

    public function sumarItem($datos)
    {
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $return = false;
        $ambCompra = new AbmCompra();
        $ambitem = new AbmCompraItem();
        $datos["cofecha"] = date('Y-m-d h:i:s');
        //var_dump($datos);


        if ($ambitem->alta($datos)) {
            if ($ambCompra->modificacion($datos)) {
                $return = true;
            }
        }

        return $return;
    }

    public function confirmarcarrito($datos)
    {
        $return = false;
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $ambCompra = new AbmCompra();
        $ambCompraEstado = new AbmCompraEstado();
        $abmProducto = new AbmProducto();
        $ambitem = new AbmCompraItem();
        $datos["idcompraestadotipo"] = 1;
        //echo "modifico compra estado";
        //var_dump($datos);
        $filtro = array();
        $filtro["idcompra"] = $datos["idcompra"];
        $carrito = $ambCompraEstado->buscar($filtro);
        //var_dump($carrito);
        var_dump($filtro);
        $filtro["idcompraestado"] = $carrito[0]->getidcompraestado();
        $filtro["idcompraestadotipo"] = 2;
        $filtro["cefechaini"] = null;
        $filtro["cefechafin"] = date('Y-m-d h:i:s');
        //var_dump($filtro);
        if ($ambCompraEstado->modificacion($filtro)) {
            echo "modifico compra estado";
            if ($ambCompra->modificacion($datos)) {
                $filtro = array();
                $filtro["idcompra"] = $datos["idcompra"];
                $items = $ambitem->buscar($filtro);
                foreach ($items as $item) {
                    $modificacion = array();
                    $producto = $item->getidproducto();
                    $modificacion["idproducto"] = $producto->getidproducto();
                    $modificacion["pronombre"] = $producto->getpronombre();
                    $modificacion["prodetalle"] = $producto->getprodetalle();
                    $modificacion["procantstock"] = $producto->getprocantstock() - $item->getcicantidad();
                    if ($abmProducto->modificacion($modificacion)) {
                        echo "modifico item";
                        $return = true;
                    }
                }
            }
        }
        return $return;
    }



    public function crearcompra($datos, $tipo)
    {
        $return = array();
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $respuesta = false;
        $fechafin = null;
        $abmProducto = new AbmProducto();
        $ambCompra = new AbmCompra();
        $ambCompraEstado = new AbmCompraEstado();
        $ambitem = new AbmCompraItem();
        if ($datos["cicantidad"] > 1) {
            $datos["ciprecio"] = $datos["ciprecio"] * $datos["cicantidad"];
        }
        $datos["idcompra"] = "DEFAULT";
        $datos["cofecha"] = date('Y-m-d h:i:s');
        $datos["coprecio"] = $datos["ciprecio"];
        $datos["proprecio"] = $datos["ciprecio"];
        $datos["cefechaini"] = date('Y-m-d h:i:s');
        if ($tipo == 2) {
            $fechafin = date('Y-m-d h:i:s');
        }
        $datos["cefechafin"] = $fechafin;
        $datos["idcompraestadotipo"] = $tipo;
        $datos["idcompra"] = "DEFAULT";
        $datos["idcompraestado"] = "DEFAULT";
        $datos["idcompraitem"] = "DEFAULT";
        //var_dump($datos);


        list($idcompra, $resp) = $ambCompra->alta($datos);
        if ($resp) {
            $datos["idcompra"] = $idcompra;
            $ambCompraEstado->alta($datos);
            list($iditem, $respitem) = $ambitem->alta($datos);
            if ($respitem) {
                $datos["procantstock"] = $datos["procantstock"] - $datos["cicantidad"];
                $abmProducto->modificacion($datos);
                $respuesta = true;
            }
        }
        array_push($return, $idcompra,$iditem, $respuesta);
        return $return;
    }
}
