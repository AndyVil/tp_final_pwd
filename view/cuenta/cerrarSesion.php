<?php
include_once '../../config.php';

$sesion = new Session();
$sesion->cerrar();
$message = "
<div class='alert alert-danger' role='alert' align=center>
  Se ha cerrado la sesion. ¡Hasta la proxima!
</div>
";
header('Location: ../inicio_cliente/index.php?message=' . urlencode($message));
?>

