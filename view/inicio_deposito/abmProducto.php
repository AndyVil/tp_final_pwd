<?php
require_once("../structure/header.php");
//HEADER================================================================================
?>


<!--BODY ACTION DIV=====================================================================-->
<?php

	$datos = data_submited();
	$productos = new AbmProducto;
	$base = new BaseDatos();
	$arrProductos = [];
	$arrProductos = $productos->buscar(null);
	if($datos["accion"]=="borrar"){
		$productos->baja($datos);
	}
	else{
    
     //Llamada a clases y resolucion del problema
	 //Del archivo funciones
   
	 $tipoProducto = $datos['tipoProducto'];
	 $stock = $datos['procantstock'];
	 $descripcion = $datos['descripcion'];
	 $talle = $datos['talle'];
	 //var_dump($talle);
	 $arraytostring = implode(', ', $talle);
	 $datos['prodetalle'] = $descripcion.$arraytostring;
	 $datos['pronombre'] = $tipoProducto.$descripcion;
	 $precio = $datos['proprecio'];
 
	 /**
	  * Cargo los prodcutos de la base de datos en una variable para hacer un conteo de los mismos
	  * Esto me permite asignarle un nuevo nombre al archivo para identificarlo
	  */

	//  $cantidadProductos = count($arrProductos)+1;
 
	//  $formularioCargarProducto = new Formulario();
	//  $nombre = $tipoProducto.$cantidadProductos;
	//  $formularioCargarProducto ->cargarArchivos($cantidadProductos,$datos);
	 
 
 
	 if($datos["accion"]=="cargar"){	
		 list($valido,$id)=$productos->alta($datos); 
		 if($valido){			/**
			 * Cargo los prodcutos de la base de datos en una variable para hacer un conteo de los mismos
			 * Esto me permite asignarle un nuevo nombre al archivo para identificarlo
			 */
			
			var_dump($id);
	        //$nombre = $tipoProducto.$producto->getidproducto();
			//$formularioCargarProducto = new Formulario();			
			//$formularioCargarProducto ->cargarArchivos($cantidadProductos,$datos);
		 }
	 }
	 if($datos["accion"]=="editar"){
		 
		 $productos->modificacion($datos);
	 }
 
 
 
		 
		 
	 //Volver a la pagina anterior 
	 echo "<br><br><a href='Directorio local host'>
		 Volver a la pagina anterior</a>"; //NO puede haber echos en las clases
	}

?>


<?php
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>
