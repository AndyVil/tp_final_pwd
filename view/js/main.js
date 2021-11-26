$(document).ready(function () {
	//Esto es cuando carga el documento, entonces ya esta listo para ejecutar script
	console.log('El documento está cargado');

	let window = jQuery(location).attr('href');
	console.log(window);
	tabSelect(window);

	//MENU-----------------------------------------------------------------------------

	//Para que la pestaña se enfoque en la que estamos seleccionando (utiliza la url actual)
	function tabSelect(window) {
		let valWindow = '';

		//Separa el arreglo por cada / que aparezca
		arrWindow = window.split('/');

		//$ignore = $arrWindow.length;

		//Elimina el ultimo elemento del arreglo
		arrWindow.pop();
		//Junta el arreglo de nuevo en un string
		valWindow = arrWindow.join('/') + '/';

		//console.log(arrWindow);
		//console.log(valWindow);

		switch (valWindow) {
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/inicio_cliente/':
				$('#cliente_ini').attr('class', 'nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/inicio_deposito/':
				$('#dep_ini').attr('class', 'nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/inicio_admin/':
				$('#admin_ini').attr('class', 'nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/login/':
				$('#login').attr('class', 'nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/registro/':
				$('#registro').attr('class', 'nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/cuenta/':
				$('#cuenta').attr('class', 'nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/carrito/':
				$('#carrito').attr('class', 'nav-link active');
				break;
		}
	}

	//COMPROBACIONES-----------------------------------------------------------------------------

	 //Escucha la accion del boton
	$('#btn-registro').click(function (a) {
		a.preventDefault(); //Previene que se recargue la pagina
		let comprobacion = []; //Serializamos todos los campos del form dinámicamente
		comprobacion = $('#registro').serializeArray(); //Convierte todos los datos del formulario en array
		let valido = 1;
		let msj = '';
		const formulario = $('#registro');
		formulario.attr('action', ' ');


		const usuario = $('#usnombre').val(); //Toma el valor del formulario
		const mail = $('#usmail').val();
		const pass = $('#uspass').val();

		//Recorremos todos los campos del formulario
		$.each(comprobacion, function (index, value) {
			//Si uno de los valores no cumple la condicion pasamos la validación a 0
			if (value.value == '' || value.value == null) valido = 0;
			msj = 'Hay campos incompletos';
			//console.log(value.value);
		});

		//Si la validación es 0 no enviamos el form y mostramos un mensaje
		if (valido == 0) {
			$('#aviso').remove(); //Evita que se repita el append
			//$('#aviso').append(msj);
			$('#aviso').text(msj);
		} else {
			//Si la validación es 1  enviamos el form
			formulario.attr('action', 'action.php'); //Si es correcto enviar el formulario manipulando el action
			formulario.submit(); //Envia el formulario
		}













		console.log('Final de la comprobacion');
	});
});
