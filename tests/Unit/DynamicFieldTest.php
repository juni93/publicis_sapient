<?php

namespace Tests\Unit\DynamicField;

use App\Http\Requests\Forms\DynamicFieldForm;
use App\Models\DataType\Boolean;
use App\Models\DynamicField;
use App\Models\DynamicForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DynamicFieldTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_dynamic_fields()
    {
        DynamicField::factory()->count(5)->create();

        $response = $this->get('/dynamic-fields');

        $response->assertStatus(200);
        $response->assertViewIs('dynamicfield.index');
        $response->assertViewHas('data');
        $dynamicFields = $response->viewData('data');
        $this->assertCount(5, $dynamicFields);
    }



    public function test_show_returns_dynamic_field()
    {
        $dynamicField = DynamicField::factory()->create();

        $response = $this->get('/dynamic-fields/' . $dynamicField->id);

        $response->assertStatus(200);
        $response->assertViewIs('dynamicfield.show');
        $response->assertViewHas('data', $dynamicField);
    }

    public function test_dynamic_field_belongs_to_many_dynamic_forms()
    {
        $dynamicField = DynamicField::factory()->create();
        $dynamicForm = DynamicForm::factory()->create();

        $dynamicField->dynamicForms()->attach($dynamicForm);

        $this->assertTrue($dynamicField->dynamicForms->contains($dynamicForm));
    }

    public function test_dynamic_field_form_passes_validation_with_valid_data()
    {
        $this->withoutExceptionHandling();

        $formRequest = new DynamicFieldForm;
        $formRequest->merge([
            'label' => 'Test Field',
            'field_type' => random_int(0, 2),
            'validation_type' => random_int(0, 4),
            'placeholder' => 'Enter a value',
            'max_length' => 50,
            'tool_tip' => 'Some tooltip',
            'is_required' => Boolean::true(),
        ]);
        try {
            $validatedData = $formRequest->validate($formRequest->rules());
            $this->assertEquals('Test Field', $validatedData['label']);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $this->fail('Validation failed with valid data. Errors: ' . implode(', ', $errors));
        }
    }

    public function test_dynamic_field_form_fails_validation_with_invalid_data()
    {
        $formRequest = new DynamicFieldForm;
        $formRequest->merge([
            'label' => '', // Invalid: label is required
            'field_type' => 'invalid_type', // Invalid: field_type does not exist
            'validation_type' => 'required|string',
            'placeholder' => 'Enter a value',
            'max_length' => 'not_an_integer', // Invalid: max_length must be an integer
            'tool_tip' => 'Some tooltip',
            'is_required' => 'not_a_boolean', // Invalid: is_required must be a boolean
        ]);

        $this->expectException(ValidationException::class);
        $formRequest->validate($formRequest->rules());
    }
}
