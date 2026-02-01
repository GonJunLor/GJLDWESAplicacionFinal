<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 28/01/2026
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

$entradaOK = true; //Variable que nos indica que todo va bien
$aErrores = [  //Array donde recogemos los mensajes de error
    'codDepartamento' => '', 
    'descDepartamento' => '', 
    'volumenDeNegocio'=>''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'codDepartamento' => '', 
    'descDepartamento' => '', 
    'volumenDeNegocio'=>''
]; 

//Para cada campo del formulario: Validar entrada y actuar en consecuencia
if (isset($_REQUEST["crear"])) {//Código que se ejecuta cuando se envía el formulario

    // Validamos los datos del formulario
    $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'],3,3,1);
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'],255,3,1);

    // Reemplazar la coma por un punto para estandarizar el formato numérico
    $volumenNegocioPunto = str_replace(',', '.', $_REQUEST['volumenDeNegocio']);
    $aErrores['volumenDeNegocio'] = validacionFormularios::comprobarFloat($volumenNegocioPunto);
    
    foreach($aErrores as $campo => $valor){
        if(!empty($valor)){ // Comprobar si el valor es válido
            $entradaOK = false;
        } 
    }

    if ($entradaOK) {
        if(DepartamentoPDO::validaCodNoExiste($_REQUEST['codDepartamento'])){
            $entradaOK = false;
            $aErrores['codDepartamento'] = 'Éste código ya existe en la BBDD';
        }
    }
    
} else {//Código que se ejecuta antes de rellenar el formulario
    $entradaOK = false;
}

// Si la validación de datos es correcta procedemos a buscar el departamento en la BBDD
if ($entradaOK) {
    // cargamos el objeto departamento de la BBDD
    $oDepartamento = DepartamentoPDO::altaDepartamento(
        $_REQUEST['codDepartamento'],
        $_REQUEST['descDepartamento'],
        $_REQUEST['volumenDeNegocio']
    );

    if (!is_null($oDepartamento)) {
        $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
        $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
        header('Location: index.php');
        exit;
    }
}

// Creamos las fechas que vienen del objeto Departamento para formatearlas antes de pasarlas a la vista
$fechaCreacion = new DateTime();
$avDepartamento = [
    'fechaCreacionDepartamento' => $fechaCreacion->format('d/m/Y')
];

$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];