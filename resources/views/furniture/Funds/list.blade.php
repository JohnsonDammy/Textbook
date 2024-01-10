@extends('layouts.layout')
@section('title', 'Manage Funding')
@section('content')
    <main>
        <style>
            .check {
                width: 50px;
                height: 20px;
            }
        </style>
        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center border-bottom border-2">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Manage Funding</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#">Manage Funding Request</a>
                            </li>
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
                                        <h4 class="popup-alert_title">Funds Suceesfully Requested</h4>
                                        <p class="popup-alert_des">{{ $message }}</p>
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
                @if ($message = Session::get('error'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                        <h4 class="popup-alert_title">Manage Request Funding</h4>
                                        <p class="popup-alert_des">{{ $message }}</p>
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
                @if ($message = Session::get('alert'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5"
                                            alt="">
                                        <h4 class="popup-alert_title">Manage Request Funding</h4>
                                        <p class="popup-alert_des">{{ $message }}</p>
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

                    <div class="container">
                        <!-- breadcrumb -->

                        @if ($TextBoookProcument == 'Yes')
                            <form action="{{ route('request.funds') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-12 my-3">
                                        <div class=" bg-light fw-bold py-4 color-primary px-5">
                                            <p class="mb-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="checkbox" onchange="toggleButton()" class="check"
                                                        id="checkbox1" name="Textbook" value="Textbook" required>
                                                    <label for="checkbox1"><b><a
                                                                style="color:blue; text-decoration: underline; "
                                                                href="{{ asset('public/pdf/School-Based Procurement.pdf') }}"
                                                                target="_blank">Read Allocation Circular: <b>PDF</b></a>
                                                        </b><b style="color:brown"></b></label>
                                                </div>

                                            </div>

                                            </p>
                                        </div>
                                    </div>

                                    <input type="hidden" name="broken_items[]" id="broken_array" value="">
                                    <div class="col-12 col-md-12 my-3">
                                        <div class="row g-4">
                                            <div class="form-group col-12 col-md-6 col-xl-3">
                                                <input type="text" name="School" class="form-control form-control-lg"
                                                    disabled required="required" value="{{ Auth::user()->name }}"
                                                    placeholder=" ">
                                                <label>School Name</label>
                                                <input type="hidden" value="{{ Auth::user()->name }}"
                                                    name="SchoolName">
                                            </div>
                                            <div class="form-group col-12 col-md-6 col-xl-3">
                                                <input type="text" name="Emis" class="form-control form-control-lg"
                                                    value="{{ Auth::user()->username }}" disabled required="required"
                                                    placeholder=" ">
                                                <input type="hidden" value="{{ Auth::user()->username }}"
                                                    name="SchoolEmis">
                                                <label>School EMIS Number</label>
                                            </div>
                                            <div class="form-group col-12 col-md-6 col-xl-4">
                                                <input type="text" class="form-control form-control-lg"
                                                    style="box-shadow:0 0 0 0.25rem #7cbf7a" name="TextBookAmount"
                                                    required="required" placeholder="Enter Funds Amount">

                                                <span class="text-danger" style="display: none;" id="counterror"
                                                    role="alert">
                                                    <strong id="counterrormsg">Funds Amount is required</strong>
                                                </span>

                                                <label>Enter Textbook Funds Amount</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4 mb-2">
                                        <button id="requestButton" style="display: none" class="btn" type="button"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                            Request funds now
                                        </button>

                                    </div>
                                    <div class="modal fade" id="exampleModal1" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered popup-alert">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                                            class="img-fluid mb-5" alt="">
                                                        <h4 class="modal-title popup-alert_des fw-bold">Textbook Funds
                                                            Request</h4>
                                                        <p class="modal-title_des">Are you sure of your selection</p>
                                                    </div>

                                                </div>
                                                <div class="modal-footer justify-content-around text-center">
                                                    <button type="button" class="btn btn--dark px-5"
                                                        data-bs-dismiss="modal">No</button>
                                                    <button type="submit" class="btn btn-secondary px-5">Yes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        @elseif($StationaryProcument == 'Yes')
                            <form method="POST" action="{{ route('requestStat.funds') }}" id="">
                                @csrf
                                <div class="row">
                                    <div class="col-12 my-3">
                                        <div class=" bg-light fw-bold py-4 color-primary px-5">
                                            <p class="mb-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    {{-- <input type="checkbox" class="check" id="checkbox1" value="Textbook">
                                    <label for="checkbox1">Stationary Funds :<b>Avaliable Funds Amount :</b><b
                                            style="color:brown">R700,000</b></label> --}}


                                                    <input type="checkbox" onchange="toggleButton()" class="check"
                                                        id="checkbox1" name="Textbook" value="Textbook" required>
                                                    <label for="checkbox1"><b><a
                                                                style="color:blue; text-decoration: underline; "
                                                                href="{{ asset('public/pdf/School-Based Procurement.pdf') }}"
                                                                target="_blank">Read Allocation Circular: <b>PDF</b></a>
                                                        </b><b style="color:brown"></b></label>
                                                </div>
                                            </div>

                                            </p>
                                        </div>
                                    </div>

                                    <input type="hidden" name="broken_items[]" id="broken_array" value="">
                                    <div class="col-12 col-md-12 my-3">
                                        <div class="row g-4">
                                            <div class="form-group col-12 col-md-6 col-xl-3">
                                                <input type="text" class="form-control form-control-lg"
                                                    required="required" value="{{ Auth::user()->name }}" disabled
                                                    placeholder=" ">
                                                <input type="hidden" value="{{ Auth::user()->name }}"
                                                    name="SchoolName">
                                                <label>School Name</label>
                                            </div>
                                            <div class="form-group col-12 col-md-6 col-xl-3">
                                                <input type="text" class="form-control form-control-lg"
                                                    value="{{ Auth::user()->username }}" disabled required="required"
                                                    placeholder=" ">
                                                <input type="hidden" value="{{ Auth::user()->username }}"
                                                    name="SchoolEmis">
                                                <label>School EMIS Number</label>
                                            </div>
                                            <div class="form-group col-12 col-md-6 col-xl-4">
                                                <input type="text" class="form-control form-control-lg"
                                                    name="StationaryFundsAmount" style="box-shadow:0 0 0 0.25rem #7cbf7a"
                                                    required="required" placeholder="Enter Funds Amount">

                                                <span class="text-danger" style="display: none;" id="counterror"
                                                    role="alert">
                                                    <strong id="counterrormsg">Funds Amount is required</strong>
                                                </span>

                                                <label>Enter Stationary Funds Amount</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4 mb-2">
                                        <button id="requestButton" style="display: none" class="btn" type="button"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                            Request funds now
                                        </button>

                                    </div>
                                    <div class="modal fade" id="exampleModal2" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered popup-alert">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                                            class="img-fluid mb-5" alt="">
                                                        <h4 class="modal-title popup-alert_des fw-bold">Stationary Funds
                                                            Request</h4>
                                                        <p class="modal-title_des">Are you sure of your selection</p>
                                                    </div>

                                                </div>
                                                <div class="modal-footer justify-content-around text-center">
                                                    <button type="button" class="btn btn--dark px-5"
                                                        data-bs-dismiss="modal">No</button>
                                                    <button type="submit" class="btn btn-secondary px-5">Yes</button>
                                                </div>
                                            </div>
                                        </div>
                            </form>
                    </div>
                @elseif($NoDeclaration == 'Yes')
                    <!-- Handle other cases or provide a default -->
                    <p>No Declaration for this year.</p>
                @elseif($TextBoookProcument == 'Yes' && $StationaryProcument == 'Yes')
                @else
                    <!-- Handle other cases or provide a default -->
                    <center>
                        <h3>No Request found!!!</h3>
                    </center>
                @endif

            </div>
            <br><br><br>


            <div class="col-12">
                @if ($message = Session::get('searcherror'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $message }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>School</th>
                                <th>Reference No.</th>
                                <th>Status</th>
                                <th>EMIS Number</th>
                                <th>Funds Type</th>
                                <th>Amount Request</th>
                                <th>Status</th>
                                <th>Message</th>
                                <th>Date Created</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        {{-- @foreach ($data as $key => $value) --}}

                        <tbody>

                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->School_Name }}</td>
                                    <td>{{ $item->References_Number }}</td>
                                    <td>{{ $item->Status }}</td>
                                    <td>{{ $item->School_Emis }}</td>
                                    <td>{{ $item->RequestType }}</td>
                                    <td>{{ $item->FundsAmount }}</td>
                                    <td>{{ $item->Status }}</td>
                                    <td>{{ $item->Message }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>
                                        <i class="ri-pencil-fill"></i>
                                        | <i class="ri-delete-bin-7-fill"></i> 

                                    </td>
                                </tr>
                            @endforeach


                        </tbody>

                    </table>
                </div>
                <nav class="pagination-wrap">
                    <ul class="pagination">
                        <li class="page-item ">
                            <a class="" href="#">
                                <i class="ri-arrow-left-s-line me-4"></i>
                                Previous</a>
                        </li>

                        <li class="page-item">
                            <a class="" href="#">Next
                                <i class="ri-arrow-right-s-line ms-4"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
  
      </div>
    </main>
    </div>
    </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    @if ($message = Session::get('error'))
        <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    @if ($message = Session::get('alert'))
        <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    <script>
        function hidePopup() {
            $("#exampleModal").fadeOut(200);
            $('.modal-backdrop').remove();
            console.log("hidePop")
        }

        $(function() {
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();

            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;
            $('.dates').attr('max', maxDate);
        });
    </script>

    <script>
        function toggleButton() {
            var checkbox = document.getElementById('checkbox1');
            var requestButton = document.getElementById('requestButton');

            if (checkbox.checked) {
                requestButton.style.display = 'block';
            } else {
                requestButton.style.display = 'none';
            }
        }
    </script>
    </main>
@endsection
