<!DOCTYPE html>
<!--HEADER================================================================================-->
<html lang="en">

<!--HEAD-->

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./../css/bootstrap-5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="./../css/style.css">


  <title></title>
</head>

<!--BODY==================================================================================-->

<body>

  <!--Es el inicio de body y la cabecera-->
  <?php
  //LLAMADO A CONFIG==================================================================
  require_once("../../config.php");
  ?>


  <!--CABECERA DIV-->
  <header>
    <a href="./../inicio_cliente/" id="linktitulo">
      <h3 id="titulo">Tienda de ropa</h3>
    </a>


    <!-- MENU SEGUN USUARIOS -->
    <!-- MENU TABS -->
    <ul class="nav nav-tabs justify-content-center">
      <?php
      #MANERA 1 de MENU
      $sesion = new Session();
      $datosCuenta = array_key_exists('usnombre', $_SESSION) and array_key_exists('uspass', $_SESSION);

      if ($sesion->activa() && $datosCuenta) {
        list($sesionValidar, $error) = $sesion->validar();
        if ($sesionValidar) {
          $idUser = $sesion->getIdUser();
          //$esUsuario = $sesion->validarRol($idUser);
          $roles = [];
          $roles = $sesion->obtenerRol(); #La funcion la cree debajo del validarRol() en Sesion
          $validRol = $sesion->arrayRolesUser($roles);

          $menus = $sesion->idMenu($roles);
          $validMenu = $sesion->menusroles($menus);
          //var_dump($validMenu);
 
//array(7) { ["admin_ini"]=> bool(true) ["dep_ini"]=> bool(true) ["cliente_ini"]=> bool(true) ["login"]=> bool(true) ["registro"]=> bool(true) ["cuenta"]=> bool(true) ["carrito"]=> bool(true) }

          echo "
              <li class='nav-item'>
              <a id='cliente_ini' class='nav-link' href='./../inicio_cliente/'>Catalogo</a>
              </li>
            ";
          if ($validMenu['carrito'] == true) {
            echo "
              <li class='nav-item'>
              <a id='carrito' class='nav-link' href='./../carrito/'>Carrito</a>
              </li>
            ";
          }
          if ($validMenu['dep_ini'] == true) {
            echo "
              <li class='nav-item'>
              <a id='dep_ini' class='nav-link' href='./../inicio_deposito/'>Deposito</a>
              </li>
            ";
          }
          if ($validMenu['admin_ini'] == true) {
            echo "
              <li class='nav-item'>
              <a id='admin_ini' class='nav-link' href='./../inicio_admin/'>Administrador</a>
              </li>
            ";
          }
        }
        echo "
              <li class='nav-item'>
              <a id='cuenta' class='nav-link' href='./../cuenta/'>Cuenta</a>
              </li>
            ";
      } else {
        echo "
              <li class='nav-item'>
              <a id='cliente_ini' class='nav-link' href='./../inicio_cliente/'>Catalogo</a>
              </li>
            ";
        echo "
              <li class='nav-item'>
              <a id='login' class='nav-link' href='./../login/'>Log In</a>
              </li>
            ";
        echo "
              <li class='nav-item'>
              <a id='registro' class='nav-link' href='./../registro/'>Registrarse</a>
              </li>
            ";
      }
      ?>
    </ul>


  </header>
  <main>