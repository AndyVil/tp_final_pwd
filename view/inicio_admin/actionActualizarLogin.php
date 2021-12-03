<?php
require_once("../structure/Header.php");
//HEADER============================================================================
$dir = "../inicio_cliente/index.php";
$rol = "Administrador";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);

$datos = data_submited();
$roles = $sesion->obtenerRol();
$valid = $sesion->arrayRolesUser($roles);
$esSuperuser = $valid["superuser"];

$formulario = new Formulario();
$respuesta = $formulario->actualizarLogin($datos);
$allrol = $respuesta['allrol'];
$unUsuario = $respuesta['unUsuario'];
$colrol = $respuesta['colrol'];

$_SESSION['actionLogin'] = $respuesta;
$_SESSION['esSuperuser'] = $esSuperuser;

header('Location:actualizarLogin.php');

//FOOTER============================================================================
require_once("../structure/footer.php");
?>