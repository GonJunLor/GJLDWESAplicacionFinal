<?php
/**
 * Clase para ejecutar consultas sobre la base de datos
 * * Esta clase contiene métodos que se conectan a la base de datos y ejecutan las sentencias sql
 * con los paramámetros que se la pasan en la llamada.
 * 
 * @package App\Model
 * @author: Gonzalo Junquera Lorenzo
 * @since: 02/02/2026
 * @version 1.0.0
 */
final class DBPDO{

    /**
     * Ejecuta una consulta sql con los parámetros requeridos.
     * @param string $sentenciaSQL Instrucción SQL a ejecutar
     * @param array|null $parametros [Opcional] Parametros a pasarle a la instrucción SQL antes de ejecutarla.
     * @return PDOStatement Objeto con el resultado de la consulta, los registros afectados.
     * @throws PDOException Si ocurre un error inesperado durante la consulta.
     */ 
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

    /**
     * Ejecuta una consulta sql con los parámetros requeridos y con transacción.
     * * Este método sirve para consultas masivas donde todas las operaciones
     * deben tener éxito o ninguna se aplicará.
     * @param string $sentenciaSQL Instrucción SQL a ejecutar
     * @param array $parametros Array bidimensional donde cada elemento es un set de parámetros.
     * @return PDOStatement Objeto con el resultado de la consulta, los registros afectados.
     * @throws PDOException Si ocurre un error inesperado durante la consulta.
     * @throws miExceptionPDO Si no se ejecuta la transacción entera.
     */ 
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
