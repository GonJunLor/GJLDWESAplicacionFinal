<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 31/01/2026
*/

?>
<main id="vCuenta">
    <div id="cuenta">
        <h2>DATOS PERSONALES</h2>
        <form id="cambiarContrasena" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <button name="cambiarContrasena" class="boton" >
                <h2>Cambiar Contraseña</h2>
            </button>
        </form>
        <form class="contenido" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" 
        enctype="multipart/form-data"> 
        <!-- Propiedad imprescindible para enviar archivos al servidor -->
            <div>
                <div>
                    <label for="codUsuario">Usuario</label>
                    <input type="text" id="inputCodUsuario" value="<?php echo $avCuenta['codUsuario'] ?>" disabled>
                </div>
                <div>
                    <label for="fotoUsuario" class="labelFoto">
                        <img class="fotoUsuario" 
                            src="<?php echo $avCuenta['fotoUsuario'] ?>" 
                            alt="Foto Usuario"
                        >
                        <div class="mensajeFoto">Pulsar para cargar foto y guardar para que se cambie.</div>
                    </label>
                    <input type="file" name="fotoUsuario" id="fotoUsuario" accept="image/*">
                </div>
            </div>
            <span class="error rojo"><?php echo $aErrores['fotoUsuario'] ?></span>
            <label for="descUsuario">Nombre y Apellidos</label>
            <input type="text" class="obligatorio" id="descUsuario" name="descUsuario" value="<?php echo $avCuenta['descUsuario'] ?>">
            <span class="error rojo"><?php echo $aErrores['descUsuario'] ?></span>
            <label for="numConexiones">Número de accesos</label>
            <input type="text" value="<?php echo $avCuenta['numConexiones'] ?>" disabled>
            <label for="fechaHoraUltimaConexion">Fecha de última conexion</label>
            <input type="text" value="<?php echo $avCuenta['fechaHoraUltimaConexion'] ?>" disabled>
            <label for="fechaHoraUltimaConexionAnterior">Fecha de última conexión anterior</label>
            <input type="text" value="<?php echo $avCuenta['fechaHoraUltimaConexionAnterior'] ?>" disabled>
            <label for="perfil">Perfil</label>
            <input type="text" value="<?php echo $avCuenta['perfil'] ?>" disabled>
            <button name="guardar" class="boton" id="guardar"><span>GUARDAR</span></button>
            <button name="cancelar" class="boton" id="cancelar"><span>Cancelar</span></button>
            <hr>
            <button name="borrarCuenta" class="boton" id="borrarCuenta"><span>Eliminar cuenta</span></button>
        </form>
    </div>       
</main>
