@extends('layouts.layout')
@section('title', 'Stationery Capturing')
@section('content')

    @php
        $dummyPrice = 100;

        $totalLoops = 0;
        $totalPriceForSchool = 0;
        $totalPriceCapturedQuantity = 0;
        $statement = '';
    @endphp
    <main>

        <style>
            .tab-content {
                display: none;
            }

            .buttonGenerate {
                display: inline-block;
                padding: 2px 2px;
                /* Adjust the padding for the desired height */
                text-decoration: none;
                color: #14A44D;
                /* Text color for the active tab */

                /* Blue text color for inactive tabs */
            }

            #PreviousButton {
                color: black;
            }

            #NextButton {
                color: black;
            }

            .tab-button {
                background-color: #f0f0f0;
                border: 1px solid #ccc;
                padding: 10px;
                cursor: pointer;
            }

            .tab-button:hover {
                background-color: #ddd;
            }

            .short-text {
                max-height: 3em;
                /* Set the maximum height for the shortened view */
                overflow: hidden;
            }

            .full-text {
                display: none;
            }


            input[type="checkbox"] {
                width: 20px;
                height: 15px;
            }

            .custom-table tbody tr {
                height: 10px;
                /* Adjust the height as needed */
            }


            /* Style for the tab links */
            .tab-link {
                display: inline-block;
                padding: 10px 20px;
                /* Adjust the padding for the desired height */
                text-decoration: none;
                color: #14A44D;
                /* Blue text color for inactive tabs */
            }

            /* Style for the active tab link (tab-like appearance) */
            .tab-link.active {
                background-color: #14A44D;
                /* Background color of the active tab */
                color: #fff;
                /* Text color for the active tab */
                border-top-left-radius: 5px;
                border-top-right-radius: 5px;
            }

            /* Optional: Hover effect for the active tab link */
            .tab-link.active:hover {
                background-color: #14A44D;
                /* Darker blue on hover for the active tab */
            }

            /* Hide the up and down arrows on number input */
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type="number"] {
                -moz-appearance: textfield;
            }

            /* Hide the arrows in Firefox */
            input[type="number"] {
                -moz-appearance: textfield;
            }

            /* Additional styling if needed */
            input[type="number"] {
                padding-right: 0;
                /* Adjust as needed */
            }
        </style>
        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center border-bottom border-2">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Manage Stationary</h4>
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a
                                    href="{{ route('stationeryCat', ['requestType' => 'Stationery', 'idInbox' => 1]) }}">Stationery
                                    Catalogue</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('inboxSchool') }}">Inbox</a></li>

                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">

                                <div class="spinner-container" id="spinner">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <p> LOADING.. </p>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="tabs">

                <a href="#" class="tab-link {{ session('activeTab') == 'tab1' ? 'active' : '' }}" data-tab="tab1"
                    data-toggle="1">Capture Delivery Note</a>

                <a href="#" class="tab-link active {{ session('activeTab') == 'tab2' ? 'active' : '' }}"
                    data-tab="tab2" data-toggle="2">Stationery Catalogue</a>


                <a href="#" class="tab-link {{ session('activeTab') == 'tab3' ? 'active' : '' }}" data-tab="tab3"
                    data-toggle="3">View Items</a>

                <!-- Your tab content here -->

                <div class="tab-content" data-toggle="1" id="tab1">

                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>RequestType</th>
                            <th>Delivery Note</th>
                            <th>Date</th>
                        </tr>
                        @if (count(session('dataNewStat')) < 1)

                            <tr class="text-center text-dark">
                                <td colspan="7">No Delivery Note Found</td>
                            </tr>
                            </tbody>
                        @else
                            @foreach (session('dataNewStat') as $key => $delivery)
                                <tbody>
                                    <td>{{ $delivery->Id }}</td>
                                    <td>{{ $delivery->RequestType }}</td>

                                    <td>
                                        @if ($delivery->FilePath)
                                            <a href="{{ asset('public/Delivery/' . $delivery->FilePath) }}" download>
                                                <i class="fa fa-download"></i> Download File
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <td>{{ $delivery->date }}</td>

                                </tbody>
                            @endforeach
                        @endif

                    </table>
                </div>

                <div class="tab-content " data-toggle="2" id="tab2" id="textbooks-container">
                    <div class="col-12 col-md-12 my-3">

                        @if (session('quoteStatus') == 'Quote Created')
                            <br>
                            <p style="color: red; font-weight: bold;"> Please note quote has been created for
                                {{ date('Y') }}. All actions on this form has been disabled. </p>
                            <br>
                        @endif


                        <form action="{{ route('searchStationeryAdmin') }}" method="get">
                            <div class="row justify-content-center align-items-center g-4">



                                <div class="form-group col-12 col-md-6 col-xl-3">
                                    <input type="text" name="searchKeyword" class="form-control form-control-sm"
                                        value=" {{ old('searchWord', $searchWord) }}" placeholder=" ">
                                    <label>Enter a keyword</label>


                                </div>






                                <div class="col-3 col-sm-6 col-xl-1" style=" max-width: 4%">
                                    <a type="reset"
                                        href="{{ route('CaptureData', ['requestType' => 'Stationery', 'idInbox' => '1', 'emis_new' => session('Newemis')]) }}"
                                        class="text-decoration-underline" value="Clear">Clear</a>
                                </div>

                                <div class="col-6 col-sm-9 col-xl-2">
                                    <input type="submit" class="btn btn-primary w-100"
                                        @if (session('quoteStatus') == 'Quote Created') disabled @endif value="Search">
                                </div>
                            </div>
                        </form>


                        <br>
                        {{--  @if (session('activeTab') != 'tab3')
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                </div>
                            @elseif ($message = Session::get('failed'))
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @endif
                        @endif --}}
                        <form id="saveItemsForm" action="{{ route('saveCheckedItemsStatStionery') }}" method="post">
                            @csrf
                            <input type="hidden" name="UncheckedItems" value="">

                            <div>
                                <table class="table">
                                    <thead>
                                        <tr>

                                            <th> </th>
                                            <th> Code </th>
                                            <th> Name </th>
                                            <th> Unit Price</th>
                                            <th> Quantity </th>
                                            <th>Captured Quantity </th>

                                        </tr>
                                    </thead>


                                    @if (count(session('stationeryCat')) < 1)
                                        <tbody>
                                            <tr class="text-center text-dark small">
                                                <td colspan="9">There is no records that matches your filter criteria
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody>
                                            @foreach (session('stationeryCat') as $item)
                                                <tr class="pt-1 px-1">
                                                    <td>

                                                        <input type="checkbox" class="checkbox"
                                                            id="Checkbox_{{ $item->Id }}" name="selectedItems[]"
                                                            @if (session('dataSavedStationery')->contains('ItemCode', $item->item_code)) @if (session('dataSavedStationery')->where('Emis', session('Newemis'))) checked @endif
                                                            @endif

                                                        value="{{ $item->Id }}"
                                                        @if (session('quoteStatus') == 'Quote Created') disabled @endif>

                                                    </td>
                                                    <td> {{ $item->item_code }} </td>
                                                    <td class="col-md-4">
                                                        <div class="short-text" title="{{ $item->item_title }}">
                                                            {{ Str::limit($item->item_title, 40) }}
                                                        </div>

                                                    </td>
                                                    <td>100,00</td>

                                                    <td>

                                                        <input type="number"
                                                            class="form-control input-sm quantity-input input"
                                                            name="selectedQuantities[{{ $item->Id }}]"
                                                            id="Quantity_{{ $item->Id }}"
                                                            style="box-shadow: 0 0 0 0.25rem #7cbf7a; width: 60px; height: 20px;"
                                                            min="0" required
                                                            @if (session('dataSavedStationery')->contains('ItemCode', $item->item_code)) @if (session('dataSavedStationery')->where('Emis', session('Newemis'))) checked @endif
                                                            @endif

                                                        value="{{ $item->Quantity }}">


                                                        </span>


                                                    </td>

                                                    <td><input type="number"
                                                            class="form-control input-sm quantity-input input"
                                                            name="CaptureQuantity[{{ $item->Id }}]"
                                                            id="Quantity_{{ $item->Id }}"
                                                            style="box-shadow: 0 0 0 0.25rem #7cbf7a; width: 60px; height: 20px;"
                                                            min="0"
                                                            @if (session('dataSavedStationery')->contains('ItemCode', $item->item_code)) @if (session('dataSavedStationery')->where('Emis',session('Newemis')) )
                                                        value="{{ session('dataSavedStationery')->where('ItemCode', $item->item_code)->first()->Captured_Quantity }}" checked @endif
                                                            @endif
                                                        @if (session('dataSavedStationery')->contains('ItemCode', $item->item_code)) enabled 
                                                    @else
                                                        disabled @endif
                                                        ></td>




                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif
                                </table>
                                <style>
                                    .pagination-wrap a {
                                        margin-right: -70px;
                                        /* Adjust this value to add more or less space */
                                    }

                                    .pagination-wrap a:last-child {
                                        margin-right: 70;
                                        /* Remove margin from the last link to avoid extra space */
                                    }
                                </style>
                                <div id="pagination-links">
                                    <center>
                                        <nav class="pagination-wrap">
                                            <ul class="pagination">
                                                <li class="page-item ">

                                                    <a class="{{ session('stationeryCat')->previousPageUrl() ? 'next-page-link' : 'disabled' }}"
                                                        href="#">

                                                        <input type="hidden" name="previousPage" value="">
                                                        <button type="submit" class="page-link" id="PreviousButton">
                                                            <i class="ri-arrow-left-s-line me-4"></i>
                                                            Previous
                                                        </button>
                                                    </a>
                                                </li>
                                                @php
                                                    $currentPage = session('stationeryCat')->currentPage();
                                                    $totalPages = session('stationeryCat')->lastPage();
                                                @endphp
                                                <center style="margin-right: -60px; margin-top: 10px;">
                                                    Page: {{ $currentPage }}/{{ $totalPages }}
                                                </center>
                                                <li class="page-item">
                                                    <a class="{{ session('stationeryCat')->nextPageUrl() ? 'next-page-link' : 'disabled' }}"
                                                        href="#">

                                                        <input type="hidden" name="nextPage" value="">
                                                        <button type="submit" class="page-link" id="NextButton">
                                                            <i class="ri-arrow-right-s-line ms-4"></i>
                                                            Next
                                                        </button>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </center>
                                </div>

                                <center>
                                    <div class="row justify-content-center align-items-center g-4"
                                        style="margin-right: -90px;">
                                        <div class="col-6 col-md-6 col-xl-2">
                                            <input type="submit" id="submitFormButton" class="btn btn-primary btn-sm"
                                                value="Save & Continue" @if (session('quoteStatus') == 'Quote Created') disabled @endif>

                                        </div>
                                    </div>
                                </center>

                            </div>

                        </form>
                    </div>

                </div>



                <div class="tab-content" data-toggle="3" id="tab3">

                    <div class="col-12 col-md-12 my-3" id="textbooks-container">

                        <div class="row justify-content-center align-items-center g-4">
                            <br><br>

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                </div>
                            @elseif ($message = Session::get('failed'))
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table">
                                    @php
                                        $TotalAccumalated = 0;
                                    @endphp
                                    <thead>
                                        <tr>

                                            <th> Code </th>
                                            <th>Title</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Capture Quantity</th>

                                            @if (session('quoteStatus') != 'Quote Created')
                                                <th> Action </th>
                                            @endif
                                        </tr>
                                    </thead>


                                    @if (count(session('dataSavedStationery')) < 1)
                                        <tbody>
                                            <tr class="text-center text-dark">
                                                <td colspan="9">There is no saved Items to be displayed.
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody>
                                            @foreach (session('dataSavedStationery') as $item)
                                                <tr>

                                                    <td> {{ $item->ItemCode }} </td>
                                                    <td> {{ $item->Item }} </td>
                                                    {{-- {{ $item->UnitPrices }} --}}
                                                    <td> {{ $dummyPrice }} </td>
                                                    <td> {{ $item->Quantity }} </td>
                                                    {{-- @php
                                                        $TotalAccumalated = $TotalAccumalated + $item->TotalPrice;
                                                    @endphp
                                                    <td> R {{ number_format($item->TotalPrice, 2, '.', ',') }} </td> --}}
                                                    <td>{{ $item->Captured_Quantity }}</td>

                                                    @if (session('quoteStatus') != 'Quote Created')
                                                        <td>
                                                            <form
                                                                action="{{ route('StationeryItemDeleteNEW', ['deleteId' => $item->id]) }} "
                                                                method="POST">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token"
                                                                    value="{{ csrf_token() }}">

                                                                <button class="btn-reset"
                                                                    @if (session('quoteStatus') == 'Quote Created') disabled @endif
                                                                    type="submit">
                                                                    <i class="ri-delete-bin-7-fill"></i>
                                                                </button>

                                                            </form>

                                                        </td>
                                                    @endif



                                                </tr>

                                                @php
                                                    $price = (float) str_replace(['R', ',', ' '], '', 100);
                                                    $Quantity = $item->Quantity;
                                                    $totalPriceForSchool = $price * $Quantity;
                                                @endphp

                                                @php
                                                    $price = (float) str_replace(['R', ',', ' '], '', 100);
                                                    $Quantity = $item->Captured_Quantity;
                                                    $totalPriceCapturedQuantity = $price * $Quantity;
                                                @endphp
                                            @endforeach
                                    @endif
                                    @php
                                        if ($totalPriceCapturedQuantity > $totalPriceForSchool) {
                                            $statement = 'The total Captured Quantity Amount is greater than order amount';
                                        }
                                    @endphp


                                    </tbody>
                                    <center><label><b>School Total Amount: </b> <b
                                                style="color:blue">R{{ $totalPriceForSchool }}</b> </label> &nbsp; &nbsp;
                                        <label><b>Total Captured Quantity Amount:</b> <b
                                                style="color:green">R{{ $totalPriceCapturedQuantity }}</b> &nbsp; &nbsp;
                                            <label><b>Statement:</b> <b style="color:red">{{ $statement }}</b></label>

                                </table>


                                <center>

                                    @if (count($dataSavedStationery) > 1)
                                        {{--    <table class="table">
                                            <thead>
                                                <tr>

                                                    @if (session('quoteStatus') != 'Quote Created')
                                                    <th> Action </th>
                                                    @endif
                                                  
                                                    <th>View</th>
                                                  
                                                    @if (session('quoteStatus') != 'Quote Created')
                                                    <th>Status</th>
                                                    @endif
                                                    <th>Number Of Pages</th>
                                                    <th>Total </th>

                                                    @if (session('quoteStatus') != 'Quote Created')
                                                    <th>Delete</th>
                                                    @endif

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr class="pt-1 px-1">
                                                    @if (session('quoteStatus') != 'Quote Created')
                                                    <td>
                                                        <form action=" {{ route('generateQuoteStationery') }} "
                                                            method="post" onsubmit="setInProgress()">
                                                            @csrf
                                                            <input type="submit" class="buttonGenerate"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                @if (session('quoteStatus') == 'Quote Created' || session('status') == 'Generated') disabled @endif
                                                                value="Generate Quote">
                                                        </form>




                                                        <!-- Progress Bar -->

                                                    </td>
                                                    @endif

                                                    <td>
                                                        <a href="{{ route('viewQuotesStat') }}" target="_blank"
                                                            style="color: @if (session('quoteStatus') == 'Quote Created' || session('status') == 'Generated') green @else grey @endif;
                                                          text-decoration: underline; font-style: italic;
                                                          @if (session('quoteStatus') != 'Quote Created' && session('status') != 'Generated') pointer-events: none; @endif">
                                                            View Quote
                                                        </a>


                                                    </td>

                                                    @if (session('quoteStatus') != 'Quote Created')
                                                    <td>
                                                     
                                                        @php
                                                            if (session('status') != 'Generated') {
                                                                session(['status' => 'Not Generated']);
                                                            }

                                                        @endphp
                                                        <p id="statusParagraph"> {{ session('status') }} </p>


                                                    </td>
                                                    @endif

                                                    <td>

                                                        @if (session('status') != 'Generated')
                                                            <p> 0 </p>
                                                        @else
                                                            <p> {{ session('pages') }} </p>
                                                        @endif



                                                    </td>


                                                    <td class="col-md"
                                                        style="color: {{ $TotalAccumalated > session('AllocatedAmt') ? 'red' : 'green' }}">
                                                        R {{ number_format($TotalAccumalated, 2, '.', ',') }}
                                                    </td>

                                                    @if (session('quoteStatus') != 'Quote Created')
                                                    <td>
                                                        <form action="{{ route('quoteTextbookDeleteStationery') }} "
                                                            method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">

                                                            <button class="btn-reset" type="button"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal{{ $item->id }}">
                                                                <i class="ri-delete-bin-7-fill"></i>
                                                            </button>

                                                            <div class="modal fade" id="exampleModal{{ $item->id }}"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-dialog-centered popup-alert">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <div class="text-center">
                                                                                <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                                                                    class="img-fluid mb-5" alt="">
                                                                                <h4 class="modal-title">Delete</h4>
                                                                                <p class="modal-title_des">Are you sure you
                                                                                    want to delete?</p>
                                                                            </div>

                                                                        </div>
                                                                        <div
                                                                            class="modal-footer justify-content-around text-center">
                                                                            <button type="button"
                                                                                class="btn btn--dark px-5"
                                                                                data-bs-dismiss="modal">No</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary px-5">Yes</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table> --}}
                                    @endif

                                    <form id="saveItemsForm" action="{{ route('submitSavedItems') }}" method="post">
                                        @csrf

                                        <button @if (session('quoteStatus') == 'Quote Created' || count($dataSavedStationery) < 1) disabled @endif
                                            class="btn btn-primary btn-sm" id="sumitbuttton" type="button"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal5">
                                            SUMBIT
                                        </button>

                                        <div class="modal fade" id="exampleModal5" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered popup-alert">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                                                class="img-fluid mb-5" alt="">
                                                            <h4 class="modal-title">SUBMIT</h4>
                                                            <p class="modal-title_des">Are you sure you want to submit
                                                                these items for Quote Generation?</p>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer justify-content-around text-center">
                                                        <button type="button" class="btn btn--dark px-5"
                                                            data-bs-dismiss="modal">No</button>
                                                        <button type="submit" id="sumitbuttton"
                                                            class="btn btn-primary px-5">Yes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <script>
            function validateInput(input) {

                var value = input.value;

                // Check if the value is blank or below 1
                if (value !== '' && parseInt(value) > 0) {
                    // Set the border color to red
                    input.style.boxShadow = '0 0 0 0.25rem #7cbf7a';
                } else {

                    input.style.boxShadow = '0 0 0 0.25rem red';
                }

            }
        </script>

        <script>
            function setInProgress() {
                // Show the spinner
                document.getElementById('spinner').style.display = 'block';

                // Example: Simulating a delay of 5 seconds (5000 milliseconds)
                setTimeout(function() {
                    // Hide the spinner after the process is complete
                    document.getElementById('spinner').style.display = 'none';
                }, 5000);
            }
        </script>

        {{-- Show and Hide Tabs Dynamically --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {


                @if (session('activeTab') != 'tab3')
                    $(".tab-link[data-toggle='2']").addClass('active');
                    $("#tab2").show();
                    localStorage.clear();
                @else
                    $("#tab3").show();
                @endif

                @if (session('quoteStatus') == 'Quote Created')
                    $(".tab-link[data-toggle='3']").addClass('active');
                    $("#tab3").show();
                @endif

                // Hide and show tabs based on the toggle link selected
                $(".toggleLink").click(function() {
                    var toggleId = $(this).data("toggle");

                    // Remove 'active' class from all tab links
                    $(".tab-link").removeClass('active');
                    // Add 'active' class to the clicked tab link
                    $(this).addClass('active');

                    // Hide all tab buttons
                    $(".tab-button").hide();
                    // Show tab buttons with matching toggleId
                    $(".tab-button[data-toggle='" + toggleId + "']").show();

                    $(".tab-button[data-toggle='3']").show();
                });

                $(".tab-link").click(function() {
                    // Remove 'active' class from all tab links
                    $(".tab-link").removeClass('active');
                    // Add 'active' class to the clicked tab link
                    $(this).addClass('active');

                    // Hide all tab content
                    $(".tab-content").hide();

                    // Show the tab content with the corresponding data-tab value
                    $("#" + $(this).data("tab")).show();
                });

            });
        </script>

        {{--  Set next and previous values  --}}
        <script>
            // Get references to the "Previous" and "Next" buttons and the hidden inputs
            var previousButton = document.getElementById('PreviousButton');
            var nextButton = document.getElementById('NextButton');
            var previousPageInput = document.querySelector('input[name="previousPage"]');
            var nextPageInput = document.querySelector('input[name="nextPage"]');

            // Add click event listeners to the "Previous" and "Next" buttons
            previousButton.addEventListener('click', function() {
                // Set the value of the hidden input to 'true' when the "Previous" button is clicked
                previousPageInput.value = 'true';
                nextPageInput.value = 'false'; // Set the "Next" button value to empty
            });

            nextButton.addEventListener('click', function() {
                // Set the value of the hidden input to 'true' when the "Next" button is clicked
                nextPageInput.value = 'true';
                previousPageInput.value = 'false'; // Set the "Previous" button value to empty
            });
        </script>

        {{-- Only enable quantities  when checked  --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {

                // Listen for changes in the checkbox state
                $(".checkbox").change(function() {
                    var input = $(this).closest("tr").find(".input");
                    if (this.checked) {
                        // Checkbox is checked, enable the input
                        input.prop("disabled", false);
                    } else {
                        // Checkbox is unchecked, clear and disable the input
                        //    input.prop("disabled", true);
                        input.val('').prop("disabled", true);

                    }
                });
            });
        </script>

        {{--  When unchecked add ID's to hidden list to be deleted --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var uncheckedItemsInput = document.querySelector('input[name="UncheckedItems"]');
                var checkboxes = document.querySelectorAll('.checkbox');

                checkboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        if (!this.checked) {
                            // If checkbox is unchecked, add the item id to UncheckedItems
                            var itemId = this.value;
                            var uncheckedItems = uncheckedItemsInput.value.split(',').filter(Boolean);

                            if (!uncheckedItems.includes(itemId)) {
                                uncheckedItems.push(itemId);
                            }

                            uncheckedItemsInput.value = uncheckedItems.join(',');
                        }
                    });
                });
            });
        </script>

    @endsection
