@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="{{ route('dynamic-fields.create') }}" class="btn btn-primary">Create New Dynamic Field</a>
        </div>
        <br>
        <h1>Dynamic Fields</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Field Type</th>
                    <th>Validation Type</th>
                    <th>Placeholder</th>
                    <th>Max Length</th>
                    <th>Tool Tip</th>
                    <th>Required</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dynamicField)
                    <tr>
                        <td>{{ $dynamicField['label'] }}</td>
                        <td>{{ $dynamicField['field_type']['text'] }}</td>
                        <td>{{ $dynamicField['validation_type']['text'] }}</td>
                        <td>{{ $dynamicField['placeholder'] }}</td>
                        <td>{{ $dynamicField['max_length'] }}</td>
                        <td>{{ $dynamicField['tool_tip'] }}</td>
                        <td>{{ $dynamicField['is_required']['text'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
