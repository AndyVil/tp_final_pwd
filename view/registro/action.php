<?php
require_once("../structure/header.php");
//HEADER=================================================================================
	$datos = data_submited(); 
	$control = new Formulario();
	$respuesta = $control->registro($datos);
	header("Location: ../login/index.php?message=". $respuesta);
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>