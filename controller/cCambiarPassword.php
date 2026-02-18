<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 30/01/2026
*/

// comprobamos que existe la sesion para este usuario, sino redirige al login
if (!isset($_SESSION["usuarioGJLDWESAplicacionFinal"])) {
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

// Vamos a pagina de cambiar contraseña, de momento a pag en construccion
if (isset($_REQUEST['datosPersonales'])) {
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;
}

$entradaOK = true; //Variable que nos indica que todo va bien
$aErrores = [  //Array donde recogemos los mensajes de error
    'contrasenaActual' => '', 
    'contrasenaNueva'=>'',
    'repiteContrasena'=>''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'contrasenaActual' => '', 
    'contrasenaNueva'=>'',
    'repiteContrasena'=>''
]; 

//Para cada campo del formulario: Validar entrada y actuar en consecuencia
if (isset($_REQUEST["guardar"])) {//Código que se ejecuta cuando se envía el formulario

    // Validamos los datos del formulario
    $aErrores['contrasenaActual'] = validacionFormularios::validarPassword($_REQUEST['contrasenaActual'],20,4,2,1);
    if (empty($aErrores['contrasenaActual'])) {
        // Comprobamos que la contraseña actual es la misma que tiene el usuario activo
        $oUsuarioActual = $_SESSION['usuarioGJLDWESAplicacionFinal'];
        $nuevaContrasenaHash = hash('sha256', $oUsuarioActual->getCodUsuario() . $_REQUEST['contrasenaActual']);
        if ($oUsuarioActual->getPassword()!=$nuevaContrasenaHash){
            $aErrores['contrasenaActual'] = 'La contraseña no coincide con la actual';
            $entradaOK = false;
        }
    }
    
    $aErrores['contrasenaNueva'] = validacionFormularios::validarPassword($_REQUEST['contrasenaNueva'],20,4,2,1);
    if (empty($aErrores['contrasenaNueva'])) {
        // Comprobamos que las nuevas contraseñas son iguales y no coinciden con la actual
        if ($_REQUEST['contrasenaActual']==$_REQUEST['contrasenaNueva']){
            $aErrores['contrasenaNueva'] = 'Pon una contraseña distinta a la actual';
            $entradaOK = false;
        }
    }

    $aErrores['repiteContrasena'] = validacionFormularios::validarPassword($_REQUEST['repiteContrasena'],20,4,2,1); 
    if (empty($aErrores['repiteContrasena'])) {
        if ($_REQUEST['contrasenaNueva']!=$_REQUEST['repiteContrasena']){
            $aErrores['repiteContrasena'] = 'Las contraseñas no son iguales';
            $entradaOK = false;
        }
    }
    
    foreach($aErrores as $campo => $valor){
        if(!empty($valor)){ // Comprobar si el valor es válido
            $entradaOK = false;
        } 
    }
    
} else {//Código que se ejecuta antes de rellenar el formulario
    $entradaOK = false;
}

// Si la validación de datos es correcta procedemos a cambiar la contraseña en la BBDD
if ($entradaOK) {
    // cargamos el objeto usuario de la sesion
    $oUsuarioActual = $_SESSION['usuarioGJLDWESAplicacionFinal'];

    // modificamos la contraseña en la BBDD 
    $oUsuarioActual = UsuarioPDO::cambiarPassword($oUsuarioActual->getCodUsuario(), $_REQUEST['contrasenaNueva']);

    // cambiarPassword devuelve el objeto usuario modificado y lo guardamos de nuevo en la sesion
    $_SESSION['usuarioGJLDWESAplicacionFinal'] = $oUsuarioActual;

    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;

}

$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];