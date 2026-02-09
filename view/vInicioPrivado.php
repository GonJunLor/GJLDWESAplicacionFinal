<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 24/01/2026
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
                        echo '<p>Usted se conectó por última vez el '.strftime("%d de %B de %Y a las %H:%M:%S", $avInicioPrivado['fechaHoraUltimaConexionSaludo']->getTimestamp()).'.</p>';
                    } 
                    echo '</div>';    
                }
                if ($_COOKIE["idioma"]=="EN") {
                    setlocale(LC_TIME, 'en_GB.utf8');

                    echo '<div><h2>Welcome '.$avInicioPrivado['descUsuario'].'.</h2></div>';
                    echo '<div><p>This is the '.$avInicioPrivado['numConexiones'].' time you have connected.</p>';
                    if (($avInicioPrivado['numConexiones'])>1) {
                        echo '<p>You were last connected on '.strftime("%d de %B de %Y a las %H:%M:%S", $avInicioPrivado['fechaHoraUltimaConexionSaludo']->getTimestamp()).'.</p>';
                    }
                    echo '</div>';
                }
                if ($_COOKIE["idioma"]=="FR") {
                    setlocale(LC_TIME, 'fr_FR.UTF-8');

                    echo '<div><h2>Bienvenue '.$avInicioPrivado['descUsuario'].'.</h2></div>';
                    echo '<div><p>Voici votre '.$avInicioPrivado['numConexiones'].' e connexion.</p>';
                    if (($avInicioPrivado['numConexiones'])>1) {
                        echo '<p>Votre dernière connexion remonte au '.strftime("%d de %B de %Y a las %H:%M:%S", $avInicioPrivado['fechaHoraUltimaConexionSaludo']->getTimestamp()).'.</p>';
                    }
                    echo '</div>';
                }   
            ?>
        </div>
        <!-- Si el perfil esta en el array de permisos carga el mto de usuarios, sino no -->
        <?php if(in_array($avInicioPrivado['perfil'],$permisos['mtoUsuarios'])): ?>
        <div class="tarjeta">
            <div>
                <h2>Usuarios</h2>
                <button name="mtoUsuarios" class="boton"><span class="enlace">Ver</span></button>
            </div>
            <div>
                <p>Espacio reservado para la futura función de mantenimiento de usuarios</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="columna2">
        <div class="tarjeta">
            <div>
                <h2>Mis datos</h2>
                <button name="cuenta" class="boton"><span class="enlace">Ver</span></button>
            </div>
            <div>
                <img class="fotoUsuario" src="<?php echo $avInicioPrivado['fotoUsuario'] ?>" alt="Foto Usuario">
                <p>Codigo de Usuario: <strong><?php echo $avInicioPrivado['codUsuario'] ?></strong></p>
                <p>Nombre y apellidos: <strong><?php echo $avInicioPrivado['descUsuario'] ?></strong></p>
                <p>Nº conexiones: <strong><?php echo $avInicioPrivado['numConexiones'] ?></strong></p>
                <p>Fecha última conexión: <strong><?php echo $avInicioPrivado['fechaHoraUltimaConexion'] ?></strong></p>
                <p>Fecha última conexión anterior: <strong><?php echo $avInicioPrivado['fechaHoraUltimaConexionAnterior'] ?></strong></p>
                <p>Perfil: <strong><?php echo $avInicioPrivado['perfil'] ?></strong></p>
            </div>
        </div>
        <!-- Si el perfil esta en el array de permisos carga el mto de cuestiones, sino no -->
        <?php if(in_array($avInicioPrivado['perfil'],$permisos['mtoCuestiones'])): ?>
        <div class="tarjeta">
            <div><h2>Cuestiones</h2></div>
            <div>
                <p>Espacio reservado para la futura función de mantenimiento de cuestiones</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    

</form>
</main>
