<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 11/01/2026
*/


if (isset($_REQUEST['iniciarSesion'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'login';
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


$entradaOK = true; //Variable que nos indica que todo va bien
$aErrores = [  //Array donde recogemos los mensajes de error
    'usuario' => '', 
    'contrasena'=>'',
    'descUsuario'=>''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'usuario' => '',  
    'contrasena'=>'',
    'descUsuario'=>''
]; 

//Para cada campo del formulario: Validar entrada y actuar en consecuencia
if (isset($_REQUEST["entrar"])) {//Código que se ejecuta cuando se envía el formulario

    // Validamos los datos del formulario
    $aErrores['usuario']= validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'],100,4,1);
    $aErrores['contrasena'] = validacionFormularios::validarPassword($_REQUEST['contrasena'],20,4,2,1);
    $aErrores['descUsuario']= validacionFormularios::comprobarAlfabetico($_REQUEST['descUsuario'],255,4,1,);
    
    foreach($aErrores as $campo => $valor){
        if(!empty($valor)){ // Comprobar si el valor es válido
            $entradaOK = false;
        } 
    }

    if ($entradaOK) {

        // si esta en la BBDD ponemos a false
        if (UsuarioPDO::validarCodNoExiste($_REQUEST['usuario'])) {
            $entradaOK = false;
            $aErrores['usuario'] = "El nombre de usuario ya existe.";
        }
    }
    
} else {//Código que se ejecuta antes de rellenar el formulario
    $entradaOK = false;
}

// Si la validación de datos es correcta procedemos a crear el usuario y guardarlo en la sesion
if ($entradaOK) {

    $oUsuario = UsuarioPDO::altaUsuario($_REQUEST['usuario'], $_REQUEST['contrasena'], $_REQUEST['descUsuario']);

    $_SESSION['usuarioGJLDWESAplicacionFinal'] = $oUsuario;

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;

}
$estadoBotonSalir = 'inactivo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];