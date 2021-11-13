<?php
require_once("../structure/header.php");
//HEADER================================================================================
?>


<!--BODY ACTION DIV=====================================================================-->
<div id="contenido" style="height: 82%; min-height:fit-content; width: 89.8%; border: 2px solid red; border-radius: 5px;margin-left:10%;">
    <?php
    //Llamada a clases y resolucion del problema
	    $datos = data_submited(); //Del archivo funciones
	    $object = new Control_ejercicio();
	    //La accion lo que hace es llamar al objeto que va 
	    //a procesar el ejercicio que estas haiendo
	    //El controlador es el que se encarga de los objetos y la parte logica.
    
    
    //Impresion de respuestas	    
	    $respuesta = $object->functionX($datos);

	    echo $respuesta;
	    
	    
    //Volver a la pagina anterior 
	    echo "<br><br><a href='Directorio local host'>
		    Volver a la pagina anterior</a>"; //NO puede haber echos en las clases
    ?>
</div>


<?php
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>
