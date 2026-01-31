<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 31/01/2026
*/

?>
<main id="vBorrarCuenta">
    <div id="borrarCuenta">
        <h2>DATOS PERSONALES</h2>
        <span></span>
        <form class="contenido" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <p>¿Estás seguro de que quieres borrar tu cuenta? Los datos se borrarán de forma permanente y no podrás recuperarlos.</p>
            <button name="eliminar" class="boton" id="eliminar"><span>Eliminar</span></button>
            <button name="cancelar" class="boton" id="cancelar"><span>Cancelar</span></button>
        </form>
    </div>       
</main>
