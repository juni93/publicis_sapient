<?php

namespace App\Http\Requests\Forms;

use App\Http\Requests\FormRequest;
use App\Models\DynamicField;
use App\Rules\EnumerableRule;

class DynamicFieldForm extends FormRequest
{
    public function rules()
    {
        return [
            "label" => ["required", "string"],
            "field_type" => ["required", new EnumerableRule(new DynamicField)],
            "validation_type" => ["required", new EnumerableRule(new DynamicField)],
            "placeholder" => ["nullable", "string"],
            "max_length" => ["required", "numeric"],
            "tool_tip" => ["nullable", "string"],
            "is_required" => ["required", new EnumerableRule(new DynamicField)],
        ];
    }
}
