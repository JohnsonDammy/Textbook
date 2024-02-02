@extends('layouts.layout')
@section('title', 'School delivery list')
@section('content')

    @php
        $OutStandingAmount = 0;
        $isFinale ="";
     
    @endphp
    <!-- main -->
    <main>
        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>School Delivery lists </h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            {{-- <li class="breadcrumb-item"><a href="{{ route('school-maintenance') }}">School Maintenance</a></li> --}}
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Delivery List</a></li>
                        </ol>
                    </div>
                </div>
                {{-- <div class="offset-xl-3 col-12 col-md-4 col-xl-2 mb-3">
                <a href="{{ route('delivery.Add') }}" class="btn btn-primary w-100">+ Add New delivery</a>
            </div> --}}
            <div class="col-12 col-md-12 my-3">
                <p class="filter-title">Transactions Search</p>
                <form method="get" action="/TransactionSearch">
                    <div class="row justify-content-center align-items-center g-4">
                        <div class="col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control rounded-0" name="ref_number" placeholder="Reference Number">
                        </div>
    
                        <div class="col-12 col-md-6 col-xl-6">
                            <input type="text" class="form-control search-input rounded-0" name="school_name" placeholder="School Name">
                        </div>
                        {{-- <div class="col-12 col-md-6 col-xl-3">
                            <select class="form-select form-control rounded-0" name="status_id" aria-label="Default select example">
                                <option selected value="">Status</option>
                                <option value="Complete">Complete</option>
                                <option value="Pending">Pending</option>

                            </select>
                        </div> --}}

                        <div class="col-12 col-md-6 col-xl-3">
                            <select class="form-select form-control rounded-0" name="RequestType" aria-label="Default select example" >
                                <option selected value="">Request Type</option>
                                <option value="Textbook">Textbook</option>
                                <option value="Stationery">Stationery</option>

                            </select>
                        </div>
             
                        <div class="col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control rounded-0" name="emis" placeholder="EMIS Number" >
                        </div>
                        <div class="col-6 col-md-6 col-xl-1 text-end">

                            <a type="reset" href="{{ route('AdminDelivery.list') }}" class="btn-reset px-4 text-decoration-underline" value="Clear">Clear </a>
                     
                        </div>
                        <div class="col-6 col-md-6 col-xl-2">
                            <input type="submit" class="btn btn-primary w-100 " value="Search">
                        </div>
                    </div>
                    @if(isset($messages))
                        <p>{{ $messages }}</p>
                    @endif
                </form>
            </div>
            </div>

            <div class="row">

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

                @if ($message = Session::get('error'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                        <h4 class="popup-alert_title">School Maintenance - School Circuit</h4>
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
                                        <h4 class="popup-alert_title">School Maintenance - School Circuit</h4>
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
                <div class="col-12">
                    @if ($message = Session::get('searcherror'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                        </div>
                    @endif
                    {{-- INSERT INTO `suppliyer`(`Id`, `email`, `CompanyName`, `CompanyAddress`, `CompanyContact`, `ISActive`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]') --}}
                    <div class="table-responsive">
                        {{-- <form class="" method="get" action="{{ route('CaptureData') }}">
                        @csrf() --}}


                        <table class="table">
                            <thead>
                                <tr>
                                    <th>References No</th>
                                    <th>School Name</th>
                                    <th>Emis</th>
                                    <th>Request Type</th>
                                    <th>Order Amount</th>
                                    <th>Delivered Amount</th>
                                    <th><div class="short-text" title="Outstanding Amount">
                                        {{ Str::limit('O / A', 40) }}
                                    </div></th>
                                    <th>Status</th>

                                    <th>Manage</th>
                                </tr>
                            </thead>
                            @if (isset($data) && count($data) < 1)
                                <tbody>
                                    <tr class="text-center text-dark">
                                        <td colspan="7">No delivery Found</td>
                                    </tr>
                                </tbody>
                            @else
                                @foreach ($data as $key => $delivery)
                                    <tbody>
                                        <tr>
                                            <td>{{ $delivery->References_Number }}</td>
                                            <td>{{ $delivery->name }}</td>
                                            <td>{{ ucwords($delivery->emis) }}</td>
                                            <td>{{ $delivery->RequestType }}</td>
                                            @php
                                                $orderedAmt = $quotesData
                                                    ->where('Emis', $delivery->emis)
                                                    ->where('requestType', $delivery->RequestType)
                                                    ->first(); // Use first() to get the first matching item

                                                // Check if $orderedAmt is not null before accessing the "ordered_amt" attribute
                                                $orderedAmtValue = $orderedAmt ? $orderedAmt->ordered_amt : null;

                                            @endphp
                                            <td>

                                                @if ($delivery->RequestType === "Textbook")
                                                R {{ number_format($orderedAmtValue, 2, '.', ',') }}

                                                @else

                                                {{-- // $OrdAmountSum = savedstationeryitems::where('school_emis', session('Newemis'))
                                                // ->sum('TotalPrice'); --}}
                                                @php
                                                    $OrdAmountSum = $AllOrderAmount ->where('school_emis', $delivery->emis)->sum('TotalPrice')
                                                @endphp
                                                R {{ number_format($OrdAmountSum, 2, '.', ',') }}

                                                @endif

                                            </td>
                                            @php
                                                $sumDeliveryAmt = $deliveryData
                                                    ->where('emis', $delivery->emis)
                                                    ->where('RequestType', $delivery->RequestType)
                                                    ->sum('TotalCaptureQuantityAmount');
                                             
                                                // Check if $orderedAmt is not null before accessing the "ordered_amt" attribute
                                              
                                            @endphp
                                            <td> R {{ number_format($sumDeliveryAmt, 2, '.', ',') }}</td>
                                            <td>
                                                @php
                                                    // $OutStandingAmount = $OrderAmount - $delivery->TotalAmount
                                                @endphp
                                                <span style="color:red">
                                                    @php
                                                        $OutStandingAmout = $orderedAmtValue- $sumDeliveryAmt;
                                                    @endphp
                                                     
                                                     @if($sumDeliveryAmt==0) 
                                                       N/A
                                                     @else
                                                        @if ($delivery->RequestType === "Textbook")
                                                        R {{ number_format($orderedAmtValue-$sumDeliveryAmt, 2, '.', ',') }}

                                                        @else
                                                        R {{ number_format($OrdAmountSum-$sumDeliveryAmt, 2, '.', ',') }}

                                                        @endif

                                                    @endif
                                                </span>

                                            </td>
                                            <td>

                                                @php
                                                $deliveryRecord = $deliveryData
                                                    ->where('RequestType', $delivery->RequestType)
                                                    ->where('emis', $delivery->emis)
                                                    ->where('isFinal', 'Yes')
                                                    ->first();
                                                
                                                $isFinal = optional($deliveryRecord)->isFinal; // Use optional to handle null case
                                            @endphp
                                    
                                            @if ($isFinal === "Yes")
                                                Complete
                                            @else
                                                Pending
                                            @endif
                                          
                                            </td>


                                            <td>
                                                <form class="" method="get"

                                                    action="{{ route('CaptureDataDelivery', ['refNo' => $delivery->References_Number, 'requestType' => $delivery->RequestType, 'idInbox' => '1', 'emis_new' => $delivery->emis]) }}">
                                                    <input type="hidden" name="emis"
                                                        value="{{ ucwords($delivery->emis) }}">
                                                    <input type="hidden" name="RequestType"
                                                        value="{{ $delivery->RequestType }}">

                                                      @if ($isFinal === "Yes")
                                                        <button type="submit" disabled>View Delivery Note</button>

                                                        @else
                                                        <button type="submit">View Delivery Note</button>

                                                        @endif
                                                </form>



                                                {{-- <div class="d-flex justify-content-end">
                                            <a href="{{ route('schooldelivery.edit', ['id' => $delivery->Id]) }}" class="color-primary me-4 fs-2">
                                                <i class="ri-pencil-fill"></i>
                                            </a>

                                            <form action="{{  route('schooldelivery.destroy') }}" method="POST">
                                                @csrf()

                                                <input type="hidden" name="DelVal" value="{{ $delivery->Id }}">

                                                <!-- Button trigger modal -->
                                                <button class="btn-reset" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$delivery->Id}}">
                                                    <i class="ri-delete-bin-7-fill"></i>
                                                </button>

                                                <div class="modal fade" id="exampleModal{{$delivery->Id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered popup-alert">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5" alt="">
                                                                    <h4 class="modal-title popup-alert_des fw-bold">Delete</h4>
                                                                    <p class="modal-title_des">Are you sure you want to delete?</p>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer justify-content-around text-center">
                                                                <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                                                                <button type="submit" class="btn btn-primary px-5">Yes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div> --}}
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @endif
                        </table>
                    </div>
                    <nav class="pagination-wrap">
                        <ul class="pagination">
                            <li class="page-item ">
                                <a class="{{ $data->previousPageUrl() ? '' : 'disabled' }}"
                                    href="{{ $data->previousPageUrl() }}">
                                    <i class="ri-arrow-left-s-line me-4"></i>
                                    Previous</a>
                            </li>

                            <li class="page-item">
                                <a class="{{ $data->nextPageUrl() ? '' : 'disabled' }}"
                                    href="{{ $data->nextPageUrl() }}">Next
                                    <i class="ri-arrow-right-s-line ms-4"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
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
            }
        </script>
    </main>
@endsection
