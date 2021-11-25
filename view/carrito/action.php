<?php
require_once("../structure/header.php");
$datos = data_submited();
$id = '';

foreach ($datos as $key => $valor) {
	$id = $key;
	$accion = $valor;
}
if (!array_key_exists("idcompra", $datos)) {
	$pronombre = $datos["pronombre"];
	$procantstock = $datos["procantstock"];
	$prodetalle = $datos["prodetalle"];
	$abmItem = new AbmCompraItem();
	$abmproducto = new AbmProducto();
	$idproducto = $datos["idproducto"];
	$productos = $abmproducto->buscar($datos);
	$proprecio = $productos[0]->getproprecio();
	$cicantidad = $datos["cicantidad"];
	$ciprecio = $datos["ciprecio"];
	$formulario = new Formulario();
	$infoArchivo = $formulario->obtenerArchivosPorId($idproducto);
	$link = $infoArchivo["link"];
}
$abmItem = new AbmCompraItem();
$abmcompra = new AbmCompra();
//var_dump($datos);

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
				<!-- Botones -->
				<?php
				if (array_key_exists("idcompra", $datos)) {
					echo "<div class='row'>";
					$idcompra = $datos["idcompra"];
					$where = ['idcompra' => $idcompra];
					$compras =$abmcompra->buscar($where);
					$coprecio = $compras[0]->getcompraprecio();
					$items = $abmItem->buscar($where);
					foreach ($items as $item) {
						$ciprecio = $item->getciprecio();
						$cicantidad = $item->getcicantidad();
						$idproducto = $item->getidproducto()->getidproducto();
						$proprecio = $item->getidproducto()->getproprecio();
						$pronombre = $item->getidproducto()->getpronombre();
						$procantstock = $item->getidproducto()->getprocantstock();
						$formulario = new Formulario();
						$infoArchivo = $formulario->obtenerArchivosPorId($idproducto);
						$link = $infoArchivo["link"];
						//var_dump($link);
						echo "<div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px';>
						</div>";
						echo "<div>$pronombre</div>";
						echo "<div>c/u: $$proprecio</div>";
						echo "<div> x$cicantidad</div>";
						echo "<div>Precio Total: $$proprecio</div>";
						echo "</div>";
					}
					echo "<input type='hidden' name='idcompra' id='idcompra'  class='btn btn-dark' value='$idcompra'>";
					echo "<div>$coprecio </div> ";
				} else {
					echo "<div class='col-lg-5 col-xl-4 text-lg-end'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px';>
						</div>";
					echo "<div>$pronombre</div>";
					echo "<div>c/u: $$proprecio</div>";
					echo "<div> x$cicantidad</div>";
					echo "<div>$$ciprecio</div>";
					echo "</div>";
					echo "<input type='hidden' name='pronombre' id='pronombre'  class='btn btn-dark' value='$pronombre'>";
					echo "<input type='hidden' name='procantstock' id='procantstock'  class='btn btn-dark' value='$procantstock'>";
					echo "<input type='hidden' name='prodetalle' id='prodetalle'  class='btn btn-dark' value='$prodetalle'>";
				}
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