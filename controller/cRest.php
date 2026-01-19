<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 19/01/2026
*/

// comprobamos que existe la sesion para este usuario, sino redirige al login
if (isset($_SESSION["usuarioDAW205AppLoginLogoff"])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

// volvemos al index principal al dar a cancelar
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
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

// Volvemoa al inicio público pero sin cerrar sesión
if (isset($_REQUEST['inicio'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

$entradaOK = true; //Variable que nos indica que todo va bien
$oFechaNasa = new DateTime(); // Variable para el objeto fechaNasa
$aErrores = [  //Array donde recogemos los mensajes de error
    'fechaNasa' => ''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'fechaNasa' => ''
]; 

//Para cada campo del formulario: Validar entrada y actuar en consecuencia
if (isset($_REQUEST["entrar"])) {//Código que se ejecuta cuando se envía el formulario

    // Validamos los datos del formulario
    $ofechaActual = new DateTime(); // creamos la fecha actual para pasarla al validarfecha
    $ofechaMinima = new DateTime('1990-04-24'); // creamos la fecha minima para pasarla al validarfecha
    $aErrores['fechaNasa']= validacionFormularios::validarFecha($_REQUEST['fechaNasa'],$ofechaActual->format('m/d/Y'),$ofechaMinima->format('m/d/Y'));
    
    foreach($aErrores as $campo => $valor){
        if(!empty($valor)){ // Comprobar si el valor es válido
            $entradaOK = false;
        } 
    }
    
    // Comprobamos que el servidor de la api este bien, que responda, etc.
    if ($entradaOK) {
        

    }
    
} else {//Código que se ejecuta antes de rellenar el formulario
    $entradaOK = false;
}

// Si la validación de datos es correcta comprobamos cargamos los datos de la nasa
if ($entradaOK) {

    $_SESSION['paginaEnCurso'] = 'rest';
    header('Location: index.php');
    exit;

}

//se obtiene la fecha de hoy para la foto del día de la Nasa
$fechaHoy = new DateTime();
$fechaHoyFormateada = $fechaHoy->format('Y-m-d');
//se llama a la api con la fecha formateada
$oFotoNasa = REST::apiNasa($fechaHoyFormateada);

$avRest = [
    'fechaNasa'=> $oFechaNasa->format('d/m/Y'),
    'fotoNasa'=>$oFotoNasa
];

// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];