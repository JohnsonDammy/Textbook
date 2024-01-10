<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- meta -->

    <!-- icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon//apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon//favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon//favicon-16x16.png') }}">

    <meta name="theme-color" content="#349933">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css?cb=1644833916086') }}" />
</head>

<body class="h-100 error-page">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-12 col-md-6">
                    <div class="form-input-content text-center error-page-wrap">
                        <h1 class="error-page-wrap-text font-weight-bold">@yield('code')</h1>
                        <h4><i class="ri-error-warning-fill text-danger align-text-bottom"></i>@yield('message')</h4>
                        <div class="mt-5">l
                            <a class="btn btn-primary" href="{{ route('home') }}">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- Js Files -->

<script src="{{ asset('vendor/jQuery/jquery.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>

</html>