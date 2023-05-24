@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dynamic Field Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $data->label }}</h5>
                <p class="card-text"><strong>Field Type:</strong> {{ $data->field_type->text }}</p>
                <p class="card-text"><strong>Validation Type:</strong> {{ $data->validation_type->text }}</p>
                <p class="card-text"><strong>Placeholder:</strong> {{ $data->placeholder }}</p>
                <p class="card-text"><strong>Max Length:</strong> {{ $data->max_length }}</p>
                <p class="card-text"><strong>Tool Tip:</strong> {{ $data->tool_tip }}</p>
                <p class="card-text"><strong>Required:</strong> {{ $data->is_required->text }}</p>
                <a href="{{ route('dynamic-fields.edit', $data) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@endsection
