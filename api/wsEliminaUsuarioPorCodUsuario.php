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

    if (isset($_REQUEST['codUsuario']) && empty(validacionFormularios::comprobarAlfabetico($_REQUEST['codUsuario'],100,4,0))) {
        
        // recuperamos de la BBDD lo que ha buscado el usuario
        if (UsuarioPDO::validarCodNoExiste($_REQUEST['codUsuario'])) {
            // Si elimina al usuario devolvemos un json con true, sino false
            echo json_encode(['estadoEliminarUsuario'=>UsuarioPDO::borrarUsuario(new Usuario($_REQUEST['codUsuario']))],JSON_PRETTY_PRINT);
        } else {
            echo json_encode(['estadoEliminarUsuario'=>'codigo no existe'],JSON_PRETTY_PRINT);
        }

        /* http://daw205.local.ieslossauces.es/GJLDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php?descUsuario=vero */
        /* http://192.168.1.205/GJLDWESAplicacionFinal/api/wsEliminaUsuarioPorCodUsuario.php?codUsuario= */
    } else {
        echo json_encode([],JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode([],JSON_PRETTY_PRINT);
}