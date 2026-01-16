<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 11/01/2026
*/
?>

</nav>
<main>
<div>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"> 
        <button name="volver" class="boton" id="volver"><span>Volver</span></button>
    </form>
</div>
<h2>VENTANA DE ERROR</h2>
<br>
<?php

    echo '<h2>Error - Code: </h2>';
    echo '<p>'.$avError['code'].'</p>';

    echo '<h2>Error - Message: </h2>';
    echo '<p>'.$avError['message'].'</p>';

    echo '<h2>Error - File: </h2>';
    echo '<p>'.$avError['file'].'</p>';

    echo '<h2>Error - Line: </h2>';
    echo '<p>'.$avError['line'].'</p>';
    
?>