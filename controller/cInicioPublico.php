<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 15/12/2025
*/

// comprobamos que existe la sesion para este usuario para cambiar el texto del boton de iniciar sesión
if (isset($_SESSION["usuarioGJLDWESLoginLogoff"])) {
    $textoBotonIniciarSesion = 'Hola '.$_SESSION["usuarioGJLDWESLoginLogoff"]->getCodUsuario();

    // si está la sesión iniciada redirigimos directamente al inicio privado
    if (isset($_REQUEST['iniciarSesion'])) {
        $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
        $_SESSION['paginaEnCurso'] = 'inicioPrivado';
        header('Location: indexLoginLogoff.php');
        exit;
    }
}

if (isset($_REQUEST['iniciarSesion'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: indexLoginLogoff.php');
    exit;
}

// comprubea si existe una cookie de idioma y si no existe la crea en español
if (!isset($_COOKIE['idioma'])) {
    setcookie("idioma", "ES", time()+604.800); // caducidad 1 semana
    header('Location: ./indexLoginLogoff.php');
    exit;
}

// comprueba si se ha pulsado cualquier botón de idioma y pone en la cookie su valor para establecer el idioma
if (isset($_REQUEST['idioma'])) {
    setcookie("idioma", $_REQUEST['idioma'], time()+604.800); // caducidad 1 semana
    header('Location: ./indexLoginLogoff.php');
    exit;
}

// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];