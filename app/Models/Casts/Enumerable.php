<?php

namespace App\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;
use Illuminate\Support\Arr;
use App\Models\Interfaces\LanguageAttributes;

/**
 * Trasforma le costanti di una Enumerazione in valori e viceversa.
 * Fornisce il dizionario dell'Enumerazione.
 * 
 * @see https://laravel.com/docs/8.x/eloquent-mutators#custom-casts
 * @see \App\Models\DataType\Enum
 * 
 * @property-read mixed $list   Il dizionario dell'Enumerazione.
 * @property-read mixed $text   Il nome della costante corrente.
 * @property-read mixed $value  Il valore corrente dell'enumerazione.
 */
class Enumerable implements CastsAttributes, LanguageAttributes, SerializesCastableAttributes
{

    protected $dictionary;
    protected $model;
    protected $value;

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        return $this->getDictionary($model, $key, $value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }

    /**
     * Get the serialized representation of the value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function serialize($model, string $key, $value, array $attributes)
    {
        return [
            "cast" => class_basename($value),
            "text" => $value->text,
            "value" => $value->value
        ];
    }

    /**
     * Get the underlying JSON translations dictionary
     *
     * @param \Illuminate\Database\Eloquent\Model  $model
     * @param string  $key
     * @return static
     */
    public function getDictionary($model, $key, $value)
    {
        $this->model = $model->withoutRelations();
        $this->value = $value;
        $this->dictionary = $this->dictionary ?? $this->loadDictionary($model, $key);
        return $this;
    }

    protected function loadDictionary($model, $key)
    {
        $filePath = resource_path('lang/it.json');
        $dictionary = json_decode(file_get_contents($filePath), true);
        return Arr::get($dictionary, sprintf("attributes.%s.%s", get_class($model), $key));
    }



    /**
     * Get the keys or values of the translation dictionary
     *
     * @param \Illuminate\Database\Eloquent\Model  $model
     * @param string  $key 
     * @param bool $onlyKeys
     * @return array
     */
    public function values($model, $key, $onlyKeys = false)
    {
        $dictionary = $this->getDictionary($model, $key, null)->list;
        return $onlyKeys ? array_map(function ($item) {
            return is_numeric($item) ? "$item" : $item;
        }, array_keys($dictionary)) : $dictionary;
    }

    public function __get($name)
    {
        if (is_array($this->dictionary)) {
            switch ($name) {
                case "list":
                    return $this->dictionary;
                case "text":
                    return $this->dictionary[$this->value] ?? null;
                case "value":
                    return $this->value;
            }
        }
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
