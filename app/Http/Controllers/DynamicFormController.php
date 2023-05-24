<?php

namespace App\Http\Controllers;

use App\Http\Requests\Forms\DynamicFormForm;
use App\Http\Requests\Forms\DynamicGeneratedForm;
use App\Models\DynamicField;
use App\Models\DynamicForm;
use Illuminate\Http\Request;

class DynamicFormController extends ResourceController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->indexing(new DynamicForm);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields = DynamicField::all()->toArray();
        return $this->creating(DynamicForm::class, ["fields" => $fields]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DynamicFormForm $request)
    {
        if ($model = $this->storing($request, DynamicForm::class)) {
            return $this->renderResource($model, "show");
        }
        return $this->invalidInsert();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DynamicForm $dynamicForm)
    {
        return $this->showing($dynamicForm);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generatedForm(DynamicForm $dynamicForm, DynamicGeneratedForm $request)
    {
        $form = $dynamicForm->form;
        $returnType = $request->input("return_type");
        if ($returnType === 'json') {
            return response()->json($form);
        } elseif ($returnType === 'html') {
            $decoded_form = json_decode($dynamicForm->form, true);
            $fields = $decoded_form['form']["fields"];
            $html = '';

            foreach ($fields as $field) {
                $html .= '<div class="form-group">';
                $html .= '<label for="' . $field['label'] . '">' . $field['label'] . '</label>';
                $html .= $this->generateFieldHtml($field['type'], $field['label'], $field['placeholder']);
                $html .= '</div>';
            }
            return $html;
        } elseif ($returnType === 'view') {
            return view('dynamicform.generatedForm', $dynamicForm);
        }
        return $this->invalidIndex();
    }

    protected function generateFieldHtml(string $type, string $name, string $placeholder): string
    {
        switch ($type) {
            case 'text':
            case 'password':
                return $this->generateInputHtml($type, $name, $placeholder);
            case 'textarea':
                return $this->generateTextareaHtml($name, $placeholder);
                // Add more cases for other field types as needed

            default:
                // Handle unrecognized field types
                return '';
        }
    }

    protected function generateInputHtml(string $type, string $name, string $placeholder): string
    {
        return sprintf('<input type="%s" name="%s" id="%s" placeholder="%s">', $type, $name, $name, $placeholder);
    }

    protected function generateTextareaHtml(string $name, string $placeholder): string
    {
        return sprintf('<textarea name="%s" id="%s" placeholder="%s"></textarea>', $name, $name, $placeholder);
    }
}
