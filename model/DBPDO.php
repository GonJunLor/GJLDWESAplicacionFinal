<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 11/01/2026
*/

final class DBPDO{
    public static function ejecutarConsulta($sentenciaSQL, $parametros = null){
        try {
            // Conectamos a la base de datos
            $miDB = new PDO(DSN,USERNAME,PASSWORD);

            // Preparamos la consulta
            $consulta = $miDB->prepare($sentenciaSQL);

            // Ejecutamos la consulta
            $consulta->execute($parametros);
            
            // Devuelvemos el resultado de la consulta
            return $consulta;
            
        } catch (PDOException $miExceptionPDO) {
            // temporalmente ponemos estos errores para que se muestren en pantalla
            $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
            $_SESSION['paginaEnCurso'] = 'error';
            $_SESSION['error'] = new ErrorApp($miExceptionPDO->getCode(),$miExceptionPDO->getMessage(),$miExceptionPDO->getFile(),$miExceptionPDO->getLine());
            header('Location: indexLoginLogoff.php');
            exit;
        } finally {
            unset($miDB);
        } 

    } 
}
