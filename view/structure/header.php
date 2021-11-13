<!DOCTYPE html>
<!--HEADER================================================================================-->
<html lang="en">

<!--HEAD-->

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./../tools/bootstrap-5.1.3/css/bootstrap.min.css">
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


  <!--CABECERA DIV
    style="height: 9%; width: 99.8%; border: 2px solid red; border-radius: 5px;"-->
  <header>
    <h3 id="titulo">Tienda de ropa</h3>
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="#">Link</a>
      </li>
    </ul>
</header>


  <?php
  //LLAMADO A LATERAL(SIDE)===========================================================
  //require_once("side.php");
  ?>