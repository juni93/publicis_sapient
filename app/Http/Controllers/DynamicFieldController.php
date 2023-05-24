<?php

namespace App\Http\Controllers;

use App\Http\Requests\Forms\DynamicFieldForm;
use App\Models\DynamicField;
use Illuminate\Http\Request;

class DynamicFieldController extends ResourceController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->indexing(new DynamicField);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->creating(DynamicField::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DynamicFieldForm $request)
    {
        if ($model = $this->storing($request, DynamicField::class)) {
            return $this->renderResource($model, "show");
        }
        return $this->invalidInsert();
    }

    public function show(DynamicField $dynamicField)
    {
        return $this->showing($dynamicField);
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
}
