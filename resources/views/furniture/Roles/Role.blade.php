@extends('layouts.layout')
@section('title', 'Add Role')
@section('content')
    @php
        $Organization = getListOfAllOrganization();
    @endphp
    <main>
        <div class="container">
            <div class="row">
                <!-- breadcrumb -->
                <div class="row align-items-center">
                    <div class="col-12 col-md-4">
                        <div class="page-titles">
                            <h4>Manage Roles</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('editRoless') }}">Manage Role</a></li>
                            </ol>
                        </div>
                    </div>

                </div>
                <div class="row justify-content-center">
                    @if ($message = Session::get('success'))
                        <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            style="display: block;" aria-modal="true" role="dialog">
                            <div class="modal-dialog modal-dialog-centered popup-alert">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                            <h4 class="popup-alert_title">{{ $message }}</h4>
                                            <p class="popup-alert_des"></p>
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
                </div>

                @if ($message = Session::get('error'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                        <h4 class="popup-alert_title">Manage Users - Add User</h4>
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
                <form method="post" action="{{ route('Add.Role') }}" id="userform" 
                    data-parsley-validate>
                    @csrf()

                    {{-- @php
                $ds = old('permission') ;
                if(is_array($ds)){
                $ds = implode(" ",$ds);
                } @endphp
                <input type="hidden" name="oldper" value="{{$ds}}" id="oldper">
                <div class="col-12 col-xl-12">
                    < class="row">

                        <div class="form-group col-12 col-xl-6">
                            <select class="form-control form-control-lg wide" id="user-type-select" onchange="selectorg()" name="organization" required data-parsley-required-message="Organization is required">
                                <option value="">Select Organization</option>
                                @foreach ($Organization as $key => $org)
                                @php
                                $per = implode(" ",$org->permissions);
                                @endphp
                                <option value="{{ $org->id }}" data-id="{{$per}}" {{ old('organization') == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('organization'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('organization') }}</strong>
                            </span>
                            @endif
                            <label for="user-type-select">Select Role<span class="text-danger">*</span></label> --}}
            </div>
            <!-- <br> -->
            <div id="user-type-wrap"></div>

            <div class="row">
           

                <div class="form-group col-12 col-md-6">
                    <input type="text" class="form-control form-control-lg" id="email" name="RoleName"
                        value="" required data-parsley-required-message="Role Name is required"
                     placeholder=" ">
                    @if ($errors->has('email'))
                        <span class="text-danger" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <label>Enter Role Name<span class="text-danger">*</span></label>
                </div>
            </div>


        

        <div class="row py-3" id="functionality">
            <div class="col-12">
                <div class="table-responsive text-center">
                    <table class="table border-table">
                        <thead>
                            <tr>
                                <th>Functionalities</th>
                                <th>Create</th>
                                <th>Read</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5"></td>
                            </tr>

                            <tr>
                                <td>Maintenance - Catalogues</td>
                                <td>
                                    <input type="checkbox" class="form-check-input" name="permission[]" id="14"
                                        value="14">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="13" value="13">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="15" value="15">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="16" value="16">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>

                            <tr>
                                <td>Maintenance - School District</td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="6" value="6">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="5" value="5">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="7" value="7">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="8" value="8">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td>Maintenance - School</td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="10" value="10">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="9" value="9">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="11" value="11">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="12" value="12">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td>Maintenance - CMC</td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="35" value="35">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="34" value="34">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="36" value="36">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="37" value="37">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td>Maintenance - Circuit</td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="39" value="39">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="38" value="38">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="40" value="40">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="41" value="41">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td>Maintenance - Subplace</td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="43" value="43">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="42" value="42">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="44" value="44">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch" name="permission[]"
                                        id="45" value="45">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td>Manage Funds Requests</td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1" name="permission[]"
                                        id="49" value="49">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 scheck" name="permission[]"
                                        id="50" value="50">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 scheck" name="permission[]"
                                        id="51" value="51">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 scheck" name="permission[]"
                                        id="52" value="52">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>

                                <td>System Admin - Manage Users</td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1" name="permission[]"
                                        id="2" value="2">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1" name="permission[]"
                                        id="1" value="1">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1" name="permission[]"
                                        id="3" value="3">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 " name="permission[]"
                                        id="4" value="4">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td>Reports</td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 scheck" name="permission[]"
                                        id="33" value="33">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch">
                                </td>
                            </tr>

                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td>Dashboard</td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 scheck" name="permission[]"
                                        id="46" value="46">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input check1 sch">
                                </td>
                            </tr>

                            <tr>
                                <td colspan="5"></td>
                            </tr>

                       
                        </tbody>
                    </table>
                    @if ($errors->has('permission'))
                        <span class="text-danger" role="alert">
                            <strong>{{ $errors->first('permission') }}</strong>
                        </span>
                    @endif
                    <span style="display: none;" class="text-danger" id="permissionError" role="alert">
                        <strong>Please tick at least one functionality</strong>
                    </span>
                </div>
            </div>
            <div class="text-end submit-btn">
                <input type="reset" class="btn-reset px-4 fs-3 text-decoration-underline" value="Cancel">
                <input type="hidden" class="mx-4  btn btn-lg btn-primary" id="add_user" name="add_user"
                    data-bs-toggle="modal" data-bs-target="#exampleModal" value="Submit">
                <input type="button"    data-bs-toggle="modal" data-bs-target="#exampleModal" class="mx-4  btn btn-lg btn-primary" name="add_user" 
                    value="Submit">
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="assets/img/popup-check.svg" class="img-fluid" alt="">
                            <h4 class="modal-title">Submit</h4>
                            <p class="modal-title_des">Are you sure you want to submit?</p>
                        </div>

                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary px-5">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </form>
        </div>
    </main>

    <script src="{{ asset('vendor/Nice-Select/js/nice-select2.js') }}"></script>

    <script>
        NiceSelect.bind(document.getElementById("user-type-select"));
        $(document).ready(function() {
            $('#functionality').hide();
            selectorg();
        })

        function loaderscreen() {
            var name = $("#name").val();
            var temp = null;
            var email = $("#email").val();
            if ($("#user-type-select").val() != 2) {
                temp = $("#surname").val();
            } else {
                temp = $("#emis").val();
            }
            if (name != '' && email != '' && temp != '') {
                $('#preloader').removeAttr('style');
            }
        }

        // function selectorg() {
        //     // $('.form-check-input').attr("disabled", false);
        //     getorg();
        //     $('#functionality').show();
        //     // $('.check1').prop("checked", false);
        //     $('#user-type-wrap').html('')
        //     var selection = $("#user-type-select option:selected").val();
        //     switch (selection) {
        //         case "":
        //             $('#functionality').hide();
        //             break;
        //         case "2":
        //             $('#user-type-wrap').append(`
    //             <div class="row">
    //                  <div class="form-group col-12 col-md-6">
    //                     <input type="text"  class="form-control form-control-lg search-input" id="sname" name="name" value="{{ old('name') }}" 
    //                     required data-parsley-required-message="Name is required"
    //                     onfocusout="hideSuggestions()"
    //                         placeholder=" " autocomplete="off">
    //                         <div class="my-2" id="auto_suggestions"></div>


    //                     @if ($errors->has('name'))
    //                     <span class="text-danger" role="alert">
    //                         <strong>{{ $errors->first('name') }}</strong>
    //                     </span>
    //                     @endif
    //                     <label>School Name<span class="text-danger">*</span></label>
    //                 </div>

    //                 <div class="form-group col-12 col-md-6">
    //                     <input type="text" class="form-control form-control-lg" id="emis" name="emis"
    //                      readonly placeholder=" ">
    //                     @if ($errors->has('emis'))
    //                     <span class="text-danger" role="alert">
    //                         <strong>{{ $errors->first('emis') }}</strong>
    //                     </span>
    //                     @endif
    //                     <label>EMIS<span class="text-danger">*</span></label>
    //                 </div>
    //                  <div class="form-group col-12 col-md-6">
    //                     <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" 
    //                     required data-parsley-required-message="Email is required"
    //                     data-parsley-type="email" data-parsley-type-message="The email address is invalid"
    //                      placeholder=" ">
    //                     @if ($errors->has('email'))
    //                     <span class="text-danger" role="alert">
    //                         <strong>{{ $errors->first('email') }}</strong>
    //                     </span>
    //                     @endif
    //                     <label>Email Address<span class="text-danger">*</span></label>
    //                 </div>
    //                 </div>
    //                 `);
        //             // $('.sch').attr("disabled", true);
        //             // $('.scheck').prop("checked", true);
        //             break;
        //         case "3":
        //             $('#user-type-wrap').append(`
    //             <div class="row">
    //                         <div class="form-group col-12 col-md-6">
    //                     <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name') }}" 
    //                     required data-parsley-required-message="Name is required" placeholder=" "
    //                     data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-pattern-message="Name accepts alphabets only">
    //                     @if ($errors->has('name'))
    //                     <span class="text-danger" role="alert">
    //                         <strong>{{ $errors->first('name') }}</strong>
    //                     </span>
    //                     @endif
    //                     <label>Name<span class="text-danger">*</span></label>
    //                 </div>
    //                 <div class="form-group col-12 col-md-6">
    //                     <input type="text" class="form-control form-control-lg" id="surname" name="surname" value="{{ old('surname') }}" 
    //                     required data-parsley-required-message="Surname is required" placeholder=" "
    //                     data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-pattern-message="Surname accepts alphabets only">
    //                     @if ($errors->has('surname'))
    //                     <span class="text-danger" role="alert">
    //                         <strong>{{ $errors->first('surname') }}</strong>
    //                     </span>
    //                     @endif
    //                     <label>Surname<span class="text-danger">*</span></label>
    //                 </div> 
    //                     <div class="form-group col-12 col-md-6">
    //                     <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}"
    //                     required data-parsley-required-message="Email is required"
    //                     data-parsley-type="email" data-parsley-type-message="The email address is invalid" placeholder=" ">
    //                     @if ($errors->has('email'))
    //                     <span class="text-danger" role="alert">
    //                         <strong>{{ $errors->first('email') }}</strong>
    //                     </span>
    //                     @endif
    //                     <label>Email Address<span class="text-danger">*</span></label>
    //                 </div>
    //                 </div>
    //                     `);
        //             break;
        //         case "1":
        //             $('#user-type-wrap').append(`
    //             <div class="row">
    //                         <div class="form-group col-12 col-md-6">
    //                     <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name') }}" 
    //                     required data-parsley-required-message="Name is required" placeholder=" "
    //                     data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-pattern-message="Name accepts alphabets only">
    //                     @if ($errors->has('name'))
    //                     <span class="text-danger" role="alert">
    //                         <strong>{{ $errors->first('name') }}</strong>
    //                     </span>
    //                     @endif
    //                     <label>Name<span class="text-danger">*</span></label>
    //                 </div>
    //                 <div class="form-group col-12 col-md-6">
    //                     <input type="text" class="form-control form-control-lg" id="surname" name="surname" value="{{ old('surname') }}" 
    //                     required data-parsley-required-message="Surname is required" placeholder=" "
    //                     data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-pattern-message="Surname accepts alphabets only">
    //                     @if ($errors->has('surname'))
    //                     <span class="text-danger" role="alert">
    //                         <strong>{{ $errors->first('surname') }}</strong>
    //                     </span>
    //                     @endif
    //                     <label>Surname<span class="text-danger">*</span></label>
    //                 </div> 
    //                     <div class="form-group col-12 col-md-6">
    //                     <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" 
    //                     required data-parsley-required-message="Email is required" 
    //                     data-parsley-type="email" data-parsley-type-message="The email address is invalid" placeholder=" ">
    //                     @if ($errors->has('email'))
    //                     <span class="text-danger" role="alert">
    //                         <strong>{{ $errors->first('email') }}</strong>
    //                     </span>
    //                     @endif
    //                     <label>Email Address<span class="text-danger">*</span></label>
    //                 </div>
    //                 </div>
    //                     `);
        //             break;
        //         default:
        //             $('#functionality').hide();
        //             console.log('sdf');
        //     }
        // }
    </script>

    <script type="text/javascript">
        var $form = $('#userform');

        function validate() {
            var checked = []
            $("input[name='permission[]']:checked").each(function() {
                checked.push(parseInt($(this).val()));
            });
            $form.parsley().validate()
            if (checked.length > 0) {
                $("#permissionError").css('display', 'none')
                if ($form.parsley().validate()) {
                    $('#add_user').click()
                }
            } else {
                $("#permissionError").removeAttr('style')
                console.log('invalid');
            }
        }
    </script>
    @if ($message = Session::get('error'))
        <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    <script>
        function hidePopup() {
            $("#exampleModal").fadeOut(200);
            $('.modal-backdrop').remove();
            console.log("hidePop")
        }

        function hideSuggestions() {
            setTimeout(() => {
                $("#auto_suggestions").hide()
            }, 300);

        }
    </script>

    <script></script>
@endsection
