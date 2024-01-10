@extends('layouts.auth')
@section('title', 'Login | Furniture')
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
                    <div class="auth-form">
                        <h1 class="text-start auth-form_title">Login</h1>
                        <form method="POST" action="{{ route('login') }}" data-parsley-validate>
                            @csrf
                            <div class="form-group">

                                <input id="username" type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required data-parsley-required-message="Username is required" autocomplete="username" autofocus placeholder=" ">

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label>Username<span class="text-danger">*</span></label>
                            </div>
                            <div class="form-group pass-box">


                                <input id="password" type="password" id="login-password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required data-parsley-required-message="Password is required" autocomplete="current-password" placeholder=" ">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label>Password<span class="text-danger">*</span></label>
                                <i class="ri-eye-fill" onclick="myFunctionn()" id="pass-icon"></i>
                            </div>

                            <div class="form-group text-end reset-password">
                                @if (Route::has('password.request'))
                                <a class="text-decoration-underline" href="{{ route('password.request') }}">Reset
                                    Password</a>
                                @endif

                            </div>
                            <div class="text-end submit-btn">
                                <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Clear">Clear </button>
                                <button type="submit" class="btn btn-lg ">Login</button>
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