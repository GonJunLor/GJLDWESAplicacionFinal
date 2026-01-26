<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 24/01/2026
*/

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="webroot/media/favicon/favicon-32x32.png">
    <link rel="stylesheet" href="webroot/css/fonts.css">
    <link rel="stylesheet" href="webroot/css/estilos.css">
    <link rel="stylesheet" href="webroot/css/<?php echo $_SESSION['paginaEnCurso']; ?>.css">
    <title>Gonzalo Junquera Lorenzo</title>
</head>
<body>
    <div id="aviso">Aplicación Final 2026</div>
    <div id="sombra"></div>
    <nav id="cabecera">
        <form action="" method="post">
            <ul class="menuCabecera">
                <li>
                    <button name="inicio" class="botonLogo">
                        <img src="webroot/media/images/logo_appFinal.svg" alt="logo">
                    </button>
                </li>
                <li>
                    <h2><?php echo $titulo[$_SESSION['paginaEnCurso']]; ?></h2>
                </li>
                <li class="menuIdioma">
                    <button type="submit" name="idioma" value="ES" id="ES" >
                        <p>ES</p>
                        <img class="<?php echo $_COOKIE["idioma"]=="ES"? 'visible' : 'oculto';?>" src="webroot/media/images/ubicacion.svg" alt="logo">
                    </button>
                    <button type="submit" name="idioma" value="EN" id="EN">
                        <p>EN</p>
                        <img class="<?php echo $_COOKIE["idioma"]=="EN"? 'visible' : 'oculto';?>" src="webroot/media/images/ubicacion.svg" alt="logo">
                    </button>
                    <button type="submit" name="idioma" value="FR" id="FR">
                        <p>FR</p>
                        <img class="<?php echo $_COOKIE["idioma"]=="FR"? 'visible' : 'oculto';?>" src="webroot/media/images/ubicacion.svg" alt="logo">
                    </button>
                </li>
                <li class="menuIniciarSesion">
                    <button name="iniciarSesion" class="botonIniciarSesion">
                        <img src="webroot/media/images/usuario.svg" alt="logo">
                    </button>
                    <ul class="submenuIniciarSesion">
                        <li class="<?php echo $estadoBotonIniciarSesion; ?>"><button name="iniciarSesion" class="enlaceIniciarSesion">Iniciar Sesion</button></li>
                        <li class="<?php echo $estadoBotonSalir; ?>"><button name="miCuenta" class="enlaceCuenta">Mi Cuenta</button></li>
                        <li class="<?php echo $estadoBotonIniciarSesion; ?>"><button name="registrarse" class="enlaceRegistrarse">Registrarse</button></li>
                        <li class="<?php echo $estadoBotonSalir; ?>"><button name="cerrarSesion" class="enlaceCerrarSesion">Salir</button></li>
                    </ul>
                </li>
                <li>
                    <button class="<?php echo $estadoBotonSalir; ?>" name="cerrarSesion" class="botonCerrarSesion">
                        <img src="webroot/media/images/salir.svg" alt="logo">
                    </button>
                </li>
            </ul>
        </form>
    </nav>
    <?php require_once $view[$_SESSION['paginaEnCurso']]; ?>
    <footer id="pie">
        <div>
            <a href="https://gonzalojunlor.ieslossauces.es/" target="_blank">
            <address style="display: inline;">Gonzalo Junquera Lorenzo</address>
            </a>
        </div>
        <div class="derechos">
            <p>2025-26 IES LOS SAUCES. &#169;Todos los derechos reservados. </p>
            <!-- <time datetime="2025-12-15">15-12-2025.</time> -->
        </div>
        <div>
            <a id="iconoGithub" href="https://github.com/GonJunLor/GJLDWESAplicacionFinal.git target="_blank">
                <img src="webroot/media/images/github.png" alt="">
            </a>
            <a id="webImitada" href="https://www.kiwoko.com/"  target="_blank">
                <img src="webroot/media/images/kiwoko.png" alt="">
            </a>
            <a id="cv" href="doc/pdf/cv.pdf" target="_blank">          
                <img src="webroot/media/images/cv.png" alt="cv gonzalo" height="35" >        
            </a>
        </div>
    </footer>
</body>
</html>