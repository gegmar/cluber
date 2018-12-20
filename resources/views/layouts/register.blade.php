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
                            <p>Free platform for theatre clubs</p>
                        </div>
                    </div>
                </div>
                <!-- Form Panel    -->
                <div class="col-lg-6 bg-white">
                    <div class="form d-flex align-items-center">
                        <div class="content">
                            <form class="form-validate">
                                <div class="form-group">
                                    <input id="register-username" type="text" name="registerUsername" required data-msg="Please enter your username"
                                        class="input-material">
                                    <label for="register-username" class="label-material">User Name</label>
                                </div>
                                <div class="form-group">
                                    <input id="register-email" type="email" name="registerEmail" required data-msg="Please enter a valid email address"
                                        class="input-material">
                                    <label for="register-email" class="label-material">Email Address </label>
                                </div>
                                <div class="form-group">
                                    <input id="register-password" type="password" name="registerPassword" required
                                        data-msg="Please enter your password" class="input-material">
                                    <label for="register-password" class="label-material">Password </label>
                                </div>
                                <div class="form-group">
                                    <input id="register-password-rep" type="password" name="registerPasswordRep"
                                        required data-msg="Please repeat your password" class="input-material">
                                    <label for="register-password-rep" class="label-material">Repeat Password </label>
                                </div>
                                <div class="form-group terms-conditions">
                                    <input id="register-agree" name="registerAgree" type="checkbox" required value="1"
                                        data-msg="Your agreement is required" class="checkbox-template">
                                    <label for="register-agree">Read and agree to the <a href="#">general terms</a> and
                                        the <a href="#">data protection policy</a></label>
                                </div>
                                <div class="form-group">
                                    <button id="register" type="submit" name="registerSubmit" class="btn btn-primary">Register</button>
                                </div>
                            </form><small>Already have an account? </small><a href="login.html" class="signup">Login</a>
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