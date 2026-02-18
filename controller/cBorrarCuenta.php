<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 11/01/2026
*/

// comprobamos que existe la sesion para este usuario, sino redirige al login
if (!isset($_SESSION["usuarioGJLDWESAplicacionFinal"])) {
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;
}

// Vamos a pagina de cambiar contraseña, de momento a pag en construccion
if (isset($_REQUEST['eliminar'])) {
    
    // Borramos el usuario de la BBDD pasandole el objeto usuario de la sesion
    if (UsuarioPDO::borrarUsuario($_SESSION['usuarioGJLDWESAplicacionFinal']->getCodUsuario())) {
        // Destruye la sesión
        session_destroy();
        $_SESSION['paginaEnCurso'] = 'inicioPublico';
        header('Location: index.php');
        exit;
    } 
}

$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];