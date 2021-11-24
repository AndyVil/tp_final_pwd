<?php

class Carrito
{

    public function crearNuevoCarrito($datos,$iduser)
    {
        $return = array();
        $respuesta= false;
        $ambCompra = new AbmCompra();
        $ambitem = new AbmCompraItem();
        $ambCompraEstado = new AbmCompraEstado();
        $ambCompraEstadoTipo = new AbmCompraEstadoTipo();  
        date_default_timezone_set("America/Argentina/Buenos_Aires");

        $datos["idcompra"] = "DEFAULT";
        $datos["cofecha"] = date('Y-m-d h:i:s');
        $datos["idusuario"] = $iduser;
        $datos["coprecio"] = $datos["ciprecio"];
        $datos["proprecio"]= $datos["ciprecio"];
        $datos["cefechaini"] = date('Y-m-d h:i:s');
        $datos["cefechafin"] = null;
        $datos["idcompraestadotipo"] = 1; 
        $datos["idcompra"] = "DEFAULT";
        $datos["idcompraestado"] = "DEFAULT"; 
        $datos["idcompraitem"] = "DEFAULT";          
        //var_dump($datos);
        list($idcompra,$resp)=$ambCompra->alta($datos);
        if($resp){
            $datos["idcompra"] = $idcompra;

            $ambCompraEstado->alta($datos);                      
            if($ambitem->alta($datos)){
                $respuesta= true;                
            }
        }
        array_push($return,$idcompra,$respuesta); 
        return $return;       
    }
    public function sumarItem($datos){
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $return = false;
        $ambCompra = new AbmCompra();
        $ambitem = new AbmCompraItem(); 
        $datos["cofecha"] = date('Y-m-d h:i:s');       
        //var_dump($datos);
        
        if($ambitem->alta($datos)){
            if($ambCompra->modificacion($datos)){
                $return= true;
            }

        }        
        
        return $return;   
    }
}
