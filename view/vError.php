<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 21/01/2026
*/
?>
<main id="vError">
    <form action="" method="post">
    <div>
        <button name="volver" class="boton"><span>Volver</span></button> 
    </div>
    
    <div class="columna1">
        <div class="tarjeta">
            <?php
                echo '<div><h2>Error - Code: </h2></div>';
                echo '<div><p>'.$avError['code'].'</p></div>';
            ?>
        </div>
        <div class="tarjeta">
            <?php
                echo '<div><h2>Error - Message: </h2></div>';
                echo '<div><p>'.$avError['message'].'</p></div>';
            ?>
        </div>
    </div>
    <div class="columna2">
        <div class="tarjeta">
            <?php
                echo '<div><h2>Error - File: </h2></div>';
                echo '<div><p>'.$avError['file'].'</p></div>';
            ?>
        </div>
        <div class="tarjeta">
            <?php
                echo '<div><h2>Error - Line: </h2></div>';
                echo '<div><p>'.$avError['line'].'</p></div>';
            ?>
        </div>
    </div>
    </form>
</main>
