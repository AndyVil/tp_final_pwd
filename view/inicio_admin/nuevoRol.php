<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
//HEADER============================================================================
?>

<div align="center">
	<h2 class="mt-5">Administración</h2>
	<h3>Nuevo Rol</h3>
</div>

<div class="container">
	<div class="row" style="padding-top: 2%;">
		<div class="col" align="center">
			<!-- Formulario -->
			<form id="nuevoRol" name="nuevoRol" method="POST" action="abmRol.php" data-toggle="validator">
				<label for="roldescricion">Descripcion de Rol</label> <br>
				<input name="roldescricion" id="roldescricion" type="text" placeholder="Descripcion de Rol" required>
				<br>
				<br>
				<!-- accion = nuevo (input oculto) -->
				<input id="idrol" name="idrol" value="DEFAULT" type="hidden">
				<input id="accion" name="accion" value="nuevo" type="hidden">
				<!-- Submit -->
				<input type="submit" value="Crear" name="btn-form" id="btn-form" class="btn btn-success">
				<br>
				<br>
				<input type="reset" name="btn-form" id="btn-form" class="btn btn-warning">
			</form>
			<button onclick="location.href='listarRoles.php'" class="btn btn-dark">Roles</button>
		</div>
	</div>
</div>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>