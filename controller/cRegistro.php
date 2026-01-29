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

$entradaOK = true; //Variable que nos indica que todo va bien
$aErrores = [  //Array donde recogemos los mensajes de error
    'usuario' => '', 
    'contrasena'=>'',
    'descUsuario'=>'',
    'palabraSeguridad'=>'',
    'repiteContrasena'=>''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'usuario' => '',  
    'contrasena'=>'',
    'descUsuario'=>'',
    'palabraSeguridad'=>'',
    'repiteContrasena'=>''
]; 

//Para cada campo del formulario: Validar entrada y actuar en consecuencia
if (isset($_REQUEST["entrar"])) {//Código que se ejecuta cuando se envía el formulario

    // Validamos los datos del formulario
    $aErrores['usuario']= validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'],100,4,1);
    $aErrores['contrasena'] = validacionFormularios::validarPassword($_REQUEST['contrasena'],20,4,2,1);
    $aErrores['descUsuario']= validacionFormularios::comprobarAlfabetico($_REQUEST['descUsuario'],255,4,1,);
    $aErrores['palabraSeguridad']= validacionFormularios::comprobarAlfabetico($_REQUEST['palabraSeguridad'],255,4,1,);
    $aErrores['repiteContrasena'] = validacionFormularios::validarPassword($_REQUEST['repiteContrasena'],20,4,2,1);
    
    if ($_REQUEST['contrasena']!=$_REQUEST['repiteContrasena']){
        $aErrores['repiteContrasena'] = 'Las contraseñas no son iguales';
    }

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

        if ($_REQUEST['palabraSeguridad']!=PALABRASEGURIDAD){
            $entradaOK = false;
            $aErrores['palabraSeguridad'] = 'Palabra de seguridad incorrecta';
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