<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 29/01/2026
*/

// comprobamos que existe la sesion para este usuario, sino redirige al login
if (!isset($_SESSION["usuarioGJLDWESAplicacionFinal"])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'rest';
    header('Location: index.php');
    exit;
}

$oFotoNasaEnCurso = $_SESSION['fotoNasaEnCurso'];
$avDetalleNasa = [
    'fechaNasaEnCurso'=>$_SESSION["fechaNasaEnCurso"]->format('d-m-Y'),
    'fotoNasaEnCursoTitulo'=>$oFotoNasaEnCurso->getTitulo(),
    'fotoNasaEnCursoFecha'=>$oFotoNasaEnCurso->getfecha(),
    'fotoNasaEnCursoDescripcion'=>$oFotoNasaEnCurso->getDescripcion(),
    'fotoNasaEnCursoUrl'=>$oFotoNasaEnCurso->getUrl(),
    'fotoNasaEnCursoUrlHD'=>$oFotoNasaEnCurso->getUrlHD()
];

$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];