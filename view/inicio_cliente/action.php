<?php
require_once("../structure/header.php");
$datos = data_submited();
$id = '';
$accion = "carrito.php";
foreach ($datos as $key => $valor) {
	$id = $key;
	$accion = $valor;
}
if ($accion == "Comprar")
	$accion = "comprar.php";
//HEADER================================================================================
?>

<div class="container" align=center>
	<!-- Titulo pagina -->
	<div class="card bg-light mb-3" style="max-width: 18rem; margin-top:30px;">
		<div align="center">
			<h2 class="mt-5">No inicio sesion</h2>
		</div>
		<form method="POST" action="../login/index.php">
			<div align="center">
				<!-- Botones -->
				<input type='submit' formaction="../login/index.php" name='<?= $id ?>' id='Seleccion:$archivo' class='btn btn-dark' value='Ya tengo cuenta'>
				<br>
				<br>
				<input type='submit' formaction="../registro/index.php" name='<?= $id ?>' id='Seleccion:$archivo' class='btn btn-dark' value='Soy nuevo'>
				<br>
				<br>
			</div>
		</form>
	</div>
</div>



<?php
//FOOTER=================================================================================
require_once("../structure/footer.php");
?>