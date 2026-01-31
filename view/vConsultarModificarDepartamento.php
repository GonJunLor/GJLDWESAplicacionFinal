<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 14/01/2026
*/

?>
<main id="vConsultarModificarDepartamento">
    <form action="" method="post">
        <div>
            <button name="volver" class="boton <?php echo $estadoBotonVolver ?>"><span>Volver</span></button> 
        </div>
    </form>
    <div id="consultarModificarDepartamento">
        <h2>DEPARTAMENTO</h2>
        <span></span>
        <form class="contenido" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
            <label for="codDepartamento">Código</label>
            <input type="text" id="codDepartamento" name="codDepartamento" value="<?php echo $avDepartamento['codDepartamento'] ?>" disabled>
            <label for="descDepartamento">Departamento de</label>
            <input type="text" class="obligatorio<?php echo $estadoInputs ?>" id="descDepartamento" name="descDepartamento" value="<?php echo $avDepartamento['descDepartamento'] ?>" <?php echo $estadoInputs ?>>
            <span class="error rojo"><?php echo $aErrores['descDepartamento'] ?></span>
            <label for="fechaCreacionDepartamento">Fecha de Creacion</label>
            <input type="text" id="fechaCreacionDepartamento" name="fechaCreacionDepartamento" value="<?php echo $avDepartamento['fechaCreacionDepartamento'] ?>" disabled>
            <label for="volumenDeNegocio">Volumen de Negocio</label>
            <div id="cajaVolumenDeNegocio">
                <input type="text" class="obligatorio<?php echo $estadoInputs ?>" id="volumenDeNegocio" name="volumenDeNegocio" value="<?php echo $avDepartamento['volumenDeNegocio'] ?>" <?php echo $estadoInputs ?>>
                <span>€</span>
            </div>
            <span class="error rojo"><?php echo $aErrores['volumenDeNegocio'] ?></span>
            <label for="fechaBajaDepartamento">Fecha de Baja</label>
            <input type="text" id="fechaBajaDepartamento" name="fechaBajaDepartamento" value="<?php echo $avDepartamento['fechaBajaDepartamento'] ?>" disabled>
            <button name="modificar" class="boton <?php echo $estadoBotonModificar ?>" id="modificar"><span>MODIFICAR</span></button>
            <button name="volver" class="boton <?php echo $estadoBotonModificar ?>" id="cancelar"><span>CANCELAR</span></button> 
        </form>
    </div>       
</main>
