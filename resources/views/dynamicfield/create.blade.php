@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Dynamic Field') }}</div>

                    <div class="card-body">
                        <form action="{{ route('dynamic-fields.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="label">{{ __('Label') }}:</label>
                                <input type="text" name="label" id="label" class="form-control">
                                @error('label')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="field_type">{{ __('Field Type') }}:</label>
                                <select name="field_type" id="field_type" class="form-control">
                                    @foreach ($model->field_type->list as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('field_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="validation_type">{{ __('Validation Type') }}:</label>
                                <select name="validation_type" id="validation_type" class="form-control">
                                    @foreach ($model->validation_type->list as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('validation_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="placeholder">{{ __('Placeholder') }}:</label>
                                <input type="text" name="placeholder" id="placeholder" class="form-control">
                                @error('placeholder')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="max_length">{{ __('Max Length') }}:</label>
                                <input type="text" name="max_length" id="max_length" class="form-control">
                                @error('max_length')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tool_tip">{{ __('Tool Tip') }}:</label>
                                <input type="text" name="tool_tip" id="tool_tip" class="form-control">
                                @error('tool_tip')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="is_required">{{ __('Required') }}:</label>
                                <select name="is_required" id="is_required" class="form-control">
                                    @foreach ($model->is_required->list as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('is_required')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
