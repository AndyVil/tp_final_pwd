<?php
require_once("../structure/header.php");
//HEADER=================================================================================
$datos = data_submited();
$control = new Formulario();
$respuesta = $control->verificarLogin($datos);
header($respuesta);
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>