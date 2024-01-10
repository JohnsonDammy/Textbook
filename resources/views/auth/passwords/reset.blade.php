@extends('layouts.auth')
@section('title', 'Create New Password | Furniture')
@section('content')
<div>
    <!-- preloader -->
    <div id="preloader">
        <div class="kw-three-bounce">
            <div class="kw-child kw-bounce1"></div>
            <div class="kw-child kw-bounce2"></div>
            <div class="kw-child kw-bounce3"></div>
        </div>
    </div>
    <!-- authincation -->
    <div class="authincation mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-8">
                    <div class="text-start mb-3">
                        <a href="index.html"><img src="{{ asset('img/logo.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="auth-form py-4">
                        <h1 class="text-start auth-form_title">Create a new Password</h1>
                        <form method="POST" action="{{ route('password.update') }}" data-parsley-validate>
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group mt-5">
                                <input id="email" type="hidden" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly autofocus>

                                <input id="username" type="text" class="form-control form-control-lg @error('email') is-invalid @enderror" name="username" value="{{ $username ?? old('username') }}" required autocomplete="email" readonly autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label>Username<span class="text-danger">*</span></label>
                            </div>
                            <div class="form-group mt-5 pass-box">

                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required data-parsley-required-message="The Password is required" autocomplete="new-password" placeholder="Enter New Password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label>New Password<span class="text-danger">*</span></label>
                                <i class="ri-eye-fill" onclick="myFunctionn()" id="pass-icon"></i>
                            </div>
                            <div class="form-group mt-5 pass-box">

                                <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required data-parsley-required-message="The confirm Password is required" autocomplete="new-password" placeholder="Confirm New Password">
                                <label>Confirm New Password<span class="text-danger">*</span></label>
                                <i class="ri-eye-fill" onclick="myFunctionc()" id="pass-iconc"></i>
                            </div>
                            <ul class="mt-4 reset-password-des__list">
                                <li> The password must meet the following requirements:</li>
                                <li> A minimum of 8 characters</li>
                                <li> A combination of both uppercase and lowercase letters</li>
                                <li> A combination of both letters and numbers</li>
                                <li> An inclusion of at least one special character, eg., !@#?]</li>
                            </ul>

                            <div class="text-end submit-btn">
                                <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Clear">Clear </button>
                                <button type="submit" class="btn btn-lg">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="authincation-footer">

        </div>
    </div>
</div>
@endsection