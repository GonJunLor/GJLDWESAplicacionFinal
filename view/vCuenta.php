<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 14/01/2026
*/

?>
<main id="vCuenta">
    <form action="" method="post">
        <div>
            <button name="volver" class="boton"><span>Volver</span></button> 
        </div>
    </form>
    <div id="cuenta">
        <h2>DATOS PERSONALES</h2>
        <span></span>
        <form class="contenido" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo $avCuenta['codUsuario'] ?>" disabled>
            <span class="error rojo"><?php echo $aErrores['usuario'] ?></span>
            <label for="descUsuario">Nombre y Apellidos</label>
            <input type="text" id="descUsuario" name="descUsuario" value="<?php echo $avCuenta['descUsuario'] ?>">
            <span class="error rojo"><?php echo $aErrores['descUsuario'] ?></span>
            <label for="perfil">Perfil</label>
            <input type="password" id="perfil" name="perfil" value="<?php echo $avCuenta['perfil'] ?>" disabled>
            <span class="error rojo"><?php echo $aErrores['contrasena'] ?></span>
            <button name="guardar" class="boton" id="guardar"><span>GUARDAR</span></button>
            <button name="cambiarContrasena" class="boton" id="cambiarContrasena"><span>Cambiar contraseña</span></button>
        </form>
    </div>       
</main>
