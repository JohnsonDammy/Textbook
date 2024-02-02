@extends('layouts.layout')
@section('title', 'Caputure Stationary Unit Price')
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
          <style>
            .recommended-row {
            color: green;
            font-weight: bold;
            }

            .CaptureUnit{
                color:green;
                text-align: center;
                font-weight: bold;
                display: block;
            }
        </style>


        <div class="container">
            <div class="row align-items-center border-bottom border-2">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Capture Unit Price</h4>
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


            <div class="row align-items-center border-bottom border-2">
                <br> <br> <br>
    
                <div class="row">
    
                    <input type="hidden" name="broken_items[]" id="broken_array" value="">
                    <div class="col-12 col-md-12 my-3">
                        <div class="row g-4">
                            <div class="form-group col-12 col-md-6 col-xl-3">
                                <input type="text" name="School" class="form-control form-control-lg" disabled
                                    required="required" value="{{ session('schoolname') }}" placeholder=" ">
                                <label>School Name</label>
                                <input type="hidden" value="{{ session('schoolname') }}" name="SchoolName">
                            </div>
                            <div class="form-group col-12 col-md-6 col-xl-2">
                                <input type="text" name="Emis" class="form-control form-control-lg"
                                    value="{{ session('Emis') }}" disabled required="required" placeholder=" ">
                                <input type="hidden" value="{{ session('Emis') }}" name="SchoolEmis">
                                <label>School EMIS Number</label>
                            </div>
                        </div>
    
                    </div>
    
                </div>
    
    
                <br> <br>
            </div>
    
    
            <div class="card" id="cardSupplier">
                <h5 class="card-header" style ="color:#14A44D">Recommend Captured Suppliers</h5>
                <div class="card-body">
    
    
                    <table class="table">
                        <input type="hidden" name="UncheckedItems" value="">
                        <thead>
                            <tr >
    
                                {{--  <th> </th> --}}
                                <th> Email </th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact No</th>
                                <th> Amount </th>
                                {{-- <th> Mark up (%) </th> --}}
                                <th> Action </th>
    
    
    
    
    
                            </tr>
                        </thead>
    
                        @if (count(session('CapturedData')) < 1)
                            <tbody>
    
                                <tr class="text-center text-dark">
                                    <td colspan="9">Please capture minumum of three suppliers
                                    </td>
                                </tr>
                            </tbody>
                        @else
                            <tbody>
                                @foreach (session('CapturedData') as $item)
       
                                    <tr @if ($item->Recommended === "yes") class="recommended-row" @endif>
    
                                        <td>{{ $item->email }} </td>
                                        <td>{{ $item->CompanyName }} </td>
                                        <td>
                                            <div class="short-text" title="{{ $item->CompanyAddress }} ">
                                                {{ Str::limit($item->CompanyAddress, 40) }}
                                            </div>
                                        </td>
    
                                        <td>{{ $item->CompanyContact }} </td>
    
                                        <td>
    
    
                                            @if ($item->markUp > 27)
                                                <span style="color:red">R
                                                    {{ number_format($item->amount, 2, '.', ',') }}</span>
                                            @else
                                                <span style="color:black">R
                                                    {{ number_format($item->amount, 2, '.', ',') }}</span>
                                            @endif

                                    

                                            @if ($item->Recommended === "yes")
                                            @php
                                                $recommendedAmount = $item->amount; // Set the recommended amount
                                                session(['RecommendedAmout' => $item->amount]);

                                            @endphp
                                            @endif
                                      

    
                                        </td>
    
                                        {{-- <td>
    
    
                                            {{ $item->markUp }}
    
                                        </td> --}}
    
    
                                        <td>
                                            <a href="{{ route('viewSupplierDetails', ['itemId' => $item->savedSupplierID]) }}"
                                                style="color:green; text-decoration: underline; font-style:italic"> View
                                                <a>
                                        </td>
    
                                    </tr>
                                @endforeach
                        @endif
    
    
    
                        </tbody>
    
    
                    </table>
    
                    {{-- Download and upload ef48 --}}
                    {{-- Download and upload comittee PDF  --}}
    
    
                    <i class="fas fa-download" style="color: green;"></i><a href="{{ route('downloadEF58New') }}"
                    style="color:green; text-decoration: underline; font-style: italic;">
                    Download EF58
                </a>
                </div>
            </div>
    
            {{-- Download EF58 --}}
           
<br><br>
<div class="CaptureUnit"> <h3><u>Capture Unit Price below</u>   </h3></div>
<br><br>


            <form action="{{ route('searchStationeryNew') }}" method="get">
                <div class="row justify-content-start align-items-center g-4">



                    <div class="form-group col-3 col-md-6 col-xl-3">
                        <input type="text" name="searchKeyword" class="form-control form-control-sm" value=""
                            placeholder=" ">
                        <label>Enter a keyword</label>


                    </div>

                    <div class="col-3 col-sm-6 col-xl-1" style=" max-width: 4%">
                        <a type="reset"
                            href="{{ route('AdminCaptureStatUnitPrice', ['RequestTypes' => $RequestTypes, 'Emis' => $Emis, 'fundsId' => $fundsId]) }}"
                            class="text-decoration-underline" value="Clear">Clear</a>
                    </div>

                    <div class="col-3 col-sm-9 col-xl-2">
                        <input type="submit" class="btn btn-primary w-100"
                            @if (session('quoteStatus') == 'Quote Created') disabled @endif value="Search">
                    </div>
                </div>
            </form>



            @if (session('StatusChange') == 'Request Failed.')
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5"
                                    alt="">
                                <p class="popup-alert_des"> Rework Succeed</p>
                            </div>

                        </div>

                        <div class="modal-footer text-center justify-content-center p-3 border-0">
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                onclick="Procced()">OK</button>

                        </div>
                    </div>
                </div>
            </div>
        @endif



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
                    {{-- <p><label>Total Allocation Funds <b
                                style="color: #14A44D">R{{ number_format($AllocatedAmt, 2, '.', ',') }}</b> </label> |
                        <label>Total Order Amount</label> <b
                            style="color: red">R{{ number_format($OrdAmountSum, 2, '.', ',') }}</b> </p> --}}

                            @if ($OrdAmountSum > session('RecommendedAmout'))
                             <center>   <label style="color:red"><B>Total capture unit amount is greater than recommended supplier amount</B></label></center>
                            @endif

                    <div class="table-responsive">
                        <form id="saveItemsForm" action="{{ route('SaveUnitPriceStationery') }}" method="post">
                            @csrf

                            <table class="table">
                                @php
                                    $TotalAccumalated = 0;
                                    $totalPrice = 0;
                                @endphp
                                <thead>
                                    <tr>
                                        <td></td>
                                        <th> Code </th>
                                        <th>Title</th>
                                        <th>Quantity</th>
                                        <th>Enter Unit Price</th>
                                        <th style="text-align: right;">Total Price</th>
                                    </tr>
                                </thead>


                                @if (count($dataSavedStationery) < 1)
                                    <tbody>
                                        <tr class="text-center text-dark">
                                            <td colspan="9">There is no saved Items to be displayed.
                                            </td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        @foreach ($dataSavedStationery as $item)
                                            <tr>
                                                <td>

                                                    <input type="checkbox" class="checkbox" checked style="display: none"
                                                        id="Checkbox_{{ $item->item_code }}" name="selectedItems[]"
                                             
                                                    value="{{ $item->item_code }}" 
                                                    @if (session('quoteStatus') == 'Quote Created') disabled @endif>
                                                </td>
                                                <td> {{ $item->item_code }} </td>
                                                <td> {{ $item->item_title }} </td>
                                                <td> {{ $item->Quantity }} </td>
                                                <td>
                                                    {{-- <input type="text" name="SelectedQuantity[{{$item->Quantity}}]" value="{{ $item->Quantity }}"> --}}
                                                    <input type="hidden" name="SelectedQuantity[{{ $item->item_code }}]"
                                                        value="{{ $item->Quantity }}">

                                                        <div class="input-group" style="width: 80px;">

                                                   R&nbsp; <input type="number" class="form-control input-sm quantity-input input"
                                                        name="selectedUnitPrice[{{ $item->item_code }}]"
                                                        value="{{ $item->price }}"
                                                        style="box-shadow: 0 0 0 0.25rem #7cbf7a; width: 60px; height: 20px;"
                                                        id="newQuantity"  onblur="validateInput(this)"
                                                        step="any"></div>

                                                </td>
                                                <td style="text-align: right;">
                                                   R {{ $item->TotalPrice }}
                                                </td>
                                                @php
                                                    // $TotalAccumalated = $item->Quantity * $item->price;
                                                    //    $totalPrice= $totalPrice + ($item->price * $item->Quantity);
                                                    // dump($totalPrice)
                                                @endphp


                                            </tr>
                                        @endforeach
                                @endif


                                {{-- <input type="text" value="{{$totalPrice}}"> --}}


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

                                                <a class="{{ session('dataSavedStationery')->previousPageUrl() ? 'next-page-link' : 'disabled' }}"
                                                    href="#">

                                                    <input type="hidden" name="previousPage" value="">
                                                    <button type="submit" class="page-link" id="PreviousButton">
                                                        <i class="ri-arrow-left-s-line me-4"></i>
                                                        Previous
                                                    </button>
                                                </a>
                                            </li>
                                            @php
                                                $currentPage = session('dataSavedStationery')->currentPage();
                                                $totalPages = session('dataSavedStationery')->lastPage();
                                            @endphp
                                            <center style="margin-right: -60px; margin-top: 10px;">
                                                Page: {{ $currentPage }}/{{ $totalPages }}
                                            </center>
                                            <li class="page-item">
                                                <a class="{{ session('dataSavedStationery')->nextPageUrl() ? 'next-page-link' : 'disabled' }}"
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
 
                                <input type="hidden" name="CheckVal" id="CheckVal">

                                <input type="submit" value="Save Unit Price" class="btn btn-primary btn-sm"
                                    id="sumitbuttton">

                                {{-- {{session('RecommendedAmout')}} --}}

                                @if ($OrdAmountSum > session('RecommendedAmout'))
                                   
                                    {{-- @if($itemsWithoutPrice->isEmpty()) --}}
                                    <button type="button" id="sumitbutttonPPP" class="btn btn-primary btn-sm recommended-row">Rework</button>
                                    {{-- @else

                                    @endif --}}
                                    <div class="modal fade" id="exampleModal1NewNew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered popup-alert">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5" alt="">
                                                        <h4 class="modal-title">Confirmation</h4>
                                                        <p class="modal-title_des">Are you sure the information captured is correct</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-around text-center">
                                                    <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                                                    <button type="submit" class="btn btn-primary px-5">Yes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @else

                                @if($itemsWithoutPrice->isEmpty())
                                    <button type="button" class="btn btn-primary btn-sm" id="BtnOpen">
                                        Save & Continue
                                    </button>
                                
                                    <div class="modal fade" id="exampleModal1New" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered popup-alert">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5" alt="">
                                                        <h4 class="modal-title">Confirmation</h4>
                                                        <p class="modal-title_des">Are you sure the information captured is correct</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-around text-center">
                                                    <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                                                    <button type="button" class="btn btn-primary px-5 confirm-save-continue">Yes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                
                                
                                    <script>
                                        $("#BtnOpen").click(function(){
                                            $('#exampleModal1New').modal('show');
                                        });
                                    </script>
                                @endif
                              
                                @endif

                        </form>

                        
                        </center>
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
                    document.getElementById("sumitbuttton").disabled = false;
                } else {
                    input.style.boxShadow = '0 0 0 0.25rem red';
                    document.getElementById("sumitbuttton").disabled = true;

                }

            }

            function Procced() {
        // Replace 'your-route' with the actual route you want to redirect to
        window.location.href = "{{ route('InboxSchoolDistrict') }}";
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
                $('.confirm-save-continue').click(function() {
                    window.location.href = "{{ route('AdminCaptureSupplierOrder', ['requestType' => $RequestTypes, 'emis' => $Emis, 'fundsId' => $fundsId]) }}";
                });

            
            });
        </script>

        <script>
            $(document).ready(function() {
                $("#sumitbutttonPPP").click(function() {
                    
                    $("#CheckVal").val("true");
//alert("HHH")
                    $('#exampleModal1NewNew').modal('show');




                });


            });
            </script>

        <script>
            $(document).ready(function() {


                @if (session('activeTab') != 'tab3')
                    $(".tab-link[data-toggle='2']").addClass('active');
                    $("#tab2").show();
                    localStorage.clear();
                @else
                    $("#tab3").show();
                @endif

                @if (session('quoteStatus') != 'Allocated Funds')
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
