@extends('layouts.layout')
@section('title', 'History Requests')
@section('content')
    <style>
        /* Style for the tab links */
        .tab-link {
            display: inline-block;
            padding: 10px 20px;
            /* Adjust the padding for the desired height */
            text-decoration: none;
            color: #14A44D;
            /* Blue text color for inactive tabs */
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
    </style>
    <main>
        <link href="path/to/bootstrap-datepicker.min.css" rel="stylesheet">
        <script src="path/to/jquery.min.js"></script>
        <script src="path/to/bootstrap.min.js"></script>
        <script src="path/to/bootstrap-datepicker.min.js"></script>

        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center border-bottom border-2">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Capture Supplier Details</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#"> Receive Quotes </a>
                        



                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('inboxSchool') }}">Inbox</a></li>
                        </ol>
                    </div>
                </div>
            </div>

            @if (session('success') != null)

                @if ($message = Session::get('success'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                        <p class="popup-alert_des">{{ $message }}</p>
                                    </div>

                                </div>

                                <div class="modal-footer text-center justify-content-center p-3 border-0">
                                    <a href="{{ route('inboxSchool') }}"> <button type="button"
                                            class="btn btn-secondary px-5" data-bs-dismiss="modal">OK</button></a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @endif


            {{-- Standard school and Emis --}}
            <div class="row align-items-center border-bottom border-2">
                <br> <br> <br>

                <div class="row">

                    <input type="hidden" name="broken_items[]" id="broken_array" value="">
                    <div class="col-12 col-md-12 my-3">
                        <div class="row g-4">
                            <div class="form-group col-12 col-md-6 col-xl-3">
                                <input type="text" name="School" class="form-control form-control-lg" disabled
                                    required="required" value="{{ Auth::user()->name }}" placeholder=" ">
                                <label>School Name</label>
                                <input type="hidden" value="{{ Auth::user()->name }}" name="SchoolName">
                            </div>
                            <div class="form-group col-12 col-md-6 col-xl-2">
                                <input type="text" name="Emis" class="form-control form-control-lg"
                                    value="{{ Auth::user()->username }}" disabled required="required" placeholder=" ">
                                <input type="hidden" value="{{ Auth::user()->username }}" name="SchoolEmis">
                                <label>School EMIS Number</label>
                            </div>
                        </div>

                    </div>

                </div>


                <br> <br>
            </div>


            {{-- Tabs section --}}
            <div class="row align-items-center border-bottom border-2">
                <br>
                <div class="tabs">

                    <a href="#" class="tab-link {{ session('activeTab') == 'tab1' ? 'active' : '' }}" data-tab="tab1"
                        data-toggle="1" style="font-weight: bold;">Supplier Details</a>

                    <a href="#" id="recommendTab" style="display:none"
                        class="tab-link {{ session('activeTab') == 'tab3' ? 'active' : '' }}" data-tab="tab3"
                        data-toggle="3" style="font-weight: bold;">Recommend Supplier</a>




                    <div class="tab-content " data-toggle="1" id="tab1">


                        <form id="submitForm" action="{{ route('submitSuppliers') }}" method="POST">
                            @csrf


                            <br>
                          {{--   @if (session('statusComment') == '') --}}
                                <div class="card" id="minQuotesSelection">
                                    <h5 class="card-header" style =" color:#14A44D">Received Minimum Quotes ? </h5>
                                    <div class="card-body">
                                        <div class="container mt-2">
                                            <div class="row">

                                                <input type="hidden" name="isReceivedMinimumQuotes" id="hiddenField"
                                                    value="">

                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioOptions"
                                                            @if (session('isReceivedMinimumQuotes') == 'true') checked @endif
                                                            id="inlineRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioOptions"
                                                            @if (session('isReceivedMinimumQuotes') == 'false') checked @endif
                                                            id="inlineRadio2" value="option2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                      {{--       @endif --}}

                            <div class="card" id="cardSupplier" style="display:none">
                                <h5 class="card-header" style ="color:#14A44D">Capture Supplier Details</h5>
                                <div class="card-body">

                                    <table class="table">
                                        <input type="hidden" name="UncheckedItems" value="">
                                        <thead>
                                            <tr>

                                                {{--  <th> </th> --}}
                                                <th> Email </th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Contact No</th>
                                                <th> Amount </th>
                                                <th> Mark up (%) </th>
                                                <th> Action </th>




                                            </tr>
                                        </thead>

                                        @if (count(session('supplierData')) < 1)
                                            <tbody>

                                                <tr class="text-center text-dark">
                                                    <td colspan="9">There is no saved Items to be displayed.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @else
                                            <tbody>
                                                @foreach (session('supplierData') as $item)
                                                    {{--  @php
                                                        use App\Models\capturedsuppliers;

                                                        $existRecord = capturedsuppliers::where('savedSupplierID', $item->id)->exists();
                                                    @endphp --}}
                                                    <tr>

                                                        {{--  <td> <input type="checkbox" class="checkbox" name="selectedItems[]"
                                                            @if (session('savedSuppliers')->contains('supplierID', $item->Id)) checked @endif
                                                            value={{ $item->Id }}>
                                                    </td> --}}

                                                        <td>{{ $item->email }} </td>
                                                        <td>{{ $item->CompanyName }} </td>
                                                        <td>
                                                            <div class="short-text" title="{{ $item->CompanyAddress }} ">
                                                                {{ Str::limit($item->CompanyAddress, 40) }}
                                                            </div>
                                                        </td>

                                                        <td>{{ $item->CompanyContact }} </td>

                                                        <td>
                                                            @if (session('supplierCaptured')->contains('savedSupplierID', $item->id))
                                                                @php
                                                                    $capturedSupplier = session('supplierCaptured')
                                                                        ->where('savedSupplierID', $item->id)
                                                                        ->first();
                                                                @endphp



                                                                @if ($capturedSupplier->markUp > 27)
                                                                    <span style="color:red">

                                                                        R
                                                                        {{ number_format($capturedSupplier->amount, 2, '.', ',') }}</span>
                                                                @else
                                                                    <span style="color:black">
                                                                        R
                                                                        {{ number_format($capturedSupplier->amount, 2, '.', ',') }}</span>
                                                                @endif
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>

                                                        <td>

                                                            @if (session('supplierCaptured')->contains('savedSupplierID', $item->id))
                                                                @php
                                                                    $capturedSupplier = session('supplierCaptured')
                                                                        ->where('savedSupplierID', $item->id)
                                                                        ->first();
                                                                @endphp
                                                                {{ $capturedSupplier->markUp }}
                                                            @else
                                                                N/A
                                                            @endif



                                                        </td>


                                                        <td> <a href="{{ route('captureSuppliersPage', ['itemId' => $item->id]) }}"
                                                                style="color:green; text-decoration: underline; font-style:italic">
                                                                @if (session('supplierCaptured')->contains('savedSupplierID', $item->id))
                                                                    Captured
                                                                @else
                                                                    Capture
                                                                @endif
                                </div>
                                </a>
                                </td>


                                {{--  <td>  <button  class="buttonGenerate"  onclick="redirectToSubmitSuppliers('{{ route('submitSuppliers2', ['itemId' => $item->id ]) }}')">Submit</button> </td> --}}
                                {{--   <td> <input type="button" class="buttonGenerate" value="Capture"
                                                              {{--   data-bs-toggle="modal" data-bs-target="#modelSuppliers" --}}
                                {{--  data-value="{{ $item->id }}"
                                                                onclick="captureAndSubmit('{{ $item->id }}')">
                                                        </td> --}}

                                </tr>
                                @endforeach
                                @endif



                                </tbody>


                                </table>
                            </div>
                    </div>
                    <center>
                        <input type="hidden" name="isSubmit" id="isSubmit" value="">
                        <input type="submit" style="width:150px" class="btn btn-primary " name="submitBtn"
                            value="SUBMIT" onclick="setIsSubmitted()">
                    </center>


                    </form>
                </div>



                <div class="tab-content" data-toggle="3" id="tab3">
                    <br>
                    @if (session('statusComment') != '')
                        <p style="font-weight: bold; color: red;"> Declined Reason :  {{ session('statusComment') }}</p>
                    @endif
                    <div class="card" id="cardSupplier">
                        <h5 class="card-header" style ="color:#14A44D">Recommend Captured Suppliers</h5>
                        <div class="card-body">


                            <form id="submitEF48" action="{{ route('updateRecommended') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <table class="table">
                                    <input type="hidden" name="UncheckedItems" value="">
                                    <thead>
                                        <tr>

                                            {{--  <th> </th> --}}
                                            <th> Email </th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Contact No</th>
                                            <th> Amount </th>
                                            <th> Mark up (%) </th>
                                            <th> Recommend </th>




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
                                                {{--  @php
                                                use App\Models\capturedsuppliers;

                                                $existRecord = capturedsuppliers::where('savedSupplierID', $item->id)->exists();
                                            @endphp --}}
                                                <tr>

                                                    {{--  <td> <input type="checkbox" class="checkbox" name="selectedItems[]"
                                                    @if (session('savedSuppliers')->contains('supplierID', $item->Id)) checked @endif
                                                    value={{ $item->Id }}>
                                            </td> --}}

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



                                                    </td>

                                                    <td>


                                                        {{ $item->markUp }}

                                                    </td>


                                                    <td>
                                                        @php
                                                            $supplierRecommended = session('CapturedData')
                                                                ->where('Recommended', 'yes')
                                                                ->first();

                                                            if ($supplierRecommended != null) {
                                                                $recommendedIDs = $supplierRecommended->custom_id;
                                                            }
                                                        @endphp
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioRecommend"
                                                            @if ($supplierRecommended != null) @if ($recommendedIDs == $item->custom_id) checked @endif
                                                            @endif
                                                        id="inlineRadio{{ $item->custom_id }}"
                                                        value="{{ $item->custom_id }}"
                                                        onclick="updateHiddenInput(this)">
                                                        <label class="form-check-label"
                                                            for="inlineRadioRecommend">Select</label>
                                                    </td>

                                                </tr>
                                            @endforeach
                                    @endif



                                    </tbody>


                                </table>

                                {{-- Download and upload ef48 --}}
                                {{-- Download and upload comittee PDF  --}}



                        </div>
                    </div>

                    <div class="card" id="cardRecommended">
                        <h5 class="card-header" style ="color:#14A44D">EF58 Download and Upload</h5>
                        <div class="card-body">
                            <div class="row align-items-center border-bottom border-2 mx-auto ">

                                <div class="form-group col-12 col-md-6 col-xl-2">

                                    <i class="fas fa-download" style="color: green;"></i><a
                                        href="{{ route('downloadEF58') }}"
                                        style="color:green; text-decoration: underline; font-style: italic;"
                                        onclick="enableUploadInput()">
                                        Download EF58
                                    </a>

                                </div>


                                <div class="form-group col-12 col-xl-4 col-xl-2">
                                    <div class="row justify-content-center ">
                                        <div class="col-md-4 form-control" style="width: 100%;" class="form-control">
                                            <label for="reference-number">Upload EF58 Form</label>
                                            <div class="input-group">
                                                <input type="file" name="fileEF48" id="fileEF48" required
                                                    value="" required disabled>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <center>
                        <input type="hidden" name="recommendedID" id="recommendedID" value="">
                        <input type="hidden" name="isSubmitRecommend" id="isSubmitRecommend" value="">
                        <input type="submit" style="width:150px" class="btn btn-primary " id="btnSubK" name="submitBtn"
                            value="SUBMIT" onclick="setIsSubmittedRecommend()" disabled>
                        </form>


                    </center>
                </div>


                         {{-- Sucess email sent --}}
            <div class="modal fade" id="ModelLoading" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="spinner-container" id="spinner">
                            <div class="spinner-border text-primary" role="status">
                            </div>
                            <label> Loading... </label>
                        </div>

                    </div> 


                    </div>
               
                </div>
            </div>
        </div>





        





                {{-- Model --}}
                {{--    <div class="modal fade" id="modelSuppliers" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">


                                        <!-- Hidden input field in the modal -->


                                        <h5 class="modal-title" id="exampleModalLabel">Capture suppliers</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                    </div>
                                    <div class="modal-body">



                                        <form action="{{ route('CaptureSuppliers') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="text" id="hiddenFieldValue" name="hiddenFieldValue"
                                                value="">


                                            @php
                                                use App\Models\capturedsuppliers;

                                                $savedSupplierID = request('hiddenFieldValue');
                                                $existRecord = capturedsuppliers::where('savedSupplierID', $savedSupplierID)->exists();
                                            @endphp


                                            <div class="form-group">
                                                <label for="firstName">Upload Quote Form:</label>
                                                <input type="file" class="form-control" name="fileQuote"
                                                    id="fileDisclosureInput" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="firstName">Upload SBD 4 Form:</label>
                                                <input type="file" class="form-control" name="fileSBD4"
                                                    id="fileDisclosureInput">
                                            </div>
                                            <div class="form-group">
                                                <label for="firstName">Upload Disclosure Form:</label>
                                                <input type="file" class="form-control" name="fileDisclosure"
                                                    id="fileDisclosureInput">
                                            </div>
                                            <div class="form-group">
                                                <label for="firstName">Upload Tax Clearance Form:</label>
                                                <input type="file" class="form-control" name="fileTax"
                                                    id="fileDisclosureInput">
                                            </div>

                                            <div class="form-group">
                                                <label for="firstName">Amount :</label>
                                                <input type="text" class="form-control" name="amtCaptured"
                                                    id="fileDisclosureInput" required
                                                    @if ($existRecord) value="{{ capturedsuppliers::where('savedSupplierID', $savedSupplierID)->value('amount') }}" @endif>
                                            </div>

                                            <div class="form-group">
                                                <label for="firstName">Comment :</label>
                                                <textarea class="form-control" id="memo" name="comment" placeholder="Enter comment" rows="2" required>   @if ($existRecord)
                                                    {{ capturedsuppliers::where('savedSupplierID', $savedSupplierID)->value('comment') }}
                                                    @endif
                                                    </textarea>
                                            </div>

                                            <br>
                                            <div class="card">

                                                <div class="card-body" style="background-color: #f4f9f4">

                                                    <label for="firstName">Tax Clearance Valid: </label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioOptions" id="taxRadio1" value="yes">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioOptions" id="taxRadio2" value="no">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>

                                                    <!-- Hidden field to store the selected value -->
                                                    <input type="hidden" id="taxClearanceHidden"
                                                        name="taxClearanceHidden">

                                                </div>


                                            </div>


                                    </div>

                                    <div class="modal-footer justify-content-center">
                                        <!-- Add space between buttons -->
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    </form>

                                </div>
                            </div>
                        </div> --}}




                {{-- SECOND TAB CONTENT --}}

            </div>




            {{--  Model --}}

        </div>

        <br>

        {{-- Enable upload only once the download is clicked --}}
        <script>
            function enableUploadInput() {
                var uploadInput = document.getElementById('fileEF48');
                uploadInput.disabled = false;


            document.getElementById('btnSubK').disabled = false;
              

            }
        </script>

        {{-- Recommend supplier ID retrieve --}}
        <script>
            function updateHiddenInput(radio) {
                var hiddenInput = document.getElementById('recommendedID');
                hiddenInput.value = radio.value;
            }
        </script>

        {{-- Show and Hide Tabs Dynamically --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {






                @if (session('activeTab') != 'tab3')

                    $(".tab-link[data-toggle='1']").addClass('active');
                    $("#tab1").show();
                    $("#tab3").hide();
                    localStorage.clear();
                @else
                    $("#tab3").show();
                    $("#tab1").hide();
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

        {{-- Show and hide elements based on yes or no buttons  --}}
        <!-- Add this script in your HTML file, preferably at the end of the body section -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Get the radio buttons and hidden field
                const yesRadio = document.getElementById("inlineRadio1");
                const tab2 = document.getElementById("recommendTab");
                const supplierCard = document.getElementById("cardSupplier");
                const noRadio = document.getElementById("inlineRadio2");
                const hiddenField = document.getElementById("hiddenField");
                const minQuotesSelection = document.getElementById("minQuotesSelection");

                @if (session('isReceivedMinimumQuotes') == 'true') 

                @if (session('statusComment') != '')
                     minQuotesSelection.style.display = "none";
                @endif
                    hiddenField.value = "true";
                    tab2.style.display = "block";
                    supplierCard.style.display = "block";
                    showRecommendSupplierTab();
                @else
                    hiddenField.value = "false";
                    tab2.style.display = "none";
                    supplierCard.style.display = "none";
                    hideRecommendSupplierTab();
                @endif

               

                // Add click event listeners to the radio buttons
                yesRadio.addEventListener("click", function() {
                    hiddenField.value = "true";
                    tab2.style.display = "block";
                    supplierCard.style.display = "block";
                    showRecommendSupplierTab();
                });

                noRadio.addEventListener("click", function() {
                    hiddenField.value = "false";
                    tab2.style.display = "none";
                    supplierCard.style.display = "none";
                    hideRecommendSupplierTab();
                });

                // Function to hide the recommend supplier tab and the grid
                function hideRecommendSupplierTab() {
                    const recommendSupplierTab = document.querySelector(".tab-link[data-tab='tab3']");
                    const supplierDetailsCard = document.querySelector(".card[data-card='supplierDetailsCard']");

                    if (recommendSupplierTab && supplierDetailsCard) {
                        recommendSupplierTab.style.display = "none";
                        supplierDetailsCard.style.display = "none";
                    }
                }

                // Function to show the recommend supplier tab
                function showRecommendSupplierTab() {
                    const recommendSupplierTab = document.querySelector(".tab-link[data-tab='tab3']");

                    if (recommendSupplierTab) {
                        recommendSupplierTab.style.display = "inline-block"; // Set the appropriate display property
                    }
                }
            });
        </script>




        @if ($showModel == true)
            <script>
                $(document).ready(function() {
                    $('#modelSuppliers').modal('show');
                });
            </script>
        @endif

        @if (session('OkNowSuccess') == "true")
        <script>
            $(document).ready(function() {
                $('#ModelLoading').modal('hide');
            });
        </script>
        @endif


@if (session('OkNowSuccessAnother') == "true")
<script>
    $(document).ready(function() {
        $('#ModelLoading').modal('hide');
    });
</script>
 @endif



        <script>
            $(document).ready(function() {
                // Add change event listener to the radio buttons
                $('input[name="inlineRadioOptions"]').change(function() {
                    // Submit the form when a radio button is changed
                    // document.getElementById('ModelLoading').style.display='block';
                    $('#ModelLoading').modal('show');
                    event.preventDefault();
                    $('#submitForm').submit();
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                // Add change event listener to the radio buttons
                $('input[name="inlineRadioRecommend"]').change(function() {
                    // Submit the form when a radio button is changed
                    $('#ModelLoading').modal('show');

                    event.preventDefault();
                    $('#submitEF48').submit();
                });
            });

            
        </script>

<script>
    function setInProgress() {
        // Show the spinner
        document.getElementById('spinner').style.display = 'block';

        // Example: Simulating a delay of 5 seconds (5000 milliseconds)
        setTimeout(function () {
            // Hide the spinner after the process is complete
            document.getElementById('spinner').style.display = 'none';
        }, 5000);
    }
</script>


        {{-- Radio buttons within the model --}}
        <script>
            // Add an event listener to the radio buttons
            document.getElementById('taxRadio1').addEventListener('change', function() {
                // Update the hidden field when "Yes" is selected
                document.getElementById('taxClearanceHidden').value = this.value;
            });

            document.getElementById('taxRadio2').addEventListener('change', function() {
                // Update the hidden field when "No" is selected
                document.getElementById('taxClearanceHidden').value = this.value;
            });
        </script>



        {{-- isSubmit hidden field set  --}}

        <script>
            function setIsSubmitted() {
                // Set the hidden field value to 'true' before submitting the form
                document.getElementById('isSubmit').value = 'true';
            }
        </script>

        <script>
            function setIsSubmittedRecommend() {
                // Set the hidden field value to 'true' before submitting the form
                document.getElementById('isSubmitRecommend').value = 'true';
            }
        </script>


    @endsection
