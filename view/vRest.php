<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 24/01/2026
*/
?>
<main id="vRest">
    <form action="" method="post">
        <div>
            <button name="volver" class="boton"><span>Volver</span></button> 
        </div>
    </form>
    <div class="columna1">
        <div class="tarjeta">
            <div><h2>API NASA</h2></div>
            <div class="contenidoNasa">
                <form action="">
                    <div>
                        <label for="fechaNasaEnCurso">Fecha: </label>
                        <input type="date" id="fechaNasaEnCurso" name="fechaNasaEnCurso" value="<?php echo $avRest['fechaNasaEnCurso'] ?>">
                        <span class="error rojo"><?php echo $aErrores['fechaNasaEnCurso'] ?></span>
                    </div>
                    <div>
                        <button name="entrar" class="boton" id="entrar"><span>VER</span></button>
                        <button name="detalle" class="boton" id="detalle"><span>Detalle</span></button>
                    </div>
                </form> 
                <br><hr><br>
                <h3><?php echo $avRest['fotoNasaEnCursoTitulo']; ?></h4>
                <div class="fotoNasa">
                    <img src="<?php echo $avRest['fotoNasaEnCursoUrl']; ?>" alt="Foto de la NASA">
                    <p class="descripcionNasa"><?php echo $avRest['fotoNasaEnCursoDescripcion']; ?></p>
                </div>
                <br><br>
                <h3>Instrucciones:</h3>
                <p>- Pedimos la key en <strong><a href="https://api.nasa.gov/" target="_blank">api.nasa.gov</a></strong></p>
                <br>
                <p>Construimos la <strong>$url</strong> con 3 partes, url, fecha y key:</p>
                <p>- <strong>https://api.nasa.gov/planetary/apod?</strong></p>
                <p>- <strong>date=$fecha</strong> (en $fecha esta la fecha del formulario)</p>
                <p>- <strong>&api_key=API_KEY_NASA</strong></p>
                <br>
                <p>Con <strong>$ch = curl_init()</strong> Iniciamos el cURL</p>
                <p>Con <strong>curl_setopt($ch, CURLOPT_URL, $url)</strong> Configuramos opciones para el cURL.</p>
                <p>Con <strong>$resultado = curl_exec($ch)</strong> ejecutamos la petición</p>
                <p>Con <strong>json_decode($resultado, true)</strong> transformamos a array la respuesta para poder usarlo</p>
            </div>
        </div>
    </div>
    <div class="columna2">
        <div class="tarjeta">
            <div><h2>Otra API</h2></div>
            <div>
                <p></p>
            </div>
        </div>
    </div>
    <div class="columna3">
        <div class="tarjeta">
            <div><h2>Mi API - Obtener volumen de negocio por codigo departamento</h2></div>
            <div>
                <form action="">
                    <label for="codDepartamentoEnCursoRest">Código a buscar su volumen: </label>
                    <select id="codDepartamentoEnCursoRest" name="codDepartamentoEnCursoRest">
                        <option value="">Seleccione un departamento</option>
                        <?php
                        foreach ($avRestDepartamentos as $departamento) {
                            // En cada option le ponemos de valor el codigo del departamento
                            /* En la siuiente linea es para que ponga select o nada en funcion de si 
                            el código que estamos pintando es el mismo que el guardado en la sesión */
                            echo '<option 
                                value="'.$departamento['codDepartamento'].'" 
                                '.(($avRest['codDepartamentoEnCursoRest'] == $departamento['codDepartamento']) ? 'selected' : '').'
                            >'.$departamento['codYdesc'].'</option>';   
                            // en esta última linea ponemos el texto "codigo - descripcion" para verlo bien.                     
                        }
                        ?>
                    </select>
                    <button name="entrarDepartamentoRest" class="boton" id="entrarDepartamentoRest"><span>Buscar</span></button>
                </form> 
                <hr>
                <div id="restVolumenResultado">
                    <h2>Volumen de negocio</h2>
                    <h2><?php echo $avRest['volumenDeNegocio'] ?> €</h2>
                </div>
            </div>
        </div>
    </div>
</main>