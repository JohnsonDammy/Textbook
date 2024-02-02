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
                    <form class="form-with-modal" method="post" action="{{ route('AddMember') }}" data-parsley-validate>
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
                            <div class="form-group">
                                <select class="form-control form-control-lg" name="Designation" id="Designation" required>
                                    <option value="" disabled selected>Select Designation</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation }}">{{ $designation }}</option>
                                    @endforeach
                                </select>
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
                                <input type="number" class="form-control form-control-lg" name="ContactNo" id="ContactNo" value="{{ old('ContactNo') }}" placeholder="Enter a valid contact number eg. 0839356789"  pattern="0[0-9]{9}"  title="Please enter a valid South African phone number starting with 0 and total of 10 digits"
                                
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                maxlength="10" 
                                required>
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
                                <input type="email" class="form-control form-control-lg" name="Email" id="Email" value="{{ old('Email') }}">
                                @if($errors->has('Email'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('Email') }}</strong>
                                </span>
                                @endif
                                <label>Email<span class="text-danger"></span></label>
                            </div>
                        </div>

                     
                        <div class="text submit-btn my-4">
                            <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Clear">Clear </button>
                            <input type="submit" class="mx-4  btn btn-lg btn-primary" id="yesBtnModel" name="add_circuit" data-bs-toggle="modal" data-bs-target="#alret-pop" value="Add">
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="modal fade" id="ModelLoading" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered popup-alert">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="spinner-container" id="spinner">
                        <div class="spinner-border text-primary" role="status">
                        </div>
                        <label> Please wait... </label>
                    </div>

                </div>


            </div>

        </div>
    </div>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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

{{-- <script>
    $(document).ready(function() {
        $("#yesBtnModel").click(function(){
        $('#ModelLoading').modal('show');

        })

    
    });
</script> --}}


<script>
    $(document).ready(function() {
        $(".form-with-modal").submit(function() {
            // Show the modal when the form is submitted
            $('#ModelLoading').modal('show');
        });
    });
</script>
</main>
@endsection