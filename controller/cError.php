<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 21/01/2026
*/

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

// Volvemos al inicio público pero sin cerrar sesión
if (isset($_REQUEST['inicio'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

// comprueba si existe una cookie de idioma y si no existe la crea en español
if (!isset($_COOKIE['idioma'])) {
    setcookie("idioma", "ES", time()+604.800); // caducidad 1 semana
    header('Location: ./index.php');
    exit;
}

// comprueba si se ha pulsado cualquier botón de idioma y pone en la cookie su valor para establecer el idioma
if (isset($_REQUEST['idioma'])) {
    setcookie("idioma", $_REQUEST['idioma'], time()+604.800); // caducidad 1 semana
    header('Location: ./index.php');
    exit;
}

// Volvemos al índice general destruyendo la sesión
if (isset($_REQUEST['cerrarSesion'])) {
    $_SESSION['paginaAnterior'] = '';
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    // Destruye la sesión
    session_destroy();
    header('Location: index.php');
    exit;
}

//Se crea un array con la información de la clase ErrorApp
$avError=[
    'code' => $_SESSION['error']->getCode(),
    'message' => $_SESSION['error']->getMessage(),
    'file' => $_SESSION['error']->getFile(),
    'line' => $_SESSION['error']->getLine()
];

$estadoBotonSalir = 'inactivo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];