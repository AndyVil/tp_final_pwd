<?php 
Class Menu{
    
  private $idMenu;
  private $menuNombre;
  private $menuDescripcion;
  private $objpadre;
  private $menuDeshabilitado;
  private $mensajeoperacion;
  

  public function __construct()
    {
        $this->idMenu = "";
        $this->menuNombre = "";
        $this->menuDescripcion = "";
        $this->objpadre = new Menu();
        $this->menuDeshabilitado = "";
    }


    /** SETEAR **/
    public function setear($idMenu, $menuNombre, $menuDescripcion, $objpadre, $menuDeshabilitado)
    {
        $this->setidMenu($idMenu);
        $this->setmenuNombre($menuNombre);
        $this->setmenuDescripcion($menuDescripcion);
        $this->setobjpadre($objpadre);
        $this->setmenuDeshabilitado($menuDeshabilitado);
    }


    /** GETS Y SETS **/
    public function getidMenu()
    {
        return $this->idMenu;
    }

    public function setidMenu($valor)
    {
        $this->idMenu = $valor;
    }

    public function getmenuNombre()
    {
        return $this->menuNombre;
    }

    public function setmenuNombre($valor)
    {
        $this->menuNombre = $valor;
    }

    public function getmenuDescripcion()
    {
        return $this->menuDescripcion;
    }

    public function setmenuDescripcion($valor)
    {
        $this->menuDescripcion = $valor;
    }

    public function getobjpadre()
    {
        return $this->objpadre;
    }

    public function setobjpadre($valor)
    {
        $this->objpadre->$valor;
        //var_dump($valor);

        // $idPadre = $this->getidMenu();
        // $idPadre->setidgetidMenu($valor);
        // $this->idPadre = $idPadre;
        // $this->idPadre->cargar();
        
    }

    public function getmenuDeshabilitado()
    {
        return $this->menuDeshabilitado;
    }

    public function setmenuDeshabilitado($valor)
    {
        $this->menuDeshabilitado = $valor;
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
        $sql = "SELECT * FROM menu WHERE idmenu = " . $this->getidMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();                   
                    $objpadre = NULL;
                    if ($row['idpadre'] != null) {
                        $objpadre = new Menu();
                        $objpadre->setidMenu($row['ipPadre']);
                        $objpadre->cargar();
                    }
                    $this->setear($row['idmenu'], $row['menunombre'], $row['menudescripcion'], $objpadre, $row['menudeshabilitado']);
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
        $sql = "INSERT INTO menu(idmenu,menunombre,menudescripcion,idpadre,menudesabilitado)  VALUES('" . $this->getidMenu() . "','" . $this->getmenuNombre() . "','" . $this->getmenuDescripcion() . "','" . $this->getobjpadre()->getidMenu() ."','" .$this->getmenuDeshabilitado() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidMenu($elid);
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
        $sql = "UPDATE menu SET menunombre='" . $this->getmenuNombre() . "',";
        $sql .= "menudescripcion=" . $this->getmenuDescripcion() . ",";
        $sql .= "menudeshabilitado='" . $this->getmenuDeshabilitado() . "' ";
        $sql .= "WHERE idmenu='" . $this->getidMenu() . "'";
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
        $sql = "DELETE FROM menu WHERE idmenu=" . $this->getidMenu();
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
                    $objpadre = NULL;
                    if ($row['idpadre'] != null) {
                        $objpadre = new Menu();
                        $objpadre->setidMenu($row['idpadre']);
                        $objpadre->cargar();
                    }
                    $obj->setear($row['idmenu'], $row['menunombre'], $row['menudescripcion'], $objpadre,$row['menudeshabilitado']);

                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setmensajeoperacion("menu->listar: ".$base->getError());
        }
        return $arreglo;
    }

     

}