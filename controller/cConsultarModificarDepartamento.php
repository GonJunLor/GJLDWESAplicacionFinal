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

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

// Vamos a pagina de cambiar contraseña, de momento a pag en construccion
if (isset($_REQUEST['cambiarContrasena'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'wip';
    header('Location: index.php');
    exit;
}

$entradaOK = true; //Variable que nos indica que todo va bien
$aErrores = [  //Array donde recogemos los mensajes de error
    'descDepartamento' => '', 
    'volumenDeNegocio'=>''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'descDepartamento' => '', 
    'volumenDeNegocio'=>''
]; 

//Para cada campo del formulario: Validar entrada y actuar en consecuencia
if (isset($_REQUEST["modificar"])) {//Código que se ejecuta cuando se envía el formulario

    // Validamos los datos del formulario
    $aErrores['descDepartamento']= validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'],255,0,1);

    // Reemplazar la coma por un punto para estandarizar el formato numérico
    $volumenNegocioPunto = str_replace(',', '.', $_REQUEST['volumenDeNegocio']);
    $aErrores['volumenDeNegocio']= validacionFormularios::comprobarFloat($volumenNegocioPunto);
    
    foreach($aErrores as $campo => $valor){
        if(!empty($valor)){ // Comprobar si el valor es válido
            $entradaOK = false;
        } 
    }
    
} else {//Código que se ejecuta antes de rellenar el formulario
    $entradaOK = false;
}

// Si la validación de datos es correcta procedemos a crear el usuario
if ($entradaOK) {
    // cargamos el objeto departamento de la BBDD
    $oDepartamento = DepartamentoPDO::buscaDepartamentoPorCod($_SESSION['codDepartamentoEnCurso']);

    // modificamos los datos del departamento en la BBDD 
    $oDepartamento = DepartamentoPDO::modificaDepartamento(
        $oDepartamento, 
        'Departamento de '.$_REQUEST['descDepartamento'], 
        str_replace(',', '.', $_REQUEST['volumenDeNegocio'])
    );

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'consultarModificarDepartamento';
    header('Location: index.php');
    exit;

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

$estadoInputs = $_SESSION['paginaEnCurso']=='consultarDepartamento'?'disabled':'';
$estadoBotonModificar = $_SESSION['paginaEnCurso']=='consultarDepartamento'?'inactivo':'activo';
$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];