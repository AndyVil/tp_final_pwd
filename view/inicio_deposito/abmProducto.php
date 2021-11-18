<?php
require_once("../structure/header.php");
//HEADER================================================================================
?>


<!--BODY ACTION DIV=====================================================================-->
<?php

	$ruta = $GLOBALS['ROOT'];
	$datos = data_submited();
	$productos = new AbmProducto;
	$base = new BaseDatos();
	$arrProductos = [];
	$arrProductos = $productos->buscar(null);
	if($datos["accion"]=="borrar"){
		$productos->baja($datos);
		echo "Se elimino el producto correctamente";
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
 
 
 
 
	 if($datos["accion"]=="cargar"){	
		 list($valido,$id)=$productos->alta($datos); 
		 if($valido){
			 /**
			 * Cargo los prodcutos de la base de datos en una variable para hacer un conteo de los mismos
			 * Esto me permite asignarle un nuevo nombre al archivo para identificarlo
			 */


			/**
			 * Cargo los prodcutos de la base de datos en una variable para hacer un conteo de los mismos
			 * Esto me permite asignarle un nuevo nombre al archivo para identificarlo
			 */

			//  $cantidadProductos = count($arrProductos)+1;

			$dirUpload = $ruta . "uploads";
			$ext = pathinfo($_FILES['productoImagen']['name'], PATHINFO_EXTENSION);
			//$nombre = $datos['tipoProducto'] . ($id + 1) . "." . $ext; #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$nombre = $id.".".$ext;
			if (is_uploaded_file($_FILES['productoImagen']['tmp_name'])) {
				move_uploaded_file($_FILES['productoImagen']['tmp_name'], "$dirUpload/$nombre");//tmp
				echo "Imagen Cargada <br><br>";
				$formularioCargarProducto = new Formulario();
				$formularioCargarProducto->cargarArchivos($nombre, $datos);
			} else {
				echo "Error de archivo subido";
			}

	//  $nombre = $tipoProducto.$cantidadProductos;
	//  $formularioCargarProducto ->cargarArchivos($cantidadProductos,$datos);
			//var_dump($id);
	        //$nombre = $tipoProducto.$producto->getidproducto();
			//$formularioCargarProducto = new Formulario();			
			//$formularioCargarProducto ->cargarArchivos($cantidadProductos,$datos);
		 }
	 }
	 if($datos["accion"]=="editar"){		 
		 if($productos->modificacion($datos)){
			$id = $datos["idproducto"];
			$dirUpload = $ruta . "uploads";
			$ext = pathinfo($_FILES['productoImagen']['name'], PATHINFO_EXTENSION);
			//$nombre = $datos['tipoProducto'] . ($id + 1) . "." . $ext; #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$nombre = $id.".".$ext;
			if (is_uploaded_file($_FILES['productoImagen']['tmp_name'])) {
				move_uploaded_file($_FILES['productoImagen']['tmp_name'], "$dirUpload/$nombre");//tmp
				echo "Imagen Cargada <br><br>";
				$formularioCargarProducto = new Formulario();
				$formularioCargarProducto->cargarArchivos($nombre, $datos);
			} else {
				echo "Error de archivo subido";
			} 
		 }
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
