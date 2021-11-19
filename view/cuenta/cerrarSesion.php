<?php
include_once '../../config.php';

$sesion = new Session();
$sesion->cerrar();
$message = "Sesión cerrada";
header('Location: login.php?message=' . urlencode($message));
