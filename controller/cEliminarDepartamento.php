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

if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['eliminar'])) {

    if (DepartamentoPDO::bajaFisicaDepartamento($_SESSION['codDepartamentoEnCurso'])) {
        $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
        $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
        header('Location: index.php');
        exit;
    }
}

$oDepartamento = DepartamentoPDO::buscaDepartamentoPorCod($_SESSION['codDepartamentoEnCurso']);

// Creamos las fechas que vienen del objeto Departamento para formatearlas antes de pasarlas a la vista
$fechaCreacion = new DateTime($oDepartamento->getFechaCreacionDepartamento());
$fechaBajaFormateada = '';
if (!is_null($oDepartamento->getFechaBajaDepartamento())) {
    $fechaBaja = new DateTime($oDepartamento->getFechaBajaDepartamento());
    $fechaBajaFormateada = $fechaBaja->format('d/m/Y');
}
//Se crea un array con los datos del usuario para pasarlos a la vista
$avDepartamento = [
    'codDepartamento'           => $oDepartamento->getCodDepartamento(),
    'descDepartamento'          => $_REQUEST['descDepartamento']??str_replace('Departamento de ','',$oDepartamento->getDescDepartamento()),
    'fechaCreacionDepartamento' => $fechaCreacion->format('d/m/Y'),
    'volumenDeNegocio'          => $_REQUEST['volumenDeNegocio']??(number_format($oDepartamento->getVolumenDeNegocio(), 2, ',', '')),
    'fechaBajaDepartamento'     => $fechaBajaFormateada
];

$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];