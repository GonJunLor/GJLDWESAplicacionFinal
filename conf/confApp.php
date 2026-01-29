<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 19/01/2026
*/

require_once 'core/231018libreriaValidacion.php';

require_once 'conf/confDBPDO.php';

//Cargamos la definición de la clase
require_once 'model/Usuario.php'; 
require_once 'model/UsuarioPDO.php';
require_once 'model/DBPDO.php';
require_once 'model/ErrorApp.php';
require_once 'model/REST.php';
require_once 'model/FotoNasa.php';
require_once 'model/Departamento.php'; 
require_once 'model/DepartamentoPDO.php';

// constante para acceder a la api de la nasa con una clave privada mia
const API_KEY_NASA = 'uwcgeJsRXJe8JY2SPm26LWceI9GHg8bNXynfkq9s';
const PALABRASEGURIDAD = 'pimentel';

$controller=[
    'inicioPublico' => 'controller/cInicioPublico.php',
    'login' => 'controller/cLogin.php',
    'inicioPrivado' => 'controller/cInicioPrivado.php',
    'detalle' => 'controller/cDetalle.php',
    'error' => 'controller/cError.php',
    'registro' => 'controller/cRegistro.php',
    'wip' => 'controller/cWIP.php',
    'cuenta' => 'controller/cCuenta.php',
    'rest' => 'controller/cRest.php',
    'mtoDepartamentos' => 'controller/cMtoDepartamentos.php',
    'modificarDepartamento' => 'controller/cConsultarModificarDepartamento.php',
    'consultarDepartamento' => 'controller/cConsultarModificarDepartamento.php',
    'detalleNasa' => 'controller/cDetalleNasa.php'
];

$view=[
    'layout' => 'view/Layout.php',
    'inicioPublico' => 'view/vInicioPublico.php',
    'login' => 'view/vLogin.php',
    'inicioPrivado' => 'view/vInicioPrivado.php',
    'detalle' => 'view/vDetalle.php',
    'error' => 'view/vError.php',
    'registro' => 'view/vRegistro.php',
    'wip' => 'view/vWIP.php',
    'cuenta' => 'view/vCuenta.php',
    'rest' => 'view/vRest.php',
    'mtoDepartamentos' => 'view/vMtoDepartamentos.php',
    'modificarDepartamento' => 'view/vConsultarModificarDepartamento.php',
    'consultarDepartamento' => 'view/vConsultarModificarDepartamento.php',
    'detalleNasa' => 'view/vDetalleNasa.php'
];

$titulo=[
    'layout' => 'Layout',
    'inicioPublico' => 'Inicio Publico',
    'login' => 'Login',
    'inicioPrivado' => 'Inicio Privado',
    'detalle' => 'Detalle',
    'registro' => 'Registro',
    'cuenta' => 'Cuenta de Usuario',
    'rest' => 'REST',
    'error' => 'VENTANA DE ERROR',
    'wip' => 'VENTANA DE MANTENIMIENTO',
    'mtoDepartamentos' => 'Mantenimiento de departamentos',
    'modificarDepartamento' => 'Modificar Departamento',
    'consultarDepartamento' => 'Consultar Departamento',
    'detalleNasa' => 'Detalle foto Nasa'
];

$estadoBotonSalir = 'inactivo';
$estadoBotonIniciarSesion = 'activo';

?>