<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 30/01/2026
*/

?>
<main id="vCambiarPassword">
    <div id="cambiarPassword">
        <form id="datosPersonales" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <button name="datosPersonales" class="boton" >
                <h2>DATOS PERSONALES</h2>
            </button>
        </form>
        <h2>Cambiar Contraseña</h2>
        <form class="contenido" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <label for="contrasenaActual">Contraseña actual</label>
            <input type="text" class="obligatorio" id="contrasenaActual" name="contrasenaActual" value="<?php echo $_REQUEST['contrasenaActual']??''; ?>">
            <span class="error rojo"><?php echo $aErrores['contrasenaActual'] ?></span>
            <label for="contrasenaNueva">Nueva contraseña</label>
            <input type="text" class="obligatorio" id="contrasenaNueva" name="contrasenaNueva" value="<?php echo $_REQUEST['contrasenaNueva']??''; ?>">
            <span class="error rojo"><?php echo $aErrores['contrasenaNueva'] ?></span>
            <label for="repiteContrasena">Repite contraseña</label>
            <input type="text" class="obligatorio" id="repiteContrasena" name="repiteContrasena" value="<?php echo $_REQUEST['repiteContrasena']??''; ?>">
            <span class="error rojo"><?php echo $aErrores['repiteContrasena'] ?></span>
            <button name="guardar" class="boton" id="guardar"><span>GUARDAR</span></button>
            <button name="cancelar" class="boton" id="cancelar"><span>Cancelar</span></button>
        </form>
    </div>       
</main>
