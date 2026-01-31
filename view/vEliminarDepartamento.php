<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 31/01/2026
*/

?>
<main id="vEliminarDepartamento">
    <div id="eliminarDepartamento">
        <h2>DEPARTAMENTO</h2>
        <span></span>
        <form class="contenido" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <label for="codDepartamento">Código</label>
            <input type="text" id="codDepartamento" name="codDepartamento" value="<?php echo $avDepartamento['codDepartamento'] ?>" disabled>
            <label for="descDepartamento">Departamento de</label>
            <input type="text" id="descDepartamento" name="descDepartamento" value="<?php echo $avDepartamento['descDepartamento'] ?>" disabled>
            <label for="fechaCreacionDepartamento">Fecha de Creacion</label>
            <input type="text" id="fechaCreacionDepartamento" name="fechaCreacionDepartamento" value="<?php echo $avDepartamento['fechaCreacionDepartamento'] ?>" disabled>
            <label for="volumenDeNegocio">Volumen de Negocio</label>
            <div id="cajaVolumenDeNegocio">
                <input type="text" id="volumenDeNegocio" name="volumenDeNegocio" value="<?php echo $avDepartamento['volumenDeNegocio'] ?>" disabled>
                <span>€</span>
            </div>
            <label for="fechaBajaDepartamento">Fecha de Baja</label>
            <input type="text" id="fechaBajaDepartamento" name="fechaBajaDepartamento" value="<?php echo $avDepartamento['fechaBajaDepartamento'] ?>" disabled>
            <button name="eliminar" class="boton" id="eliminar"><span>Eliminar</span></button>
            <button name="cancelar" class="boton" id="cancelar"><span>CANCELAR</span></button> 
        </form>
    </div>       
</main>
