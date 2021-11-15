<?php 
Class CompraEstado{
    
  private $idcompraestado;
  private $idcompra;
  private $idcompraestadotipo;
  private $cefechaini;
  private $cefechafin;
  private $mensajeoperacion;
  

  public function __construct()
    {
        $this->idcompraestado = "";
        $this->idcompra = "";
        $this->idcompraestadotipo = "";
        $this->cefechaini = "";
        $this->cefechafin = "";
    }


    /** SETEAR **/
    public function setear($idcompraestado, $idcompra, $idcompraestadotipo, $cefechaini, $cefechafin)
    {
        $this->setidcompraestado($idcompraestado);
        $this->setidcompra($idcompra);
        $this->setidcompraestadotipo($idcompraestadotipo);
        $this->setcefechaini($cefechaini);
        $this->setcefechafin($cefechafin);
    }


    /** GETS Y SETS **/
    public function getidcompraestado()
    {
        return $this->idcompraestado;
    }

    public function setidcompraestado($valor)
    {
        $this->idcompraestado = $valor;
    }

    public function getidcompra()
    {
        return $this->idcompra;
    }

    public function setidcompra($valor)
    {
        $this->idcompra = $valor;
    }

    public function getidcompraestadotipo()
    {
        return $this->idcompraestadotipo;
    }

    public function setidcompraestadotipo($valor)
    {
        $this->idcompraestadotipo = $valor;
    }

    public function getcefechaini()
    {
        return $this->cefechaini;
    }

    public function setcefechaini($valor)
    {
        $this->cefechaini->$valor;
        //var_dump($valor);

        // $cefechaini = $this->getidcompraestado();
        // $cefechaini->setidgetidcompraestado($valor);
        // $this->cefechaini = $cefechaini;
        // $this->cefechaini->cargar();
        
    }

    public function getcefechafin()
    {
        return $this->cefechafin;
    }

    public function setcefechafin($valor)
    {
        $this->cefechafin = $valor;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
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
        $sql = "SELECT * FROM menu WHERE idcompraestado = " . $this->getidcompraestado();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();                   
                    
                    $this->setear($row['idcompraestado'], $row['idcompra'], $row['idcompraestadotipo'], $row['cefechaini'], $row['cefechafin']);
                }
            }
        } else {
            $this->setmensajeoperacion("menu->listar: " . $base->getError());
        }
        return $resp;
    }


    /** INSERTAR **/
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO menu(idcompraestado,idcompra,idcompraestadotipo,cefechaini,menudesabilitado)  VALUES('" . $this->getidcompraestado() . "','" . $this->getidcompra() . "','" . $this->getidcompraestadotipo() . "','" . $this->getcefechaini()->getidcompraestado() ."','" .$this->getcefechafin() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidcompraestado($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("menu->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->insertar: " . $base->getError());
        }
        return $resp;
    }


    /** MODIFICAR **/
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE menu SET idcompra='" . $this->getidcompra() . "',";
        $sql .= "idcompraestadotipo=" . $this->getidcompraestadotipo() . ",";
        $sql .= "cefechafin='" . $this->getcefechafin() . "' ";
        $sql .= "WHERE idcompraestado='" . $this->getidcompraestado() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("menu->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->modificar: " . $base->getError());
        }
        return $resp;
    }


    /** ELIMINAR **/
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM menu WHERE idcompraestado=" . $this->getidcompraestado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("menu->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->eliminar: " . $base->getError());
        }
        return $resp;
    }


    /** LISTAR **/
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Menu();
                    $objcompra = NULL;
                    if ($row['cefechaini'] != null) {
                        $objcompra = new Compra();
                        $objcompra->setidcompra($row['idcompra']);
                        $objcompra->cargar();
                    }
                    $objcet = NULL;
                    if ($row['idcompraestadotipo'] != null) {
                        $objcet = new CompraEstadoTipo();
                        $objcet->setidcompraestadotipo($row['idcompraestadotipo']);
                        $objcet->cargar();
                    }
                    $obj->setear($row['idcompraestado'], $objcompra, $objcet, $row['cefechaini'],$row['cefechafin']);

                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setmensajeoperacion("menu->listar: ".$base->getError());
        }
        return $arreglo;
    }

     

}