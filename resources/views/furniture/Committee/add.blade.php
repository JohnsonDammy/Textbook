@extends('layouts.layout')
@section('title', 'Add Member')
@section('content')
<!-- main -->
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center">
            <div class="col-12 col-md-4">
                <div class="page-titles">
                    <h4>+ Add New Member</h4>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('Member.list') }}">View Member</a></li>

                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Add New Member</a>
                        </li>
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
            @if ($message = Session::get('errorMessage'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
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
                    <form class="" method="post" action="{{ route('AddMember') }}" data-parsley-validate>
                        @csrf()
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="text" class="form-control form-control-lg" name="MemberName" id="MemberName" value="{{ old('MemberName') }}" required>
                                @if($errors->has('MemberName'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('MemberName') }}</strong>
                                </span>
                                @endif
                                <label>Name<span class="text-danger">*</span></label>
                                <input type="hidden" name="Emis" value="{{ Auth::user()->username }}">

                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="text" class="form-control form-control-lg" name="Designation" id="Designation" value="{{ old('Designation') }}"  required>
                                @if($errors->has('Designation'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('Designation') }}</strong>
                                </span>
                                @endif
                                <label>Designation<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="number" class="form-control form-control-lg" name="ContactNo" id="ContactNo" value="{{ old('ContactNo') }}" placeholder=" " required>
                                @if($errors->has('ContactNo'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('ContactNo') }}</strong>
                                </span>
                                @endif
                                <label>Contact<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="email" class="form-control form-control-lg" name="Email" id="Email" value="{{ old('Email') }}" required>
                                @if($errors->has('Email'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('Email') }}</strong>
                                </span>
                                @endif
                                <label>Email<span class="text-danger">*</span></label>
                            </div>
                        </div>

                     
                        <div class="text submit-btn my-4">
                            <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Clear">Clear </button>
                            <input type="submit" class="mx-4  btn btn-lg btn-primary" id="add_circuit" name="add_circuit" data-bs-toggle="modal" data-bs-target="#alret-pop" value="Add">
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    @if ($message = Session::get('error'))
    <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    <script>
        function hidePopup() {
            $("#exampleModal").fadeOut(200);
            $('.modal-backdrop').remove();
            console.log("hidePop")
        }
    </script>
</main>
@endsection