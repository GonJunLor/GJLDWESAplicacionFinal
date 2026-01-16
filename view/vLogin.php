<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 16/12/2025
*/

?>

</nav>
<main>
<div id="login">
    <h2>INICIO SESIÓN</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
        <input type="text" id="usuario" name="usuario" value="<?php echo $_REQUEST['usuario']??'' ?>" placeholder="Usuario">
        <br>
        <input type="password" id="contrasena" name="contrasena" value="<?php echo $_REQUEST['contrasena']??'' ?>" placeholder="Contraseña">
        <br>   
        <button name="entrar" class="boton" id="entrar"><span>Entrar</span></button>
        <button name="cancelar" class="boton" id="cancelar"><span>Cancelar</span></button>
        <br>
        <hr>
        <p>¿No tienes cuenta?</p>
        <input type="submit" value="Registrarse" name="registro" class="boton" id="registro">
    </form>
</div>
