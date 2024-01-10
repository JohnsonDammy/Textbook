@extends('layouts.layout')
@section('title', 'Delivery Capture')
@section('content')

    @php
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
=

            /*  .hover-trigger .full-text {
                                            display: none;
                                        }

                                        .hover-trigger:hover .short-text {
                                            display: none;
                                        }

                                        .hover-trigger:hover .full-text {
                                            display: block;
                                        } */

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
                        <h4>Manage School Transactions</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a
                                    href="{{ route('textbookCat', ['requestType' => 'Textbook', 'idInbox' => 1]) }}">Saved
                                    Textbook Catalogue</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('inboxSchool') }}">Inbox</a></li>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row mb-5">

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
                            @if (count(session('dataNew')) < 1)

                                <tr class="text-center text-dark">
                                    <td colspan="7">No Delivery Note Found</td>
                                </tr>
                                </tbody>
                            @else
                                @foreach (session('dataNew') as $key => $delivery)
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
                                        <td> <form class="" method="get" action=" {{ route('CaptureData', ['delID'=>  $delivery->Id, 'requestType' => $delivery->RequestType, 'idInbox' => "1", 'emis_new'=> $delivery->Emis]) }} ">
                                           
                                            <button type="submit">Capture Data</button>
                                        </form> </td>

                                    </tbody>
                                @endforeach
                            @endif

                        </table>


            </div>
            </div>


    </main>


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

    {{-- Dynamically change status  --}}
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script></script>






@endsection
