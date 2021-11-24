<?php

/*3. Implementar dentro de la capa de Control la clase Session con los siguientes métodos:
• _ _construct(). Constructor que. Inicia la sesión.
• iniciar($nombreUsuario,$passUsuario). Actualiza las variables de sesión con los valores ingresados.
• validar(). Valida si la sesión actual tiene usuario y passUsuario válidos. Devuelve true o false.
• activa(). Devuelve true o false si la sesión está activa o no. 
• getUsuario().Devuelve el usuario logeado.
• getRol(). Devuelve el rol del usuario logeado.
• cerrar(). Cierra la sesión actual.
 */


class Session
{
    private $objUser;    

    /** CONSTRUCTOR **/
    public function __construct()
    {
        $sesionIni = session_status() == PHP_SESSION_ACTIVE;
        if(!$sesionIni)session_start();
    }


    /** GETS Y SETS **/
    public function getIdUser()
    {
        return $_SESSION['idusuario'];
    }

    public function setIdUser($idUser)
    {
        $_SESSION['idusuario'] = $idUser;
    }

    public function getUserName()
    {
        return $_SESSION['usnombre'];
    }

    public function setUserName($userName)
    {
        $_SESSION['usnombre'] = $userName;
    }

    public function getPass()
    {
        return $_SESSION['uspass'];
    }
    public function setPass($pass)
    {
        $_SESSION['uspass'] = $pass;
    }


    /** INICIAR **/
    public function iniciar($nombreUsuario, $passUsuario)
    {
        $this->setUserName($nombreUsuario);
        $this->setPass($passUsuario);
    }


    /** VALIDAR **/
    public function validar()
    {

        $inicia = false;
        $nombreUsuario = $this->getUserName();
        $passUsuario = $this->getPass();
        $abmUsuario = new AbmUsuario();
        $where = array();
        $filtro1 = array();
        $filtro1['usnombre'] = $nombreUsuario;
        $filtro2 = array();
        $filtro2['uspass'] = $passUsuario;
        $where['usnombre'] = $nombreUsuario;
        $where['uspass'] = $passUsuario;
        $listaUsuarios = $abmUsuario->buscar($where);
        $username = $abmUsuario->buscar($filtro1);
        $pass =  $abmUsuario->buscar($filtro2);
        $error = '';
        
        if ($username == null||$pass == null) {
            $error .= "Datos de login incorrectos";
        } 
        if (count($listaUsuarios) > 0) {
            if ($listaUsuarios[0]->getUsdeshabilitado()!= '0000-00-00 00:00:00') {
                $error .= "El usuario está deshabilitado";
            } else {
                $inicia = true;
                $id= $listaUsuarios[0]->getidusuario();
                $this->setIdUser($id);
                $this->setobjUsuario($id);
            }
        }
        return array($inicia, $error);
    }
    
    /**
     * @param idrol
     * Se podria usar el motodo obtener rol, para obtener el arreglo y con eso verificar los roles de los usuarios
     */
    public function validarRol($id){

        $resp = false;
        $abmrol = new AbmUsuariorol();
        $where = ['idusuario' => $this->getIdUser()];
        $rolesUsuario= $abmrol->buscar($where);

        foreach($rolesUsuario as $usrol){
            $rol=$usrol->getobjrol();
            if($rol->getidrol()==$id){
               $resp = true;
            }
        }
        return $resp;
    }
    public function setear(){

    }

    /**
     * @param int ID de usuario
     * @return array ID de ROL
     * La idea es obtener el ROL de la tabla UsuarioRol por medio del ID del usuario
     */
    public function obtenerRol($idUser){
        $abmrol = new AbmUsuariorol();#Nuevo objeto ROL
        $where = ['idusuario' => $this->getIdUser()];#Where idusuario = ID de este usuario
        $arrayUsuario = $abmrol->buscar($where);#Busca la lista de roles ARRAY con objetos dentro (cada objeto es un rol vinculado de un iduser)

        $roles=[];
        #Recorre el arreglo de roles
        foreach ($arrayUsuario as $usuario) {
            $rolUser = $usuario->getobjrol();
            $rol = $rolUser->getidrol();#Devuelve el id del rol 1 al 5
            array_push($roles, $rol);
        }
        return $roles;
    }

    /** ACTIVA **/
    public function activa()
    {
        $activa = false;
        if (isset($_SESSION['usnombre'])) {
            $activa = true;
        }
        return $activa;
    }

    /** GET USUARIO **/
    public function getobjUsuario()
    {        
        return $this->objUser;
    }


    /** SET USUARIO **/
    public function setobjUsuario($idUsuario)
    {
        $abmUsuario = new AbmUsuario();
        $where = ['idusuario' => $idUsuario];
        $listaUsuarios = $abmUsuario->buscar($where);
        if ($listaUsuarios >= 1) {
            $usuarioLog = $listaUsuarios[0];
        }
        $this->objUser= $usuarioLog;
    }



    /** CERRAR **/
    public function cerrar()
    {
        session_unset();
        session_destroy();
    }
}
