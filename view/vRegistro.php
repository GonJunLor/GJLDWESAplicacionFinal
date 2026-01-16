<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 11/01/2026
*/

?>

</nav>
<main>
<div id="login">
    <h2>DATOS PERSONALES</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
        <input type="text" id="usuario" name="usuario" value="<?php echo $_REQUEST['usuario']??'' ?>" placeholder="Usuario">
        <span class="error"><?php echo $aErrores['usuario'] ?></span>
        <br>
        <input type="text" id="descUsuario" name="descUsuario" value="<?php echo $_REQUEST['descUsuario']??'' ?>" placeholder="Nombre Apellido">
        <span class="error"><?php echo $aErrores['descUsuario'] ?></span>
        <br>
        <input type="password" id="contrasena" name="contrasena" value="<?php echo $_REQUEST['contrasena']??'' ?>" placeholder="Contraseña">
        <span class="error"><?php echo $aErrores['contrasena'] ?></span>
        <br>   
        <button name="entrar" class="boton" id="entrar"><span>Entrar</span></button>
        <button name="cancelar" class="boton" id="cancelar"><span>Cancelar</span></button>
    </form>
</div>