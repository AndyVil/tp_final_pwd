<?php
class CargaDatos{

    /**
     * @param array $datos
     * @return array [[0]bool and [1]data] 
     */
    public function cargarCarrito($datos){
        $comprobacion = array_key_exists("idcompra", $datos);
        $datosRes = [];
        if ($comprobacion) {
            $abmItem = new AbmCompraItem();
            $abmcompra = new AbmCompra();
            $idcompra = $datos["idcompra"];
            $where = ['idcompra' => $idcompra];
            $compras = $abmcompra->buscar($where);
            $coprecio = $compras[0]->getcompraprecio();
            $items = $abmItem->buscar($where);
            $forItem = [];
            $i = 0;
            foreach ($items as $item) {
                $ciprecio = $item->getciprecio();
                $cicantidad = $item->getcicantidad();
                $idproducto = $item->getidproducto()->getidproducto();
                $proprecio = $item->getidproducto()->getproprecio();
                $pronombre = $item->getidproducto()->getpronombre();
                $procantstock = $item->getidproducto()->getprocantstock();
                $formulario = new Formulario();
                $infoArchivo = $formulario->obtenerArchivosPorId($idproducto);
                $link = $infoArchivo["link"];
                
                $forItem[$i] = [
                'ciprecio'=>$ciprecio,
                'cicantidad'=>$cicantidad,
                'idproducto'=>$idproducto,
                'proprecio'=>$proprecio,
                'pronombre'=>$pronombre,
                'procantstock'=>$procantstock,
                'link'=>$link
                ];
                $i++;
            }
            $datosRes = [
                'idcompra'=> $idcompra,
                'coprecio'=> $coprecio,
                'items'=>$forItem
            ];
            $return = ['comprobacion' => $comprobacion, 'datosRes' => $datosRes];
        }else{
            $abmItem = new AbmCompraItem();
            $abmproducto = new AbmProducto();
            $pronombre = $datos["pronombre"];
            $procantstock = $datos["procantstock"];
            $prodetalle = $datos["prodetalle"];
            $idproducto = $datos["idproducto"];
            $productos = $abmproducto->buscar($datos);
            $proprecio = $productos[0]->getproprecio();
            $cicantidad = $datos["cicantidad"];
            $ciprecio = $datos["ciprecio"];
            $formulario = new Formulario();
            $infoArchivo = $formulario->obtenerArchivosPorId($idproducto);
            $link = $infoArchivo["link"];

            $datosRes = [
                'pronombre' => $pronombre,
                'procantstock' => $procantstock,
                'prodetalle' => $prodetalle,
                'idproducto' => $idproducto,
                'proprecio' => $proprecio,
                'cicantidad' => $cicantidad,
                'ciprecio' => $ciprecio,
                'link' => $link
            ];
            $return = ['comprobacion' => $comprobacion, 'datosRes' => $datosRes];
        }
        return $return;
    }
}
?>