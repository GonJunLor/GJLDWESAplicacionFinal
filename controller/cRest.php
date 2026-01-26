<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 24/01/2026
*/

// comprobamos que existe la sesion para este usuario, sino redirige al login
if (!isset($_SESSION["usuarioGJLDWESAplicacionFinal"])) {
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

// Para control de la fecha, por defecto creamos la fecha de hoy
$oFechaNasaEnCurso = new DateTime(); // Variable para el objeto fechaNasa
if (isset($_SESSION["fechaNasaEnCurso"])) {
    // si ya hay una fecha en la sesión se usa esa en vez de la actual
    $oFechaNasaEnCurso = $_SESSION["fechaNasaEnCurso"];
}

/* Para que al cargar la pagina aparezca directamente la foto de la nasa
cargamos aqui el objeto fotoNasa. En caso de error en la api lo controlamos 
justo antes de cargar el layout */
$fechaNasaFormateada = $oFechaNasaEnCurso->format('Y-m-d');

$entradaOK = true; //Variable que nos indica que todo va bien
$aErrores = [  //Array donde recogemos los mensajes de error
    'fechaNasaEnCurso' => ''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'fechaNasaEnCurso' => ''
]; 

//Para cada campo del formulario: Validar entrada y actuar en consecuencia
if (isset($_REQUEST["entrar"])) {//Código que se ejecuta cuando se envía el formulario

    // Validamos los datos del formulario
    $ofechaActual = new DateTime(); // creamos la fecha actual para pasarla al validarfecha
    $ofechaMinima = new DateTime('1995-06-16'); // creamos la fecha minima para pasarla al validarfecha
    $aErrores['fechaNasaEnCurso']= validacionFormularios::validarFecha($_REQUEST['fechaNasaEnCurso'],$ofechaActual->format('m/d/Y'),$ofechaMinima->format('m/d/Y'));
    
    foreach($aErrores as $campo => $valor){
        if(!empty($valor)){ // Comprobar si el valor es válido
            $entradaOK = false;
        } 
    }
    
    // Comprobamos que el servidor de la api este bien, que responda, etc.
    if ($entradaOK) {
        $oFechaNasaEnCurso = new DateTime($_REQUEST['fechaNasaEnCurso']); // Variable para el objeto fechaNasa
        $fechaNasaFormateada = $oFechaNasaEnCurso->format('Y-m-d');

        $oFotoNasaEnCurso = REST::apiNasa($fechaNasaFormateada);

        // guardamos en la sesion la fecha que viene del formulario para recordarla después.
        $_SESSION['fechaNasaEnCurso'] = $oFechaNasaEnCurso;

        // aqui entramos en caso de algo haya ido mal al usar la api de la nasa
        if (!isset($oFotoNasaEnCurso)) {
            $entradaOK = false;
            $aErrores['fechaNasaEnCurso'] = "Error al cargar la api de la NASA";
        } else {
            // guardamos en la sesion el objeto fotoNasa que viene de la api para no tener que usarla constantemente al recargar paginas
            $_SESSION['fotoNasaEnCurso'] = $oFotoNasaEnCurso;
            $_SESSION['fechaNasaEnCurso'] = new DateTime($_REQUEST['fechaNasaEnCurso']);
        }
    }
    
} else {//Código que se ejecuta antes de rellenar el formulario
    $entradaOK = false;
}

// Si la validación de datos es correcta cargamos los datos de la nasa
if ($entradaOK) {

    $_SESSION['paginaEnCurso'] = 'rest';
    header('Location: index.php');
    exit;

}

/* Para que se vea bien la fecha en la vista, ya que sino se me cambia a la anterior aunque es sólo
visual ya que en la sesión esta la fecha nueva pero en el input no aparece */
if (isset($_SESSION["fechaNasaEnCurso"])) {
    // si ya hay una fecha en la sesión se usa esa en vez de la actual
    $oFechaNasaEnCurso = $_SESSION["fechaNasaEnCurso"];
}

// Si ya hay un objeto en la sesion usamos éste en vez de pedir otro
if (isset($_SESSION['fotoNasaEnCurso'])) {
    $oFotoNasaEnCurso = $_SESSION['fotoNasaEnCurso'];
} else {
    //se llama a la api con la fecha formateada
    $oFotoNasaEnCurso = REST::apiNasa($fechaNasaFormateada);
    $_SESSION['fotoNasaEnCurso'] = $oFotoNasaEnCurso;
}

// Para controlar si el objeto fotoNasa se ha creado correctamente, sino creamos uno para que no de error la vista
if (!isset($oFotoNasaEnCurso)) {
    $oFotoNasaEnCurso = new FotoNasa('1990-04-24','','webroot/media/images/banderaEs.png','No hay foto del dia','webroot/media/images/banderaEs.png');
}


$avRest = [
    'fechaNasaEnCurso'=>$oFechaNasaEnCurso->format('Y-m-d'),
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