<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 16/12/2025
*/

// volvemos al index principal al dar a cancelar
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
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


// vamos a la pagina de registro
if (isset($_REQUEST['registro'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'registro';
    header('Location: index.php');
    exit;
}

$entradaOK = true; //Variable que nos indica que todo va bien
$oUsuario = null; // Variable para el objeto usuario
$aErrores = [  //Array donde recogemos los mensajes de error
    'nombre' => '', 
    'contrasena'=>''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'nombre' => '',  
    'contrasena'=>''
]; 

//Para cada campo del formulario: Validar entrada y actuar en consecuencia
if (isset($_REQUEST["entrar"])) {//Código que se ejecuta cuando se envía el formulario

    // Validamos los datos del formulario
    $aErrores['usuario']= validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'],100,0,1,);
    $aErrores['contrasena'] = validacionFormularios::validarPassword($_REQUEST['contrasena'],20,4,2);
    
    foreach($aErrores as $campo => $valor){
        if(!empty($valor)){ // Comprobar si el valor es válido
            $entradaOK = false;
        } 
    }
    
    if ($entradaOK) {
        $oUsuario = UsuarioPDO::validarUsuario($_REQUEST['usuario'], $_REQUEST['contrasena']);

        // si no esta en la BBDD ponemos a false
        if (!isset($oUsuario)) {
            $entradaOK = false;
        }
    }
    
} else {//Código que se ejecuta antes de rellenar el formulario
    $entradaOK = false;
}

// Si la validación de datos es correcta comprobamos si está en la BBDD
if ($entradaOK) {

    $oUsuario = UsuarioPDO::registrarUltimaConexion($oUsuario);
    
    $_SESSION['usuarioGJLDWESLoginLogoff'] = $oUsuario;

    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;

}
// si la validación de entrada no es correcta o el usuario no está en la BBDD recargamos el login 

// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];