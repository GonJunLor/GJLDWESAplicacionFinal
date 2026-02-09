<?php
/**
 * Servicio Web: Consulta el volumen de negocio de un departamento por su código.
 * * Este endpoint permite obtener el volumen de negocio de la base de datos de un departamento cuyo codigo coincida con el parámetro pasado. 
 * Requiere autenticación mediante una API KEY válida.
 * * @url http://gonzalojunlor.ieslossauces.es/GJLDWESAplicacionFinal/api/wsConsultarVolumenDeNegocio.php
 * @method GET|POST
 * * @param string api_key Clave de acceso obligatoria.
 * @param string codUsuario Código del departamento a consultar.
 * * @return json Devuelve un array con el volumen de negocio en formato JSON. 
 * Si hay error de validación o falta de permisos, devuelve un array vacío [].
 * * @example URL: .../wsConsultarVolumenDeNegocio.php?api_key=TU_CLAVE&codDepartamento=pas
 * * @author Gonzalo Junquera Lorenzo
 * @since 07/02/2026
 * @version 1.0
 */
require_once 'confApi.php';

if (isset($_REQUEST['api_key']) && in_array($_REQUEST['api_key'],API_KEYS_NUESTRAS)) {
    require_once '../core/231018libreriaValidacion.php';
    require_once '../conf/confDBPDO.php';

    //Cargamos la definición de la clase
    require_once '../model/Departamento.php'; 
    require_once '../model/DepartamentoPDO.php';
    require_once '../model/DBPDO.php';

    if (isset($_REQUEST['codDepartamento']) && empty(validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'],3,3,1))) {

        // buscamos el departamento y si esta en la bbdd devolvemos json con su volumen de negocio
        $oDepartamento = DepartamentoPDO::buscaDepartamentoPorCod($_REQUEST['codDepartamento']);
        if (!is_null($oDepartamento)) {
            echo json_encode(['volumenDeNegocio'=>$oDepartamento->getVolumenDeNegocio()],JSON_PRETTY_PRINT);
        } else {
            echo json_encode([],JSON_PRETTY_PRINT);
        } 
    } else {
        echo json_encode([],JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode([],JSON_PRETTY_PRINT);
}