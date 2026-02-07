<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 07/02/2026
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

        /* http://daw205.local.ieslossauces.es/GJLDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php?descUsuario=vero */
    } else {
        echo json_encode([],JSON_PRETTY_PRINT);
    }

} else {
    echo json_encode([],JSON_PRETTY_PRINT);
}

