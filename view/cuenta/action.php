<?php
require_once("../structure/header.php");
//HEADER=================================================================================
$datos = data_submited();
$control = new Formulario();
if (array_key_exists('accion', $datos)){
    if($datos['action']=='editar') $control->cambiarMail($datos['emailCambio']);
}
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>