<?php
require_once("../structure/Header.php");
//HEADER============================================================================
$datos = data_submited();
$obj = new Formulario();
$arregloRes = $obj->misCompras($datos);
if ($arregloRes[0] !== false){
    $arregloRes[0] = array_reverse($arregloRes[0]);
}
$_SESSION['misCompras'] = $arregloRes;
header('Location:misCompras.php');
//FOOTER============================================================================
require_once("../structure/footer.php");
?>