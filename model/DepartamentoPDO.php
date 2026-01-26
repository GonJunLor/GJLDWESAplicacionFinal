<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 23/01/2026
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

}
