<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 21/01/2026
*/
?>
<main id="vWIP">
    <form action="" method="post">
        <div>
            <button name="volver" class="boton"><span>Volver</span></button> 
        </div>
        <div class="columna1">
            <div class="tarjeta">
                <?php
                    echo '<div><h2>PÁGINA EN CONSTRUCCIÓN</h2></div>';
                    echo '<div><p>Lo sentimos, el enlace que has seguido no está disponible en este momento.</p></div>';
                    echo '<p>Lo que hay en la sesion: '.$_SESSION['codDepartamentoEnCurso'].'</p>'
                ?>
            </div>
        </div>
    </form>
</main>
