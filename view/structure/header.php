<!DOCTYPE html>
<!--HEADER================================================================================-->
<html lang="en">

<!--HEAD-->
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
       <div style="height: 9%; width: 99.8%; border: 2px solid red; border-radius: 5px;">
           <h1>Este es la cabecera</h1>
       </div>


      <?php
      //LLAMADO A LATERAL(SIDE)===========================================================
       require_once("side.php");
      ?>

    <!-- 
    Podes notar aca que en el modelo MVC la cabecera habre un html y el body, luego el lateral
    simplemente es un codigo de html sin etiquetas de abertura, al cual invocamos debajo de la cabecera
    y por ultimo el pie es el cierre de las etiquetas html y body.
    Es importante remarcar que el pie de invoca al finald el cuerpo de la pagina (index.php), ya que si lo
    llamamos al final de la cabecera, este se sobrepondria con el cuerpo
    -->
