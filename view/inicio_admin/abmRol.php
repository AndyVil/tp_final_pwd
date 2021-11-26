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
		header('Location: listarRols.php');
	}
	
	$Titulo = "Acción abmRol - TP5";
	
	$resp = false;
	$abmUser = new AbmRol();
	$abmmenurol= new AbmMenuRol();
	$userDelete = new AbmRol();
	$filtro = array();
	$filtro['idRol'] = $datos['idRol'];
	$user = $userDelete->buscar($filtro);
	$objRol = $user[0];
	
	/* Accion que permite: cargar una nueva Rol, borrar y editar */
	if (isset($datos['accion'])) {
		$mensaje = "";
		if ($datos['accion'] == 'editar') {

			$nuevosRoles = $datos['colrol'];
			//var_dump($nuevosRoles);
			$filtrorol= array();#Rol actual de la coleccion de arreglos y el id de Rol
			$filtrorol['idRol'] =$datos['idRol'];
			$roles = $abmmenurol->buscar($filtro);
			if(count($nuevosRoles)>count($roles)){
				foreach($nuevosRoles as $idrol){					
					
					$filtrorol['idrol'] =$idrol;
					$existerol=$abmmenurol->buscar($filtrorol);
					#compruebo que el Rol no tenga el rol con el id actual de la iteracion para agregarlo
					if($existerol==null)
					$abmmenurol->alta($filtrorol);
				}				
			}
			#Si el count del array es menor a la cantidad de roles que corresponda entonces SI quita un rol
			elseif(count($nuevosRoles)<count($roles)){
				foreach($nuevosRoles as $idrol){					
					$filtrorol['idrol'] =$idrol;
					$existerol=$abmmenurol->buscar($filtrorol);
					#compruebo que el Rol si tenga el rol con el id actual de la iteracion para eliminarlo
					if($existerol!=null)
					$abmmenurol->baja($filtrorol);
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
			$datos['usnombre'] = $objRol->getusnombre();
			$datos['uspass'] = $objRol->getuspass();
			$datos['usmail'] = $objRol->getusmail();
			date_default_timezone_set("America/Argentina/Buenos_Aires");
			#Si la fecha y hora seteada la convierte en 0000-00-00 00:00:00, si no es seteada coloca un timestamp
			if ($objRol->getusdeshabilitado() != '0000-00-00 00:00:00' && $objRol->getusdeshabilitado() != NULL) {
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
			if ($objRol->alta($datos)) {
				$resp = true;
			} else {
				$mensaje = "<b>ERROR:</b> No pudo completarse la accion.<br>";
			}
		}
		if ($datos['accion'] == 'nuevo') {
			if ($objRol->alta($datos)) {
				$resp = true;
			} else {
				$mensaje = "<b>ERROR:</b> No pudo completarse la accion.<br>";
			}
		}


		if ($resp) {
			$mensaje = "La acción <b>" . $datos['accion'] . " Rol</b>Se realizo correctamente.";
			header('Location: listarRols.php?mensaje='.urldecode('edicion_exitosa'));
		} else {
			$mensaje .= "La acción <b>" . $datos['accion'] . " Rol</b>No pudo concretarse.";
			header('Location: listarRols.php?mensaje=' . urldecode('edicion_fallida'));
		}
	}	
	$encuentraError = strpos(strtoupper($mensaje), 'ERROR');
	
?>



<?php
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>
