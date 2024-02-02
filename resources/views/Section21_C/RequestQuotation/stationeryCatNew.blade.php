@extends('layouts.layout')
@section('title', 'Manage Stationery Catalogue')
@section('content')
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
                        <h4>Manage Catologue</h4>
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a
                                    href="{{ route('stationeryCatNew', ['requestType' => 'Stationery', 'idInbox' => 1]) }}">Stationery
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

                @if (session('quoteStatus') == "Allocated Funds" )
                <a href="#" class="tab-link active {{ session('activeTab') == 'tab2' ? 'active' : '' }}"
                    data-tab="tab2" data-toggle="2">Stationery Catalogue</a>
                @endif


                <a href="#" class="tab-link {{ session('activeTab') == 'tab3' ? 'active' : '' }}" data-tab="tab3"
                    data-toggle="3">View Items</a>

                <!-- Your tab content here -->
                @if (session('quoteStatus') == "Allocated Funds" )
                <div class="tab-content " data-toggle="2" id="tab2" id="textbooks-container">
                    <div class="col-12 col-md-12 my-3">

                        @if (session('quoteStatus') == 'Quote Created')
                            <br>
                            <p style="color: red; font-weight: bold;"> Please note quote has been created for
                                {{ date('Y') }}. All actions on this form has been disabled. </p>
                            <br>
                        @endif


                        <form action="{{ route('searchStationery') }}" method="get">
                            <div class="row justify-content-center align-items-center g-4">



                                <div class="form-group col-12 col-md-6 col-xl-3">
                                    <input type="text" name="searchKeyword" class="form-control form-control-sm"
                                        value="" placeholder=" ">
                                    <label>Enter a keyword</label>


                                </div>


                                <div class="col-3 col-sm-6 col-xl-1" style=" max-width: 4%">
                                    <a type="reset"
                                        href="{{ route('stationeryCat', ['requestType' => $requestType, 'idInbox' => $idInbox]) }}"
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
                        <form id="saveItemsForm" action="{{ route('saveCheckedItemsStatNew') }}" method="post">
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


                                        </tr>
                                    </thead>


                                    @if (count(session('dataSavedStationeryNew')) < 1)
                                        <tbody>
                                            <tr class="text-center text-dark small">
                                                <td colspan="9">There is no records that matches your filter criteria
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody>
                                            @foreach (session('dataSavedStationeryNew') as $item)
                                                <tr class="pt-1 px-1">
                                                    <td>

                                                        <input type="checkbox" class="checkbox"
                                                            id="Checkbox_{{ $item->item_code }}" name="selectedItems[]"
                                                            @if ($dataSavedStationeryNew->contains('item_code', $item->item_code)) @if ($dataSavedStationeryNew->where('school_emis', $emis)) checked @endif
                                                            @endif
                                                        value="{{ $item->item_code }}"
                                                        @if (session('quoteStatus') == 'Quote Created') disabled @endif>




                                                    </td>
                                                    <td> {{ $item->item_code }} </td>
                                                    <td class="col-md-4">
                                                        <div class="short-text" title="{{ $item->item_title }}">
                                                            {{ Str::limit($item->item_title, 40) }}
                                                        </div>

                                                    </td>
                                                    <td>R {{ number_format( $item->price, 2, '.', ',') }}</td>

                                                    <td>

                                                        <input type="number"
                                                            class="form-control input-sm quantity-input input"
                                                            name="selectedQuantities[{{ $item->item_code }}]"
                                                            id="Quantity_{{ $item->Id }}"
                                                            style="box-shadow: 0 0 0 0.25rem #7cbf7a; width: 60px; height: 20px;"
                                                            min="0" required
                                                            @if ($dataSavedStationeryNew->contains('item_code', $item->item_code)) @if ($dataSavedStationeryNew->where('school_emis', $emis))
                                                                value="{{ $dataSavedStationeryNew->where('item_code', $item->item_code)->first()->Quantity }}" @endif
                                                            @endif
                                                        @if ($dataSavedStationeryNew->contains('item_code', $item->item_code)) enabled 
                                                            @else
                                                                disabled @endif
                                                        @if (session('quoteStatus') == 'Quote Created') disabled @endif
                                                        onblur="validateInput(this)">
                                                        </span>


                                                    </td>



                                                </tr>
                                            @endforeach


                                        </tbody>

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

                                                    <a class="{{ session('dataSavedStationeryNew')->previousPageUrl() ? 'next-page-link' : 'disabled' }}"
                                                        href="#">

                                                        <input type="hidden" name="previousPage" value="">
                                                        <button type="submit" class="page-link" id="PreviousButton">
                                                            <i class="ri-arrow-left-s-line me-4"></i>
                                                            Previous
                                                        </button>
                                                    </a>
                                                </li>
                                                @php
                                                    $currentPage = session('dataSavedStationeryNew')->currentPage();
                                                    $totalPages = session('dataSavedStationeryNew')->lastPage();
                                                @endphp
                                                <center style="margin-right: -60px; margin-top: 10px;">
                                                    Page: {{ $currentPage }}/{{ $totalPages }}
                                                </center>
                                                <li class="page-item">
                                                    <a class="{{ session('dataSavedStationeryNew')->nextPageUrl() ? 'next-page-link' : 'disabled' }}"
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

                            @endif

                        </form>
                    </div>

                </div>
               @endif


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
                                <br>
                                @if ($OrdAmountSum > $AllocatedAmt )
                                    <center><span style="color: red"><b>Order amount is greater than allocation funds, kindly please reduce your quantity to continue</b></span></center>
                                @endif
                                <br>
                                <table class="table">
                                    @php
                                        $TotalAccumalated = 0;
                                    @endphp
                                    <thead>
                                        <tr>

                                            <th> Code </th>
                                            <th>Title</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            {{-- <th>Total Price</th> --}}

                                            @if (session('quoteStatus') != 'Quote Created')
                                            {{-- <th> Action </th> --}}
                                            @endif
                                        </tr>
                                    </thead>


                                    @if (count($dataSavedStationeryNew) < 1)
                                        <tbody>
                                            <tr class="text-center text-dark">
                                                <td colspan="9">There is no saved Items to be displayed.
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody>
                                            @foreach ($dataSavedStationeryNew as $item)
                                                <tr>

                                                    <td> {{ $item->item_code }} </td>
                                                    <td> {{ $item->item_title }} </td>
                                                    <td>R {{ number_format( $item->price, 2, '.', ',') }}</td>
                                                    <td> {{ $item->Quantity }} </td>
                                                    @php
                                                        $TotalAccumalated = $TotalAccumalated + $item->TotalPrice;
                                                    @endphp
                                                    {{-- <td> R {{ number_format($item->TotalPrice, 2, '.', ',') }} </td> --}}

                                                    @if (session('quoteStatus') != 'Quote Created')
                                                    {{-- <td>
                                                        <form
                                                            action="{{ route('StationeryItemDelete')}}"
                                                            method="POST">
                                                          @csrf

                                                                <input type="hidden" name="DelID" value="{{$item->Id}}">


                                                            <button class="btn-reset"
                                                                @if (session('quoteStatus') == 'Quote Created') disabled @endif
                                                                type="submit">
                                                                <i class="ri-delete-bin-7-fill"></i>
                                                            </button>

                                                        </form>

                                                    </td> --}}
                                                    @endif
                                                </tr>
                                            @endforeach
                                    @endif



                                    </tbody>

                                </table>
                                <center>


                                    <form id="saveItemsForm" action="{{ route('submitSavedItemsNew') }}" method="post">
                                        @csrf

                                        <button @if ($OrdAmountSum >  $AllocatedAmt) disabled @endif
                                            class="btn btn-primary btn-sm" id="sumitbuttton" type="button"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal5">
                                            SUBMIT & CLOSE
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
                                                                these items for Approval</p>
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
                    document.getElementById("submitFormButton").disabled= false;

                } else {

                    input.style.boxShadow = '0 0 0 0.25rem red';
                    document.getElementById("submitFormButton").disabled= true;
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

                @if (session('quoteStatus') != "Allocated Funds" )
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
