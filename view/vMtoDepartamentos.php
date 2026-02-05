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
            <button name="altaDepartamento" class="boton"><span>Alta Departamento</span></button> 
            <button name="exportar" class="boton"><span>Exportar</span></button> 
            <button name="exportarPDF" class="boton"><span>ExportarPDF</span></button> 
        </div>
    </form>
    <div class="columna1">
        <div class="tarjeta">
            <div><h2>Buscar departamento</h2></div>
            <div>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" id="formularioBuscar">
                    <span>
                        <label for="DescDepartamentoBuscado">Introduce Departamento a Buscar: </label>
                        <input type="text" name="DescDepartamentoBuscado" value="<?php echo $_SESSION['descDepartamentoBuscadaEnCurso']??'' ?>">
                        <span class="error"><?php echo $aErrores['DescDepartamentoBuscado'] ?></span>
                        <button name="buscar" class="boton" id="buscar"><span>Buscar</span></button>
                    </span>
                    <span>
                        <label for="radioAlta">Alta</label>
                        <input type="radio" name="radio" id="radioAlta" value="radioAlta" <?php echo $criterioRadio=='radioAlta'?'checked':'' ?>>
                        <label for="radioBaja">Baja</label>
                        <input type="radio" name="radio" id="radioBaja" value="radioBaja" <?php echo $criterioRadio=='radioBaja'?'checked':'' ?>>
                        <label for="radioTodos">Todos</label>
                        <input type="radio" name="radio" id="radioTodos" value="radioTodos" <?php echo $criterioRadio=='radioTodos'?'checked':'' ?>>
                    </span>
                    
                </form>
            </div>
            <div>
                <form class="archivoImportar" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" 
                enctype="multipart/form-data"> 
                <!-- Propiedad imprescindible para enviar archivos al servidor -->
                    <label for="archivoDepartamentos" class="labelFoto">Busca un archivo a importar: </label>
                    <input type="file" name="archivoDepartamentos" id="archivoDepartamentos" accept="application/json">
                    <button name="importar" class="boton" id="importar"><span>Importar</span></button>
                    
                </form>
                <span class="error"><?php echo $aErrores['archivoDepartamentos'] ?></span>
                <span class="correcto"><?php echo $aRespuestas['archivoDepartamentos'] ?></span>
            </div>
        </div>
        <div class="tarjeta">
            <div><h2>Resultado</h2></div>
            <div>
                <form id="formTablaDepartamentos" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
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
                        echo '<td><button name="bajaAlta" value="'.$aDepartamento['codDepartamento'].'" class="boton" id="bajaAlta"><span>'.$aDepartamento['estadoDepartamento'].'</span></button></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                ?>
                </form>
            </div>
            <form id="paginacionTabla" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <button name="paginaInicial" class="boton" id="paginaInicial">|<</button>
                <button name="paginaAnterior" class="boton" id="paginaAnterior"><</button>
                <p><?php echo $paginaActual ?></p>
                <p>de</p>
                <p><?php echo $totalPaginas ?></p>
                <button name="paginaSiguiente" class="boton" id="paginaSiguiente">></button>
                <button name="paginaFinal" class="boton" id="paginaFinal">>|</button>
            </form>
        </div>
    </div>
    
</main>
