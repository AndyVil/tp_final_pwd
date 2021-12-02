<?php
require_once("../structure/header.php");

$dir = "../inicio_cliente/index.php";
$rol = "Administrador";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);
//HEADER================================================================================
?>


<?php
	$datos = data_submited();
	if ($datos['accion'] == 'noAccion') {
		header('Location: listarUsuarios.php');
	}
	
	$Titulo = "Acción abmUsuario - TP5";
	
	$resp = false;
	$abmUser = new AbmUsuario();
	$ambuserRol= new AbmUsuarioRol();
	$userDelete = new AbmUsuario();
	$filtro = array();
	$filtro['idusuario'] = $datos['idusuario'];
	$user = $userDelete->buscar($filtro);
	$objUsuario = $user[0];
	
	/* Accion que permite: cargar una nueva usuario, borrar y editar */
	if (isset($datos['accion'])) {
		$mensaje = "";
		if ($datos['accion'] == 'editar') {

			$nuevosRoles = $datos['colrol'];
			//var_dump($nuevosRoles);
			$filtrorol= array();#Rol actual de la coleccion de arreglos y el id de usuario
			$filtrorol['idusuario'] =$datos['idusuario'];
			$roles = $ambuserRol->buscar($filtro);
			if(count($nuevosRoles)>count($roles)){
				foreach($nuevosRoles as $idrol){					
					
					$filtrorol['idrol'] =$idrol;
					$existerol=$ambuserRol->buscar($filtrorol);
					#compruebo que el usuario no tenga el rol con el id actual de la iteracion para agregarlo
					if($existerol==null)
					$ambuserRol->alta($filtrorol);
				}				
			}
			#Si el count del array es menor a la cantidad de roles que corresponda entonces SI quita un rol
			elseif(count($nuevosRoles)<count($roles)){
				foreach($nuevosRoles as $idrol){					
					$filtrorol['idrol'] =$idrol;
					$existerol=$ambuserRol->buscar($filtrorol);
					#compruebo que el usuario si tenga el rol con el id actual de la iteracion para eliminarlo
					if($existerol!=null)
					echo 'entro a baja';
					$ambuserRol->baja($filtrorol);
				}	
			}
			//$datos['usnombre'] = md5($datos['usnombre']); Mejor no hacer esto
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
			date_default_timezone_set("America/Argentina/Buenos_Aires");
			#Si la fecha y hora seteada la convierte en 0000-00-00 00:00:00, si no es seteada coloca un timestamp
			if ($objUsuario->getusdeshabilitado() != '0000-00-00 00:00:00' && $objUsuario->getusdeshabilitado() != NULL) {
				$datos['usdeshabilitado'] = '0000-00-00 00:00:00';
			} else {
				$datos['usdeshabilitado'] = date('Y-m-d h:i:s'); #Timestamp
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
			$mensaje = "La acción <b>" . $datos['accion'] . " usuario</b>Se realizo correctamente.";
			header('Location: listarUsuarios.php?mensaje='.urldecode('edicion_exitosa'));
		} else {
			$mensaje .= "La acción <b>" . $datos['accion'] . " usuario</b>No pudo concretarse.";
			header('Location: listarUsuarios.php?mensaje=' . urldecode('edicion_fallida'));
		}
	}	
	$encuentraError = strpos(strtoupper($mensaje), 'ERROR');
	
?>



<?php
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>
