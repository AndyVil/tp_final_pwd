<?php
class Compra
{
    private $idcompra;
    private $cofecha;
    private $idusuario;
    private $coprecio;
    private $mensajeoperacion;
    // private $arrayItems;


    /** CONSTRUCTOR **/
    public function __construct()
    {
        $this->idcompra = "";
        $this->cofecha = "";
        $this->idusuario = new Usuario();
    }


    /** SETEAR **/
    public function setear($idcompra, $cofecha, $idusuario, $precio)
    {
        $this->setidcompra($idcompra);
        $this->setcofecha($cofecha);
        $this->setidusuario($idusuario);
        $this->setcompraprecio($precio);
        //$this->setarrayItems();
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
    public function getcompraprecio()
    {
        return $this->coprecio;
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
                    $objUsuario = NULL;
                    if ($row['idusuario'] != null) {
                        $objUsuario = new Usuario();
                        $objUsuario->setidusuario($row['idusuario']);
                        $objUsuario->cargar();
                    }
                    $this->setear($row['idcompra'], $row['cofecha'],$objUsuario,$row['coprecio']);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("compra->listar: " . $base->getError());
        }
        return $resp;
    }

    // public function getarrayItems(){        
    //     return $this->arrayItems;;
    // }
    // /** inicializa la lista de items de la compra **/
    // public function setarrayItems()
    // {
    //     $arr = array();
    //     $condicion = "idcompra='" . $this->getidcompra() . "'";
    //     $objCompraItem = new CompraItem();
    //     $colCompraItems = $objCompraItem->listar($condicion);
    //     foreach ($colCompraItems as $CompraItem) {
    //         array_push($arr, $CompraItem);
    //     }
    //     $this->arrayItems= $arr;
    // }

    public function setcompraprecio($valor){
        $precio= $valor; 
        if($valor ==null){
            $precio = $this->getcompraprecio();
            $items = new CompraItem();
            $where = 'idcompra='. $this->getidcompra();
            //var_dump($where);
            $colCompraItems = $items->listar($where);
            foreach ($colCompraItems as $item){
                $precio =+$item->getciprecio();
            }
        }     
               
        //$colItems = $this->getarrayItems();
        
        return $precio;
    }

    /** INSERTAR **/
    public function insertar()
    {
        $arr=array();
        
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compra(idcompra,cofecha,idusuario,coprecio)  VALUES('" . $this->getidcompra() . "','" . $this->getcofecha() . "','" . $this->getidusuario() ."','" . $this->getcompraprecio() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidcompra($elid);
                $resp = true;
                array_push($arr,$resp,$elid);
            } else {
                $this->setmensajeoperacion("compra->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compra->insertar: " . $base->getError());
        }
        return $arr;
    }


    /** MODIFICAR **/
    public function modificar()
    {   
        $this->setcompraprecio(null);     
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compra SET coprecio='" . $this->getcompraprecio() . "'
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
                    $objUsuario = NULL;
                    if ($row['idusuario'] != null) {
                        $objUsuario = new Usuario();
                        $objUsuario->setidusuario($row['idusuario']);
                        $objUsuario->cargar();
                    }
                    $obj->setear($row['idcompra'], $row['cofecha'],$objUsuario,$row['coprecio'] );
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
