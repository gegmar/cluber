@extends('layouts.app')

@section('title', 'Register')

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
                            <form class="form-validate" action="{{ route('register') }}" method="post">
                                @csrf

                                <div class="form-group">
                                    <input id="register-username" type="text" name="name" data-msg="Please enter your username"
                                        class="input-material{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"
                                        required autofocus>
                                    <label for="register-username" class="label-material">{{ __('Name') }}</label>

                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <input id="register-email" type="email" name="email" data-msg="Please enter a valid email address"
                                        class="input-material{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}"
                                        required>
                                    <label for="register-email" class="label-material">{{ __('E-Mail Address') }}</label>

                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <input id="register-password" type="password" name="password" required data-msg="Please enter your password"
                                        class="input-material{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                    <label for="register-password" class="label-material">{{ __('Password') }}</label>

                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <input id="register-password-rep" type="password" name="password_confirmation"
                                        required data-msg="Please repeat your password" class="input-material">
                                    <label for="register-password-rep" class="label-material">{{ __('Confirm Password')
                                        }}</label>
                                </div>

                                <div class="form-group terms-conditions">
                                    <input id="register-agree" name="registerAgree" type="checkbox" required value="1"
                                        data-msg="Your agreement is required" class="checkbox-template">
                                    <label for="register-agree">Read and agree to the <a href="{{ route('terms') }}">general
                                            terms</a> and
                                        the <a href="{{ route('privacy') }}">data protection policy</a></label>
                                </div>

                                <div class="form-group">
                                    <button id="register" type="submit" name="registerSubmit" class="btn btn-primary">{{
                                        __('Register') }}</button>
                                </div>
                            </form><small>Already have an account? </small><a href="{{ route('login') }}" class="signup">{{
                                __('Login') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyrights text-center">
        <p>Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a>
        </p>
    </div>
</div>
@endsection