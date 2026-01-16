<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 14/01/2026
*/

?>
<form action="" method="post">
    <button name="cerrarSesion" class="boton">
        <span>Cerrar Sesión</span>
    </button>
</form>
</nav>
<main>
<div id="login">
    <h2>DATOS PERSONALES</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
        Usuario:
        <input type="text" id="usuario" name="usuario" value="<?php echo $avCuenta['codUsuario'] ?>" disabled>
        <br>
        Nombre y apellidos:
        <input type="text" id="descUsuario" name="descUsuario" value="<?php echo $avCuenta['descUsuario'] ?>">
        <span class="error"><?php echo $aErrores['descUsuario'] ?></span>
        <br>  
        Perfil: 
        <input type="text" id="perfil" name="perfil" value="<?php echo $avCuenta['perfil'] ?>" disabled>
        <br>
        <button name="guardar" class="boton" id="entrar"><span>Guardar</span></button>
        <button name="volver" class="boton" id="cancelar"><span>Volver</span></button>
        <br>
        <button name="cambiarContrasena" class="boton" id="cambiarContrasena"><span>Cambiar contraseña</span></button>
    </form>
</div>