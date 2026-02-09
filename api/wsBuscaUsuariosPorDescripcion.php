<?php
/**
 * Servicio Web: Búsqueda de Usuarios por Descripción.
 * * Este endpoint permite consultar la base de datos para obtener información de usuarios 
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
require_once 'confApi.php';

if (isset($_REQUEST['api_key']) && in_array($_REQUEST['api_key'],API_KEYS_NUESTRAS)) {
    require_once '../core/231018libreriaValidacion.php';
    require_once '../conf/confDBPDO.php';
    
    //Cargamos la definición de la clase
    require_once '../model/Usuario.php'; 
    require_once '../model/UsuarioPDO.php';
    require_once '../model/DBPDO.php';

    if (isset($_REQUEST['descUsuario']) && empty(validacionFormularios::comprobarAlfabetico($_REQUEST['descUsuario'],255,0,0))) {
        // recuperamos de la BBDD lo que ha buscado el usuario
        $aUsuariosExportar = UsuarioPDO::buscaUsuariosPorDesc($_REQUEST['descUsuario']??'');

        $aArchivoExportar=[];
        if (!is_null($aUsuariosExportar) && is_array($aUsuariosExportar)) {
            foreach ($aUsuariosExportar as $oUsuarioExportar) {

                $aArchivoExportar[] = [
                    'codUsuario'           => $oUsuarioExportar->getCodUsuario(),
                    // 'password'          => $oUsuarioExportar->getPassword(),
                    'descUsuario' => $oUsuarioExportar->getDescUsuario(),
                    'numAccesos'          => $oUsuarioExportar->getNumAccesos(),
                    'fechaHoraUltimaConexion'     => $oUsuarioExportar->getFechaHoraUltimaConexion(),
                    // 'fechaHoraUltimaConexionAnterior'     => $oUsuarioExportar->getFechaHoraUltimaConexionAnterior(),
                    'perfil'     => $oUsuarioExportar->getPerfil(),
                    // 'imagenUsuario'     => $oUsuarioExportar->getImagenUsuario()
                    // 'imagenUsuario' => 'Error al mostrar la imagen'
                ];
            }
        }

        // Convertimos a JSON con un formato limpio
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($aArchivoExportar,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        
    } else {
        echo json_encode([],JSON_PRETTY_PRINT);
    }

} else {
    echo json_encode([],JSON_PRETTY_PRINT);
}

