<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 01/02/2026
*/

?>
<main id="vAltaDepartamento">
    <div id="altaDepartamento">
        <h2>DEPARTAMENTO</h2>
        <span></span>
        <form class="contenido" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <label for="codDepartamento">Código</label>
            <input type="text" class="obligatorio" id="codDepartamento" name="codDepartamento" value="<?php echo $_REQUEST["codDepartamento"]??'' ?>">
            <span class="error rojo"><?php echo $aErrores['codDepartamento'] ?></span>
            <label for="descDepartamento">Departamento de</label>
            <input type="text" class="obligatorio" id="descDepartamento" name="descDepartamento" value="<?php echo $_REQUEST["descDepartamento"]??'' ?>">
            <span class="error rojo"><?php echo $aErrores['descDepartamento'] ?></span>
            <label for="fechaCreacionDepartamento">Fecha de Creacion</label>
            <input type="text" id="fechaCreacionDepartamento" name="fechaCreacionDepartamento" value="<?php echo $avDepartamento['fechaCreacionDepartamento'] ?>" disabled>
            <label for="volumenDeNegocio">Volumen de Negocio</label>
            <div id="cajaVolumenDeNegocio">
                <input type="text" class="obligatorio" id="volumenDeNegocio" name="volumenDeNegocio" value="<?php echo $_REQUEST["volumenDeNegocio"]??'' ?>">
                <span>€</span>
            </div>
            <span class="error rojo"><?php echo $aErrores['volumenDeNegocio'] ?></span>
            <button name="crear" class="boton" id="crear"><span>Crear</span></button>
            <button name="cancelar" class="boton" id="cancelar"><span>CANCELAR</span></button> 
        </form>
    </div>       
</main>
