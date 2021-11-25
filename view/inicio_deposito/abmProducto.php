<?php
require_once("../structure/header.php");
//HEADER================================================================================
$url = data_submited();
$dir = "../inicio_cliente/index.php";
$rol = "Deposito";
$sesion = new Session();
$sesion->permisoAcceso($dir, $rol);
?>

<?php

$ruta = $GLOBALS['ROOT'];
$datos = data_submited();
$productos = new AbmProducto;
$base = new BaseDatos();
$arrProductos = [];
$arrProductos = $productos->buscar(null);
if ($datos["accion"] == "borrar") {
	$productos->baja($datos);
	$idproducto = $datos['idproducto'];
	header("Location: index.php?mensaje="). urlencode("se elimino exitosamente el producto: ".$idproducto);
} else {

	//Llamada a clases y resolucion del problema
	//Del archivo funciones

	$tipoProducto = $datos['tipoProducto'];
	$stock = $datos['procantstock'];
	$descripcion = $datos['descripcion'];
	$talle = $datos['talle'];
	//var_dump($talle);
	$arraytostring = implode(', ', $talle);
	$datos['prodetalle'] = $descripcion . " " . $arraytostring;
	$datos['pronombre'] = $tipoProducto;
	$precio = $datos['proprecio'];




	if ($datos["accion"] == "cargar") {
		list($valido, $id) = $productos->alta($datos);
		if ($valido) {
			$idproducto = $datos['idproducto'];
			header("Location: index.php?mensaje=" . urlencode("Se cargo exitosamente el producto: " . $idproducto . "."));
			/**
			 * Cargo los prodcutos de la base de datos en una variable para hacer un conteo de los mismos
			 * Esto me permite asignarle un nuevo nombre al archivo para identificarlo
			 */


			/**
			 * Cargo los prodcutos de la base de datos en una variable para hacer un conteo de los mismos
			 * Esto me permite asignarle un nuevo nombre al archivo para identificarlo
			 */
			// $dirUpload = $ruta . "uploads";
			// $ext = pathinfo($_FILES['productoImagen']['name'], PATHINFO_EXTENSION);
			// $nombre = $id . "." . $ext;

			// #El move funciona para mover un archivo temporal a otra carpeta
			// //move_uploaded_file($_FILES['productoImagen']['tmp_name'], "$dirUpload/$nombre");

			// $formularioCargarProducto = new Formulario();
			// $array = $formularioCargarProducto->cargarArchivos($nombre, $datos);			
			// $link = "../../uploads/".$nombre;
			// $error = $array['imagen']['error'];
		}
	}
	if ($datos["accion"] == "editar") {
		if ($productos->modificacion($datos)) {
			$idproducto = $datos['idproducto'];
			header("Location: index.php?mensaje=" . urlencode("Se edito exitosamente el producto: " . $idproducto . "."));
			// $id = $datos["idproducto"];
			// $dirUpload = $ruta . "uploads";
			// $ext = pathinfo($_FILES['productoImagen']['name'], PATHINFO_EXTENSION);
			// $nombre = $id . "." . $ext;
			// //echo "Imagen Cargada <br><br>";
			// $formularioCargarProducto = new Formulario();
			// $array = $formularioCargarProducto->cargarArchivos($nombre, $datos);			
			// $link = "../../uploads/".$nombre;
			// $error = $array['imagen']['error'];
			
		}
	}

}

?>


<!-- <div class="row mb-3">
	<div class="col-sm-12 "> -->
		<?php
		// $detalles = $datos['prodetalle'];
		// if ($error == "") {
        //     echo "<div class='alert alert-success mt-5' role='alert'>
        //             <div class='row px-2 my-3'>
        //                 <div class='col-lg-7 col-xl-8'>$detalles</div>
        //                 <div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src=" . $link . "></div>
        //             </div>
        //           </div>";
		// } else {
		// 	echo "<div class='alert alert-danger mt-5' role='alert'>$error</div>";
		// }
		?>
	<!-- </div>
</div> -->


<?php
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>