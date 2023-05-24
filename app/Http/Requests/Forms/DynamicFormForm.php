<?php

namespace App\Http\Requests\Forms;

use App\Http\Requests\FormRequest;
use App\Models\DynamicField;
use App\Rules\EnumerableRule;

class DynamicFormForm extends FormRequest
{
    public function rules()
    {
        return [
            "label" => ["required", "string"],
            "description" => ["nullable", new EnumerableRule(new DynamicField)],
            "tool_tip" => ["nullable", "string"],
            "form" => ["nullable"],
        ];
    }
}
