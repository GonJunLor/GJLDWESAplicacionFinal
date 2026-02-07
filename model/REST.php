<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 07/02/2026
*/
class REST{

    // public static function apiNasa($fecha){
    //     $volumen = null;

    //     // El @ evita que el Warning salga en pantalla
    //     $resultado = @file_get_contents("https://api.nasa.gov/planetary/apod?date=$fecha&api_key=" . API_KEY_NASA);
        
    //     if ($resultado === false) {
    //         return null;
    //     }

    //     $archivoApi = json_decode($resultado, true);

    //     if (isset($archivoApi)) {
    //         if (isset($archivoApi['date']) && isset($archivoApi['explanation']) && isset($archivoApi['hdurl']) && isset($archivoApi['title']) && isset($archivoApi['url'])) {
    //             $volumen = new FotoNasa($archivoApi['date'], $archivoApi['explanation'], $archivoApi['hdurl'], $archivoApi['title'], $archivoApi['url']);
    //         } else {
    //             $volumen = new FotoNasa('1990-04-24','','webroot/media/images/banderaEs.png','No hay foto del dia','webroot/media/images/banderaEs.png');
    //         }
    //     }

    //     return $volumen;
    // }

    // Codigo alternativo por si no funciona el anterior en el servidor, este es más seguro.
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
            // Si quieres ver el error real, podrías hacer un: echo curl_error($ch);
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

        // si ha habido un error en vez de devolver null, devolvemos un objeto falso para que el programa siga funcionando
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

    public static function apiPropia($codDepartamento){
        $volumen = 0;
        // $url = "http://daw205.local.ieslossauces.es/GJLDWESAplicacionFinal/api/wsConsultarVolumenDeNegocio.php?codDepartamento=$codDepartamento&api_key=" . API_KEY_PROPIA;
        $url = "http://192.168.1.205/GJLDWESAplicacionFinal/api/wsConsultarVolumenDeNegocio.php?codDepartamento=$codDepartamento&api_key=" . API_KEY_PROPIA;
        // $url = "http://gonzalojunlor.ieslossauces.es/GJLDWESAplicacionFinal/api/wsConsultarVolumenDeNegocio.php?codDepartamento=$codDepartamento&api_key=" . API_KEY_PROPIA;

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
            $volumen = 0;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Si el código no es 200 (OK), algo ha ido mal (ej. fecha incorrecta o API KEY mal)
        if ($httpCode !== 200) {
            $volumen = 0;
        }

        // 5. Procesamos el JSON
        $archivoApi = json_decode($resultado, true);

        if (isset($archivoApi)) {
            if (isset($archivoApi['volumenDeNegocio'])) {
                $volumen = $archivoApi['volumenDeNegocio'];
            }
        }

        return $volumen;
    }
}
