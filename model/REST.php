<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 19/01/2026
*/
class REST{

    public static function apiNasa($fecha){
        $oFotoNasa = null;

        // El @ evita que el Warning salga en pantalla
        $resultado = @file_get_contents("https://api.nasa.gov/planetary/apod?date=$fecha&api_key=" . API_KEY_NASA);

        if ($resultado === false) {
            return null;
        }

        $archivoApi = json_decode($resultado, true);

        if (isset($archivoApi)) {
            if (isset($archivoApi['date']) && isset($archivoApi['explanation']) && isset($archivoApi['hdurl']) && isset($archivoApi['title']) && isset($archivoApi['url'])) {
                $oFotoNasa = new FotoNasa($archivoApi['date'], $archivoApi['explanation'], $archivoApi['hdurl'], $archivoApi['title'], $archivoApi['url']);
            } else {
                $oFotoNasa = new FotoNasa('1990-04-24','','webroot/media/images/banderaEs.png','No hay foto del dia','webroot/media/images/banderaEs.png');
            }
        }

        return $oFotoNasa;
    }

}