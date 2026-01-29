<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 11/01/2026
*/

?>
<main id="vRegistro">
    <div id="registro">
        <h2>REGÍSTRATE</h2>
        <form id="iniciarSesion" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <button name="iniciarSesion" class="boton" >
                <h2>INICIA SESIÓN</h2>
            </button>
        </form>
        <form class="contenido" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <label for="usuario"><span class="rojo">*</span>Usuario</label>
            <input type="text" class="obligatorio <?php echo $aErrores['usuario']?'cuadroRojo':'' ?>" id="usuario" name="usuario" value="<?php echo $_REQUEST['usuario']??'' ?>">
            <span class="error rojo"><?php echo $aErrores['usuario'] ?></span>
            <label for="descUsuario"><span class="rojo">*</span> Nombre y Apellidos</label>
            <input type="text" class="obligatorio" id="descUsuario" name="descUsuario" value="<?php echo $_REQUEST['descUsuario']??'' ?>">
            <span class="error rojo"><?php echo $aErrores['descUsuario'] ?></span>
            <label for="contrasena"><span class="rojo">*</span>Contraseña</label>
            <input type="password" class="obligatorio" id="contrasena" name="contrasena" value="<?php echo $_REQUEST['contrasena']??'' ?>">
            <span class="error rojo"><?php echo $aErrores['contrasena'] ?></span>
            <label for="repiteContrasena"><span class="rojo">*</span>Repite Contraseña</label>
            <input type="password" class="obligatorio" id="repiteContrasena" name="repiteContrasena" value="<?php echo $_REQUEST['repiteContrasena']??'' ?>">
            <span class="error rojo"><?php echo $aErrores['repiteContrasena'] ?></span>
            <label for="usuario"><span class="rojo">*</span>Palabra de Seguridad</label>
            <input type="text" class="obligatorio <?php echo $aErrores['palabraSeguridad']?'cuadroRojo':'' ?>" id="palabraSeguridad" name="palabraSeguridad" value="<?php echo $_REQUEST['palabraSeguridad']??'' ?>">
            <span class="error rojo"><?php echo $aErrores['palabraSeguridad'] ?></span>
            <button name="entrar" class="boton" id="entrar"><span>CREAR CUENTA</span></button>
        </form>
    </div>       
</main>