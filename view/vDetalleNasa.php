<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 29/01/2026
*/
?>
<main id="vDetalleNasa">
    <form action="" method="post">
        <div>
            <button name="volver" class="boton"><span>Volver</span></button> 
        </div>
        <div class="columna1">
            <div class="tarjeta">
                <div>
                    <?php
                        echo '<h2>'.$avDetalleNasa['fotoNasaEnCursoTitulo'].'</h2>';
                        echo '<p>'.$avDetalleNasa['fotoNasaEnCursoDescripcion'].'</p>';
                    ?>
                </div>
                <div>
                    <?php echo '<p>'.$avDetalleNasa['fechaNasaEnCurso'].'</p>'; ?>
                    <!-- <a href="<?php echo $avDetalleNasa['fotoNasaEnCursoUrlHD']; ?>" target="_blank"> -->
                        <img src="<?php echo $avDetalleNasa['fotoNasaEnCursoUrlHD']; ?>" alt="">
                    <!-- </a> -->
                </div>
                
            </div>
            
        </div>
    </form>
</main>
