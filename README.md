### Ruta de proyecto: C:\xampp\htdocs\pwd_proyectos\tp_final_pwd

# TP Final Programacion Web Dinamica (Lucas Villarruel / Santiago Avilez)

## Objetivo
El objetivo del trabajo es integrar
los conceptos vistos en la materia. Se espera que el alumno implemente una tienda On-Line que tendrá 2 vistas:
una vista “pública” y otra “privada”.

Desde la vista *pública* se tiene acceso a la información de la tienda: dirección, medios
de contacto, descripción y toda aquella información que crea importante desplegar.
Además se podrá acceder a la vista privada de la aplicación, a partir del ingreso de un
usuario y contraseña válida.

Desde la vista *privada*, luego de concretar el proceso de autenticación y dependiendo los
roles con el que cuenta el usuario que ingresa al sistema, se van a poder realizar
diferentes operaciones. Los roles iniciales son: cliente, depósito y administrador.

## Pautas

1. La aplicación debe ser desarrollada sobre una arquitectura MVC (Modelo-Vista-Control) utilizando PHP como lenguaje de programación. 

2. Se debe utilizar la Base de Datos bdcarritocompras otorgada por la cátedra.
Realizar el MOR de las tablas del modelo de base de datos.
Verificar la estructura de las tablas y realizar las modificaciones que crea necesarias.

3. La aplicación tendrá páginas públicas y otras restringidas, que sólo podrán ser accedidas a partir de un usuario y contraseña. Utilizar el módulo de autenticación implementado en TP5.
*La aplicación debe tener como mínimo los siguientes*
*ROLES: cliente, depósito y administrador.*

4. El menú de la aplicación debe ser un menú dinámico que pueda ser gestionado por el administrador de la aplicación. Las tablas de la base de datos vinculadas a esta información son: menu y menurol.

5. Cualquier usuario que tenga más de un rol asignado, puede cambiar de rol según lo desee.

6. Desde la aplicación un usuario con rol Cliente podrá:
 - Gestionar los datos de su cuenta, como cambiar su e-mail y contraseña.
 - Realizar la compra de uno o más productos con stock suficiente.

7. Desde la aplicación un usuario con rol Deposito podrá:
 - Crear nuevos productos y administrar los existentes.
 - Acceder a los procedimientos que permite el cambio de estado de los productos.
 - Modificar el stock de los productos.

8. Desde la aplicación un usuario con rol Administrador podrá:
 - Crear nuevos usuarios al sistema, asignar los roles correspondientes y actualizar la información que se requiera.
 - Gestionar y administrar nuevos roles e ítem del menú. Vinculando item del menú al rol según corresponda.





HICE
jquery X
desactivar usuarios desactivarlos(vista) X
action de login
action de registro
action de deposito
action de admin
action de cuenta
action carrito
action cliente




FALTA
desactivar roles en editar usuarios

arreglar carrito

no eliminar productos, solo deshabilitarlos

editar roles(ahra editar menus, tiene mal las rutas en los formaction y no ahce lo que debe)
que se puedan agregar menus a los roles cambiar por el menu roles(falta la accion de la base de datos con los botones)




MENOS IMPORTANTE
crear usuario desde administrador no se hace

crear nuevo menu rol no se hace(seria mejor solo modificarlo y poner null donde no hay)

cambiar mail usuario desde cuenta (falta cambiar la ruta del script del boton)

corregir errores de la vista

form


los action se complicaron cuando empezaron a imprimir los datos de las cosas que se compran 