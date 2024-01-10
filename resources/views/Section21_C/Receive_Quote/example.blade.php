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
                        <h4>Manage Funding</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#"> Receive Quotes </a>
                                @if ($requestType == 'Textbook')
                            <li class="breadcrumb-item"><a
                                    href="{{ route('textbookCat', ['requestType' => 'Textbook', 'idInbox' => 1]) }}">View
                                    Items</a></li>
                        @else
                            <li class="breadcrumb-item"><a
                                    href="{{ route('stationeryCat', ['requestType' => 'Stationery', 'idInbox' => 2]) }}">View
                                    Items</a></li>
                            @endif


                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('inboxSchool') }}">Inbox</a></li>
                        </ol>
                    </div>
                </div>
            </div>




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

            <div class="row align-items-center border-bottom border-2">
               
                <div class="tabs">

                  <div>   <a href="#" class="tab-link {{ session('activeTab') == 'tab1' ? 'active' : '' }}"
                        data-tab="tab1" data-toggle="1" style="font-weight: bold;">Supplier Details</a>
                  </div>

                  <div id="recommendTab" style="display:none;">
                    <a href="#"   
                        class="tab-link {{ session('activeTab') == 'tab3' ? 'active' : '' }}" data-tab="tab3"
                        data-toggle="3" style="font-weight: bold;">Recommend Supplier</a>
                  </div>




                  
                </div>
            </div>

            {{-- Tabs section --}}
            {{-- <form id="saveItemsForm" action="{{ route('submitSuppliers') }}" method="post">
                @csrf
               

                            <center>
                                <br> <br>
                                <div class="col-6 col-md-6 col-xl-2">
                                    <input type="submit" class="btn btn-primary w-100" name="submitBtn"
                                        value="Submit N">
                                </div>
                                <br> <br>
                            </center>



                        </div>
            </form> --}}

            <form action="{{ route('submitSuppliers') }}" method="POST">
                @csrf

                <div class="tab-content " data-toggle="1" id="tab1" >
                    <br>
                    <div class="card">
                        <h5 class="card-header" style =" color:#14A44D">Received Minimum Quotes ? </h5>
                        <div class="card-body">
                            <div class="container mt-2">
                                <div class="row">

                                    <input type="text" name="isReceivedMinimumQuotes" id="hiddenField"
                                        value="">

                                    <div class="col-md-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio1" value="option1">
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio2" value="option2">
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>









                 
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

                                                <td> </td>
                                                <td> <input type="button" class="buttonGenerate" value="Capture"
                                                        data-bs-toggle="modal" data-bs-target="#modelSuppliers">
                                                </td>

                                            </tr>
                                        @endforeach
                                @endif



                                </tbody>


                            </table>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary w-100" name="submitBtn" value="Submit">
                </div>

              
            </form>

        

        {{-- Model Popup Capture supplier details --}}

   

    


            {{-- SECOND TAB CONTENT --}}
            <div class="tab-content" data-toggle="3" id="tab3"> TAB 3 </div>
        </div>

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
            document.addEventListener("DOMContentLoaded", function () {
                // Get the radio buttons and hidden field
                const yesRadio = document.getElementById("inlineRadio1");
                const tab2 = document.getElementById("recommendTab");
                const supplierCard = document.getElementById("cardSupplier");
                const noRadio = document.getElementById("inlineRadio2");
                const hiddenField = document.getElementById("hiddenField");
                
                // Add click event listeners to the radio buttons
                yesRadio.addEventListener("click", function () {
                    hiddenField.value = "true";
                    tab2.style.display="block";
                    supplierCard.style.display="block";
                   
                    showRecommendSupplierTab();
                });
        
                noRadio.addEventListener("click", function () {
                    hiddenField.value = "false";
                    tab2.style.display="none";
        
                    supplierCard.style.display="none";
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

    @endsection
