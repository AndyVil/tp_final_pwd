<?php
require_once("../structure/header.php");
$datos = data_submited();
$resultado = $_SESSION['cargarCarrito'];
$comprobacion = $resultado['comprobacion'];
$datosRes = $resultado['datosRes'];
//HEADER================================================================================
?>

<div class="container" align=center>
	<!-- Titulo pagina -->
	<div class="card bg-light mb-3" style="max-width: 18rem; margin-top:30px;">
		<div align="center">
			<h2 class="mt-5">Confirmar la compra</h2>
		</div>
		<form method="POST" action="compraexitosa.php">
			<div align="center">
				<?php
				$id = '';
				foreach ($datos as $key => $valor) {
					$id = $key;
					$accion = $valor;
				}
				echo "<div class='row'>";
				if ($comprobacion) {
					$idcompra = $datosRes["idcompra"];
					$coprecio = $datosRes["coprecio"];
					$items = $datosRes["items"];
					for($i=0; $i<count($items); $i++) {
						$ciprecio = $items[$i]['ciprecio'];
						$cicantidad = $items[$i]['cicantidad'];
						$idproducto = $items[$i]['idproducto'];
						$proprecio =  $items[$i]['proprecio'];
						$pronombre = $items[$i]['pronombre'];
						$procantstock = $items[$i]['procantstock'];
						$link = $items[$i]['link'];

						echo "<div>Nombre de Producto: $pronombre</div>";
						echo "<div>C/U: $$proprecio</div>";
						echo "<div>Cantidad ×$cicantidad</div>";
						echo "<div>Total: $$proprecio</div>";
						echo '<span class="container"><hr></span>'; //Los span limitan el ancho de los hr
					}

					echo "<input type='hidden' name='idcompra' id='idcompra'  class='btn btn-dark' value='$idcompra'>";
					echo "<div>Precio total de compra : $coprecio </div> ";
					echo '<span class="container"><hr></span>'; //Los span limitan el ancho de los hr
				} else {
					$pronombre = $datosRes["pronombre"];
					$procantstock = $datosRes["procantstock"];
					$prodetalle = $datosRes["prodetalle"];
					$idproducto = $datosRes["idproducto"];
					$proprecio = $datosRes["proprecio"];
					$cicantidad = $datosRes["cicantidad"];
					$ciprecio = $datosRes["ciprecio"];
					$link = $datosRes["link"];

					echo "<div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px';>
						 </div>";
					echo "<div>$pronombre</div>";
					echo "<div>C/U: $$proprecio</div>";
					echo "<div>×$cicantidad</div>";
					echo "<div>$$ciprecio</div>";
					echo "<input type='hidden' name='pronombre' id='pronombre'  class='btn btn-dark' value='$pronombre'>";
					echo "<input type='hidden' name='procantstock' id='procantstock'  class='btn btn-dark' value='$procantstock'>";
					echo "<input type='hidden' name='prodetalle' id='prodetalle'  class='btn btn-dark' value='$prodetalle'>";
				}
				echo '</div>'; //div class row
				?>

				<input type='submit' name='<?= $idproducto ?>' id='<?= $idproducto ?>' class='btn btn-info' value='Confirmar compra'>
				<input type='hidden' name='ciprecio' id='ciprecio' class='btn btn-dark' value='<?= $ciprecio ?>'>
				<input type='hidden' name='cicantidad' id='cicantidad' class='btn btn-dark' value='<?= $cicantidad ?>'>
				<input type='hidden' name='idproducto' id='idproducto' class='btn btn-dark' value='<?= $idproducto ?>'>
				<br>
				<br>
				<input type='submit' formaction="../inicio_cliente/index.php" name='<?= $idproducto ?>' id='<?= $idproducto ?>' class='btn btn-warning' value='Cancelar compra'>
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