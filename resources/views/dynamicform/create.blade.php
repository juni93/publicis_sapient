@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Dynamic Form</h1>
        <form action="{{ route('dynamic-forms.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="label">Label:</label>
                <input type="text" name="label" id="label" class="form-control" required>
                @error('label')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_active">Is Active:</label>
                <select name="is_active" id="is_active" class="form-control" required>
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </select>
                @error('is_active')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="dynamic_field">Select Form Fields:</label>
                <select name="dynamic_field[]" id="dynamic_field" class="form-control" multiple required>
                    @foreach ($fields as $field)
                        <option value="{{ $field['id'] }}">{{ $field['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Dynamic Form</button>
        </form>
    </div>
@endsection
