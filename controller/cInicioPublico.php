<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 24/01/2026
*/

// comprobamos que existe la sesion para este usuario para redirigir a las paginas correctas
if (isset($_SESSION["usuarioGJLDWESAplicacionFinal"])) {
    $estadoBotonSalir = 'activo';
    $estadoBotonIniciarSesion = 'inactivo';

    // si está la sesión iniciada redirigimos directamente al inicio privado
    if (isset($_REQUEST['iniciarSesion']) || isset($_REQUEST['miCuenta'])) {
        $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
        $_SESSION['paginaEnCurso'] = 'inicioPrivado';
        header('Location: index.php');
        exit;
    }
}


if (isset($_REQUEST['iniciarSesion'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['registrarse'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'registro';
    header('Location: index.php');
    exit;
}

// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];