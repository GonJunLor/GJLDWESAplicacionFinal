<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 16/12/2025
*/

?>
<main id="vLogin">
    <div id="login" >
        <form id="registro" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <button name="registro" class="boton" >
                <h2>REGÍSTRATE</h2>
            </button>
        </form>
        <h2>INICIA SESIÓN</h2>
        <form class="contenido" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <p>Bienvenid@ de nuevo! ¡Ya te echábamos de menos!</p>
            <label for="usuario"><span class="rojo">*</span> Usuario</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo $_REQUEST['usuario']??'' ?>">
            <label for="contrasena"><span class="rojo">*</span> Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" value="<?php echo $_REQUEST['contrasena']??'' ?>">
            <button name="entrar" class="boton" id="entrar"><span>Aceptar</span></button>
            <button name="cancelar" class="boton" id="cancelar"><span>Cancelar</span></button>
        </form>
    </div>
</main>