<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 19/01/2026
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
                    </div>
                </form> 
                <br><hr><br>
                <h3><?php echo $avRest['fotoNasaEnCursoTitulo']; ?></h4>
                <a class="fotoNasa" href="<?php echo $avRest['fotoNasaEnCursoUrlHD']; ?>" target="_blank">
                    <img src="<?php echo $avRest['fotoNasaEnCursoUrl']; ?>" alt="Foto de la NASA">
                    <p class="descripcionNasa"><?php echo $avRest['fotoNasaEnCursoDescripcion']; ?></p>
                </a>
                <br><br>
                <h3>Instrucciones:</h3>
                <p>- Pedimos la key en <strong><a href="https://api.nasa.gov/">api.nasa.gov</a></strong></p>
                <br>
                <p>Construimos la url con 3 partes, url, fecha y key:</p>
                <p>- <strong>https://api.nasa.gov/planetary/apod?</strong></p>
                <p>- <strong>date=$fecha</strong> (en $fecha esta la fecha del formulario)</p>
                <p>- <strong>&api_key=API_KEY_NASA</strong></p>
                <br>
                <p>Con <strong>file_get_contents(url)</strong> obtenemos la respuesta json de la API</p>
                <p>Con <strong>json_decode(archivoJson, true)</strong> transformamos a array la respuesta para poder usarlo</p>
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
            <div><h2>Mi API</h2></div>
            <div>
                <p></p>
            </div>
        </div>
    </div>
</main>