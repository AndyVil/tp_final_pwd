<?php
class AbmCompra
{

    private function cargarObjeto($param)
    {
        $obj = null;
        //var_dump($param);
        if (array_key_exists('idcompra', $param) and array_key_exists('cofecha', $param) and array_key_exists('idusuario', $param) and array_key_exists('coprecio', $param)) {
            $obj = new Compra();
            $obj->setear($param['idcompra'], $param['cofecha'], $param['idusuario'], $param['coprecio']);
        }
        //var_dump($obj);
        return $obj;
    }


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los  de las variables instancias del objeto que son claves
     * @param array $param
     * @return Compra
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idcompra'])) {
            $obj = new Compra();
            $obj->setear($param['idcompra'], "", $param['idusuario'], "");
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
        if (isset($param['idcompra']) and isset($param['idusuario']))
            $resp = true;
        return $resp;
    }


    /**
     * Carga un objeto con los datos pasados por parámetro y lo 
     * Inserta en la base de datos
     * @param array $param= idusuario/idcompra
     * @return boolean
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
        return $arr;
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
            $objcompras = $this->cargarObjetoConClave($param);
            if ($objcompras != null and $objcompras->eliminar()) {
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
            $buscar2['idcompra'] = $param['idcompra'];
            $compras = $this->buscar($buscar2);
            if ($compras != null) {
                $objcompra = $compras[0];
                $objcompra->setcofecha($param['cofecha']);

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
            if (isset($param['idcompra']))
                $where .= " and idcompra =" . $param['idcompra'];
            if (isset($param['cofecha']))
                $where .= " and cofecha =" . $param['cofecha'];
            if (isset($param['idusuario']))
                $where .= " and idusuario =" . $param['idusuario'];
        }
        $arreglo = Compra::listar($where);
        return $arreglo;
    }
}
