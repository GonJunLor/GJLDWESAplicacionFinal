<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 05/02/2026
*/
?>
<main id="vExportarPDF">
    <form action="" method="post">
        <button name="volver" class="boton"><span>Volver</span></button>
        <button class="boton" onclick="window.print();"><span>Imprimir</span></button> 
    </form>
    <div class="columna1">
        <div class="tarjeta">
            <!-- <div>
                <h2>DEPARTAMENTOS</h2>
            </div> -->
            <div>
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
                        echo '</tr>';
                    }
                    echo '</table>';
                ?>
            </div>
            <p>1/2</p>
        </div>
        <div class="tarjeta">
            <!-- <div>
                <h2>DEPARTAMENTOS</h2>
            </div> -->
            <div>
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
                        echo '</tr>';
                    }
                    echo '</table>';
                ?>
            </div>
            <p>2/2</p>
        </div>
    </div>
</main>
