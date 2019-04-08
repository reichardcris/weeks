@extends('layouts.app2')

@section('content')
<h1>Admin/Add User</h1>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-shadow" data-collapsed="0">
            <!-- to apply shadow add class "panel-shadow" -->
            <!-- panel head -->
            <div class="panel-heading">
                <div class="panel-title">Please Fill The Form</div>
               
            </div>
            <!-- panel body -->
            <div class="panel-body">
                <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('User Type') }}</label>

                            <div class="col-md-6">
                                    <label>
                                        <input type="radio" name="role" id="optionsRadios1" value="3" checked="">Student
                                    </label>
                                    <label>
                                        <input type="radio" name="role" id="optionsRadios2" value="2">Teacher
                                    </label>
                               
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('sidebar')
 <li >
    <a href="/">
        <i class="entypo-home"></i>
        <span class="title">Home</span>
    </a> 
 
</li>
 <li class="active">
    <a href="/register">
        <i class="entypo-user-add"></i>
        <span class="title">Add User</span>
    </a> 
 
</li>
<li> 
    <a href="/enrollStudent"><i class="entypo-book"></i><span class="title">Enroll Student</span></a> 
</li>
<li > 
        <a href="/scheduling"><i class="entypo-clipboard"></i><span class="title">Assign Teachers</span></a> 
    </li>
@endsection