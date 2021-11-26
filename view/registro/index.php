<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
//HEADER============================================================================
?>



<!-- PAGINA REGISTRO -->
<div align="center">
    <h2 class="mt-5">Registro</h2>
</div>

<div class="container">

    <div class="row" style="padding-top: 2%;">
        <div class="col" align="center">
            <!-- Formulario -->
            <form class="form-register" id="registro" name="registro" method="POST" action="action.php">
                <label for="usnombre">Usuario</label> <br>
                <input name="usnombre" id="usnombre" type="text" placeholder="Usuario">
                <br>
                <br>
                <label for="usmail">Email</label> <br>
                <input name="usmail" id="usmail" type="text" placeholder="ejemplo@gmail.com">
                <br>
                <br>
                <label for="uspass">Contraseña</label> <br>
                <input name="uspass" id="uspass" type="password" placeholder="Contraseña">
                <br>
                <br>
                <input type="hidden" value="DEFAULT" name="idusuario" id="idusuario">
                <input type="hidden" value="0000-00-00 00:00:00" name="usdeshabilitado" id="usdeshabilitado">
                <!-- Submit -->
                <input type="submit" value="Enviar" name="btn-form" id="btn-registro" class="btn btn-success">
                <br>
                <br>
                <input type="reset" name="btn-form" id="btn-form" class="btn btn-warning">
            </form>
        </div>
        <!-- <span id='aviso' class='alert alert-warning' role='alert' align='center'></span> -->
    </div>

</div>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>