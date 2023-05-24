<?php

namespace App\Helpers;



class Alias
{
    /*
    * Autoload Models in the global scope from App\Models
    * @return array
    */
    public static function loadModels()
    {
        $models = [];
        $dir = app_path('Models') . DIRECTORY_SEPARATOR;
        if ($dir_handle = opendir($dir)) {
            while (($file = readdir($dir_handle)) !== false) {
                if ($file != "." && $file != ".." && !is_dir($dir . $file) && !preg_match("#(abstract class|interface|trait)#", file_get_contents($dir . $file))) {
                    $model = str_replace(".php", "", $file);
                    $models[$model] = "App\\Models\\" . $model;
                }
            }
        }
        return $models;
    }
}
