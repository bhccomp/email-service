@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Template') }}</div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                @endif
                <div class="card-body">

                    <form class="panel-body" action="{{ route('templates.edit', ['template_id' => $template->id]) }}" method="POST">
                        <input name="_method" type="hidden" value="POST">
                        @csrf
                        <fieldset class="form-group">
                            <label for="form-group-input-1">Template Name:</label>
                            <input type="text" name="template_name" class="form-control" id="form-group-input-1" value="{{$template->template_name}}">
                        </fieldset>
                        <br>
                        <fieldset class="form-group">
                            <div class="form-group purple-border">
                                <label for="exampleFormControlTextarea4">Email Content:</label>
                                <textarea class="ckeditor form-control" name="content">{{$template->content}}</textarea>
                            </div>
                        </fieldset>

                        <br>
                        <fieldset class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </fieldset>
                    </form>
                    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection