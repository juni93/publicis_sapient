<?php

namespace App\Rules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Casts\Enumerable;

/**
 * Regola di validazione per una qualsiasi enumerazione (input select).
 */
class EnumerableRule implements Rule
{
    /**
     * Il modello da validare
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;
    
    /**
     * L'attributo da validare del payload
     *
     * @var string
     */
    protected $attribute;
    
    /**
     * L'attributo da validare se diverso dal nome in payload
     *
     * @var string
     */
    protected $anotherAttribute;

    /**
     * Costruisce la regola di validazione.
     *
     * @param Model $model
     */
    public function __construct(Model $model, $anotherAttribute = null)
    {
        $this->model = $model;
        $this->anotherAttribute = $anotherAttribute;
    }

    /**
     * Determina se il valore da validare è compreso tra i valori dell'enumerazione.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->resolveAttribute($attribute);
        if (! $cast = $this->model->getAttributeValue($this->anotherAttribute ?? $this->attribute)) {
            $cast = new Enumerable;
        }
        return in_array($value, $cast->values($this->model, $this->anotherAttribute ?? $this->attribute, true));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("validation.in");
    }

    protected function resolveAttribute($attribute)
    {
        $this->attribute = $attribute;
        if (! $this->anotherAttribute && Str::contains($attribute, ".")) {
            $this->attribute = last(explode(".", $attribute));
        }
    }
    
}