<?php

namespace App\Models;

use App\Models\Casts\Choiceable;
use App\Models\Casts\Enumerable;

class DynamicField extends ModelFactory
{

    protected $fillable = [
        "label",
        "field_type",
        "validation_type",
        "placeholder",
        "max_length",
        "tool_tip",
        "is_required",
    ];

    protected $casts = [
        "field_type" =>  Enumerable::class,
        "validation_type" => Enumerable::class,
        "is_required" => Choiceable::class,
    ];

    /**
     * Relations
     */


    public function dynamicForms()
    {
        return $this->belongsToMany(DynamicForm::class);
    }

    /**
     * Logic
     */
}