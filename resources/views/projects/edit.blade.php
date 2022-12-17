@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Project') }}</div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="panel-body" action="{{ route('projects.edit', ['id' => $id]) }}" method="POST">
                        <input name="_method" type="hidden" value="POST">
                        @csrf
                        <fieldset class="form-group">
                            <label for="form-group-input-1">Project Name</label>
                            <input type="text" name="project_name" class="form-control" id="form-group-input-1" value="">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="form-group-input-1">Project Name</label>
                            <input type="text" name="project_name" class="form-control" id="form-group-input-1" value="">
                        </fieldset>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


