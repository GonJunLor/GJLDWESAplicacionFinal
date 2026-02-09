<?php
/**
 * Servicio Web: Eliminar Usuarios por Descripción.
 * * Este endpoint permite eliminar de la base de datos un usuario cuyo codigo coincida con el parámetro pasado. 
 * Requiere autenticación mediante una API KEY válida.
 * * @url http://gonzalojunlor.ieslossauces.es/GJLDWESAplicacionFinal/api/wsEliminaUsuarioPorCodUsuario.php
 * @method GET|POST
 * * @param string api_key Clave de acceso obligatoria.
 * @param string codUsuario Código del usuario a eliminar.
 * * @return json Devuelve un array con true en formato JSON, o false si no lo elimina. 
 * Si hay error de validación o falta de permisos, devuelve un array vacío [].
 * * @example URL: .../wsEliminaUsuarioPorCodUsuario.php?api_key=TU_CLAVE&codUsuario=pas
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

    if (isset($_REQUEST['codUsuario']) && empty(validacionFormularios::comprobarAlfabetico($_REQUEST['codUsuario'],100,4,0))) {
        
        // recuperamos de la BBDD lo que ha buscado el usuario
        if (UsuarioPDO::validarCodNoExiste($_REQUEST['codUsuario'])) {
            // Si elimina al usuario devolvemos un json con true, sino false
            echo json_encode(['estadoEliminarUsuario'=>UsuarioPDO::borrarUsuario(new Usuario($_REQUEST['codUsuario']))],JSON_PRETTY_PRINT);
        } else {
            echo json_encode(['estadoEliminarUsuario'=>'codigo no existe'],JSON_PRETTY_PRINT);
        }

    } else {
        echo json_encode([],JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode([],JSON_PRETTY_PRINT);
}