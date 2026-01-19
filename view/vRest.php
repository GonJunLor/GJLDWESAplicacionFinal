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
    <div class="columna1">
        <div class="tarjeta">
            <div><h2>API NASA</h2></div>
            <div>
                <label for="fechaNasa">Fecha</label>
                <!-- <input type="date" id="fechaNasa" name="fechaNasa" value="<?php echo $avRest['fechaNasa']??'12/12/2012' ?>"> -->
                <input type="date" id="fechaNasa" name="fechaNasa" value="12/12/2012">
                <span class="error rojo"><?php echo $aErrores['fechaNasa'] ?></span>
                <button name="entrar" class="boton" id="entrar"><span>VER</span></button>
                    
                <?php echo $avRest['fotoNasa']->getTitulo(); ?>
                <img src="<?php echo $avRest['fotoNasa']->getUrl(); ?>" alt="Foto de la NASA">
                 
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

</form>
</main>