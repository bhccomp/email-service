@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New SMTP Account') }}</div>
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

                    <form class="panel-body" action="{{ route('emails.create') }}" method="POST">
                        <input name="_method" type="hidden" value="POST">
                        @csrf
                        <fieldset class="form-group">
                            <label for="form-group-input-1">Account Name:</label>
                            <input type="text" name="account_name" class="form-control" id="form-group-input-1" value="">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="form-group-input-2">From Address:</label>
                            <input type="text" name="from_address" class="form-control" id="form-group-input-2" value="">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="form-group-input-2">SMTP Hostname:</label>
                            <input type="text" name="smtp_hostname" class="form-control" id="form-group-input-2" value="">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="form-group-input-3">SMTP Username:</label>
                            <input type="text" name="smtp_username" class="form-control" id="form-group-input-3" value="">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="form-group-input-4">SMTP Password:</label>
                            <input type="text" name="smtp_password" class="form-control" id="form-group-input-4" value="">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="form-group-input-5">Encryption Type:</label>
                            <input type="text" name="encryption_type" class="form-control" id="form-group-input-5" value="">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="form-group-input-5">SMTP Port:</label>
                            <input type="text" name="smtp_port" class="form-control" id="form-group-input-6" value="">
                        </fieldset>
                        <br>
                        <fieldset class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </fieldset>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection