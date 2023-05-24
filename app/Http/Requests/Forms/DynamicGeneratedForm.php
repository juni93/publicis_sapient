<?php

namespace App\Http\Requests\Forms;

use App\Http\Requests\FormRequest;
use App\Models\DynamicForm;

class DynamicGeneratedForm extends FormRequest
{
    public function rules()
    {
        return [
            "return_type" => ["required", $this->getInRule(DynamicForm::RETURN_TYPES)],
        ];
    }
}
