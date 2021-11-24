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
        $this->cefechaini=$valor;
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
        $sql = "SELECT * FROM CompraEstado WHERE idcompraestado = " . $this->getidcompraestado();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();                   
                    
                    $this->setear($row['idcompraestado'], $row['idcompra'], $row['idcompraestadotipo'], $row['cefechaini'], $row['cefechafin']);
                }
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->listar: " . $base->getError());
        }
        return $resp;
    }


    /** INSERTAR **/
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraestado(idcompraestado,idcompra,idcompraestadotipo,cefechaini,cefechafin)  VALUES('" . $this->getidcompraestado() . "','" . $this->getidcompra() . "','" . $this->getidcompraestadotipo() . "','" . $this->getcefechaini() ."','" .$this->getcefechafin() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidcompraestado($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("CompraEstado->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->insertar: " . $base->getError());
        }
        return $resp;
    }


    /** MODIFICAR **/
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE CompraEstado SET idcompra='" . $this->getidcompra() . "',";
        $sql .= "idcompraestadotipo=" . $this->getidcompraestadotipo() . ",";
        $sql .= "cefechafin='" . $this->getcefechafin() . "' ";
        $sql .= "WHERE idcompraestado='" . $this->getidcompraestado() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("CompraEstado->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->modificar: " . $base->getError());
        }
        return $resp;
    }


    /** ELIMINAR **/
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM CompraEstado WHERE idcompraestado=" . $this->getidcompraestado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("CompraEstado->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->eliminar: " . $base->getError());
        }
        return $resp;
    }


    /** LISTAR **/
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM CompraEstado ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        //var_dump($sql);
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new CompraEstado();
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
                    $obj->setear($row['idcompraestado'], $row['idcompra'], $row['idcompraestadotipo'], $row['cefechaini'],$row['cefechafin']);

                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setmensajeoperacion("CompraEstado->listar: ".$base->getError());
        }
        return $arreglo;
    }

     

}