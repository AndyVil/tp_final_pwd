<?php
class AbmCompraEstado
{

    private function cargarObjeto($param)
    {
        $obj = null;

        if (
            array_key_exists('idcompraestado', $param)
            and array_key_exists('idcompraestadotipo', $param)
            and array_key_exists('idcompra', $param)
            and array_key_exists('cefechaini', $param)
            and array_key_exists('cefechafin', $param)
        ) {
            $obj = new CompraEstado();
            $obj->setear($param['idcompraestado'], $param['idcompra'], $param['idcompraestadotipo'], $param['cefechaini'], $param['cefechafin']);
        }
        //var_dump($obj,$param['cefechaini']);
        return $obj;
    }


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los  de las variables instancias del objeto que son claves
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idcompraestado'])) {
            $obj = new CompraEstado();
            $obj->setear($param['idcompraestado'], null, null, null, null);
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
        if (isset($param['idcompraestado']) and isset($param['idcompra']) and isset($param['idcompraestadotipo']))
            $resp = true;
        return $resp;
    }


    /**
     * Carga un objeto con los datos pasados por parámetro y lo 
     * Inserta en la base de datos
     * @param array $param= idcompra/idcompraestado
     * @return boolean
     */
    public function alta($param)
    {
        $resp = false;
        $objCompraEstados = $this->cargarObjeto($param);
        if ($objCompraEstados != null and $objCompraEstados->insertar()) {
            $resp = true;
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
            $objCompraEstados = $this->cargarObjetoConClave($param);
            if ($objCompraEstados != null and $objCompraEstados->eliminar()) {
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
            $buscar2['idcompraestado'] = $param['idcompraestado'];
            $CompraEstados = $this->buscar($buscar2);
            if ($CompraEstados != null) {
                $objCompraEstado = $CompraEstados[0];
                $objCompraEstado->setcefechaini($param['cefechaini']);
                $objCompraEstado->setcefechafin($param['cefechafin']);

                if ($CompraEstados[0] != null and $CompraEstados[0]->modificar()) {
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
            if (isset($param['idcompraestado']))
                $where .= ' and idcompraestado =' . $param['idcompraestado'];
            if (isset($param['idcompra']))
                $where .= ' and idcompra =' . $param['idcompra'];
            if (isset($param['idcompraestadotipo']))
                $where .= ' and idcompraestadotipo =' . $param['idcompraestadotipo'];
            if (isset($param['cefechaini']))
                $where .= 'and cefechaini =' . $param['cefechaini'];
            if (isset($param['cefechafin']))
                $where .= ' and cefechafin =' . $param['cefechafin'];
        }
        //var_dump($param);
        //echo($where);
        $arreglo = CompraEstado::listar($where);
        return $arreglo;
    }
}
