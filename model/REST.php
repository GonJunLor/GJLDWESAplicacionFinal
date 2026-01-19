<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 19/01/2026
*/
class REST{

    public static function apiNasa($fecha){

        // El @ evita que el Warning salga en pantalla
        $resultado = @file_get_contents("https://api.nasa.gov/planetary/apod?date=$fecha&api_key=" . API_KEY_NASA);

        if ($resultado === false) {
            return null;
        }

        $archivoApi = json_decode($resultado, true);

        if (isset($archivoApi)) {
            return new FotoNasa($archivoApi['title'], $archivoApi['url'], $archivoApi['date']);
        }

        return null;
    }

}