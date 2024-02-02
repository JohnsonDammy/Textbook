@extends('layouts.layout')
@section('title', 'Add Stationery')
@section('content')
<!-- main -->
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center">
            <div class="col-12 col-md-4">
                <div class="page-titles">
                    <h4>+ Add New Stationery</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a                                     href="{{ route('stationeryCat', ['requestType' => 'Stationery', 'idInbox' => 1]) }}">View Stationery</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Add New Stationery</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            @if ($message = Session::get('success'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">{{ $message }}</h4>
                                {{-- <p class="popup-alert_des">{{ $message }}</p> --}}
                            </div>

                        </div>
                        <div class="modal-footer text-center justify-content-center p-3 border-0">
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                onclick="hidePopup()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
            @if ($message = Session::get('errorMessage1'))
            <div class="modal fade show" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">{{ $message }}</h4>
                                {{-- <p class="popup-alert_des">{{ $message }}</p> --}}
                            </div>

                        </div>
                        <div class="modal-footer justify-content-around text-center">
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="hidePopup()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="align-items-center">
                <form class="" method="post" action="{{ route('addItemToCart') }}" data-parsley-validate>
                    @csrf
                    <div class="col-12 col-md-6 col-xl-6">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" name="itemName" id="itemName" value=""
                                required>
                            @if($errors->has('itemName'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('itemName') }}</strong>
                            </span>
                            @endif
                            <label>Stationery Name<span class="text-danger">*</span></label>
                            <!-- Remove the hidden input with the name "itemName" -->
                        </div>
                    </div>

                    <div class="text submit-btn my-4">
                        <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Clear">Clear
                        </button>
                        <button type="submit" class="mx-4  btn btn-lg btn-primary" id="add_circuit" name="add_circuit"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($message = Session::get('error'))
    <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    <script>
        function hidePopup() {
            $("#exampleModal2").fadeOut(200);
            $('.modal-backdrop').remove();
            console.log("hidePop")
        }
    </script>
</main>
@endsection