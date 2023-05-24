@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <br>
                    <a href="{{ route('dynamic-fields.index') }}" class="btn btn-primary">Dynamic Fields</a>
                    <br>
                    <br>
                    <a href="{{ route('dynamic-forms.index') }}" class="btn btn-primary">Dynamic Forms</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
