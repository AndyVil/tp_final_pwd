<?php
    include_once '../../config.php';
    include_once '../../controller/AbmUsuario.php';
    include_once '../../model/Usuario.php';
    include_once '../../model/conector/BaseDatos.php';

    $datos = data_submited();
    $sesion = new Session();
    $name = md5($datos['usnombre']);
    $pass = md5($datos['uspass']);
    $sesion->iniciar($name, $pass);
    list($valido, $error) = $sesion->validar();

    if ($valido) {
        header("Location:paginaSegura.php");
    } else {
        $sesion->cerrar();
        header("Location:login.php?error=" . urlencode($error));
    }
