<?php

namespace App\Models\DataType;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Forms\Interfaces\FormBuilder;
use App\Models\Casts\Choiceable;

class Boolean {

    public $formFieldType = "radio";

    public const CHOICES = ["Y", "N"];
    
    public static function true()
    {
        return head(static::CHOICES);
    }
    
    public static function false()
    {
        return last(static::CHOICES);
    }

    public function validate($value, $meta = null): bool
    {
        return in_array($value, static::CHOICES);
    }
}
