<?php
/**
 * Clase de acceso a APIs.
 * * Esta clase final proporciona métodos estáticos para conectarse y obtener 
 * información de la API de la NASA y servicios REST propios.
 * 
 * @package App\Model
 * @author Gonzalo Junquera Lorenzo
 * @since 07/02/2026
 * @version 1.1.0
 */
class REST {

    /**
     * Consulta la API de la NASA.
     * * Realiza una petición cURL para obtener los datos de la imagen del día.
     * Si la petición falla, devuelve un objeto FotoNasa con datos por defecto.
     *
     * @param string $fecha Fecha de la cual se desea obtener la imagen.
     * @return FotoNasa Objeto con la información de la fotografía.
     */
    public static function apiNasa($fecha) {
        $volumen = null;

        $url = "https://api.nasa.gov/planetary/apod?date=$fecha&api_key=" . API_KEY_NASA;

        // 1. Iniciamos cURL
        $ch = curl_init();

        // 2. Configuramos las opciones
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve el resultado como string
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);          // Timeout de 10 segundos
        
        // ESTO ES CLAVE PARA EL NAS:
        // Ignora la verificación de certificados si el NAS no tiene los bundles actualizados
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // 3. Ejecutamos la petición
        $resultado = curl_exec($ch);
        
        // 4. Control de errores de conexión
        if (curl_errno($ch)) {
            curl_close($ch);
            $volumen = null;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Si el código no es 200 (OK), algo ha ido mal (ej. fecha incorrecta o API KEY mal)
        if ($httpCode !== 200) {
            $volumen = null;
        }

        // 5. Procesamos el JSON
        $archivoApi = json_decode($resultado, true);

        if (isset($archivoApi) && !isset($archivoApi['error'])) {
            if (isset($archivoApi['date'], $archivoApi['explanation'], $archivoApi['title'], $archivoApi['url'])) {
                $hdurl = $archivoApi['hdurl'] ?? $archivoApi['url'];
                
                $imagenSerializada = self::serializarImagen($hdurl);

                $volumen = new FotoNasa(
                    $archivoApi['date'], 
                    $archivoApi['explanation'], 
                    $imagenSerializada, 
                    $archivoApi['title'], 
                    $imagenSerializada
                );
            }
        }

        // Si ha habido un error, devolvemos un objeto "falso" o fallback
        if ($volumen == null) {
            $volumen = new FotoNasa(
                '1990-04-24',
                '',
                'webroot/media/images/banderaEs.png',
                'No hay foto del dia',
                'webroot/media/images/banderaEs.png'
            );
        }
        return $volumen;
    }

    /**
     * Descarga una imagen y la convierte a formato Base64.
     * * Útil para incrustar imágenes directamente en el HTML sin depender de 
     * enlaces externos directos en el cliente.
     *
     * @param string $url Dirección URL de la imagen.
     * @return string Imagen codificada en Base64 con cabecera MIME (data:image/...;base64,...).
     */
    public static function serializarImagen($url) {
        // Obtenemos el contenido de la imagen
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $datosImagen = curl_exec($ch);
        $tipoMime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        // Convertimos a base64
        $base64 = base64_encode($datosImagen);
        
        // Retornamos el formato listo para el atributo 'src' de una <img>
        return "data:$tipoMime;base64,$base64";
    }

    /**
     * Consulta el volumen de negocio de un departamento a través de una API propia.
     *
     * @param string $codDepartamento Código identificador del departamento.
     * @return float|int El volumen de negocio obtenido o 0 en caso de error.
     */
    public static function apiPropia($codDepartamento){
        $volumen = 0;
        $url = "https://gonzalojunlor.ieslossauces.es/GJLDWESAplicacionFinal/api/wsConsultarVolumenDeNegocio.php?codDepartamento=$codDepartamento&api_key=" . API_KEY_PROPIA;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $resultado = curl_exec($ch);
        
        if (curl_errno($ch)) {
            // curl_close($ch);
            // return 0;
            echo 'Error de cURL: ' . curl_error($ch); // Esto te dará la respuesta definitiva
            die();
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return 0;
        }

        $archivoApi = json_decode($resultado, true);

        if (isset($archivoApi) && isset($archivoApi['volumenDeNegocio'])) {
            $volumen = $archivoApi['volumenDeNegocio'];
        }

        return $volumen;
    }
}