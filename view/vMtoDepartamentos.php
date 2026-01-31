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
                    <input type="text" name="DescDepartamentoBuscado" value="<?php echo $_SESSION['descDepartamentoBuscadaEnCurso']??'' ?>">
                    <span class="error"><?php echo $aErrores['DescDepartamentoBuscado'] ?></span>
                    <br>
                    <button name="buscar" class="boton" id="buscar"><span>Buscar</span></button>
                </form>
            </div>
        </div>
        <div class="tarjeta">
            <div><h2>Resultado</h2></div>
            <div>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <?php 
                    echo '<table>';
                    echo '<tr>';
                    echo '<th>Código</th>';
                    echo '<th>Departamento▼</th>';
                    echo '<th>Fecha de Creacion</th>';
                    echo '<th>Volumen de Negocio</th>';
                    echo '<th>Fecha de Baja</th>';
                    echo '</tr>';

                    foreach ($avMtoDepartamentos as $aDepartamento){
                        echo '<tr>';
                        echo '<td class="'.$aDepartamento['estadoDepartamento'].'">' . $aDepartamento['codDepartamento'] . '</td>';
                        echo '<td class="'.$aDepartamento['estadoDepartamento'].'">' . $aDepartamento['descDepartamento'] . '</td>';
                        echo '<td class="'.$aDepartamento['estadoDepartamento'].'">' . $aDepartamento['fechaCreacionDepartamento'] . '</td>';
                        echo '<td class="'.$aDepartamento['estadoDepartamento'].'">' . $aDepartamento['volumenDeNegocio'] . '</td>';
                        echo '<td class="'.$aDepartamento['estadoDepartamento'].'">' . $aDepartamento['fechaBajaDepartamento'] . '</td>';
                        echo '<td><button name="editar" value="'.$aDepartamento['codDepartamento'].'" class="boton" id="editar"><span>Editar</span></button></td>';
                        echo '<td><button name="mostrar" value="'.$aDepartamento['codDepartamento'].'" class="boton" id="mostrar"><span>Mostrar</span></button></td>';
                        echo '<td><button name="borrar" value="'.$aDepartamento['codDepartamento'].'" class="boton" id="borrar"><span>Borrar</span></button></td>';
                        echo '<td><button name="bajaAlta" value="'.$aDepartamento['codDepartamento'].'" class="boton" id="bajaAlta"><span>Baja/Alta</span></button></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                ?>
                </form>
            </div>
        </div>
    </div>
    
</main>
