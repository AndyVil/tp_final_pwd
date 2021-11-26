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
        $this->setidMenu($idmenu);
        $this->setidrol($idrol);
    }


    /** GETS **/
    public function getidMenu()
    {
        return $this->idmenu;
    }

    public function getidrol()
    {
        return $this->idrol;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }


    /** SETS **/
    public function setidMenu($idmenu)
    {
        $this->idmenu = $idmenu;
    }

    public function setidrol($idrol)
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
        $sql = "SELECT * FROM menurol WHERE idmenu = " . $this->getidMenu() . "and idrol =" . $this->getidrol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $idMenu = NULL;
                    if ($row['idmenu'] != null) {
                        $idMenu = new Menu();
                        $idMenu->setidmenu($row['idmenu']);
                        $idMenu->cargar();
                    }
                    $idRol = NULL;
                    if ($row['idrol'] != null) {
                        $idRol = new Rol();
                        $idRol->setIdrol($row['idrol']);
                        $idRol->cargar();
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
        $sql = "INSERT INTO menurol (idmenu,idrol)  VALUES ('" . $this->getidMenu() . "','" . $this->getidrol() . "')";
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
        $sql = "DELETE FROM menurol WHERE idmenu = " . $this->getidMenu() . "and idrol =" . $this->getidrol();
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
                    $idMenu = NULL;
                    if ($row['idmenu'] != null) {
                        $idMenu = new Menu();
                        $idMenu->setidmenu($row['idmenu']);
                        $idMenu->cargar();
                    }
                    $idRol = NULL;
                    if ($row['idrol'] != null) {
                        $idRol = new Rol();
                        $idRol->setIdrol($row['idrol']);
                        $idRol->cargar();
                    }
                    $id = new Menurol();
                    $id->setear($row['idmenu'], $row['idrol']);
                    array_push($arreglo, $id);
                }
            }
        } else {
            // $this->setmensajeoperacion("menurol->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
