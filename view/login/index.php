<title><?= "Tienda de ropa" ?></title>
<?php
require_once("../structure/Header.php");
//HEADER============================================================================
?>


<!--BODY============================================================================-->
<!-- PAGINA LOGIN -->
<main role="main" class="container">

    <div class="row" style="padding-top: 2%;">
        <div class="col" align="center">
            <h3>LOG IN</h3>
            <!-- Formulario -->
            <form action="">
                <label for="usnombre">Usuario</label> <br>
                <input name="usnombre" id="usnombre" type="text" placeholder="Usuario">
                <br>
                <br>
                <label for="uspass">Contraseña</label> <br>
                <input name="uspass" id="uspass" type="text" placeholder="Contraseña">
                <br>
                <br>
                <!-- Submit -->
                <input type="submit" value="Enviar" name="btn-form" id="btn-form" class="btn btn-success">
                <br>
                <br>
                <input type="reset" name="btn-form" id="btn-form" class="btn btn-warning">
            </form>
            <!-- Redireccion a registro -->
            <span>Si no tiene cuenta:
                <a href="./../registro/">
                    <p>Regístrese</p>
            </span>
        </div>
    </div>

</main>


<?php
//FOOTER============================================================================
require_once("../structure/footer.php");
?>