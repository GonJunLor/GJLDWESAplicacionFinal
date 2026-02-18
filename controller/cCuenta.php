<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 31/01/2026
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
if (isset($_REQUEST['cambiarContrasena'])) {
    $_SESSION['paginaEnCurso'] = 'cambiarContrasena';
    header('Location: index.php');
    exit;
}

// vamos a ventana de elimnar cuenta
if (isset($_REQUEST['borrarCuenta'])) {
    $_SESSION['paginaEnCurso'] = 'borrarCuenta';
    header('Location: index.php');
    exit;
}

$entradaOK = true; //Variable que nos indica que todo va bien
$aErrores = [  //Array donde recogemos los mensajes de error
    'descUsuario'=>'',
    'fotoUsuario'=>''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'descUsuario'=>'',
    'fotoUsuario'=>''
]; 

//Para cada campo del formulario: Validar entrada y actuar en consecuencia
if (isset($_REQUEST["guardar"])) {//Código que se ejecuta cuando se envía el formulario

    // Validamos los datos del formulario
    $aErrores['descUsuario']= validacionFormularios::comprobarAlfabetico($_REQUEST['descUsuario'],255,4,1);
    $aExtensiones = ['jpg','png','jpeg'];
    $nombreArchivo = $_FILES['fotoUsuario']['name'] ?? '';
    $aErrores['fotoUsuario']= validacionFormularios::validarNombreArchivo($nombreArchivo,$aExtensiones,150,4,0);

    foreach($aErrores as $campo => $valor){
        if(!empty($valor)){ // Comprobar si el valor es válido
            $entradaOK = false;
        } 
    }

    // Nos aseguramos que la imagen que sube tenga un tamaño pequeño
    $tamanoMaximo = 64 * 1024; // 64 KB en bytes
    if ($_FILES['fotoUsuario']['size'] > $tamanoMaximo) {
        $aErrores['fotoUsuario'] = "La imagen es demasiado grande. Máximo 64 KB.";
        $entradaOK = false;
    }
    
} else {//Código que se ejecuta antes de rellenar el formulario
    $entradaOK = false;
}

// Si la validación de datos es correcta procedemos a crear el usuario
if ($entradaOK) {
    // cargamos el objeto usuario de la sesion
    $oUsuario = $_SESSION['usuarioGJLDWESAplicacionFinal'];

    // Verificamos si se ha subido un archivo sin errores
    if (isset($_FILES['fotoUsuario']) && $_FILES['fotoUsuario']['error'] === UPLOAD_ERR_OK) {
        // Leemos el contenido del archivo temporal y lo pasamos a binario
        $contenidoImagen = file_get_contents($_FILES['fotoUsuario']['tmp_name']);
    } else {
        $aErrores['fotoUsuario']='Error al subir el archivo';
        // Si no se sube una foto nueva, mantenemos la que ya tiene el objeto usuario
        $contenidoImagen = $_SESSION['usuarioGJLDWESAplicacionFinal']->getImagenUsuario();
    }
    
    // modificamos los datos del usuario en la BBDD 
    $oUsuario = UsuarioPDO::modificarUsuario($oUsuario->getCodUsuario(), $_REQUEST['descUsuario'], $oUsuario->getPerfil(), $contenidoImagen);

    // modificarUsuario devuelve el objeto usuario modificado y lo guardamos de nuevo en la sesion
    $_SESSION['usuarioGJLDWESAplicacionFinal'] = $oUsuario;

    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

$fotoUsuario = 'webroot/media/images/fotoUsuario.png';
if ($_SESSION['usuarioGJLDWESAplicacionFinal']->getImagenUsuario()!=null) {
    $fotoUsuario = 'data:image/png;base64,'.base64_encode($_SESSION['usuarioGJLDWESAplicacionFinal']->getImagenUsuario());
}

//Se crea un array con los datos del usuario para pasarlos a la vista
$avCuenta=[
    'codUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getCodUsuario(),
    'descUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getDescUsuario(),
    'numConexiones' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getNumAccesos(),
    'fechaHoraUltimaConexion' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getFechaHoraUltimaConexion()->format("d-m-Y H:i:s"),
    'fechaHoraUltimaConexionSaludo' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getFechaHoraUltimaConexion(),
    'fechaHoraUltimaConexionAnterior' => ($_SESSION['usuarioGJLDWESAplicacionFinal']->getFechaHoraUltimaConexionAnterior()? $_SESSION['usuarioGJLDWESAplicacionFinal']->getFechaHoraUltimaConexionAnterior()->format("d-m-Y H:i:s"):""),
    'perfil' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getPerfil(),
    'fotoUsuario' => $fotoUsuario
];

$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];