<?php
/**
 * Clase para el acceso a datos de los departamentos mediante PDO.
 * * Esta clase contiene todos los métodos necesarios para realizar operaciones
 * CRUD y de gestión de estados sobre la tabla T02_Departamento.
 *
 * @package App\Model
 * @author Gonzalo Junquera Lorenzo
 * @since 04/02/2026
 * @version 1.0.0
 */
final class DepartamentoPDO {

    /**
     * Busca departamentos existente en la BBDD por la descripción.
     * @param string $descDepartamento Descripción de los departamentos a buscar.
     * @return Departamento[] Array de objeto departamento encontrados en la BBDD. Vacío si no encuentra ninguno.
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
     * @param string $codDepartamento Codigo departamento a buscar
     * @return Departamento|null Objeto departamento encontrado en la BBDD. Null si no lo ha encontrado.
     */
    public static function buscaDepartamentoPorCod($codDepartamento){
        DBPDO::insertarTrazabilidad('buscaDepartamentoPorCod','T02_Departamento','T02_CodDepartamento: '.$codDepartamento);

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
     * @param string $nuevoDescDepartamento Descripción departamento a modificar
     * @param float $nuevoVolumenDeNegocio Volumen de negocio del departamento a modificar
     * @return Departamento|null Objeto departamento modificado en la BBDD. Null si no lo ha modificado correctamente.
     */
    public static function modificaDepartamento($oDepartamento, $nuevoDescDepartamento, $nuevoVolumenDeNegocio){
        DBPDO::insertarTrazabilidad('modificaDepartamento','T02_Departamento',
            'T02_CodDepartamento: '.$oDepartamento->getCodDepartamento());

        $sql = <<<SQL
            UPDATE T02_Departamento SET 
                T02_DescDepartamento = :nuevoDescDepartamento,
                T02_VolumenDeNegocio = :nuevoVolumenDeNegocio,
                T02_Usuario = :codUsuario,
                T02_Timestamp = now()
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;

        $parametros = [
            ':nuevoDescDepartamento' => $nuevoDescDepartamento,
            ':nuevoVolumenDeNegocio' => $nuevoVolumenDeNegocio,
            ':codUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getCodUsuario(),
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
     * @param string $codDepartamento Código del departamento a eliminar
     * @return boolean True si se borró correctamente, false si no se borró
     */
    public static function bajaFisicaDepartamento($codDepartamento){
        DBPDO::insertarTrazabilidad('bajaFisicaDepartamento','T02_Departamento','T02_CodDepartamento: '.$codDepartamento);

        $sql = 'DELETE FROM T02_Departamento WHERE T02_CodDepartamento = "'.$codDepartamento.'"';

        return DBPDO::ejecutarConsulta($sql)->rowCount() > 0;
    }
    
    /**
     * Deshabilita un departamento poniendo la fecha de baja actual.
     * @param string $codDepartamento Código del departamento a deshabilitar
     * @return boolean True si lo deshabilitó correctamente y False en caso contrario.
     */
    public static function bajaLogicaDepartamento($codDepartamento){
        DBPDO::insertarTrazabilidad('bajaLogicaDepartamento','T02_Departamento','T02_CodDepartamento: '.$codDepartamento);

        $sql = <<<SQL
            UPDATE T02_Departamento SET 
                T02_FechaBajaDepartamento = now(),
                T02_Usuario = :codUsuario,
                T02_Timestamp = now()
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;

        $parametros = [
            ':codUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getCodUsuario(),
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
     * @param string $codDepartamento Código del departamento a habilitar
     * @return boolean True si lo habilitó correctamente y False si no lo habilitó.
     */
    public static function rehabilitaDepartamento($codDepartamento){
        DBPDO::insertarTrazabilidad('rehabilitaDepartamento','T02_Departamento','T02_CodDepartamento: '.$codDepartamento);

        $sql = <<<SQL
            UPDATE T02_Departamento SET 
                T02_FechaBajaDepartamento = null,
                T02_Usuario = :codUsuario,
                T02_Timestamp = now()
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;

        $parametros = [
            ':codUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getCodUsuario(),
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
     * @param string $codDepartamento Código del departamento a insertar
     * @param string $descDepartamento Descripción departamento a insertar
     * @param float $volumenDeNegocio Volumen de negocio del departamento a insertar
     * @return Departamento|null Objeto con el nuevo departamento de la BBDD. Null si no lo ha insertado correctamente.
     */
    public static function altaDepartamento($codDepartamento, $descDepartamento, $volumenDeNegocio){
        DBPDO::insertarTrazabilidad('altaDepartamento','T02_Departamento','T02_CodDepartamento: '.$codDepartamento);

        $oDepartamento = null;

        // SQL para insertar el nuevo registro
        $sql = <<<SQL
            INSERT INTO T02_Departamento (
                T02_CodDepartamento, 
                T02_DescDepartamento, 
                T02_FechaCreacionDepartamento, 
                T02_VolumenDeNegocio, 
                T02_FechaBajaDepartamento,
                T02_Usuario,
                T02_Timestamp
            ) VALUES (
                :codDepartamento, 
                :descDepartamento, 
                now(), 
                :volumenDeNegocio, 
                null,
                :codUsuario,
                now()
            )
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':codDepartamento' => $codDepartamento,
            ':descDepartamento' => $descDepartamento,
            ':volumenDeNegocio' => $volumenDeNegocio,
            ':codUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getCodUsuario()
        ]);

        if ($consulta) {
            // Si la inserción tiene éxito, se valida al usuario para obtener el objeto completo
            $oDepartamento = self::buscaDepartamentoPorCod($codDepartamento);
        }

        return $oDepartamento;
    }

    /**
     * Comprueba si existe un departamento con el código indicado en la BBDD.
     * @param string $codDepartamento Código del departamento a buscar
     * @return boolean True si encontró un departamento en la BBDD y False si no lo encontró.
     */
    public static function validaCodNoExiste($codDepartamento){
        $sql = "SELECT T02_CodDepartamento FROM T02_Departamento WHERE T02_CodDepartamento = '$codDepartamento'";

        return DBPDO::ejecutarConsulta($sql)->rowCount() > 0;
    }

    /**
     * Inserta en la BBDD un conjunto de departamentos a partir de un array.
     * @param array $aDepartamentos Array con los departamentos.
     * @return boolean True si insertó todos los departamentos en la BBDD y False si no insertó ningun por fallar aunque sea uno sólo.
     * @throws Exception Si ocurre un error inesperado durante la transacción.
     * @see DBPDO::ejecutarConsultasTransaccion()
     */
    public static function insertarDepartamentos($aDepartamentos){
        DBPDO::insertarTrazabilidad('insertarDepartamentos','T02_Departamento',
            'Intento insertar '.count($aDepartamentos).' departamentos');

        $sql = <<<SQL
            INSERT INTO T02_Departamento (
                T02_CodDepartamento, 
                T02_DescDepartamento, 
                T02_FechaCreacionDepartamento, 
                T02_VolumenDeNegocio, 
                T02_FechaBajaDepartamento,
                T02_Usuario,
                T02_Timestamp
            ) VALUES (
                :codDepartamento, 
                :descDepartamento, 
                :fechaCreacionDepartamento, 
                :volumenDeNegocio, 
                :fechaBajaDepartamento,
                :codUsuario,
                now()
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
                ":fechaBajaDepartamento"=>$ofechaBaja,
                ':codUsuario' => $_SESSION['usuarioGJLDWESAplicacionFinal']->getCodUsuario()
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
     * @param string $descDepartamento Descripción de los departamentos a buscar.
     * @param string $estadoDepartamento Estado de alta, baja de los departamentos a buscar.
     * @return Departamento[] Array de objeto departamento encontrados en la BBDD. Vacío si no encuentra ninguno.
     */
    public static function buscaDepartamentosPorDescEstado($descDepartamento, $estadoDepartamento){
        DBPDO::insertarTrazabilidad('buscaDepartamentosPorDescEstado','T02_Departamento',
            'Descripcion: '.$descDepartamento.', estado: '.$estadoDepartamento
        );

        $aDepartamentos = [];
        if ($estadoDepartamento == 'radioTodos') {
            $aDepartamentos = self::buscaDepartamentosPorDesc($descDepartamento);
        } else {

            // Definimos la condición de fecha según el estado
            $condicionFecha = ($estadoDepartamento == 'radioAlta') ? "IS NULL" : "IS NOT NULL";

            $sql = <<<SQL
                SELECT * FROM T02_Departamento
                WHERE lower(T02_DescDepartamento) LIKE lower(:departamento)
                AND T02_FechaBajaDepartamento $condicionFecha
            SQL;
                
            $parametros = [
                ':departamento' => '%'.$descDepartamento.'%'
            ];

            $consulta = DBPDO::ejecutarConsulta($sql,$parametros);

            // si encuentra algo en la BBDD rellenamos el array con los departamentos
            while ($DepartamentoBD = $consulta->fetchObject()) {
                $aDepartamentos[] = new Departamento(
                    $DepartamentoBD->T02_CodDepartamento,
                    $DepartamentoBD->T02_DescDepartamento,
                    $DepartamentoBD->T02_FechaCreacionDepartamento,
                    $DepartamentoBD->T02_VolumenDeNegocio,
                    $DepartamentoBD->T02_FechaBajaDepartamento
                );
            }
        }

        return $aDepartamentos;
    }

    /**
     * Cuenta departamentos existente en la BBDD por la descripción y el estado de alta o baja.
     * @param string $descDepartamento Descripción de los departamentos a buscar.
     * @param string $estadoDepartamento Estado de alta, baja de los departamentos a buscar.
     * @return int Número total de registros encontrados.
     */
    public static function contarDepartamentosPorDescEstado($descDepartamento, $estadoDepartamento){

        if ($estadoDepartamento == 'radioTodos') {
            
            $sql = <<<SQL
                SELECT COUNT(*) numeroDepartamentos FROM T02_Departamento
                WHERE lower(T02_DescDepartamento) LIKE lower(:departamento)
            SQL;

        } else {
            // Definimos la condición de fecha según el estado
            $condicionFecha = ($estadoDepartamento == 'radioAlta') ? "IS NULL" : "IS NOT NULL";

            $sql = <<<SQL
                SELECT COUNT(*) numeroDepartamentos FROM T02_Departamento
                WHERE lower(T02_DescDepartamento) LIKE lower(:departamento)
                AND T02_FechaBajaDepartamento $condicionFecha
            SQL;      
        }

        $parametros = [
            ':departamento' => '%'.$descDepartamento.'%'
        ];

        $consulta = DBPDO::ejecutarConsulta($sql,$parametros);

        if ($contarDB = $consulta->fetchObject()) {
            return $contarDB->numeroDepartamentos;
        }

        return 0;
    }

    /**
     * Busca departamentos existente en la BBDD por la descripción, el estado de alta o baja y devuelve en función de la paginaActual.
     * * Realiza una consulta filtrada por descripción y estado, aplicando un límite y un desplazamiento
     * calculado en base a la página actual y la constante global RESULTADOSPORPAGINA.
     *
     * @param string $descDepartamento Descripción de los departamentos a buscar.
     * @param string $estadoDepartamento Estado de alta, baja de los departamentos a buscar.
     * @param int $paginaActual El número de la página que se desea visualizar.
     * @return Departamento[] Array de objeto departamento encontrados en la BBDD. Vacío si no encuentra ninguno.
     */
    public static function buscaDepartamentosPorDescEstadoPaginado($descDepartamento, $estadoDepartamento, $paginaActual){
        DBPDO::insertarTrazabilidad('buscaDepartamentosPorDescEstadoPaginado','T02_Departamento',
        'Descripcion: '.$descDepartamento.', estado: '.$estadoDepartamento.', en pagina: '.$paginaActual);

        // Calculamos los valores numéricos fuera porque si los paso por parámetro de error
        // tampoco puedo poner la constante en la instruccion sql actual
        $numResultados = (int) RESULTADOSPORPAGINA;
        $indicePagina = (int) (($paginaActual - 1) * $numResultados);

        if ($estadoDepartamento == 'radioTodos') {
            
            $sql = <<<SQL
                SELECT * FROM T02_Departamento
                WHERE lower(T02_DescDepartamento) LIKE lower(:departamento)
                LIMIT $numResultados OFFSET $indicePagina
            SQL;

        } else {
            // Definimos la condición de fecha según el estado
            $condicionFecha = ($estadoDepartamento == 'radioAlta') ? "IS NULL" : "IS NOT NULL";

            $sql = <<<SQL
                SELECT * FROM T02_Departamento
                WHERE lower(T02_DescDepartamento) LIKE lower(:departamento)
                AND T02_FechaBajaDepartamento $condicionFecha
                LIMIT $numResultados OFFSET $indicePagina
            SQL;      
        }
            
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
    }
}
