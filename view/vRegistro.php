<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 11/01/2026
*/

?>
<main id="vRegistro">
    <form id="registro" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
        <h2>REGÍSTRATE</h2>
        <button name="iniciarSesion" class="boton" id="iniciarSesion">
            <h2>INICIA SESIÓN</h2>
        </button>
        <div>
            <label for="usuario"><span class="rojo">*</span>Usuario</label>
            <input type="text" class="<?php echo $aErrores['usuario']?'cuadroRojo':'' ?>" id="usuario" name="usuario" value="<?php echo $_REQUEST['usuario']??'' ?>">
            <span class="error rojo"><?php echo $aErrores['usuario'] ?></span>
            <label for="descUsuario"><span class="rojo">*</span> Nombre y Apellidos</label>
            <input type="text" id="descUsuario" name="descUsuario" value="<?php echo $_REQUEST['descUsuario']??'' ?>">
            <span class="error rojo"><?php echo $aErrores['descUsuario'] ?></span>
            <label for="contrasena"><span class="rojo">*</span>Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" value="<?php echo $_REQUEST['contrasena']??'' ?>">
            <span class="error rojo"><?php echo $aErrores['contrasena'] ?></span>
            <button name="entrar" class="boton" id="entrar"><span>CREAR CUENTA</span></button>
        </div>
    </form>
</main>