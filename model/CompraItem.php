<?php
class CompraItem
{
    private $idcompraitem;
    private $idproducto;
    private $idcompra;
    private $cicantidad;
    private $ciprecio;
    private $mensajeoperacion;


    /** CONSTRUCTOR **/
    public function __construct()
    {
        $this->idcompraitem = "";
        $this->idproducto = new Producto();
        $this->idcompra = new Compra();
        $this->cicantidad = "";
    }


    /** SETEAR **/
    public function setear($idcompraitem, $idproducto, $idcompra, $cicantidad,$precio)
    {
        $this->setidcompraitem($idcompraitem);
        $this->setidproducto($idproducto);
        $this->setidcompra($idcompra);
        $this->setcicantidad($cicantidad);
        $this->setciprecio($precio);
        
    }


    /** GETS **/
    public function getidcompra()
    {
        return $this->idcompra;
    }



    public function getidcompraitem()
    {
        return $this->idcompraitem;
    }

    public function getidproducto()
    {
        return $this->idproducto;
    }

    public function getcicantidad()
    {
        return $this->cicantidad;
    }

    public function getciprecio(){
        return $this->ciprecio;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }


    /** SETS **/


    public function setidcompraitem($valor)
    {
        $this->idcompraitem = $valor;
    }
    public function setidproducto($valor)
    {
        $this->idproducto = $valor;
    }
    public function setidcompra($valor)
    {
        $this->idcompra = $valor;
    }
    
    public function setcicantidad($valor)
    {
        $this->cicantidad = $valor;
    }

    public function setciprecio($valor){
        if ($valor<> NULL) {
            $this->ciprecio=$valor;
        }
        else if($valor ===""){
            $this->ciprecio=$valor;
        }
        elseif(is_string($this->getidproducto())){
            $abmProducto = new Producto();
            $where = "idproducto=".$this->getidproducto();
            $arr=$abmProducto->listar($where);
            $producto =$arr[0];
            $precio = $producto->getproprecio();
            $cant = $this->getcicantidad();
            $preciofinal= $precio*$cant;
            $this->ciprecio=$preciofinal;
        }
        else{            
            $precio = $this->getidproducto()->getprecio();
            $cant = $this->getcicantidad();
            $preciofinal= $precio*$cant;
            $this->ciprecio=$preciofinal;
        }

    }



    public function setmensajeoperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }


    /** CARGAR **/
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra WHERE idcompraitem = " . $this->getidcompraitem();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $idproducto = NULL;
                    if ($row['idproducto'] != null) {
                        $idproducto = new Producto();
                        $idproducto->setidproducto($row['idproducto']);
                        $idproducto->cargar();
                    } 
                    $idcompra = NULL;
                    if ($row['idcompra'] != null) {
                        $idcompra = new Compra();
                        $idcompra->setidcompra($row['idcompra']);
                        $idcompra->cargar();
                    }                   
                    $this->setear($row['idcompraitem'], $idproducto, $idcompra, $row['cicantidad'],$row['ciprecio']);
                    
                    
                }
            }
        } else {
            $this->setmensajeoperacion("compra->listar: " . $base->getError());
        }
        return $resp;
    }


    /** INSERTAR **/
    public function insertar()
    {
        $arr=array();
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraitem(idcompraitem,idproducto,idcompra,cicantidad, ciprecio)  VALUES('" . $this->getidcompraitem() . "','" . $this->getidproducto() ."','" . $this->getidcompra() ."','" . $this->getcicantidad(). "','" . $this->getciprecio() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidcompraitem($elid);
                $resp = true;
                array_push($arr,$resp,$elid);
                
            } else {
                $this->setmensajeoperacion("compraitem->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraitem->insertar: " . $base->getError());
        }
        //var_dump($arr);
        return $arr;
    }


    /** MODIFICAR **/
    public function modificar()
    {
        $this->setciprecio(null);
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraitem SET cicantidad='" . $this->getcicantidad() 
        . "',ciprecio='".$this->getciprecio() 
        . "' WHERE idcompraitem=" . $this->getidcompraitem();
        if ($base->Iniciar()) {
            //var_dump($sql);
            if ($base->Ejecutar($sql)) {
                $resp = true;
                
            } else {
                $this->setmensajeoperacion("compraitem->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraitem->modificar: " . $base->getError());
        }
        return $resp;
    }


    /** ELIMINAR **/
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompraitem=" . $this->getidcompraitem();
        if ($base->Iniciar()) {
            //var_dump($sql);
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compra->eliminar: " . $base->getError());
        }
        return $resp;
    }


    /** LISTAR **/
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        //var_dump($parametro);
        $sql = "SELECT * FROM compraitem ";
        if ($parametro != "") {
            //var_dump($parametro);
            $sql .= 'WHERE ' . $parametro;
            //var_dump($sql);
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new CompraItem();
                    $idproducto = NULL;
                    if ($row['idproducto'] != null) {
                        $idproducto = new Producto();
                        $idproducto->setidproducto($row['idproducto']);
                        $idproducto->cargar();
                    } 
                    $idcompra = NULL;
                    if ($row['idcompra'] != null) {
                        $idcompra = new Compra();
                        $idcompra->setidcompra($row['idcompra']);
                        $idcompra->cargar();
                    }     
                    $obj->setear($row['idcompraitem'], $idproducto,$idcompra,$row['cicantidad'],$row['ciprecio']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setmensajeoperacion("compra->listar: " . $base->getError());
        }
        return $arreglo;
    }


    /** TO STRING **/
    function __toString()
    {
        return $this->getidproducto();
    }
}
