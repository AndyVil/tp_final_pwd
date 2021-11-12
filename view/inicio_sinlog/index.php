<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
//HEADER============================================================================
?>


<!--BODY============================================================================-->
<!--BODY Aca va todo el condtenido de la vista de la pagina y la interaccion del usuario-->
<div id="contenido" style="height: 82%; min-height:fit-content; width: 89.8%; border: 2px solid red; border-radius: 5px;margin-left:10%;">
    <h1> Este es el cuerpo </h1>


    <!--Formulario-->
    <form action="action.php" method="GET" id="Ejemplo" name="Ejemplo">
        <!--FORMULARIOS-->
        <input type="number" id="Ejemplo_1" name="Ejemplo_1" placeholder="Ejemplo">
        <!--SUBMIT-->
        <input type="submit" value="Enviar">
    </form>
</div>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>