<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 16/12/2025
*/

// comprobamos que existe la sesion para este usuario, sino redirige al login
if (isset($_SESSION["usuarioDAW205AppLoginLogoff"])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: indexLoginLogoff.php');
    exit;
}

// vamos a la página detalle
if (isset($_REQUEST['detalle'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'detalle';
    header('Location: indexLoginLogoff.php');
    exit;
}


// vamos a la página error
if (isset($_REQUEST['error'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $consultaError = "SELECT * FROM T03_Cuestion";
    DBPDO::ejecutarConsulta($consultaError);
    $_SESSION['paginaEnCurso'] = 'error';
    header('Location: indexLoginLogoff.php');
    exit;
}

// vamos a la página mantenimiento de departamento
if (isset($_REQUEST['departamento'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // como no la tenemos vamos a la pagina en construcción
    $_SESSION['paginaEnCurso'] = 'wip';
    header('Location: indexLoginLogoff.php');
    exit;
}

// vamos a la página de cuenta del usuario
if (isset($_REQUEST['cuenta'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: indexLoginLogoff.php');
    exit;
}

// Volvemos al índice general destruyendo la sesión
if (isset($_REQUEST['cerrarSesion'])) {
    $_SESSION['paginaAnterior'] = '';
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    // Destruye la sesión
    session_destroy();
    header('Location: indexLoginLogoff.php');
    exit;
}

// Volvemoa al inicio público pero sin cerrar sesión
if (isset($_REQUEST['inicio'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: indexLoginLogoff.php');
    exit;
}

// comprueba si existe una cookie de idioma y si no existe la crea en español
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

//Se crea un array con los datos del usuario para pasarlos a la vista
$avInicioPrivado=[
    'descUsuario' => $_SESSION['usuarioGJLDWESLoginLogoff']->getDescUsuario(),
    'numConexiones' => $_SESSION['usuarioGJLDWESLoginLogoff']->getNumAccesos(),
    'fechaHoraUltimaConexionAnterior' => $_SESSION['usuarioGJLDWESLoginLogoff']->getFechaHoraUltimaConexionAnterior()
];

// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];