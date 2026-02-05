<?php
/**
 * Clase de acceso a datos (DAO) para la gestión de Usuarios.
 * * Esta clase final proporciona métodos estáticos para interactuar con la tabla
 * T01_Usuario, gestionando el login, registro y mantenimiento de usuarios.
 * * @package App\Model
 * @author Gonzalo Junquera Lorenzo
 * @since 31/01/2026
 * @version 1.1.0
 */
final class UsuarioPDO {

    /**
     * Valida las credenciales de un usuario y devuelve un objeto Usuario si son correctas
     * * Comprueba el código de usuario y la contraseña (aplicando SHA2).
     * * @param string $codUsuario Código del usuario
     * @param string $password Contraseña sin encriptar
     * @return Usuario|null Objeto Usuario si las credenciales son correctas, null si no
     */
    public static function validarUsuario($codUsuario, $password){
        $oUsuario = null;

        $sql = <<<SQL
            SELECT * FROM T01_Usuario
            WHERE T01_CodUsuario = :usuario
            AND T01_Password = SHA2(:contras,256)
        SQL;
        
        $parametros = [
            ':usuario' => $codUsuario,
            ':contras' => $codUsuario.$password
        ];

        $consulta = DBPDO::ejecutarConsulta($sql,$parametros);
        $usuarioBD = $consulta->fetchObject();

        // si encuentra el usuario en la BBDD creamos el objeto usuario
        if ($usuarioBD) {
            // Se convierte la fecha en datetime
            $fechaBD = $usuarioBD->T01_FechaHoraUltimaConexion;
            $oFechaValida = ($fechaBD) ? new DateTime($fechaBD) : null;

            $oUsuario = new Usuario(
                $usuarioBD->T01_CodUsuario,
                $usuarioBD->T01_Password,
                $usuarioBD->T01_DescUsuario,
                $usuarioBD->T01_NumConexiones,
                $oFechaValida,
                null,
                $usuarioBD->T01_Perfil,
                $usuarioBD->T01_ImagenUsuario
            );

        }

        return $oUsuario;
    }

    /**
     * Busca usuarios existente en la BBDD por la descripción.
     * @param string $descUsuario Descripción de los usuarios a buscar.
     * @return Usuario[] Array de objeto usuario encontrados en la BBDD. Vacío si no encuentra ninguno.
     */
    public static function buscaUsuariosPorDesc($descUsuario){

        $sql = <<<SQL
            SELECT * FROM T01_Usuario
            WHERE lower(T01_DescUsuario) like :descripcion
        SQL;
        
        $parametros = [
            ':descripcion' => '%'.$descUsuario.'%'
        ];

        $consulta = DBPDO::ejecutarConsulta($sql,$parametros);

        // si encuentra algo en la BBDD creamos el array con los departamentos
        $aUsuarios = [];
        while ($UsuariosBD = $consulta->fetchObject()) {
            $aUsuarios[] = new Usuario(
                $UsuariosBD->T01_CodUsuario,
                $UsuariosBD->T01_Password,
                $UsuariosBD->T01_DescUsuario,
                $UsuariosBD->T01_NumConexiones,
                $UsuariosBD->T01_FechaHoraUltimaConexion,
                null,
                $UsuariosBD->T01_Perfil,
                $UsuariosBD->T01_ImagenUsuario
            );
        }

        return $aUsuarios;
    }

    /**
     * Actualiza la fecha de última conexión y el contador de accesos
     * @param Usuario $oUsuario Objeto usuario a actualizar
     * @return Usuario El objeto actualizado con las nuevas fechas de conexión.
     */
    public static function registrarUltimaConexion($oUsuario){
        
        // SQL para actualizar los datos de conexión
        $sql = <<<SQL
            UPDATE T01_Usuario SET
                T01_FechaHoraUltimaConexion = NOW(),
                T01_NumConexiones = T01_NumConexiones + 1
            WHERE T01_CodUsuario = :usuario
        SQL;

        // Ejecutar la actualización en la BD
        DBPDO::ejecutarConsulta($sql, [
            ':usuario' => $oUsuario->getCodUsuario()
        ]);

        // Actualizar el objeto Usuario en memoria
        // La fecha actual que tenía ahora pasa a ser la anterior
        $oUsuario->setFechaHoraUltimaConexionAnterior($oUsuario->getFechaHoraUltimaConexion());

        // Incrementar el número de accesos
        $oUsuario->setNumAccesos($oUsuario->getNumAccesos() + 1);

        // Establecer la nueva fecha de conexión (ahora)
        $oUsuario->setFechaHoraUltimaConexion(new DateTime());

        return $oUsuario;
    }

    /**
     * Crea un nuevo usuario en la base de datos
     * @param string $codUsuario Código único.
     * @param string $password Contraseña plana.
     * @param string $descUsuario Nombre/Descripción.
     * @return Usuario|null El nuevo objeto Usuario o null si no se pudo crear.
     */
    public static function altaUsuario($codUsuario, $password, $descUsuario){
        $oUsuario = null;

        // SQL para insertar el nuevo registro
        // El perfil por defecto debe ser 'usuario'
        $sql = <<<SQL
            INSERT INTO T01_Usuario (T01_CodUsuario, T01_Password, T01_DescUsuario, T01_NumConexiones, T01_FechaHoraUltimaConexion, T01_Perfil) 
            VALUES (:usuario, SHA2(:password, 256), :descripcion, 1, NOW(), 'usuario')
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':usuario' => $codUsuario,
            ':password' => $codUsuario . $password,
            ':descripcion' => $descUsuario
        ]);

        if ($consulta) {
            // Si la inserción tiene éxito, se valida al usuario para obtener el objeto completo
            $oUsuario = self::validarUsuario($codUsuario, $password);
        }

        return $oUsuario;
    }

    /**
     * Cambia la contraseña de un usuario existente
     * @param Usuario $oUsuario Objeto del usuario actual
     * @param string $nuevaPassword Nueva contraseña sin encriptar
     * @return Usuario|null El objeto usuario actualizado o null si falla
     */
    public static function cambiarPassword($oUsuario, $nuevaPassword){
        $sql = <<<SQL
            UPDATE T01_Usuario SET 
                T01_Password = SHA2(:password, 256)
            WHERE T01_CodUsuario = :usuario
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':usuario' => $oUsuario->getCodUsuario(),
            ':password' => $oUsuario->getCodUsuario() . $nuevaPassword
        ]);

        if ($consulta) {
            // Se actualiza la contraseña en el objeto existente para que coincida con la BD
            $oUsuario->setPassword(hash('sha256', $oUsuario->getCodUsuario() . $nuevaPassword));
            return $oUsuario;
        }

        return null;
    }

    /**
     * Cambia datos de un usuario existente
     * @param Usuario $oUsuario Objeto del usuario actual
     * @param string $nuevoDescUsuario Nuevo nombre y apellidos
     * @param string $nuevoPerfil Nuevo perfil
     * @return Usuario|null El objeto usuario actualizado o null si falla
     */
    public static function modificarUsuario($oUsuario, $nuevoDescUsuario, $nuevoPerfil, $contenidoImagen=null){
        $sql = <<<SQL
            UPDATE T01_Usuario SET 
                T01_DescUsuario = :nuevoDescUsuario,
                T01_Perfil = :nuevoPerfil,
                T01_ImagenUsuario = :imagenUsuario
            WHERE T01_CodUsuario = :codUsuarioAntiguo
        SQL;

        /* Inyección SQL (Seguridad): Nunca debes insertar variables directamente en la cadena $sql (como $nuevoCodUsuario). 
        Un usuario malintencionado podría enviar código SQL en lugar de un nombre. 
        Usar :parametro hace que PDO limpie los datos automáticamente. */
        $parametros = [
            ':nuevoDescUsuario' => $nuevoDescUsuario,
            ':nuevoPerfil' => $nuevoPerfil,
            ':imagenUsuario' => $contenidoImagen,
            ':codUsuarioAntiguo' => $oUsuario->getCodUsuario()
        ];
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);

        if ($consulta) {
            $oUsuario->setDescUsuario($nuevoDescUsuario);
            $oUsuario->setPerfil($nuevoPerfil);
            $oUsuario->setImagenUsuario($contenidoImagen);
            return $oUsuario;
        }

        return null;
    }

    /**
     * Elimina un usuario de la base de datos
     * @param Usuario $oUsuario Objeto del usuario a eliminar
     * @return boolean True si se borró correctamente, false si no se borró
     */
    public static function borrarUsuario($oUsuario){
        $sql = 'DELETE FROM T01_Usuario WHERE T01_CodUsuario = "'.$oUsuario->getCodUsuario().'"';

        return DBPDO::ejecutarConsulta($sql)->rowCount() > 0;
    }

    /**
     * Comprueba si un código de usuario ya existe en la BD
     * @param string $codUsuario
     * @return boolean true si existe, false si no
     */
    public static function validarCodNoExiste($codUsuario){
        $sql = "SELECT T01_CodUsuario FROM T01_Usuario WHERE T01_CodUsuario = '$codUsuario'";

        return DBPDO::ejecutarConsulta($sql)->rowCount() > 0;
    }
}
