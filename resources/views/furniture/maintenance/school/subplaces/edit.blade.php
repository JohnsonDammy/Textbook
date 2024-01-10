@extends('layouts.layout')
@section('title', 'Edit School Sub Place')
@section('content')
<!-- main -->
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center">
            <div class="col-12 col-md-4">
                <div class="page-titles">
                    <h4>Update Sub Place</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('school-maintenance') }}">School Maintenance</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('schoolsubplace.index') }}">Sub Place</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Sub Place</a>
                        </li>
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
                                <h4 class="popup-alert_title">School Maintenance - Update Sub Place</h4>
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
                    <form class="" method="post" action="{{route('schoolsubplace.update', $subplace->id)}}" data-parsley-validate>
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <input type="text" class="form-control form-control-lg" name="subplace_name" id="subplace_name" value="{{ old('circuit_name', $subplace->subplace_name)  }}" required data-parsley-pattern="/^[a-z\d\-'_\s]+$/i" data-parsley-pattern-message="Sub place accept alphabets and numbers" data-parsley-required-message="Sub place is required" placeholder=" ">
                                @if($errors->has('subplace_name'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('subplace_name') }}</strong>
                                </span>
                                @endif
                                <label>Sub Place Name<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="form-group ">
                                <select class="form-select form-control form-control-lg" name="circuit_id" id="circuit_id" required data-parsley-required-message="Circuit is required">
                                    <option value="">Select Circuit</option>
                                    @foreach (getListOfAllCircuits() as $circuit)
                                    <option value="{{ $circuit->id }}" {{ old('circuit_id', $subplace->circuit_id ) == $circuit->id ? 'selected="selected"' : '' }}>{{ ucwords($circuit->circuit_name) }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('circuit_id'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('circuit_id') }}</strong>
                                </span>
                                @endif
                                <label>Circuit<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="text-end submit-btn my-4">
                            <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Clear">Clear </button>
                            <input type="submit" class="mx-4  btn btn-lg btn-primary" id="update_subplace" name="update_subplace" data-bs-toggle="modal" data-bs-target="#alret-pop" value="Update">
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