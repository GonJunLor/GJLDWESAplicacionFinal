<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 24/01/2026
*/
?>
<main id="vMtoDepartamentos">
    <form action="" method="post">
        <div>
            <button name="volver" class="boton"><span>Volver</span></button> 
        </div>
    </form>
    <div class="columna1">
        <div class="tarjeta">
            <div><h2>Buscar departamento</h2></div>
            <div>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <label for="DescDepartamentoBuscado">Introduce Departamento a Buscar: </label>
                    <br>
                    <input type="text" name="DescDepartamentoBuscado" value="<?php echo $_REQUEST['DescDepartamentoBuscado']??'' ?>">
                    <span class="error"><?php echo $aErrores['DescDepartamentoBuscado'] ?></span>
                    <br>
                    <button name="buscar" class="boton" id="buscar"><span>Buscar</span></button>
                </form>
            </div>
        </div>
        <div class="tarjeta">
            <div><h2>Resultado</h2></div>
            <div>
                <?php 
                    echo '<table>';
                    echo '<tr>';
                    echo '<th>Código▼</th>';
                    echo '<th>Departamento</th>';
                    echo '<th>Fecha de Creacion</th>';
                    echo '<th>Volumen de Negocio</th>';
                    echo '<th>Fecha de Baja</th>';
                    echo '</tr>';

                    foreach ($avMtoDepartamentos as $aDepartamento){
                        echo '<tr>';
                        echo '<td>' . $aDepartamento['codDepartamento'] . '</td>';
                        echo '<td>' . $aDepartamento['descDepartamento'] . '</td>';
                        echo '<td>' . $aDepartamento['fechaCreacionDepartamento'] . '</td>';
                        echo '<td>' . $aDepartamento['volumenDeNegocio'] . '</td>';
                        echo '<td>' . $aDepartamento['fechaBajaDepartamento'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                ?>
            </div>
        </div>
    </div>
    
</main>
