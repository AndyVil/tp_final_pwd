<?php
include_once '../../config.php';

$sesion = new Session();
$sesion->cerrar();
header('Location: ../inicio_cliente/index.php?message=' . urlencode("Se ha cerrado la sesion. ¡Hasta la proxima!"));
?>

