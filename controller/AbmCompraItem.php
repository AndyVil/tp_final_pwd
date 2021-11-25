<?php
class AbmCompraItem
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los idcompras de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los idcompras de las variables instancias del objeto
     * @param array $param
     * @return CompraItem
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (
            array_key_exists('idcompraitem', $param)
            and array_key_exists('idproducto', $param)
            and array_key_exists('idcompra', $param)
            and array_key_exists('cicantidad', $param)
            and array_key_exists('ciprecio', $param)
        ) {
            $obj = new CompraItem();
            $obj->setear($param['idcompraitem'], $param['idproducto'], $param['idcompra'], $param['cicantidad'], $param['ciprecio']);
        }
        //var_dump($param);
        return $obj;
    }


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los idcompras de las variables instancias del objeto que son claves
     * @param array $param
     * @return CompraItem
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idcompraitem'])) {
            $obj = new CompraItem();
            $obj->setear($param['idcompraitem'], "", "", "", "", "");
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
        if (isset($param['idcompraitem']))
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
        $arr = array();
        $elObjtProducto = $this->cargarObjeto($param);
        //var_dump($elObjtProducto);
        list($insert, $id) = $elObjtProducto->insertar();
        if ($elObjtProducto != null and $insert) {
            $resp = true;
            array_push($arr, $id, $resp);
        }
        //var_dump($insert,$id);
        return $arr;
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
            $elObjtCompraitem = $this->cargarObjetoConClave($param);
            //var_dump($elObjtCompraitem);
            $delete  =$elObjtCompraitem->eliminar();
            //var_dump($delete);
            if ($elObjtCompraitem != null and $delete) {
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
            $buscar2['idcompraitem'] = $param['idcompraitem'];
            $elCompraitem = $this->buscar($buscar2);
            if ($elCompraitem != null) {
                $elCompraitem[0]->setidproducto($param['idproducto']);
                $elCompraitem[0]->setidcompra($param['idcompra']);
                $elCompraitem[0]->setcicantidad($param['cicantidad']);                

                if ($elCompraitem[0] != null and $elCompraitem[0]->modificar()) {
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
            if (isset($param['idcompraitem']))
                $where .= " and idcompraitem =" . $param['idcompraitem'];
            if (isset($param['idproducto']))
                $where .= " and idproducto ='" . $param['idproducto'] . "'";
            if (isset($param['idcompra']))
                $where .= " and idcompra ='" . $param['idcompra'] . "'";
            if (isset($param['cicantidad']))
                $where .= " and cicantidad ='" . $param['cicantidad'] . "'";
            if (isset($param['proprecio']))
                $where .= " and proprecio ='" . $param['proprecio'] . "'";
        }
        $arreglo = CompraItem::listar($where);
        return $arreglo;
    }
}
