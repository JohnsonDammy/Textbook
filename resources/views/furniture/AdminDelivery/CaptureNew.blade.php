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

  
            <div class="table-responsive">

                    <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>RequestType</th>
                            <th>Delivery Note</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                        @if (count(session('dataNewStat')) < 1)

                            <tr class="text-center text-dark">
                                <td colspan="7">No Delivery Note Found</td>
                            </tr>
                            </tbody>
                        @else
                            @foreach (session('dataNewStat') as $key => $delivery)
                                <tbody>
                                    <td>{{ $loop->iteration }}</td>
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
                                    <td> <form class="" method="get" action=" {{ route('CaptureData', ['delID'=>  $delivery->Id, 'requestType' => $delivery->RequestType, 'idInbox' => "1", 'emis_new'=> $delivery->Emis]) }} ">
                                           
                                        <button type="submit">Capture Data</button>
                                    </form> </td>
                                </tbody>
                            @endforeach
                        @endif

                    </table>
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
