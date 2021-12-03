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
        //echo "entro";
        $baja = $ambitem->baja($datos);
        //var_dump($baja);
        if ($baja) {
            //echo "elimino item";
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
        //var_dump($filtro);
        $filtro["idcompraestado"] = $carrito[0]->getidcompraestado();
        $filtro["idcompraestadotipo"] = 2;
        $filtro["cefechaini"] = null;
        $filtro["cefechafin"] = date('Y-m-d h:i:s');
        $filtro["cofecha"] = date('Y-m-d h:i:s');
        //var_dump($filtro);
        if ($ambCompraEstado->modificacion($filtro)) {
            //echo "modifico compra estado";
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
                        //echo "modifico item";
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
        array_push($return, $idcompra, $iditem, $respuesta);
        return $return;
    }



    public function arregloCarrito()
    {
        $arreglo = array();
        $obj = new Formulario();
        $abmCompra = new AbmCompra();
        $sesion = new Session();
        $ambCompraEstado = new AbmCompraEstado();
        $ambitems = new AbmCompraItem();


        if (!$sesion->activa()) {
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
                            $carrito = $ambCompraEstado->buscar($where);
                            if (count($carrito) > 0) {
                                break;
                            }
                        }
                        if (count($carrito) == 0) {
                            $arreglo = false;
                        } else {
                            $idcompra = $carrito[0]->getidcompra();
                            $filtro = ['idcompra' => $idcompra];
                            $items = $ambitems->buscar($filtro);
                            $i = 0;
                            foreach ($items as $item) {
                                $idproducto = $item->getidproducto()->getidproducto();
                                $producto = $item->getidproducto();
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
                        }
                    } else {
                        $arreglo = false;
                    }
                } else {
                    $arreglo = false;
                }
            } else {
                header('Location: ../inicio_cliente/index.php');
            }
        }
        return $arreglo;
    }


    public function eliminarCarrito($datos)
    {
        $sesion = new Session();
        $ambCompra = new AbmCompra();
        $ambitem = new AbmCompraItem();
        $Abmproducto = new AbmProducto();
        $ambCompraEstado = new AbmCompraEstado();
        $ambCompraEstadoTipo = new AbmCompraEstadoTipo();
        $arreglo = array();
        foreach ($datos as $clave => $valor) {
            $idcompraitem = str_replace("Seleccion:", '', $clave);
        }
        $datos["idcompraitem"] = $idcompraitem;
        $datos["idusuario"] = $sesion->getIdUser();
        if ($this->eliminarItem($datos)) {
            header('Location: index.php');
        }
    }

    public function compraExitosa($datos)
    {
        $resultado = [];
        $sesion = new Session();
        $ambCompra = new AbmCompra();
        $ambitem = new AbmCompraItem();
        $carrito = new Carrito();
        $Abmproducto = new AbmProducto();
        $ambCompraEstado = new AbmCompraEstado();
        $ambCompraEstadoTipo = new AbmCompraEstadoTipo();
        $arreglo   = array();
        $idcompra = "";

        if (array_key_exists("idcompra", $datos)) {
            $idcompra = $datos["idcompra"];
            $resp = $carrito->confirmarcarrito($datos);
            $filtroitem = array();
            $filtroitem["idcompra"] = $idcompra;
            $items = $ambitem->buscar($filtroitem);
            $compras = $ambCompra->buscar($filtroitem);
            $compra = $compras[0];
            $coprecio = $compra->getcompraprecio();
            $cofecha = $compra->getcofecha();
            $i = 0;
            foreach ($items as $item) {
                $id = $item->getidproducto()->getidproducto();
                $obj = new Formulario;
                $infoArchivo = $obj->obtenerArchivosPorId($id);
                $respuesta = $infoArchivo["Descripcion"];
                $link = $infoArchivo["link"];

                $where = array();
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
            header("Location: ../cuenta/misCompras.php");
        } else {
            $i = 0;
            $datos["idusuario"] = $sesion->getIdUser();
            list($idcompra, $iditem, $resp) = $carrito->crearcompra($datos, 2);
            $obj = new Formulario;
            $infoArchivo = $obj->obtenerArchivosPorId($datos["idproducto"]);
            $respuesta = $infoArchivo["Descripcion"];
            $link = $infoArchivo["link"];
            $filtroitem = array();
            $filtroitem["idcompra"] = $idcompra;
            $compras = $ambCompra->buscar($filtroitem);
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
            header("Location: ../cuenta/misCompras.php");
        }
        $resultado = ['arreglo' => $arreglo, 'idcompra' => $idcompra, 'coprecio' => $coprecio, 'cofecha' => $cofecha];
        return $resultado;
    }



    public function aniadirCarrito($datos)
    {
        $return = "";
        $resp = false;
        $todook = true;
        $sesion = new Session();
        $ambCompra = new AbmCompra();
        $ambitem = new AbmCompraItem();
        $Abmproducto = new AbmProducto();
        $ambCompraEstado = new AbmCompraEstado();
        $ambCompraEstadoTipo = new AbmCompraEstadoTipo();
        $datos["idusuario"] = $sesion->getIdUser();
        $compras = $ambCompra->buscar($datos);
        $objcarrito = array();
        if (count($compras) > 0) {
            foreach ($compras as $compra) {
                $where['idcompra'] = $compra->getidcompra();
                $where['idcompraestadotipo'] = 1;
                $objcarrito = $ambCompraEstado->buscar($where);

                if (count($objcarrito) > 0) {
                    break;
                }
            }
        }
        if (count($compras) == 0 || count($objcarrito) == 0) {
            list($idcompra, $iditem, $resp) = $this->crearcompra($datos, 1);
            $idproducto = $datos["idproducto"];
            header("Location: ../inicio_cliente/detallesProducto.php?mensaje=" . urlencode($idproducto) . "&carrito=" . urlencode($idcompra));

        } elseif (count($objcarrito) > 0) {
            $idcompra = $objcarrito[0]->getidcompra();
            $whereitem = array();
            $whereitem["idcompra"] = $idcompra;
            $whereitem["idproducto"] = $datos["idproducto"];
            $items =  $ambitem->buscar($whereitem);
            if (count($items) == 0) {
                $datos["idcompra"] = $idcompra;
                $datos["idcompraitem"] = "DEFAULT";
                $resp = $this->sumarItem($datos);
                $idproducto = $datos["idproducto"];
                header("Location: ../inicio_cliente/detallesProducto.php?mensaje=" . urlencode($idproducto) . "&carrito=" . urlencode($idcompra));
            } else {
                $datos["idcompra"] = $idcompra;
                $datos["idcompraitem"] = $items[0]->getidcompraitem();
                $stock = $items[0]->getidproducto()->getprocantstock();
                $idproducto = $items[0]->getidproducto()->getidproducto();
                if (($items[0]->getcicantidad() + $datos["cicantidad"]) > $stock) {
                    header("Location: ../inicio_cliente/detallesProducto.php?stock=" . urlencode($idproducto) . "&idcompra=" . urlencode($idcompra));
                    $datos["cicantidad"] = $stock;
                    $todook = false;
                }
                if ($todook) {
                    $datos["cicantidad"] = $items[0]->getcicantidad() + $datos["cicantidad"];
                    $datos["ciprecio"] = $items[0]->getciprecio();
                    $resp = $ambitem->modificacion($datos);
                }
                if ($resp) {
                    header("Location: ../inicio_cliente/detallesProducto.php?mensaje=" . urlencode($idproducto) . "&carrito=" . urlencode($idcompra));
                }
            }
        }

        return $return;
    }

    public function ingresoCarrito($datos)
    {
        $resultado = [];
        $sesion = new Session();
        $ambCompra = new AbmCompra();
        $ambitem = new AbmCompraItem();
        $Abmproducto = new AbmProducto();
        $ambCompraEstado = new AbmCompraEstado();
        $ambCompraEstadoTipo = new AbmCompraEstadoTipo();
        $obj = new Formulario;
        $infoArchivo = $obj->obtenerArchivosPorId($datos["idproducto"]);
        $respuesta = $infoArchivo["Descripcion"];
        $link = $infoArchivo["link"];
        $id = $datos["idproducto"];
        $where = ['idproducto' => $id];
        $productos = $Abmproducto->buscar($where);
        $precio = $productos[0]->getproprecio();
        $nombre = $productos[0]->getpronombre();
        $stock = $productos[0]->getprocantstock();
        $detalle = $productos[0]->getprodetalle();

        $resultado = [
            'link' => $link,
            'id' => $id,
            'precio' => $precio,
            'nombre' => $nombre,
            'stock' => $stock,
            'detalle' => $detalle
        ];
        return $resultado;
    }
}
