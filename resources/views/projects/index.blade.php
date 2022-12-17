@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Projects') }} - BEARER TOKEN: {{ $token }} (stavljen ovde zbog testiranja posto nemam API Token stranicu)</div>

                <div class="card-body">
                    @if (session('msg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('msg') }}
                        </div>
                    @endif
                    <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <th>{{$project->project_name}}</th>
                            <th>
                                <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Dropdown button
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="projects/edit/{{$project->id}}">Edit</a></li>
                                    <li><a class="dropdown-item" href="projects/overview/{{$project->id}}">Overview</a></li>
                                    <li><a class="dropdown-item" href="/templates/new/{{$project->id}}">Add New Template</a></li>
                                </ul>
                                </div>
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New') }}</div>
                
                <div class="card-body">
                @if($emailMethods->isEmpty())
                    <p>You need to add at least one SMTP Method in order to create new or use existing projects!</p>
                    <p>You can create a new Email Method <a href="/emails/new">here</a></p>
                @else
                    <form class="panel-body" id="newProject" action="{{ route('projects.create') }}" method="POST">
                        <input name="_method" type="hidden" value="POST">
                        @csrf
                        <fieldset class="form-group">
                            <label for="form-group-input-1">Project Name:</label>
                            <input type="text" name="project_name" class="form-control" id="form-group-input-1" value="">
                        </fieldset>
                        <br>
                        <fieldset class="form-group">
                        <label for="form-group-input-1">Chose Mailing Method:</label>
                        <select class="form-select"  name="user_emails_config_id" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            @foreach($emailMethods as $method)
                                <option value="{{$method->id}}">{{$method->name}}</option>
                            @endforeach
                        </select>
                        </fieldset>
                        <br>
                        <fieldset class="form-group">
                            
                        <label>Check this box in order to add Webhook URL and get notified about Failed Jobs</label>
                        <br>
                            <div class="checkbox">
                                <label>
                                    <input class="form-check-input" type="checkbox" id="webhook"> Check / Uncheck Webhook Action
                                </label>
                            </div>
                            <div id="webhookUrl">
                                <div class="form-group">
                                    <label for="webhook">Webhook Url</label>
                                    <input type="text" class="form-control" name="webhook_url" id="webhook_url">
                            </div>
                        
                        </fieldset>
                        <br>
                        <fieldset class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </fieldset>
                    </form>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var form = $('#newProject'),
    webhook = $('#webhook'),
        webhookUrl = $('#webhookUrl');

        webhookUrl.hide();

        webhook.on('click', function() {

            if($(this).is(':checked')) {
                webhookUrl.show();
                webhookUrl.find('input').attr('required', true);
            } else {
                webhookUrl.hide();
                webhookUrl.find('input').attr('required', false);
                webhookUrl.find('input').val("");
            }
    })
</script>
@endsection



