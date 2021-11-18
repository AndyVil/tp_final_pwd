<?php
class UsuarioRol
{
    private $objrol;
    private $objusuario;
    private $mensajeoperacion;


    /** CONSTRUCTOR **/
    public function __construct()
    {
        $this->objusuario = new Usuario();
        $this->objrol = new Rol();
        $this->mensajeoperacion = "";
    }


    /** SETEAR **/
    public function setear($usuario, $rol)
    {
        $this->setobjusuario($usuario);
        $this->setobjrol($rol);
    }


    /** GETS **/
    public function getobjusuario()
    {
        return $this->objusuario;
    }

    public function getobjrol()
    {
        return $this->objrol;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }


    /** SETS **/
    public function setobjusuario($usuario)
    {
        $this->objusuario = $usuario;
    }

    public function setobjrol($rol)
    {
        $this->objrol = $rol;
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
        $sql = "SELECT * FROM usuariorol WHERE idusuario = " . $this->getobjusuario() . "and idrol =" . $this->getobjrol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $objUsuario = NULL;
                    if ($row['idsuario'] != null) {
                        $objUsuario = new Usuario();
                        $objUsuario->setIdusuario($row['idusuario']);
                        $objUsuario->cargar();
                    }
                    $objRol = NULL;
                    if ($row['idrol'] != null) {
                        $objRol = new Rol();
                        $objRol->setIdrol($row['idrol']);
                        $objRol->cargar();
                    }
                    $this->setear($objUsuario, $objRol);
                }
            }
        } else {
            $this->setmensajeoperacion("usuariorol->listar: " . $base->getError());
        }
        return $resp;
    }


    /** INSERTAR **/
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuariorol (idusuario,idrol)  VALUES ('" . $this->getobjusuario(). "','" . $this->getobjrol() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("usuariorol->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuariorol->insertar: " . $base->getError());
        }
        return $resp;
    }


    /** ELIMINAR **/
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuariorol WHERE idusuario = " . $this->getobjusuario() . "and idrol =" . $this->getobjrol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("usuariorol->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuariorol->eliminar: " . $base->getError());
        }
        return $resp;
    }

    

    /** LISTAR **/
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $consultasql = "SELECT * FROM usuariorol ";
        if ($parametro != "") {
            $consultasql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($consultasql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $objUsuario = NULL;
                    if ($row['idusuario'] != null) {
                        $objUsuario = new Usuario();
                        $objUsuario->setIdusuario($row['idusuario']);
                        $objUsuario->cargar();
                    }
                    $objRol = NULL;
                    if ($row['idrol'] != null) {
                        $objRol = new Rol();
                        $objRol->setIdrol($row['idrol']);
                        $objRol->cargar();
                    }
                    $obj = new UsuarioRol();
                    $obj->setear($objUsuario, $objRol);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            // $this->setmensajeoperacion("Auto->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
