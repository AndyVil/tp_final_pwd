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

    <!-- MENU TABS -->
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a id="cliente_ini" class="nav-link" href="./../inicio_cliente/">Catalogo</a>
      </li>
      <li class="nav-item">
        <a id="dep_ini" class="nav-link" href="./../inicio_deposito/">Deposito</a>
      </li>
      <li class="nav-item">
        <a id="admin_ini" class="nav-link" href="./../inicio_admin/">Administrador</a>
      </li>
      <li class="nav-item">
        <a id="login" class="nav-link" href="./../login/">Log in</a>
      </li>
      <li class="nav-item">
        <a id="registro" class="nav-link" href="./../registro/">Registrarse</a>
      </li>
      <li class="nav-item">
        <a id="cuenta" class="nav-link" href="./../cuenta/">Cuenta</a>
      </li>
      <li class="nav-item">
        <a id="carrito" class="nav-link" href="./../carrito/">Carrito</a>
      </li>
    </ul>


  </header>
  </main>