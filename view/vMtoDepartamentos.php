<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 23/01/2026
*/
?>
<main id="vMtoDepartamentos">
    <form action="" method="post">
        <div>
            <button name="volver" class="boton"><span>Volver</span></button> 
        </div>
        <div class="columna1">
            <div class="tarjeta">
                <div><h2>Buscar departamento</h2></div>
                <div>
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <label for="DescDepartamentoBuscado">Introduce Departamento a Buscar: </label>
                    <br>
                    <input type="text" name="DescDepartamentoBuscado" class="obligatorio" value="<?php echo $_REQUEST['DescDepartamentoBuscado']??'' ?>">
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

                        echo '<tr>';
                        echo '<td>'.$avMtoDepartamentos['codDepartamento'].'</td>';
                        echo '<td>'.$avMtoDepartamentos["descDepartamento"].'</td>';
                        // construimos la fecha a partir de la que hay en la bbdd y luego mostramos sólo dia mes y año
                        $oFecha = new DateTime($avMtoDepartamentos["fechaCreacionDepartamento"]);
                        echo '<td>'.$oFecha->format('d/m/Y').'</td>';
                        // formateamos el float para que se vea en €
                        echo '<td>'.number_format($avMtoDepartamentos["volumenDeNegocio"],2,',','.').' €</td>';
                        if (is_null($avMtoDepartamentos["fechaBajaDepartamento"])) {
                            echo '<td></td>';
                        } else {
                            $oFecha = new DateTime($avMtoDepartamentos["fechaBajaDepartamento"]);
                            echo '<td>'.$oFecha->format('d/m/Y').'</td>';
                        }
                        echo '</tr>';
                        
                        echo '</table>';
                    ?>
                </div>
            </div>
        </div>
    </form>
</main>
