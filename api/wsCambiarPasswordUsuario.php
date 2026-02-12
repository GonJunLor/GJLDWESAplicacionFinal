<?php
/**
 * Servicio Web: Cambia la contraseña de un usuario identificado por su código.
 * * Esta API permite cambiar la contraseña de un usuario en la base de datos de usuarios cuyo codigo coincida con el parámetro pasado. 
 * Requiere autenticación mediante una API KEY válida.
 * * @url http://gonzalojunlor.ieslossauces.es/GJLDWESAplicacionFinal/api/wsCambiarPasswordUsuario.php
 * @method GET|POST
 * * @param string api_key Clave de acceso obligatoria.
 * @param string codUsuario Código del usuario a modificar contraseña.
 * @param string contrasenaNueva Contraseña nueva que quiere guardar.
 * @param string repiteContrasena Repetición de contraseña nueva que quiere guardar.
 * * @return json Devuelve un array con información de si ha tenido éxito en formato JSON. 
 * Si hay error de validación devuelve mensajes de error y si faltan permisos devuelve un array vacío [].
 * * @example URL: .../wsCambiarPasswordUsuario.php?api_key=TU_CLAVE&codUsuario=pas&contrasenaNueva=XXX&repiteContrasena=XXX
 * * @author Gonzalo Junquera Lorenzo
 * @since 12/02/2026
 * @version 1.0
 */

// Cabecera necesaria para poder usar la api al subirla al explotación.
// sin esto el navegador no es capaz de leer el json por politicas CORS
// https://developer.mozilla.org/es/docs/Web/HTTP/Reference/Headers/Access-Control-Allow-Origin
header("Access-Control-Allow-Origin: *");

require_once 'confApi.php';

if (isset($_REQUEST['api_key']) && in_array($_REQUEST['api_key'],API_KEYS_NUESTRAS)) {
    require_once '../core/231018libreriaValidacion.php';
    require_once '../conf/confDBPDO.php';

    //Cargamos la definición de la clase
    require_once '../model/Usuario.php'; 
    require_once '../model/UsuarioPDO.php';
    require_once '../model/DBPDO.php';

    $entradaOK = true; //Variable que nos indica que todo va bien
    $aErrores = [  //Array donde recogemos los mensajes de error
        'codUsuario' =>'',
        'contrasenaNueva'=>'',
        'repiteContrasena'=>''
    ];
    $aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
        'contrasenaNueva'=>'',
        'repiteContrasena'=>''
    ]; 

    //Para cada campo del formulario: Validar entrada y actuar en consecuencia
    if (isset($_REQUEST["codUsuario"])) {
        
        $aErrores['contrasenaNueva'] = validacionFormularios::validarPassword($_REQUEST['contrasenaNueva'],20,4,2,1);
        $aErrores['repiteContrasena'] = validacionFormularios::validarPassword($_REQUEST['repiteContrasena'],20,4,2,1); 
 
        foreach($aErrores as $campo => $valor){
            if(!empty($valor)){ // Comprobar si el valor es válido
                $entradaOK = false;
            } 
        }

        if ($entradaOK) {
            if (!UsuarioPDO::validarCodNoExiste($_REQUEST["codUsuario"])) {
                $aErrores['codUsuario'] = "Usuario no existe";
                $entradaOK = false;
            }
        }

        if ($entradaOK) {
            if ($_REQUEST['contrasenaNueva']!=$_REQUEST['repiteContrasena']){
                $aErrores['repiteContrasena'] = 'Las contraseñas no son iguales';
                $entradaOK = false;
            }
        }
        
    } else {//Código que se ejecuta antes de rellenar el formulario
        $entradaOK = false;
    }

    // Si la validación de datos es correcta procedemos a cambiar la contraseña en la BBDD
    if ($entradaOK) {
        // modificamos la contraseña en la BBDD 
        UsuarioPDO::cambiarPassword($_REQUEST['codUsuario'], $_REQUEST['contrasenaNueva']);
    }

    $aArchivoExportar = [
        'estadoCambioPassword' => $entradaOK,
        'ErrorCodUsuario' =>  $aErrores['codUsuario'],
        'ErrorContrasenaNueva' =>  $aErrores['contrasenaNueva'],
        'ErrorRepiteContrasena' => $aErrores['repiteContrasena'],
        'mensaje' => $_REQUEST['contrasenaNueva'].' - '.$_REQUEST['repiteContrasena']
    ];

    // con esto hacemos que al ver solo la url de la api el json tenga un formato ordenado
    header('Content-Type: application/json; charset=utf-8');
    // Convertimos a JSON con un formato limpio
    echo json_encode($aArchivoExportar,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([],JSON_PRETTY_PRINT);
}