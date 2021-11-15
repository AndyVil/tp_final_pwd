<?php
class AbmMenu
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los medescripcions de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los medescripcions de las variables instancias del objeto
     * @param array $param
     * @return Menu
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (
            array_key_exists('idmenu', $param)
            and array_key_exists('menombre', $param)
            and array_key_exists('medescripcion', $param)
            and array_key_exists('idpadre', $param)
            and array_key_exists('menudeshabilitado', $param)
        ) {
            $obj = new Menu();
            $objpadre = new Menu();
            $objpadre->setidmenu($param['idpadre']);
            $objpadre->cargar();
            $obj->setear($param['idmenu'], $param['menombre'], $param['medescripcion'], $objpadre, $param['menudeshabilitado']);
        }
        return $obj;
    }


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Menu
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idmenu'])) {
            $obj = new Menu();
            $obj->setear($param['idmenu'], "", "", "", "", "");
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
        if (isset($param['idmenu']) )
            $resp = true;
        return $resp;
    }


    /**
     * ALTA
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $buscar2 = array();
        $buscar2['idmenu'] = $param['idmenu'];
        $encuentraMenu = $this->buscar($buscar2);

        if ($encuentraMenu == null) {
            $elObjtMenu = $this->cargarObjeto($param);
            if ($elObjtMenu != null and $elObjtMenu->insertar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    /**
     * BAJA 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtMenu = $this->cargarObjetoConClave($param);
            if ($elObjtMenu != null and $elObjtMenu->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    /**
     * MODIFICACION
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $buscar2 = array();
            $buscar2['idmenu'] = $param['idmenu'];
            $elMenu = $this->buscar($buscar2);
            if ($elMenu != null) {
                $elMenu[0]->setmenombre($param['menombre']);
                $elMenu[0]->setmedescripcion($param['medescripcion']);                
                $elMenu[0]->setmenudeshabilitado($param['menudeshabilitado']);
                if ($elMenu[0] != null and $elMenu[0]->modificar()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }


    /**
     * BUSCAR
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idmenu']))
                $where .= " and idmenu =" . $param['idmenu'];
            if (isset($param['menombre']))
                $where .= " and menombre ='" . $param['menombre'] . "'";
            if (isset($param['medescripcion']))
                $where .= " and medescripcion ='" . $param['medescripcion'] . "'";
            if (isset($param['idpadre']))
                $where .= " and idpadre ='" . $param['idpadre'] . "'";
            if (isset($param['menudeshabilitado']))
                $where .= " and menudeshabilitado ='" . $param['menudeshabilitado'] . "'";
        }
        $arreglo = Menu::listar($where);
        return $arreglo;
    }
}
