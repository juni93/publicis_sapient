<?php

namespace Database\Factories;

use App\Models\DataType\Boolean;
use App\Models\DynamicField;
use Illuminate\Database\Eloquent\Factories\Factory;

class DynamicFieldFactory extends Factory
{
    protected $model = DynamicField::class;

    public function definition()
    {
        return [
            "label" => $this->faker->word,
            "field_type" => $this->faker->randomElement([0, 1, 2]),
            "validation_type" => $this->faker->randomElement([0, 1, 2, 3, 4]), 
            "placeholder" => $this->faker->sentence,
            "max_length" => $this->faker->numberBetween(1, 255),
            "tool_tip" => $this->faker->sentence,
            "is_required" => $this->faker->randomElement(Boolean::CHOICES), // 
        ];
    }
}
