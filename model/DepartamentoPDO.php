<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 28/01/2026
*/

final class DepartamentoPDO {

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

    
}
