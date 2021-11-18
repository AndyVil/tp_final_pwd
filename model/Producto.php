<?php
class Producto
{
    private $idproducto;
    private $pronombre;
    private $prodetalle;
    private $procantstock;
    private $proprecio;
    private $mensajeoperacion;


    /** CONSTRUCTOR **/
    public function __construct()
    {
        $this->idproducto = "";
        $this->pronombre = "";
        $this->prodetalle = "";
        $this->procantstock = "";
        $this->proprecio = "";
    }


    /** SETEAR **/
    public function setear($idproducto, $pronombre, $prodetalle, $procantstock,$proprecio )
    {
        $this->setidproducto($idproducto);
        $this->setpronombre($pronombre);
        $this->setprodetalle($prodetalle);
        $this->setprocantstock($procantstock);
        $this->setproprecio($proprecio);
        
    }

    
    /** GETS **/
    public function getprodetalle()
    {
        return $this->prodetalle;
    }

    public function getidproducto()
    {
        return $this->idproducto;
    }

    public function getpronombre()
    {
        return $this->pronombre;
    }

    public function getprocantstock()
    {
        return $this->procantstock;
    }
    public function getproprecio(){
        return $this->proprecio;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }


    /** SETS **/


    public function setidproducto($valor)
    {
        $this->idproducto = $valor;
    }
    public function setpronombre($valor)
    {
        $this->pronombre = $valor;
    }
    public function setprodetalle($valor)
    {
        $this->prodetalle = $valor;
    }
    
    public function setprocantstock($valor)
    {
        $this->procantstock = $valor;
    }
    public function setproprecio($valor)
    {
        $this->proprecio = $valor;
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
        $sql = "SELECT * FROM producto WHERE idproducto = " . $this->getidproducto();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idproducto'], $row['pronombre'],$row['prodetalle'], $row['procantstock'], $row['proprecio']);
                }
            }
        } else {
            $this->setmensajeoperacion("producto->listar: " . $base->getError());
        }
        return $resp;
    }


    /** INSERTAR **/
    public function insertar()
    {
        $arr=array();
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO producto(idproducto,pronombre,prodetalle,procantstock,proprecio)  VALUES(". $this->getidproducto() . ",'" . $this->getpronombre() ."','" . $this->getprodetalle() ."','" . $this->getprocantstock(). "','"  . $this->getproprecio() ."');";
        //var_dump($sql);
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidproducto($elid);
                $resp = true;
                array_push($arr,$resp,$elid);
            } else {
                $this->setmensajeoperacion("producto->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->insertar: " . $base->getError());
        }
        return $arr;
    }


    /** MODIFICAR **/
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE producto SET pronombre='" . $this->getpronombre() . "',
        prodetalle='" . $this->getprodetalle() . "',
        procantstock='" . $this->getprocantstock(). "',
        proprecio='" . $this->getproprecio()  . "'
        WHERE idproducto=" . $this->getidproducto();
        if ($base->Iniciar()) {
            //var_dump($sql);
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("producto->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->modificar: " . $base->getError());
        }
        return $resp;
    }


    /** ELIMINAR **/
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM producto WHERE idproducto=" . $this->getidproducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("producto->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->eliminar: " . $base->getError());
        }
        return $resp;
    }

    

    /** LISTAR **/
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Producto();
                    $obj->setear($row['idproducto'], $row['pronombre'],$row['prodetalle'], $row['procantstock'],$row['proprecio']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setmensajeoperacion("producto->listar: " . $base->getError());
        }
        return $arreglo;
    }


    /** TO STRING **/
    function __toString()
    {
        return $this->getpronombre();
    }
}
