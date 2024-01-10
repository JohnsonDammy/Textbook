@extends('layouts.layout')
@section('title', 'Edit Supplier')
@section('content')
<!-- main -->
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center">
            <div class="col-12 col-md-4">
                <div class="page-titles">
                    <h4>Update Supplier Details</h4>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('Suppliyer.list') }}">View Supplier</a></li>

                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Add New Supplier</a>
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
        @if ($message = Session::get('successD'))
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
            {{-- // INSERT INTO `school_suppliyer`(`Id`, `Suppliyer_id`, `Emis`, `email`, `CompanyName`, `CompanyAddress`, `CompanyContact`, `IsActive`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')    use HasFactory; --}}

                <div class="align-items-center">
                    <form class="" method="post" action="{{route('suppliar.update', $data->Id)}}" data-parsley-validate>
                        @csrf()
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="text" class="form-control form-control-lg" name="CompanyName" id="CompanyName" value="{{ old('CompanyName' , $data->CompanyName) }}" required>
                                @if($errors->has('CompanyName'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('CompanyName') }}</strong>
                                </span>
                                @endif
                                <label>Company Name<span class="text-danger">*</span></label>
                                <input type="hidden" name="Emis" value="{{ Auth::user()->username }}">
<input type="hidden" name="IDVAl" value="{{ $data->Id}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="email" class="form-control form-control-lg" name="Email" id="Email" value="{{ old('Email', $data->email) }}"  required>
                                @if($errors->has('Email'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('Email') }}</strong>
                                </span>
                                @endif
                                <label>Email Address:<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="text" class="form-control form-control-lg" name="CompanyAddress" id="CompanyAddress" value="{{ old('CompanyAddress', $data->CompanyAddress) }}" required>
                                @if($errors->has('CompanyAddress'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('CompanyAddress') }}</strong>
                                </span>
                                @endif
                                <label>Address<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="number" class="form-control form-control-lg" name="CompanyContact" id="CompanyContact" value="{{ old('CompanyContact', $data->CompanyContact) }}" placeholder=" " required>
                                @if($errors->has('CompanyContact'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('CompanyContact') }}</strong>
                                </span>
                                @endif
                                <label>Contact<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="text submit-btn my-4">
                            <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Clear">Clear </button>
                            <input type="submit" class="mx-4  btn btn-lg btn-primary" id="add_circuit" name="add_circuit" data-bs-toggle="modal" data-bs-target="#alret-pop" value="Update">
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