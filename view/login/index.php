<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/header.php");
include_once './../../config.php';
$datos = data_submited();
//var_dump($datos);
$objLogin = new Session();
$arrayKey = key($datos);
//var_dum($arrayKey);
if ($objLogin->activa()) {
    header('location:paginaSegura.php');
} elseif (!$objLogin->activa() && $arrayKey == 'error'){    
    echo "<div class='alert alert-danger' role='alert' align=center>
          Datos incorrectos!
          </div>";
}
$id = '';


//HEADER============================================================================
?>


 
<!-- PAGINA LOGIN -->
<div align="center">
    <h2 class="mt-5">LOG IN</h2>
</div>

<div class="container">

    <div class="row" style="padding-top: 2%;">
        <div class="col" align="center">
            <!-- Formulario -->
            <form class="form-signin" id="login" name="login" action="verificarLogin.php" method="POST">
                <label for="usnombre">Usuario</label> <br>
                <input name="usnombre" id="usnombre" type="text" placeholder="Usuario">
                <br>
                <br>
                <label for="uspass">Contraseña</label> <br>
                <input name="uspass" id="uspass" type="password" placeholder="Contraseña">
                <br>
                <br>
                <!-- Submit -->
                <input type="submit" value="Enviar" name="btn-form" id="btn-form" class="btn btn-success">
                <br>
                <br>
                <?php 
                if(count($datos)>0){
                    foreach ($datos as $key => $valor) {
                        $id = $key;
                        $accion = $valor;
                    }
                    echo "<input type='hidden' name='idproducto' id='idproducto' value='<?=$id?>'>";

                }
                ?>
                
                <input type="reset" name="btn-form" id="btn-form" class="btn btn-warning">
            </form>
            <!-- Redireccion a registro -->
            <span>Si no tiene cuenta:
                <a href="./../registro/">
                    <p>Regístrese</p>
                </a>    
            </span>
        </div>
    </div>
</div>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>