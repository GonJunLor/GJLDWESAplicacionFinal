<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 16/12/2025
*/

?>
<main id="vInicioPrivado">
<form action="" method="post">
    <div>
        <button name="detalle" class="boton"><span>Detalle</span></button>
        <button name="error" class="boton"><span>Error</span></button>
        <button name="departamento" class="boton"><span>Mantenimiento de Departamento</span></button>
        <button name="rest" class="boton"><span>REST</span></button>  
    </div>
    <div class="columna1">
        <div class="tarjeta">
            <?php
                if ($_COOKIE["idioma"]=="ES") {
                    setlocale(LC_TIME, 'es_ES.utf8');

                    echo '<div><h2>Bienvenido '.$avInicioPrivado['descUsuario'].'.</h2></div>';
                    echo '<div><p>Esta el la '.$avInicioPrivado['numConexiones'].' vez que se conecta.</p>';
                    if (($avInicioPrivado['numConexiones'])>1) {
                        echo '<p>Usted se conectó por última vez el '.strftime("%d de %B de %Y a las %H:%M:%S", $avInicioPrivado['fechaHoraUltimaConexionAnterior']->getTimestamp()).'.</p></div>';
                    }     
                }
                if ($_COOKIE["idioma"]=="EN") {
                    setlocale(LC_TIME, 'en_GB.utf8');

                    echo '<div><h2>Welcome '.$avInicioPrivado['descUsuario'].'.</h2></div>';
                    echo '<div><p>This is the '.$avInicioPrivado['numConexiones'].' time you have connected.</p>';
                    if (($avInicioPrivado['numConexiones'])>1) {
                        echo '<p>You were last connected on '.strftime("%d de %B de %Y a las %H:%M:%S", $avInicioPrivado['fechaHoraUltimaConexionAnterior']->getTimestamp()).'.</p></div>';
                    }
                }
                if ($_COOKIE["idioma"]=="FR") {
                    setlocale(LC_TIME, 'fr_FR.UTF-8');

                    echo '<div><h2>Bienvenue '.$avInicioPrivado['descUsuario'].'.</h2></div>';
                    echo '<div><p>Voici votre '.$avInicioPrivado['numConexiones'].' e connexion.</p>';
                    if (($avInicioPrivado['numConexiones'])>1) {
                        echo '<p>Votre dernière connexion remonte au '.strftime("%d de %B de %Y a las %H:%M:%S", $avInicioPrivado['fechaHoraUltimaConexionAnterior']->getTimestamp()).'.</p></div>';
                    }
                }   
            ?>
        </div>
        <div class="tarjeta">
            <div>
                <h2>Mis datos</h2>
                <button name="cuenta" class="boton"><span class="enlace">Ver</span></button>
            </div>
            <div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium quam eius, repudiandae eos ducimus, ipsa fugiat in esse lib</p>
            </div>
        </div>
    </div>
    <div class="columna2">
        <div class="tarjeta">
            <div><h2>tarjeta 2</h2></div>
            <div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium quam eius, repudiandae eos ducimus, ipsa fugiat in esse libero molestias autem magni consequuntur earum maiores quibusdam ut aliquid necessitatibus? Distinctio!</p>
            </div>
        </div>
        
        <div class="tarjeta">
            <div><h2>tarjeta 4</h2></div>
            <div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium quam eius, repudiandae eos ducimus, ipsa fugiat in esse libero molestias autem magni consequuntur earum maiores quibusdam ut aliquid necessitatibus? Distinctio!</p>
            </div>
        </div>
    </div>
    

</form>
</main>
