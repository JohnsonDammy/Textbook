@extends('layouts.auth')
@section('title', 'Reset Password | Furniture')
@section('content')
<div @if (session('status')) class="modal-open" style="overflow: hidden; padding-right: 5px;" data-bs-padding-right @endif>

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
                        <h1 class="text-start auth-form_title">Password Reset</h1>


                        <form method="POST" action="{{ route('password.email') }}" data-parsley-validate>
                            @csrf
                            <div class="form-group">

                                <input id="email" type="text" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required data-parsley-required-message="Please enter username" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror


                                <label>Username<span class="text-danger">*</span></label>
                            </div>
                            <div class="text-end submit-btn">
                                <button onclick="loaderscreen()" type="submit" class="btn btn-lg w-100">{{ __('Reset') }}</button>
                            </div>
                            <div class="mt-5 text-center d-flex justify-content-around  ">
                                <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Clear">Clear </button>
                                <a href="{{ route('login') }}" class="text-decoration-underline fs-2">Back to
                                    Login</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="authincation-footer">
        </div>
    </div>



    @if (session('status'))
    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered popup-alert">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <img src="assets/img/popup-check.svg" class="img-fluid" alt="">
                        <h4 class="popup-alert_title">Email Sent</h4>
                        <p class="popup-alert_des">An email has been sent to the profiles email address</p>
                    </div>

                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="hidePopup()">OK</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Js Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @if (session('status'))
    <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    <script>
        function hidePopup() {
            $("#exampleModal").fadeOut(200);
            $('.modal-backdrop').remove();
            console.log("hidePop")
        }

        function loaderscreen() {
            if ($('#email').val() != '') {
                $('#preloader').removeAttr('style');
            }
        }
    </script>
</div>
@endsection