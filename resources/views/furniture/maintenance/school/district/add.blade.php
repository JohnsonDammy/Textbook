@extends('layouts.layout')
@section('title', 'Add School District')
@section('content')
<main>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-12">
                <div class="page-titles">
                    <h4>+ Add New District</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('school-maintenance') }}">School Maintenance</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('schooldistricts.index') }}">School District</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)"> Add New School District</a></li>

                    </ol>
                </div>
            </div>

        </div>
        <div class="row mb-5">
            @if ($message = Session::get('error'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">School Maintenance - Add School District</h4>
                                <p class="popup-alert_des">{{ $message }}</p>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-around text-center">
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="hidePopup()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-12 col-md-12">
                <div class="row g-5 align-items-center">
                    <form class="" method="post" action="{{route('schooldistricts.store')}}" data-parsley-validate>
                        @csrf()
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="mb-5">
                                <div class="form-group ">
                                    <input type="text" class="form-control form-control-lg" name="district_office" id="district_office" value="{{ old('district_office') }}" required data-parsley-pattern="/^[a-z\d\-'_\s]+$/i" data-parsley-pattern-message="School district accept alphabets and numbers" data-parsley-required-message="School district is required" placeholder=" ">
                                    @if($errors->has('district_office'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('district_office') }}</strong>
                                    </span>
                                    @endif
                                    <label>District<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="text-end submit-btn my-4">
                                <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Clear">Clear </button>
                                <input type="submit" class="mx-4  btn btn-lg btn-primary" id="add_district" name="add_district" data-bs-toggle="modal" data-bs-target="#alret-pop" value="Add">
                            </div>
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