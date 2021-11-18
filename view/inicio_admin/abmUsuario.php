<?php
require_once("../structure/header.php");
//HEADER================================================================================
?>


<!--BODY ACTION DIV=====================================================================-->
<?php
	$datos = data_submited();
	if ($datos['accion'] == 'noAccion') {
		header('Location: listarUsuarios.php');
	}
	
	$Titulo = "Acción abmUsuario - TP5";
	include_once("../../estructura/cabeceraBT.php");
	
	$resp = false;
	$abmUser = new AbmUsuario();
	
	$userDelete = new AbmUsuario();
	$filtro = array();
	$filtro['idusuario'] = $datos['idusuario'];
	$user = $userDelete->buscar($filtro);
	$objUsuario = $user[0];
	
	/* Accion que permite: cargar una nueva usuario, borrar y editar */
	if (isset($datos['accion'])) {
		$mensaje = "";
		if ($datos['accion'] == 'editar') {
			$datos['usnombre'] = md5($datos['usnombre']);
			if ($abmUser->modificacion($datos)) {
				$resp = true;
			} else {
				$mensaje = "<b>ERROR: </b>";
			}
		}
		if ($datos['accion'] == 'deshabilitar') {
			$datos['usnombre'] = $objUsuario->getusnombre();
			$datos['uspass'] = $objUsuario->getuspass();
			$datos['usmail'] = $objUsuario->getusmail();
			if ($objUsuario->getusdeshabilitado()) {
				$datos['usdeshabilitado'] = 0;
			} else {
				$datos['usdeshabilitado'] = 1;
			}
			if ($userDelete->modificacion($datos)) {
				$resp = true;
			} else {
				$mensaje = "<b>ERROR: </b>";
			}
		}
		if ($datos['accion'] == 'nuevo') {
			if ($objUsuario->alta($datos)) {
				$resp = true;
			} else {
				$mensaje = "<b>ERROR:</b> No pudo completarse la accion.<br>";
			}
		}
		if ($datos['accion'] == 'nuevo') {
			if ($objUsuario->alta($datos)) {
				$resp = true;
			} else {
				$mensaje = "<b>ERROR:</b> No pudo completarse la accion.<br>";
			}
		}


		if ($resp) {
			$mensaje = "La acción <b>" . $datos['accion'] . " usuario</b> se realizo correctamente.";
		} else {
			$mensaje .= "La acción <b>" . $datos['accion'] . " usuario</b> no pudo concretarse.";
		}
	}	
	$encuentraError = strpos(strtoupper($mensaje), 'ERROR');
	
?>



<?php
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>
