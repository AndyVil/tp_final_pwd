<?php
class CompraItem
{
    private $idcompraitem;
    private $objproducto;
    private $objcompra;
    private $cicantidad;
    private $mensajeoperacion;


    /** CONSTRUCTOR **/
    public function __construct()
    {
        $this->idcompraitem = "";
        $this->objproducto = new Producto();
        $this->objcompra = new Compra();
        $this->cicantidad = "";
    }


    /** SETEAR **/
    public function setear($idcompraitem, $objproducto, $idcompra, $cicantidad)
    {
        $this->setidcompraitem($idcompraitem);
        $this->setobjproducto($objproducto);
        $this->setobjcompra($idcompra);
        $this->setcicantidad($cicantidad);
        
    }


    /** GETS **/
    public function getobjcompra()
    {
        return $this->objcompra;
    }

    public function getidcompraitem()
    {
        return $this->idcompraitem;
    }

    public function getobjproducto()
    {
        return $this->objproducto;
    }

    public function getcicantidad()
    {
        return $this->cicantidad;
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
    public function setobjproducto($valor)
    {
        $this->objproducto = $valor;
    }
    public function setobjcompra($valor)
    {
        $this->objcompra = $valor;
    }
    
    public function setcicantidad($valor)
    {
        $this->cicantidad = $valor;
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
                    $objProducto = NULL;
                    if ($row['idproducto'] != null) {
                        $objProducto = new Producto();
                        $objProducto->setidproducto($row['idproducto']);
                        $objProducto->cargar();
                    } 
                    $objcompra = NULL;
                    if ($row['idcompra'] != null) {
                        $objcompra = new Producto();
                        $objcompra->setidproducto($row['idcompra']);
                        $objcompra->cargar();
                    }                   
                    $this->setear($row['idcompraitem'], $objProducto, $objcompra, $row['cicantidad']);
                    
                    
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
        $sql = "INSERT INTO compraitem(idcompraitem,idproducto,idcompra,cicantidad)  VALUES('" . $this->getidcompraitem() . "','" . $this->getobjproducto() ."','" . $this->getobjcompra() ."','" . $this->getcicantidad() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidcompraitem($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraitem->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraitem->insertar: " . $base->getError());
        }
        return $resp;
    }


    /** MODIFICAR **/
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraitem SET cicantidad='" . $this->getcicantidad() . "'
        WHERE idcompraitem=" . $this->getidcompraitem();
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
        $sql = "SELECT * FROM compraitem ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new CompraItem();
                    $objProducto = NULL;
                    if ($row['idproducto'] != null) {
                        $objProducto = new Producto();
                        $objProducto->setidproducto($row['idproducto']);
                        $objProducto->cargar();
                    } 
                    $objcompra = NULL;
                    if ($row['idcompra'] != null) {
                        $objcompra = new Producto();
                        $objcompra->setidproducto($row['idcompra']);
                        $objcompra->cargar();
                    }     
                    $obj->setear($row['idcompraitem'], $objProducto,$objcompra, $row['cicantidad']);
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
        return $this->getobjproducto();
    }
}
