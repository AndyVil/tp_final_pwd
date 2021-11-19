<?php
require_once("../structure/header.php");
//HEADER================================================================================
?>

<?php
	$datos = data_submited(); 
	$ambrol = new AbmUsuarioRol();
	$object = new AbmUsuario();
	$datos["usnombre"] = md5($datos["usnombre"]);
	$datos["uspass"] = md5($datos["uspass"]);
	$datos["idrol"]= 3;
    
    //Impresion de respuestas	    
	list($alta,$id) = $object->alta($datos);
	#Asignar rol cliente al usuario nuevo	
	if($alta){
		echo "Se creo el usuario exitosamente";
		#asignamos el rol de cliente siempre que se cree una cuenta
		$datos["idusuario"]=$id;
		if($ambrol->alta($datos)){
			echo "Se creo el rol de cliente";
		}		
	}else{
		echo "Error al cargar los datos";
	}	    

?>


<?php
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>
