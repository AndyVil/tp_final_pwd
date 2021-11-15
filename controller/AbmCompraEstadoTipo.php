<?php
class AbmCompraEstadoTipo
{

    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idcompraestadotipo', $param)and array_key_exists('cetdescripcion', $param) and array_key_exists('cetdetalle', $param)) {
            $obj = new CompraEstadoTipo();
            $obj->setear($param['idcompraestadotipos'], $param['cetdescripcion'],$param['cetdetalle']);
        }
        return $obj;
    }


/**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los  de las variables instancias del objeto que son claves
     * @param array $param
     * @return CompraEstadoTipo
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idcompraestadotipo'])) {
            $obj = new CompraEstadoTipo();
            $obj->setear($param['idcompraestadotipo'], null, null);
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
        if (isset($param['idcompraestadotipo']))
            $resp = true;
        return $resp;
    }


    /**
     * Carga un objeto con los datos pasados por parámetro y lo 
     * Inserta en la base de datos
     * @param array $param= cetdetalle/idcompraestadotipo
     * @return boolean
     */
    public function alta($param)
    {
        $resp = false;
        $buscar2 = array();
        $buscar2['idcompraestadotipo'] = $param['idcompraestadotipo'];
        $encuentraPer = $this->buscar($buscar2);

        if ($encuentraPer == null) {
            $objcets = $this->cargarObjeto($param);
            if ($objcets != null and $objcets->insertar()) {
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
            $objcets = $this->cargarObjetoConClave($param);
            if ($objcets != null and $objcets->eliminar()) {
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
            $buscar2['idcompraestadotipo'] = $param['idcompraestadotipo'];
            $compras = $this->buscar($buscar2);
            if ($compras != null) {
                $objcet= $compras[0];
                $objcet->setcetdescripcion($param['cetdescripcion']); 
                $objcet->setcetdetalle($param['cetdetalle']);
                if ($compras[0] != null and $compras[0]->modificar()) {
                    $resp = true;
                }
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
            if (isset($param['idcompraestadotipo']))
                $where .= " and idcompraestadotipo =" . $param['idcompraestadotipo'];
            if (isset($param['cetdescripcion']))
                $where .= " and cetdescripcion =" . $param['cetdescripcion'];
            if (isset($param['cetdetalle']))
                $where .= " and cetdetalle =" . $param['cetdetalle'];                
        }
        $arreglo = Compra::listar($where);
        return $arreglo;
    }


}
