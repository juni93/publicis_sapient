<?php

namespace Database\Factories;

use App\Models\DataType\Boolean;
use App\Models\DynamicForm;
use Illuminate\Database\Eloquent\Factories\Factory;

class DynamicFormFactory extends Factory
{
    protected $model = DynamicForm::class;

    public function definition()
    {
        return [
            "label" => $this->faker->word,
            "description" => $this->faker->sentence,
            "is_active" => $this->faker->randomElement(Boolean::CHOICES), // 
        ];
    }
}
