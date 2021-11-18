<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
//HEADER============================================================================
?>
<div align="center">
	<h2 class="mt-5">Administración</h2>
	<h3>Nuevo Usuario</h3>
</div>

<div class="container">
	<div class="row" style="padding-top: 2%;">
		<div class="col" align="center">
			<!-- Formulario -->
			<form id="nuevoUsuario" name="nuevoUsuario" method="POST" action="abmUsuario.php" data-toggle="validator">
				<label for="usnombre">Usuario</label> <br>
				<input name="usnombre" id="usnombre" type="text" placeholder="Usuario">
				<br>
				<br>
				<label for="usmail">Email</label> <br>
				<input name="usmail" id="usmail" type="text" placeholder="ejemplo@gmail.com">
				<br>
				<br>
				<label for="uspass">Contraseña</label> <br>
				<input name="uspass" id="uspass" type="text" placeholder="Contraseña">
				<br>
				<br>
				<label for="usdeshabilitado">Usuario deshabilitado</label> <br>
				<input type="checkbox" name="usdeshabilitado" id="usdeshabilitado" value="true">
				<br>
				<br>
				<!-- Submit -->
				<input type="submit" value="Crear" name="btn-form" id="btn-form" class="btn btn-success">
				<br>
				<br>
				<input type="reset" name="btn-form" id="btn-form" class="btn btn-warning">
			</form>
			<button onclick="location.href='listarUsuarios.php'" class="btn btn-dark">Usuarios</button>
		</div>
	</div>
</div>

<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>