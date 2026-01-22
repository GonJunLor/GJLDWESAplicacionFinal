<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 11/01/2026
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
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
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

// Volvemos al inicio público pero sin cerrar sesión
if (isset($_REQUEST['inicio'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
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
if (isset($_REQUEST["guardar"])) {//Código que se ejecuta cuando se envía el formulario

    // Validamos los datos del formulario
    $aErrores['descUsuario']= validacionFormularios::comprobarAlfabetico($_REQUEST['descUsuario'],255,4,1,);
    
    foreach($aErrores as $campo => $valor){
        if(!empty($valor)){ // Comprobar si el valor es válido
            $entradaOK = false;
        } 
    }

    // if ($entradaOK) {

    //     // comprobamos que el nuevo usuario no esté en la BBDD
    //     if (
    //         UsuarioPDO::validarCodNoExiste($_REQUEST['usuario']) 
    //         && $_REQUEST['usuario']!=$_SESSION['usuarioGJLDWESAplicacionFinal']->getCodUsuario()
    //     ) {
    //         $entradaOK = false;
    //         $aErrores['usuario'] = "El nombre de usuario ya existe.";
    //     }
    // }
    
} else {//Código que se ejecuta antes de rellenar el formulario
    $entradaOK = false;
}

// Si la validación de datos es correcta procedemos a crear el usuario
if ($entradaOK) {
    // cargamos el objeto usuario de la sesion
    $oUsuario = $_SESSION['usuarioGJLDWESAplicacionFinal'];

    // modificamos los datos del usuario en la BBDD 
    $oUsuario = UsuarioPDO::modificarUsuario($oUsuario, $_REQUEST['descUsuario'], $oUsuario->getPerfil());

    // modificarUsuario devuelve el objeto usuario modificado y lo guardamos de nuevo en la sesion
    $_SESSION['usuarioGJLDWESAplicacionFinal'] = $oUsuario;


    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;

}

//Se crea un array con los datos del usuario para pasarlos a la vista
$avCuenta=[
    'codUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getCodUsuario(),
    'descUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getDescUsuario(),
    'perfil' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getPerfil()
];

// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];