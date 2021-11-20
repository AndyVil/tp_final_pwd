<?php
include_once '../../config.php';

$sesion = new Session();
$sesion->cerrar();
$message = "Sesión cerrada";
header('Location: ../inicio_cliente/index.php?message=' . urlencode($message));
?>

