<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 31/01/2026
*/

// comprobamos que existe la sesion para este usuario, sino redirige al login
if (!isset($_SESSION["usuarioGJLDWESAplicacionFinal"])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

// vamos a la página detalle
if (isset($_REQUEST['detalle'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'detalle';
    header('Location: index.php');
    exit;
}


// vamos a la página error
if (isset($_REQUEST['error'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $consultaError = "SELECT * FROM T03_Cuestion";
    DBPDO::ejecutarConsulta($consultaError);
    $_SESSION['paginaEnCurso'] = 'error';
    header('Location: index.php');
    exit;
}

// vamos a la página mantenimiento de departamento
if (isset($_REQUEST['departamento'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // como no la tenemos vamos a la pagina en construcción
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

// vamos a la página detalle
if (isset($_REQUEST['rest'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'rest';
    header('Location: index.php');
    exit;
}

// vamos a la página de cuenta del usuario
if (isset($_REQUEST['cuenta'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;
}

// vamos a la página de cuenta del usuario
if (isset($_REQUEST['mtoUsuarios'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'mtoUsuarios';
    header('Location: index.php');
    exit;
}

$fotoUsuario = 'webroot/media/images/fotoUsuario.png';
if ($_SESSION['usuarioGJLDWESAplicacionFinal']->getImagenUsuario()!=null) {
    $fotoUsuario = 'data:image/png;base64,'.base64_encode($_SESSION['usuarioGJLDWESAplicacionFinal']->getImagenUsuario());
}

//Se crea un array con los datos del usuario para pasarlos a la vista
$avInicioPrivado=[
    'codUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getCodUsuario(),
    'descUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getDescUsuario(),
    'numConexiones' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getNumAccesos(),
    'fechaHoraUltimaConexion' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getFechaHoraUltimaConexion()->format("d-m-Y H:i:s"),
    'fechaHoraUltimaConexionSaludo' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getFechaHoraUltimaConexion(),
    'fechaHoraUltimaConexionAnterior' => ($_SESSION['usuarioGJLDWESAplicacionFinal']->getFechaHoraUltimaConexionAnterior()? $_SESSION['usuarioGJLDWESAplicacionFinal']->getFechaHoraUltimaConexionAnterior()->format("d-m-Y H:i:s"):""),
    'perfil' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getPerfil(),
    'fotoUsuario' => $fotoUsuario
];

$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];