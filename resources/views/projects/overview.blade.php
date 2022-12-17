@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Project Overview') }}</div>
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

                    <p>Project Name: <b>{{ $project->project_name }}</b></p>
                    <p>Emails Method: <b>SMTP</b></p>
                    
                    

                    @if($templates->isEmpty())
                        <p>Templates: <b>You need to create at least one template per project.</b></p>
                        <p>You can create a new template <a href="/templates/new/{{$id}}">here</a></p>
                    @else

                        <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Template Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($templates as $template)
                            <tr>
                                <th>{{$template->template_name}}</th>
                                <th>
                                    <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Dropdown button
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/templates/edit/{{$template->id}}">Edit</a></li>
                                        <li><a class="dropdown-item" href="/templates/remove/{{$template->id}}">Remove</a></li>
                                    </ul>
                                    </div>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

