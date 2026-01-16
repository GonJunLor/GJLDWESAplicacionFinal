<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 16/12/2025
*/

?>
<form action="" method="post">
    <button name="cerrarSesion" class="boton">
        <span>Cerrar Sesión</span>
    </button>
</form>
</nav>
<main>
<form action="" method="post">
    <button name="detalle" class="boton"><span>Detalle</span></button>
    <button name="error" class="boton"><span>Error</span></button>
    <button name="departamento" class="boton"><span>Mantenimiento de Departamento</span></button>
    <button name="cuenta" class="boton"><span>Cuenta de Usuario</span></button>
</form>
<?php

    if ($_COOKIE["idioma"]=="ES") {
        setlocale(LC_TIME, 'es_ES.utf8');

        echo '<h2>Bienvenido '.$avInicioPrivado['descUsuario'].'.</h2>';
        echo '<h2>Esta el la '.$avInicioPrivado['numConexiones'].' vez que se conecta.</h2>';
        if (($avInicioPrivado['numConexiones'])>1) {
            echo '<h2>Usted se conectó por última vez el '.strftime("%d de %B de %Y a las %H:%M:%S", $avInicioPrivado['fechaHoraUltimaConexionAnterior']->getTimestamp()).'.</h2>';
        }
        
    }
    if ($_COOKIE["idioma"]=="EN") {
        setlocale(LC_TIME, 'en_GB.utf8');

        echo '<h2>Welcome '.$avInicioPrivado['descUsuario'].'.</h2>';
        echo '<h2>This is the '.$avInicioPrivado['numConexiones'].' time you have connected.</h2>';
        if (($avInicioPrivado['numConexiones'])>1) {
            echo '<h2>You were last connected on '.strftime("%d de %B de %Y a las %H:%M:%S", $avInicioPrivado['fechaHoraUltimaConexionAnterior']->getTimestamp()).'.</h2>';
        }
    }
    if ($_COOKIE["idioma"]=="FR") {
        setlocale(LC_TIME, 'fr_FR.UTF-8');

        echo '<h2>Bienvenue '.$avInicioPrivado['descUsuario'].'.</h2>';
        echo '<h2>Voici votre '.$avInicioPrivado['numConexiones'].' e connexion.</h2>';
        if (($avInicioPrivado['numConexiones'])>1) {
            echo '<h2>Votre dernière connexion remonte au '.strftime("%d de %B de %Y a las %H:%M:%S", $avInicioPrivado['fechaHoraUltimaConexionAnterior']->getTimestamp()).'.</h2>';
        }
    }
    
?>