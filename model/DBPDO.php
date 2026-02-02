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
            header('Location: index.php');
            exit;
        } finally {
            // Cerramos la conexión con la BBDD
            unset($miDB);
        } 
    } 

    public static function ejecutarConsultasTransaccion($sentenciaSQL, $aParametros){
        try {
            // Conectamos a la base de datos
            $miDB = new PDO(DSN,USERNAME,PASSWORD);

            // Abrimos la transacción
            $miDB->beginTransaction();

            // Preparamos la consulta
            $consulta = $miDB->prepare($sentenciaSQL);

            // Recorremos el array que trae cada conjunto de parametros a ejecutar
            foreach ($aParametros as $parametros) {
                // Ejecutamos la consulta
                $consulta -> execute($parametros);
            }
            
            // Validamos la transacción
            $miDB->commit();

            // Devuelvemos el resultado de la consulta
            return $consulta;

        } catch (PDOException $miExceptionPDO) {
            // Si alguna consulta ha ido mal anulamos toda la transacción
            $miDB->rollBack();
            // temporalmente ponemos estos errores para que se muestren en pantalla
            // $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
            // $_SESSION['paginaEnCurso'] = 'error';
            // $_SESSION['error'] = new ErrorApp($miExceptionPDO->getCode(),$miExceptionPDO->getMessage(),$miExceptionPDO->getFile(),$miExceptionPDO->getLine());
            // header('Location: index.php');
            // exit;
            throw $miExceptionPDO;
        } finally {
            // Cerramos la conexión con la BBDD
            unset($miDB);
        }
    } 
}
