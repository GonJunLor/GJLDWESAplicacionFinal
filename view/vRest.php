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
                <p><?php echo $avRest['fotoNasaEnCurso']->getTitulo(); ?></p>
                <a href="<?php echo $avRest['fotoNasaEnCurso']->getUrlHD(); ?>" target="_blank">
                    <img src="<?php echo $avRest['fotoNasaEnCurso']->getUrl(); ?>" alt="Foto de la NASA">
                </a>
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