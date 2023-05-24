<?php

namespace App\Models\Casts;

use Illuminate\Support\Arr;

/**
 * Estende Enumerazione per il valore globale unico di Y / N
 */
class Choiceable extends Enumerable {
    
    protected function loadDictionary($model, $key)
    {
        $filePath = resource_path('lang/it.json');
        $dictionary = json_decode(file_get_contents($filePath), true);
        return Arr::get($dictionary, sprintf("attributes.%s", "choice"));
    }

}