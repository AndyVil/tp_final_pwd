<?php

/**
 * Funciones para el funcionamiento de GET, POST y las clases.
 * data_submitted, es para que envie lo que envie, no importa porque lo pasa a arreglo
 *
 * spl_autoload_register, busca las clases en los directorios las clases a invocar, tanto en modelo como en control
 * y evita hacer un include para cada clase/objeto
 */

function data_submited(){
	$_AAux= array();
    if (!empty($_POST)) 
    	$_AAux =$_POST;
    else 
		if(!empty($_GET)) {
            $_AAux =$_GET;
		}
	if (count($_AAux)){
		foreach ($_AAux as $indice => $valor) {
				if ($valor=="")
                	$_AAux[$indice] = 'null'	;
			}
	}
	return $_AAux;
}


spl_autoload_register(function ($clase) {
	echo "Se cargo la clase:  ".$clase." <br><br>" ;
	$directorys = array(
		$GLOBALS['ROOT'].'model/',
		$GLOBALS['ROOT'].'controller/',
		$GLOBALS['ROOT'].'controller/imageworkshop/',
		$GLOBALS['ROOT'].'controller/imageworkshop/Core/',
		$GLOBALS['ROOT'].'controller/imageworkshop/Exception/',
		$GLOBALS['ROOT'].'controller/imageworkshop/Exif/',
		$GLOBALS['ROOT'].'utils/krumo-0.4.4/',
	);
	foreach($directorys as $directory){
	  if(file_exists($directory.$clase . '.php')){  
			require_once($directory.$clase.'.php');
			return;
		}           
	}
});
?>
