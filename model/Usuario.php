<?php
class Usuario
{
    private $idusuario;
    private $usnombre;
    private $uspass;
    private $usmail;
    private $usdeshabilitado;
    //private $arrayRol;
    //private $arrayCompra;


    /** CONSTRUCTOR **/
    public function __construct()
    {
        $this->idusuario = "";
        $this->usnombre = "";
        $this->uspass = "";
        $this->usmail = "";
        $this->usdeshabilitado = "";
    }


    /** SETEAR **/
    public function setear($idusuario, $usnombre, $uspass, $usmail, $usdeshabilitado)
    {
        $this->setidusuario($idusuario);
        $this->setusnombre($usnombre);
        $this->setuspass($uspass);
        $this->setusmail($usmail);
        $this->setusdeshabilitado($usdeshabilitado);
        // $this->setarrayRol();
        // $this->setarrayCompra();
    }

    // public function getarrayRol(){        
    //     return $this->arrayRol;
    // }
    // /** inicializa la lista de roles del usuario **/
    // public function setarrayRol()
    // {
    //     $arr = array();
    //     $condicion = "idusuario='" . $this->getidusuario() . "'";
    //     $objUsuarioRol = new UsuarioRol();
    //     $colCompras = $objUsuarioRol->listar($condicion);
    //     foreach ($colCompras as $UsuarioRol) {
    //         $rol = $UsuarioRol->getobjrol();
    //         array_push($arr, $rol);
    //     }
    //     $this->arrayRol= $arr;
    // }

    // public function getarrayCompra(){        
    //     return $this->arrayCompra;
    // }
    // /** inicializa la lista de compras del usuario **/
    // public function setarrayCompra()
    // {
    //     $arr = array();
    //     $condicion = "idusuario='" . $this->getidusuario() . "'";
    //     $objCompra = new Compra();
    //     $colCompras = $objCompra->listar($condicion);
    //     foreach ($colCompras as $compra) {            
    //         array_push($arr, $compra);
    //     }
    //     $this->arrayCompra= $arr;
    // }


    /** GETS Y SETS **/
    public function getidusuario()
    {
        return $this->idusuario;
    }

    public function setidusuario($valor)
    {
        $this->idusuario = $valor;
    }

    public function getusnombre()
    {
        return $this->usnombre;
    }

    public function setusnombre($valor)
    {
        $this->usnombre = $valor;
    }

    public function getuspass()
    {
        return $this->uspass;
    }

    public function setuspass($valor)
    {
        $this->uspass = $valor;
    }

    public function getusmail()
    {
        return $this->usmail;
    }

    public function setusmail($valor)
    {
        $this->usmail = $valor;
    }

    public function getusdeshabilitado()
    {
        return $this->usdeshabilitado;
    }

    public function setusdeshabilitado($valor)
    {
        $this->usdeshabilitado = $valor;
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
        $sql = "SELECT * FROM usuario WHERE idusuario = " . $this->getidusuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                }
            }
        } else {
            $this->setmensajeoperacion("usuario->listar: " . $base->getError());
        }
        return $resp;
    }


    /** INSERTAR **/
    public function insertar()
    {   
        $arr=array();
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuario(idusuario,usnombre,uspass,usmail,usdeshabilitado) VALUES('" . $this->getidusuario() . "','" . $this->getusnombre() . "','" . $this->getuspass() . "','" . $this->getusmail() . "','" . $this->getusdeshabilitado() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidusuario($elid);
                $resp = true;
                array_push($arr,$resp,$elid);
            } else {
                $this->setmensajeoperacion("usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->insertar: " . $base->getError());
        }
        return $arr;
    }


    /** MODIFICAR **/
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuario SET usnombre='" . $this->getusnombre() . "',
        uspass='" . $this->getuspass() . "',
        usmail='" . $this->getusmail() . "',
        usdeshabilitado='" . $this->getusdeshabilitado() . "'
        WHERE idusuario=" . $this->getidusuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->modificar: " . $base->getError());
        }
        return $resp;
    }


    /** ELIMINAR **/
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idusuario=" . $this->getidusuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("usuario->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->eliminar: " . $base->getError());
        }
        return $resp;
    }


    /** LISTAR **/
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Usuario();
                    $obj->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setmensajeoperacion("Usuario->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
