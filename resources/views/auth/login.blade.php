@extends('layouts.app2')

@section('content')
<div class="login-container">
        <div class="login-header login-caret">
            <div class="login-content">
                <a href="../../dashboard/main/index.html" class="logo"> <img src="/assets/images/logo@2x.png" width="120" alt="" /> </a>
                <h3 style="color:#fff;font-family:sans-serif;">Perfornance Monitoring System</h3>
                <!-- progress bar indicator -->
                <div class="login-progressbar-indicator">
                    <h3>43%</h3> <span>logging in...</span> </div>
            </div>
        </div>
        <div class="login-progressbar">
            <div></div>
        </div>
        <div class="login-form">
            <div class="login-content">
                <div class="form-login-error">
                    <h3>Invalid login</h3>
                    <p>Enter <strong>demo</strong>/<strong>demo</strong> as login and password.</p>
                </div>
               
                     <form method="POST" role="form" 
                     action="{{ route('login') }}">
                        @csrf

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"> <i class="entypo-mail"></i> </div>
                            <input placeholder="email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                               
                        </div><br>
                         @if ($errors->has('email'))
                                    <span class="text text-danger alert" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"> <i class="entypo-key"></i> </div>
                            <input placeholder="password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                             </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg col-xs-12"> <i class="entypo-login"></i> Login In
                        </button>
                    </div>
                    <div class="form-group"> <em>- or -</em> </div>
                   
                </form>
                <!-- <div class="login-bottom-links"> <a href="../forgot-password/index.html" class="link">Forgot your password?</a>
                    <br /> <a href="#">ToS</a> - <a href="#">Privacy Policy</a> </div> -->
            </div>
        </div>
    </div>
@endsection
