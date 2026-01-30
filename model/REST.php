<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 30/01/2026
*/
class REST{

    // public static function apiNasa($fecha){
    //     $oFotoNasa = null;

    //     // El @ evita que el Warning salga en pantalla
    //     $resultado = @file_get_contents("https://api.nasa.gov/planetary/apod?date=$fecha&api_key=" . API_KEY_NASA);
        
    //     if ($resultado === false) {
    //         return null;
    //     }

    //     $archivoApi = json_decode($resultado, true);

    //     if (isset($archivoApi)) {
    //         if (isset($archivoApi['date']) && isset($archivoApi['explanation']) && isset($archivoApi['hdurl']) && isset($archivoApi['title']) && isset($archivoApi['url'])) {
    //             $oFotoNasa = new FotoNasa($archivoApi['date'], $archivoApi['explanation'], $archivoApi['hdurl'], $archivoApi['title'], $archivoApi['url']);
    //         } else {
    //             $oFotoNasa = new FotoNasa('1990-04-24','','webroot/media/images/banderaEs.png','No hay foto del dia','webroot/media/images/banderaEs.png');
    //         }
    //     }

    //     return $oFotoNasa;
    // }

    // Codigo alternativo por si no funciona el anterior en el servidor, este es más seguro.
    public static function apiNasa($fecha) {
        $oFotoNasa = null;

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
            // Si quieres ver el error real, podrías hacer un: echo curl_error($ch);
            curl_close($ch);
            $oFotoNasa = null;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Si el código no es 200 (OK), algo ha ido mal (ej. fecha incorrecta o API KEY mal)
        if ($httpCode !== 200) {
            $oFotoNasa = null;
        }

        
        // 5. Procesamos el JSON
        $archivoApi = json_decode($resultado, true);

        if (isset($archivoApi) && !isset($archivoApi['error'])) {
            if (isset($archivoApi['date'], $archivoApi['explanation'], $archivoApi['title'], $archivoApi['url'])) {
                $hdurl = $archivoApi['hdurl'] ?? $archivoApi['url'];
                
                $imagenSerializada = self::serializarImagen($hdurl);

                $oFotoNasa = new FotoNasa(
                    $archivoApi['date'], 
                    $archivoApi['explanation'], 
                    $imagenSerializada, 
                    $archivoApi['title'], 
                    $imagenSerializada
                );
            }
        }

        // si ha habido un error en vez de devolver null, devolvemos un objeto falso para que el programa siga funcionando
        if ($oFotoNasa == null) {
            $oFotoNasa = new FotoNasa(
                '1990-04-24',
                '',
                'webroot/media/images/banderaEs.png',
                'No hay foto del dia',
                'webroot/media/images/banderaEs.png'
            );
        }
        return $oFotoNasa;
    }

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
}
