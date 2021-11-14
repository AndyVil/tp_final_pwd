<?php
class MenuRol
{
    private $idrol;
    private $idmenu;
    private $mensajeoperacion;


    /** CONSTRUCTOR **/
    public function __construct()
    {
        $this->idmenu = new Menu();
        $this->idrol = new Rol();
        $this->mensajeoperacion = "";
    }


    /** SETEAR **/
    public function setear($idmenu, $idrol)
    {
        $this->setobjMenu($idmenu);
        $this->setobjrol($idrol);
    }


    /** GETS **/
    public function getobjMenu()
    {
        return $this->idmenu;
    }

    public function getobjrol()
    {
        return $this->idrol;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }


    /** SETS **/
    public function setobjMenu($idmenu)
    {
        $this->idmenu = $idmenu;
    }

    public function setobjrol($idrol)
    {
        $this->idrol = $idrol;
    }

    public function setMensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }


    /** CARGAR **/
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol WHERE idmenu = " . $this->getobjMenu() . "and idrol =" . $this->getobjrol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $objMenu = NULL;
                    if ($row['idmenu'] != null) {
                        $objMenu = new Menu();
                        $objMenu->setidmenu($row['idmenu']);
                        $objMenu->cargar();
                    }
                    $objRol = NULL;
                    if ($row['idrol'] != null) {
                        $objRol = new Rol();
                        $objRol->setIdrol($row['idrol']);
                        $objRol->cargar();
                    }
                    $this->setear($row['idmenu'], $row['idrol']);
                }
            }
        } else {
            $this->setmensajeoperacion("Menurol->listar: " . $base->getError());
        }
        return $resp;
    }


    /** INSERTAR **/
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO menurol (idmenu,idrol)  VALUES ('" . $this->getobjMenu()->getidmenu() . "','" . $this->getobjrol()->getIdrol() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("menurol->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menurol->insertar: " . $base->getError());
        }
        return $resp;
    }


    /** ELIMINAR **/
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM menurol WHERE idmenu = " . $this->getobjMenu() . "and idrol =" . $this->getobjrol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("menurol->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menurol->eliminar: " . $base->getError());
        }
        return $resp;
    }


    /** LISTAR **/
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $consultasql = "SELECT * FROM menurol ";
        if ($parametro != "") {
            $consultasql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($consultasql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $objMenu = NULL;
                    if ($row['idmenu'] != null) {
                        $objMenu = new Menu();
                        $objMenu->setidmenu($row['idmenu']);
                        $objMenu->cargar();
                    }
                    $objRol = NULL;
                    if ($row['idrol'] != null) {
                        $objRol = new Rol();
                        $objRol->setIdrol($row['idrol']);
                        $objRol->cargar();
                    }
                    $obj = new Menurol();
                    $obj->setear($objMenu, $objRol);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            // $this->setmensajeoperacion("menurol->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
