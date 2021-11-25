<?php
require_once("../structure/header.php");
$datos = data_submited();
$id = '';

foreach ($datos as $key => $valor) {
	$id = $key;
	$accion = $valor;
}
if(!array_key_exists("idcompra",$datos)){
$idproducto = $datos["idproducto"];
$cicantidad = $datos["cicantidad"];
$ciprecio = $datos["ciprecio"];
}
//var_dump($datos);

//HEADER================================================================================
?>

<div class="container" align=center>
	<!-- Titulo pagina -->
	<div class="card bg-light mb-3" style="max-width: 18rem; margin-top:30px;">
		<div align="center">
			<h2 class="mt-5">Confirma la compra</h2>
		</div>
		<form method="POST" action="compraexitosa.php">
			<div align="center">
				<!-- Botones -->
				<?php 
				if(array_key_exists("idcompra",$datos)){
					$idcompra = $datos["idcompra"];
					echo "<input type='hidden' name='idcompra' id='idcompra'  class='btn btn-dark' value='$idcompra'>";
				}?>
				<input type='submit'  name='<?=$idproducto?>' id='<?=$idproducto?>'  class='btn btn-info' value='Confirmar compra'>
				<input type='hidden' name='ciprecio' id='ciprecio'  class='btn btn-dark' value='<?=$ciprecio?>'>
				<input type='hidden' name='cicantidad' id='cicantidad'  class='btn btn-dark' 
				value='<?=$cicantidad?>'>
				<input type='hidden' name='idproducto' id='idproducto'  class='btn btn-dark' value='<?=$idproducto?>'>
				<br>
				<br>
				<input type='submit' formaction="../inicio_cliente/index.php" name='<?=$idproducto?>' id='<?=$idproducto?>' class='btn btn-warning' value='Cancelar compra'>
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