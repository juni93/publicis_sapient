@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dynamic Form Details</h1>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Label:</strong> {{ $data->label }}</p>
                <p><strong>Description:</strong> {{ $data->description }}</p>
                <p><strong>Is Active:</strong> {{ $data->is_active ? 'Yes' : 'No' }}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h3>Dynamic Fields</h3>
                <ul>
                    @foreach ($data->dynamicFields as $dynamicField)
                        <li>{{ $dynamicField->label }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
