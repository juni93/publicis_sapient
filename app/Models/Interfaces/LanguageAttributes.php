<?php

namespace App\Models\Interfaces;

/*
 * Definisce il container per i set in lingua
 */
interface LanguageAttributes {

    public function getDictionary($model, $key, $value);
    
    public function values($model, $key, $onlyKeys = false);
    
}