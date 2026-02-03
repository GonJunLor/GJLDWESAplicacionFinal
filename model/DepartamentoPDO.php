<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 01/01/2026
*/

final class DepartamentoPDO {

    /**
     * Busca departamentos existente en la BBDD por la descripción.
     * @param String $descDepartamento Descripción de los departamentos a buscar.
     * @return array Array de objeto departamento encontrados en la BBDD. Vacío si no encuentra ninguno.
     */
    public static function buscaDepartamentosPorDesc($descDepartamento){

        $sql = <<<SQL
            SELECT * FROM T02_Departamento
            WHERE lower(T02_DescDepartamento) like :departamento
        SQL;
        
        $parametros = [
            ':departamento' => '%'.$descDepartamento.'%'
        ];

        $consulta = DBPDO::ejecutarConsulta($sql,$parametros);

        // si encuentra algo en la BBDD creamos el array con los departamentos
        $aDepartamentos = [];
        while ($DepartamentoBD = $consulta->fetchObject()) {
            $aDepartamentos[] = new Departamento(
                $DepartamentoBD->T02_CodDepartamento,
                $DepartamentoBD->T02_DescDepartamento,
                $DepartamentoBD->T02_FechaCreacionDepartamento,
                $DepartamentoBD->T02_VolumenDeNegocio,
                $DepartamentoBD->T02_FechaBajaDepartamento
            );
        }

        return $aDepartamentos;
        // return $consulta;
    }

    /**
     * Busca un departamento existente en la BBDD por codDepartamento.
     * @param String $codDepartamento Codigo departamento a buscar
     * @return Departamento|null Objeto departamento encontrado en la BBDD. Null si no lo ha encontrado.
     */
    public static function buscaDepartamentoPorCod($codDepartamento){
        $sql = <<<SQL
            SELECT * FROM T02_Departamento
            WHERE lower(T02_CodDepartamento) like :departamento
        SQL;
        
        $parametros = [
            ':departamento' => $codDepartamento
        ];

        $consulta = DBPDO::ejecutarConsulta($sql,$parametros);

        // si encuentra algo en la BBDD creamos el objeto departamento
        $oDepartamento = null;
        if ($DepartamentoBD = $consulta->fetchObject()) {
            $oDepartamento = new Departamento(
                $DepartamentoBD->T02_CodDepartamento,
                $DepartamentoBD->T02_DescDepartamento,
                $DepartamentoBD->T02_FechaCreacionDepartamento,
                $DepartamentoBD->T02_VolumenDeNegocio,
                $DepartamentoBD->T02_FechaBajaDepartamento
            );
        }

        return $oDepartamento;
    }

    /**
     * Modifica un departamento existente en la BBDD.
     * @param Departamento $oDepartamento Objeto del departamento a modificar
     * @param String $nuevoDescDepartamento Descripción departamento a modificar
     * @param Float $nuevoVolumenDeNegocio Volumen de negocio del departamento a modificar
     * @return Departamento|null Objeto departamento modificado en la BBDD. Null si no lo ha modificado correctamente.
     */
    public static function modificaDepartamento($oDepartamento, $nuevoDescDepartamento, $nuevoVolumenDeNegocio){
        $sql = <<<SQL
            UPDATE T02_Departamento SET 
                T02_DescDepartamento = :nuevoDescDepartamento,
                T02_VolumenDeNegocio = :nuevoVolumenDeNegocio
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;

        $parametros = [
            ':nuevoDescDepartamento' => $nuevoDescDepartamento,
            ':nuevoVolumenDeNegocio' => $nuevoVolumenDeNegocio,
            ':codDepartamento' => $oDepartamento->getCodDepartamento()
        ];
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);

        if ($consulta) {
            $oDepartamento->setDescDepartamento($nuevoDescDepartamento);
            $oDepartamento->setVolumenDeNegocio($nuevoVolumenDeNegocio);
            return $oDepartamento;
        }

        return null;
    }

    /**
     * Elimina un departamento de la base de datos
     * @param String $codDepartamento Código del departamento a eliminar
     * @return boolean True si se borró correctamente, false si no se borró
     */
    public static function bajaFisicaDepartamento($codDepartamento){
        $sql = 'DELETE FROM T02_Departamento WHERE T02_CodDepartamento = "'.$codDepartamento.'"';

        return DBPDO::ejecutarConsulta($sql)->rowCount() > 0;
    }
    
    /**
     * Deshabilita un departamento poniendo la fecha de baja actual.
     * @param String $codDepartamento Código del departamento a deshabilitar
     * @return boolean True si lo deshabilitó correctamente y False en caso contrario.
     */
    public static function bajaLogicaDepartamento($codDepartamento){
        $sql = <<<SQL
            UPDATE T02_Departamento SET 
                T02_FechaBajaDepartamento = now()
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;

        $parametros = [
            ':codDepartamento' => $codDepartamento
        ];
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);

        if ($consulta) {
            return true;
        }
        return false;
    }

    /**
     * Habilita un departamento poniendo la fecha de baja a null
     * @param String $codDepartamento Código del departamento a habilitar
     * @return boolean True si lo habilitó correctamente y False si no lo habilitó.
     */
    public static function rehabilitaDepartamento($codDepartamento){
        $sql = <<<SQL
            UPDATE T02_Departamento SET 
                T02_FechaBajaDepartamento = null
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;

        $parametros = [
            ':codDepartamento' => $codDepartamento
        ];
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);

        if ($consulta) {
            return true;
        }
        return false;
    }

    /**
     * Inserta un departamento nuevo en la BBDD.
     * @param String $codDepartamento Código del departamento a insertar
     * @param String $descDepartamento Descripción departamento a insertar
     * @param Float $volumenDeNegocio Volumen de negocio del departamento a insertar
     * @return Departamento|null Objeto con el nuevo departamento de la BBDD. Null si no lo ha insertado correctamente.
     */
    public static function altaDepartamento($codDepartamento, $descDepartamento, $volumenDeNegocio){
        $oDepartamento = null;

        // SQL para insertar el nuevo registro
        $sql = <<<SQL
            INSERT INTO T02_Departamento
            VALUES (:codDepartamento, :descDepartamento, now(), :volumenDeNegocio, null)
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':codDepartamento' => $codDepartamento,
            ':descDepartamento' => $descDepartamento,
            ':volumenDeNegocio' => $volumenDeNegocio
        ]);

        if ($consulta) {
            // Si la inserción tiene éxito, se valida al usuario para obtener el objeto completo
            $oDepartamento = self::buscaDepartamentoPorCod($codDepartamento);
        }

        return $oDepartamento;
    }

    /**
     * Comprueba si existe un departamento con el código indicado en la BBDD.
     * @param $codDepartamento Código del departamento a buscar
     * @return boolean True si encontró un departamento en la BBDD y False si no lo encontró.
     */
    public static function validaCodNoExiste($codDepartamento){
        $sql = "SELECT T02_CodDepartamento FROM T02_Departamento WHERE T02_CodDepartamento = '$codDepartamento'";

        return DBPDO::ejecutarConsulta($sql)->rowCount() > 0;
    }

    /**
     * Inserta en la BBDD un conjunto de departamentos a partir de un array.
     * @param $aDepartamentos Array con los departamentos.
     * @return boolean True si insertó todos los departamentos en la BBDD y False si no insertó ningun por fallar aunque sea uno sólo.
     */
    public static function insertarDepartamentos($aDepartamentos){

        $sql = <<<SQL
            INSERT INTO T02_Departamento (
                T02_CodDepartamento, 
                T02_DescDepartamento, 
                T02_FechaCreacionDepartamento, 
                T02_VolumenDeNegocio, 
                T02_FechaBajaDepartamento
            ) VALUES (
                :codDepartamento, 
                :descDepartamento, 
                :fechaCreacionDepartamento, 
                :volumenDeNegocio, 
                :fechaBajaDepartamento
            )
        SQL;

        $aParametros = [];
        // construyo el array de parametros pasando los datos a objetos que pide la BBDD
        foreach ($aDepartamentos as $departamento) {
            // La bbdd necesita pasarle un objeto fecha, lo creamos y lo formateamos correctamente para la bbdd
            $oFechaCreacion = new DateTime($departamento['fechaCreacionDepartamento']);
            $oFechaCreacion = $oFechaCreacion->format('Y-m-d H:i:s');

            // Si no hay fecha devolvemos null para la base de datos
            if ($departamento['fechaBajaDepartamento'] === null) {
                $ofechaBaja = null;

            // Si existe fecha la creamos y la formateamos antes de pasarla a la BBDD
            } else {
                $ofechaBaja = new DateTime($departamento['fechaBajaDepartamento']);
                $ofechaBaja = $ofechaBaja->format('Y-m-d H:i:s');
            }

            $aParametros[] = [
                ":codDepartamento"=>$departamento['codDepartamento'],
                ":descDepartamento"=>$departamento['descDepartamento'],
                ":fechaCreacionDepartamento"=>$oFechaCreacion,
                ":volumenDeNegocio"=>$departamento['volumenDeNegocio'],
                ":fechaBajaDepartamento"=>$ofechaBaja
            ];
        }

        try {
            DBPDO::ejecutarConsultasTransaccion($sql,$aParametros);
            return true;
        } catch (PDOException $miExceptionPDO) {
            if ($miExceptionPDO->getCode() == 23000 || str_contains($miExceptionPDO->getMessage(), 'Duplicate entry')) {
                // Lanzamos una excepción propia o manejamos el mensaje
                // throw new Exception("Error: Ya existe un departamento con ese código en la base de datos.");
                return false;
            } 
        }
        return false;
    }

    /**
     * Busca departamentos existente en la BBDD por la descripción y el estado de alta o baja.
     * @param String $descDepartamento Descripción de los departamentos a buscar.
     * @param String $estadoDepartamento Estado de alta, baja de los departamentos a buscar.
     * @return array Array de objeto departamento encontrados en la BBDD. Vacío si no encuentra ninguno.
     */
    public static function buscaDepartamentosPorDescEstado($descDepartamento, $estadoDepartamento){

        // Definimos la condición de fecha según el estado
        $condicionFecha = ($estadoDepartamento == 'alta') ? "IS NULL" : "IS NOT NULL";

        $sql = <<<SQL
            SELECT * FROM T02_Departamento
            WHERE lower(T02_DescDepartamento) LIKE lower(:departamento)
            AND T02_FechaBajaDepartamento $condicionFecha
        SQL;
            
        $parametros = [
            ':departamento' => '%'.$descDepartamento.'%'
        ];

        $consulta = DBPDO::ejecutarConsulta($sql,$parametros);

        // si encuentra algo en la BBDD creamos el array con los departamentos
        $aDepartamentos = [];
        while ($DepartamentoBD = $consulta->fetchObject()) {
            $aDepartamentos[] = new Departamento(
                $DepartamentoBD->T02_CodDepartamento,
                $DepartamentoBD->T02_DescDepartamento,
                $DepartamentoBD->T02_FechaCreacionDepartamento,
                $DepartamentoBD->T02_VolumenDeNegocio,
                $DepartamentoBD->T02_FechaBajaDepartamento
            );
        }

        return $aDepartamentos;
        // return $consulta;
    }
}
