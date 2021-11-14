<?php
class Compra
{
    private $idcompra;
    private $cofecha;
    private $idusuario;
    private $mensajeoperacion;


    /** CONSTRUCTOR **/
    public function __construct()
    {
        $this->idcompra = "";
        $this->cofecha = "";
        $this->idusuario = new Usuario();
    }


    /** SETEAR **/
    public function setear($idcompra, $cofecha, $idusuario)
    {
        $this->setidcompra($idcompra);
        $this->setcofecha($cofecha);
        $this->setidusuario($idusuario);
    }


    /** GETS **/
    public function getidusuario()
    {
        return $this->idusuario;
    }

    public function getidcompra()
    {
        return $this->idcompra;
    }

    public function getcofecha()
    {
        return $this->cofecha;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }


    /** SETS **/


    public function setidcompra($valor)
    {
        $this->idcompra = $valor;
    }
    public function setcofecha($valor)
    {
        $this->cofecha = $valor;
    }
    public function setidusuario($valor)
    {
        $this->idusuario = $valor;
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
        $sql = "SELECT * FROM compra WHERE idcompra = " . $this->getidcompra();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idcompra'], $row['cofecha'],$row['idusuario'] );
                    $objUsuario = NULL;
                    if ($row['idproducto'] != null) {
                        $objUsuario = new Usuario();
                        $objUsuario->setidusuario($row['idproducto']);
                        $objUsuario->cargar();
                    }
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
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compra(idcompra,cofecha,idusuario)  VALUES('" . $this->getidcompra() . "','" . $this->getcofecha() . "','" . $this->getidusuario() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidcompra($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("compra->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compra->insertar: " . $base->getError());
        }
        return $resp;
    }


    /** MODIFICAR **/
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compra SET cofecha='" . $this->getcofecha() . "'
        WHERE idcompra=" . $this->getidcompra();
        if ($base->Iniciar()) {
            //var_dump($sql);
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compra->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compra->modificar: " . $base->getError());
        }
        return $resp;
    }


    /** ELIMINAR **/
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compra WHERE idcompra=" . $this->getidcompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
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
        $sql = "SELECT * FROM compra ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Compra();
                    $obj->setear($row['idcompra'], $row['cofecha'],$row['idusuario']);
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
        return $this->getcofecha();
    }
}
