<?php
class AbmMenurol
{

    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idmenu', $param) and array_key_exists('idrol', $param)) {
            $objmenu = new Menu();
            $objmenu->setidmenu($param['idmenu']);
            $objmenu->cargar();

            $objrol = new Rol();
            $objrol->setIdrol($param['idrol']);
            $objrol->cargar();

            $obj = new Menurol();
            $obj->setear($objmenu, $objrol);
        }
        return $obj;
    }


    //Definir como se va a cargar el objeto y asignar las claves de lo que hace falta
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param[''])) {
            $obj = new Menurol();
            $obj->setear($param['idmenu'], $param['idrol']);
        }
        return $obj;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idmenu']) && isset($param['idrol']))
            $resp = true;
        return $resp;
    }


    /**
     * Carga un objeto con los datos pasados por parámetro y lo 
     * Inserta en la base de datos
     * @param array $param= idmenu/idrol
     * @return boolean
     */
    public function alta($param)
    {
        $resp = false;
        $buscar2 = array();
        $buscar2['idrol'] = $param['idrol'];
        $buscar2['idmenu'] = $param['idmenu'];
        $encuentraPer = $this->buscar($buscar2);

        if ($encuentraPer == null) {
            $elObjtrol = $this->cargarObjeto($param);
            if ($elObjtrol != null and $elObjtrol->insertar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    /**
     * Por lo general no se usa ya que se utiliza borrado lógico (es decir pasar de activo a inactivo)
     * Permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtArchivoE = $this->cargarObjetoConClave($param);
            if ($elObjtArchivoE != null and $elObjtArchivoE->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    /**
     * Puede traer un obj específico o toda la lista si el parámetro es null
     * Permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idmenu']))
                $where .= " and idmenu =" . $param['idmenu'];
            if (isset($param['idrol']))
                $where .= " and idrol =" . $param['idrol'];
        }
        $arreglo = menurol::listar($where);
        return $arreglo;
    }


    /** 
      * Busca todos los menurol correspondientes a un objmenu
      * Lista todos los roles que tiene el menu
      * @param object
      * @return array devuelve cada menu de dicho rol
      */
    public function buscarRolesmenu($param)
    {
        
        $arr = array();
        $condicion = "idrol='" . $param['idrol'] . "'";
        $condicion += "idmenu='" . $param['idmenu'] . "'";
            $objmenuRol = new MenuRol();
            $colmenuRols = $objmenuRol->listar($condicion);
        return $colmenuRols;
       
    }
}
