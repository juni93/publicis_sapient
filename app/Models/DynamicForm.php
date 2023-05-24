<?php

namespace App\Models;

use App\Models\Casts\Choiceable;

class DynamicForm extends ModelFactory
{
    public const RETURN_TYPES = ["json", "html", "view"];
    
    protected $fillable = [
        "label",
        "description",
        "is_active",
        "form",
    ];

    protected $casts = [
        "is_active" => Choiceable::class,
    ];

    /**
     * Accessors
     */

    protected function getFormKeyAttribute(): string
    {
        return "form";
    }

    /**
     * Relations
     */

    public function dynamicFields()
    {
        return $this->belongsToMany(DynamicField::class);
    }

    /**
     * Logic
     */

    public function generateFormJson()
    {
        $formJson = collect([
            'form' => [
                'label' => $this->label,
                'fields' => $this->dynamicFields->map(function ($dynamicField) {
                    return [
                        'label' => $dynamicField->label,
                        'placeholder' => $dynamicField->placeholder,
                        'validation' => $dynamicField->validation_type->text,
                        'type' => $dynamicField->field_type->text
                    ];
                })->all()
            ]
        ]);
    
        return $formJson->toJson();
    }

}