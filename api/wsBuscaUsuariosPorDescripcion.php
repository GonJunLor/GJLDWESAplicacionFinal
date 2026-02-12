<?php
/**
 * Servicio Web: Búsqueda de Usuarios por Descripción.
 * * Esta API permite consultar la base de datos para obtener información de usuarios 
 * cuya descripción coincida con el criterio de búsqueda proporcionado. Requiere 
 * autenticación mediante una API KEY válida.
 * * @url http://gonzalojunlor.ieslossauces.es/GJLDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php
 * @method GET|POST
 * * @param string api_key Clave de acceso obligatoria.
 * @param string descUsuario Cadena de búsqueda alfabética (máx. 255 caracteres).
 * * @return json Devuelve un array de objetos usuario en formato JSON. 
 * Si hay error de validación o falta de permisos, devuelve un array vacío [].
 * * @example URL: .../wsBuscaUsuariosPorDescripcion.php?api_key=TU_CLAVE&descUsuario=pas
 * * @author Gonzalo Junquera Lorenzo
 * @since 07/02/2026
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

    // comprobamos que exista el campo descUsuario en la llamada y además validamos con nuestra librería que el codigo es correcto
    if (isset($_REQUEST['descUsuario']) && empty(validacionFormularios::comprobarAlfabetico($_REQUEST['descUsuario'],255,0,0))) {
        // recuperamos de la BBDD lo que ha buscado el usuario
        $aoUsuarios = UsuarioPDO::buscaUsuariosPorDesc($_REQUEST['descUsuario']??'');

        $aArchivoExportar=[];
        if (!is_null($aoUsuarios) && is_array($aoUsuarios)) {
            foreach ($aoUsuarios as $oUsuario) {

                $aArchivoExportar[] = [
                    'codUsuario'           => $oUsuario->getCodUsuario(),
                    // 'password'          => $oUsuario->getPassword(),
                    'descUsuario' => $oUsuario->getDescUsuario(),
                    'numAccesos'          => $oUsuario->getNumAccesos(),
                    'fechaHoraUltimaConexion'     => $oUsuario->getFechaHoraUltimaConexion(),
                    // 'fechaHoraUltimaConexionAnterior'     => $oUsuario->getFechaHoraUltimaConexionAnterior(),
                    'perfil'     => $oUsuario->getPerfil(),
                    // 'imagenUsuario'     => $oUsuario->getImagenUsuario()
                    // 'imagenUsuario' => 'Error al mostrar la imagen'
                ];
            }
        }

        // con esto hacemos que al ver solo la url de la api el json tenga un formato ordenado
        header('Content-Type: application/json; charset=utf-8');
        // Convertimos a JSON con un formato limpio
        echo json_encode($aArchivoExportar,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        
    } else {
        // si la descripción es incorrecta devuelvo array 
        echo json_encode([],JSON_PRETTY_PRINT);
    }

} else {
    // si la clave esta incorrecta devuelvo array vacio
    echo json_encode([],JSON_PRETTY_PRINT);
}

