@extends('layouts.layout')
@section('title', 'Edit Delivery Note')
@section('content')
    <!-- main -->
    <main>
        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>+ Update Delivery Note Invoice</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('Delivery.list') }}">View Delivery Note</a></li>

                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add New Delivery</a>
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
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
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
                                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                        onclick="hidePopup()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="align-items-center">
                    <form class="" enctype="multipart/form-data" method="post" action="{{ route('Delivery.update') }}"
                        data-parsley-validate>
                        @csrf()
                        <input type="hidden" name="IDVAl" value="{{ $data->Id }}">

                        <table class="table">
                            <tr>
                                <th>School Name</th>
                                <th>School Emis</th>
                                <th>School Name</th>

                                <th>Supplier Name</th>
                                <th>Contact No</th>
                                <th>Email</th>

                            </tr>
                            <tr>
                                <td>BLACKBANK PRIMARYSCHOOL</td>
                                <td>500110445</td>
                                <td>BLACKBANK PRIMARYSCHOOL</td>
                                <td>Adams</td>
                                <td>8989888888</td>
                                <td>Admam@gmail.com</td>
                            </tr>
                            <td>

                            </td>

                        </table>

                        <br>
                        <div class="form-group ">
                            <input type="file" class="form-control form-control-lg" name="filename" id="filename"
                                value="{{ old('filename') }}" placeholder=" " required>
                            @if ($errors->has('filename'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('filename') }}</strong>
                                </span>
                                @if ($data->Emis)
                                    <span style="color: red">File Path: {{ $data->Emis }}</span>
                                    <input type="text" value="{{ $data->FilePath }}">
                                @endif
                            @endif
                            <label>Upload Delivery Note/Invoice<span class="text-danger">*
                                    {{ $data->FilePath }}</span></label>
                        </div>

                        {{-- <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="text" class="form-control form-control-lg" name="MemberName" id="MemberName" value="{{ old('MemberName') }}" required>
                                @if ($errors->has('MemberName'))
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
                                @if ($errors->has('Designation'))
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
                                @if ($errors->has('ContactNo'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('ContactNo') }}</strong>
                                </span>
                                @endif
                                <label>Contact<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="email" class="form-control form-control-lg" name="Signature" id="Signature" value="{{ old('Signature') }}" required>
                                @if ($errors->has('Signature'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('Signature') }}</strong>
                                </span>
                                @endif
                                <label>Email<span class="text-danger">*</span></label>
                            </div>
                        </div> --}}


                        <div class="text submit-btn my-4">
                            <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline"
                                value="Clear">Clear </button>
                            <input type="submit" class="mx-4  btn btn-primary" value="Update">
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
