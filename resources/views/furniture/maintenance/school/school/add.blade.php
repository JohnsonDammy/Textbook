@extends('layouts.layout')
@section('title', 'Add School')
@section('content')
    <main>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-12">
                    <div class="page-titles">
                        <h4>School</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('school-maintenance') }}">School Maintenance</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('school.index') }}">School</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)"> Add New School</a></li>

                        </ol>
                    </div>
                </div>

            </div>
            <div class="row">
                @if ($message = Session::get('error'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                        <h4 class="popup-alert_title">School Maintenance - Add School</h4>
                                        <p class="popup-alert_des">{{ $message }}</p>
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
                <form id="form" class="" method="post" action="{{ route('school.store') }}"
                    data-parsley-validate>
                    @csrf()
                    <div class="row justify-content-between">

                        <div class="form-group col-12 col-md-6">
                            <input type="text" class="form-control form-control-lg" id="name" name="name"
                                value="{{ old('name') }}" required data-parsley-pattern="/^[a-z\d\-.'_\s]+$/i"
                                data-parsley-pattern-message="School Name accept alphabets and numbers"
                                data-parsley-required-message="School name is required" placeholder=" ">
                            @if ($errors->has('name'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            <label for="name">School Name<span class="text-danger">*</span></label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <select id="district_id" name="district_id" class="form-select form-control form-control-lg"
                                required data-parsley-required-message="School district is required">
                                <option value="">Select School District</option>
                                @foreach (getListOfAllDistricts() as $district)
                                    <option value="{{ $district->id }}" {{-- {{ old('district_id') == $district->id ? 'selected="selected"' : '' }} --}}>
                                        {{ ucwords($district->district_office) }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('district_id'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('district_id') }}</strong>
                                </span>
                            @endif
                            <label for="district_id">District<span class="text-danger">*</span></label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <input type="text" class="form-control form-control-lg" id="emis" name="emis"
                                data-parsley-type="number" data-parsley-type-message="EMIS number only allows numbers."
                                required data-parsley-required-message="School EMIS number is required"
                                data-parsley-length="[9,9]"
                                data-parsley-length-message="EMIS number should be exactly 9 digits long"
                                value="{{ old('emis') }}" placeholder=" ">
                            @if ($errors->has('emis'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('emis') }}</strong>
                                </span>
                            @endif
                            <label for="emis">School EMIS<span class="text-danger">*</span></label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <!-- <input type="text" class="form-control form-control-lg" required="required" placeholder=" "> -->
                            <select id="cmc_id" name="cmc_id" class="form-select form-control form-control-lg" required
                                data-parsley-required-message="CMC is required">
                                <option value="">Select CMC</option>
                            </select>
                            @if ($errors->has('cmc_id'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('cmc_id') }}</strong>
                                </span>
                            @endif
                            <label for="cmc_id">CMC<span class="text-danger">*</span></label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <input type="text" class="form-control form-control-lg" id="school_principal"
                                name="school_principal" value="{{ old('school_principal') }}" placeholder=" ">
                            <label for="school_principal">School Principal</label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <!-- <input type="text" class="form-control form-control-lg" required="required" placeholder=" "> -->
                            <select id="circuit_id" name="circuit_id" class="form-select form-control form-control-lg"
                                required data-parsley-required-message="Circuit is required">
                                <option value="">Select Circuit</option>
                            </select>
                            @if ($errors->has('circuit_id'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('circuit_id') }}</strong>
                                </span>
                            @endif
                            <label for="circuit_id">Circuit<span class="text-danger">*</span></label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <input type="text" class="form-control form-control-lg" id="tel" name="tel"
                                data-parsley-length="[10,10]"
                                data-parsley-length-message="Telephone number should be exactly 10 digits long"
                                value="{{ old('tel') }}" placeholder=" " data-parsley-type="number"
                                data-parsley-type-message="Telephone number number only allows numbers.">
                            @if ($errors->has('tel'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('tel') }}</strong>
                                </span>
                            @endif
                            <label for="tel">Telephone Number</label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <!-- <input type="text" class="form-control form-control-lg" required="required" placeholder=" "> -->
                            <select id="subplace_id" name="subplace_id" class="form-select form-control form-control-lg"
                                required data-parsley-required-message="Sub place name is required">
                                <option value="">Select Sub Place</option>
                            </select>
                            @if ($errors->has('subplace_id'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('subplace_id') }}</strong>
                                </span>
                            @endif
                            <label for="subplace_id">Sub Place Name<span class="text-danger">*</span></label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <!-- <input type="text" class="form-control form-control-lg" required="required" placeholder=" "> -->
                            <select id="level_id" name="level_id" class="form-select form-control form-control-lg" required
                                data-parsley-required-message="Level is required">
                                <option value="">Select Level</option>
                                @foreach (getSchoolLevelList() as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('level_id') == $level->id ? 'selected="selected"' : '' }}>
                                        {{ $level->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('level_id'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('level_id') }}</strong>
                                </span>
                            @endif
                            <label for="level_id">Level<span class="text-danger">*</span></label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <input type="text" class="form-control form-control-lg" id="street_code" name="street_code"
                                value="{{ old('street_code') }}" placeholder=" " data-parsley-length="[4,4]"
                                data-parsley-length-message="Street code should be exactly 4 digits long"
                                data-parsley-type="number" data-parsley-type-message="Street code only allows numbers.">
                            @if ($errors->has('street_code'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('street_code') }}</strong>
                                </span>
                            @endif
                            <label for="street_code">Street Code</label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <!-- <input type="text" class="form-control form-control-lg" required="required" placeholder=" "> -->
                            <select id="snq_id" name="snq_id" class="form-select form-control form-control-lg" required
                                data-parsley-required-message="SNQ is required">
                                <option value="">Select SNQ</option>
                                @foreach (getSchoolSnqList() as $snq)
                                    <option value="{{ $snq->id }}"
                                        {{ old('snq_id') == $snq->id ? 'selected="selected"' : '' }}>{{ $snq->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('snq_id'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('snq_id') }}</strong>
                                </span>
                            @endif
                            <label for="level_id">SNQ<span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="text-end submit-btn my-4">
                        <input type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Clear">
                        <input type="submit" class="mx-4  btn btn-lg btn-primary" id="add_school" name="add_school"
                            data-bs-toggle="modal" value="Add">
                    </div>
                </form>
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
        <script>
            $("#district_id").change(function() {
                console.log('District console');
                var district_id = $("#district_id").val()
             //   alert(district_id)
                $.ajax({
                    method: 'POST',
                    url: '/getcmclist',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        district_id: district_id,
                    },
                    success: function(result) {
                        $("#cmc_id").html(result)
                    }
                });
            });
            $("#cmc_id").change(function() {
                console.log('CMC console');
                var cmc_id = $("#cmc_id").val()
                $.ajax({
                    method: 'POST',
                    url: '/getcircuitlist',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        cmc_id: cmc_id,
                    },
                    success: function(result) {
                        $("#circuit_id").html(result)
                    }
                });
            });
            $("#circuit_id").change(function() {
                console.log('Circuit console');
                var circuit_id = $("#circuit_id").val()
                $.ajax({
                    method: 'POST',
                    url: '/getsubplacelist',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        circuit_id: circuit_id,
                    },
                    success: function(result) {
                        $("#subplace_id").html(result)
                    }
                });
            });
        </script>
    </main>
@endsection
