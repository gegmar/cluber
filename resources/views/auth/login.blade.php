@extends('layouts.app')

@section('title', __('Login') )

@section('site-content')
<div class="page login-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
            <div class="row">
                <!-- Logo & Information Panel-->
                <div class="col-lg-6">
                    <div class="info d-flex align-items-center">
                        <div class="content">
                            <div class="logo">
                                <h1>{{ config('app.name', 'Laravel') }}</h1>
                            </div>
                            <p>{{ __('ticketshop.welcome') }}</p>
                        </div>
                    </div>
                </div>
                <!-- Form Panel    -->
                <div class="col-lg-6 bg-white">
                    <div class="form d-flex align-items-center">
                        <div class="content">
                            <form method="post" class="form-validate" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <input id="login-username" type="text" name="email" required autofocus data-msg="Please enter your username"
                                        class="input-material{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">
                                    <label for="login-username" class="label-material">{{ __('E-Mail Address') }}</label>

                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <input id="login-password" type="password" name="password" required data-msg="Please enter your password"
                                        class="input-material{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                    <label for="login-password" class="label-material">{{ __('Password') }}</label>

                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <input class="input-material" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="label-material" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyrights text-center">
        <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a>
        </p>
    </div>
</div>
@endsection