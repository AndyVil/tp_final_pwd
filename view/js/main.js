$(document).ready(function () {
	//Esto es cuando carga el documento, entonces ya esta listo para ejecutar script
	console.log('El documento está cargado');
    
    let window = jQuery(location).attr('href');
    console.log(window);
    tabSelect(window);


    //FUNCIONES-----------------------------------------------------------------------------

    //Para que la pestaña se enfoque en la que estamos seleccionando (utiliza la url actual)
    function tabSelect(window) {
		let valWindow;//ARREGLAR VENTANAS

        switch (window) {
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/inicio_cliente/':
                    $('#cliente_ini').attr('class','nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/inicio_deposito/':
                    $('#dep_ini').attr('class','nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/inicio_admin/':
                    $('#admin_ini').attr('class','nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/login/':
                    $('#login').attr('class','nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/registro/':
                    $('#registro').attr('class','nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/cuenta/':
                    $('#cuenta').attr('class','nav-link active');
				break;
			case 'http://localhost/pwd_proyectos/tp_final_pwd/view/carrito/':
                    $('#carrito').attr('class','nav-link active');
				break;
		}
    }






	// //Escucha la accion del boton
	// $('#btn-form').click(function (a) {
	// 	a.preventDefault(); //Previene que se recargue la pagina
	// 	const comprobacion = $('#numero').val(); //Toma el valor del formulario

	// 	funComprobacion(comprobacion);
	// });
});
