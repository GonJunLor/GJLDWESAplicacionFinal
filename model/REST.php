<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 19/01/2026
*/
class REST{
    

    public static function apiNasa($fecha){
        // se accede a la url de la nasa
        $resultado = file_get_contents($url = "https://api.nasa.gov/planetary/apod?api_key=" . API_KEY_NASA);
        $archivoApi=json_decode($resultado,true);

        //si el archivo se a descodificado correctamente, devuelve la foto
        if(isset($archivoApi)){
            $fotoNasa= new FotoNasa($archivoApi['title'],$archivoApi['url'], $archivoApi['date']);
            return $fotoNasa;
        }
    }

}