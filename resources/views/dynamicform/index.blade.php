@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="{{ route('dynamic-forms.create') }}" class="btn btn-primary">Create New Dynamic Form</a>
        </div>
        <br>
        <h1>Dynamic Forms</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Description</th>
                    <th>Is Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dynamicForm)
                    <tr>
                        <td>{{ $dynamicForm['label'] }}</td>
                        <td>{{ $dynamicForm['description'] }}</td>
                        <td>{{ $dynamicForm['is_active']['text'] }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="generatedFormDropdown" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    View Generated Form
                                </button>
                                <div class="dropdown-menu" aria-labelledby="generatedFormDropdown">
                                    <a class="dropdown-item" href="{{ route('dynamic-forms.generatedForm', [$dynamicForm['id'], 'return_type' => 'json']) }}">JSON</a>
                                    <a class="dropdown-item" href="{{ route('dynamic-forms.generatedForm', [$dynamicForm['id'], 'return_type' => 'html']) }}">HTML</a>
                                    <a class="dropdown-item" href="{{ route('dynamic-forms.generatedForm', [$dynamicForm['id'], 'return_type' => 'view']) }}">View</a>
                                </div>
                            </div>
                            
                            <a href="{{ route('dynamic-forms.generatedForm', $dynamicForm['id']) }}"
                                class="btn btn-info">View Generated Form</a>
                            <a href="{{ route('dynamic-forms.show', $dynamicForm['id']) }}" class="btn btn-info">View</a>
                            <a href="{{ route('dynamic-forms.edit', $dynamicForm['id']) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('dynamic-forms.destroy', $dynamicForm['id']) }}" method="POST"
                                style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this dynamic form?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').on('click', function() {
                $(this).next('.dropdown-menu').toggleClass('show');
            });
        });
    
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });
    </script>
@endsection