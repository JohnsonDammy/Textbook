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

   
    <br>
    <a href="{{ route('receiveQuotes', ['requestType' => session('requestType')]) }}">
        <i class="fa fa-arrow-circle-left"  style="font-size: 30px;" aria-hidden="true"></i>
    </a>

    <br><br>
     <center>
        <h3> Capture Supplier Details </h3>
        <div class="card" style="background-color: white; width:700px;">
        <div class="card-body"   >
            <form action="{{ route('CaptureSuppliers') }}" method="post" enctype="multipart/form-data"  onsubmit="setInProgress()">
                @csrf
                <input type="hidden" id="hiddenFieldValue" name="hiddenFieldValue" value="">


                @php
                    use App\Models\capturedsuppliers;

                   
                    $existRecord = capturedsuppliers::where('savedSupplierID', $itemId)->exists();
                @endphp


            
                <div class="form-group">
                   
                    @if ($existRecord) 
                        @if (capturedsuppliers::where('savedSupplierID', $itemId)->value('quoteForm') != null)
                            <label for="firstName">Uploaded Quote Form:</label>
                            <p  class="form-control"  style="text-align: left"> {{  capturedsuppliers::where('savedSupplierID', $itemId)->value('quoteForm') }} <p>
                        @else
                            <label for="firstName">Upload Quote Form:</label>
                            <input type="file" class="form-control" name="fileQuote" id="fileDisclosureInput" required>
                        @endif
                    @else
                    <label for="firstName">Upload Quote Form:</label>
                    <input type="file" class="form-control" name="fileQuote" id="fileDisclosureInput" required>
                    @endif
                </div>
             
              
                <div class="form-group">
                    @if ($existRecord) 
                        @if (capturedsuppliers::where('savedSupplierID', $itemId)->value('sbd4Form') != null &&  capturedsuppliers::where('savedSupplierID', $itemId)->value('sbd4Form') != "N/A")
                            <label for="firstName">Uploaded SBD 4 Form:</label>
                            <p  class="form-control"  style="text-align: left"> {{  capturedsuppliers::where('savedSupplierID', $itemId)->value('sbd4Form') }} <p>
                        @else
                            <label for="firstName">Upload SBD 4 Form:</label>
                            <input type="file" class="form-control" name="fileSBD4" id="fileDisclosureInput">
                        @endif
                    @else
                    <label for="firstName">Upload SBD 4 Form:</label>
                            <input type="file" class="form-control" name="fileSBD4" id="fileDisclosureInput">
                    @endif

                </div>


                <div class="form-group">
                    @if ($existRecord) 
                        @if (capturedsuppliers::where('savedSupplierID', $itemId)->value('disclosureForm') != null && capturedsuppliers::where('savedSupplierID', $itemId)->value('disclosureForm') != "N/A" )
                            <label for="firstName">Uploaded disclosure Form:</label>
                            <p  class="form-control"  style="text-align: left"> {{  capturedsuppliers::where('savedSupplierID', $itemId)->value('disclosureForm') }} <p>
                        @else
                            <label for="firstName">Upload Disclosure Form:</label>
                            <input type="file" class="form-control" name="fileDisclosure" id="fileDisclosureInput">
                        @endif
                    @else
                    <label for="firstName">Upload Disclosure Form:</label>
                    <input type="file" class="form-control" name="fileDisclosure" id="fileDisclosureInput">
                    @endif

                </div>


                <div class="form-group">
                    @if ($existRecord) 
                        @if (capturedsuppliers::where('savedSupplierID', $itemId)->value('taxClearanceForm') != null && capturedsuppliers::where('savedSupplierID', $itemId)->value('taxClearanceForm') != "N/A")
                            <label for="firstName">Uploaded Tax Clearance Form:</label>
                            <p  class="form-control"  style="text-align: left"> {{  capturedsuppliers::where('savedSupplierID', $itemId)->value('taxClearanceForm') }} <p>
                        @else
                            <label for="firstName">Upload Tax Clearance Form:</label>
                            <input type="file" class="form-control" name="fileTax" id="fileDisclosureInput">
                        @endif
                    @else
                    <label for="firstName">Upload Tax Clearance Form:</label>
                    <input type="file" class="form-control" name="fileTax" id="fileDisclosureInput">
                    @endif

                </div>

                @if(session('requestType')=="Textbook")
                <div class="form-group">
                    <label for="firstName">Mark Up % :</label>
                    <input type="text" class="form-control" name="markUp"  required
                        @if ($existRecord) value="{{ capturedsuppliers::where('savedSupplierID', $itemId)->value('markUp') }}" @endif>
                </div>
                @elseif(session('requestType')=="Stationery")

                <div class="form-group">
                    <label for="firstName">Amount :</label>
                    <input type="text" class="form-control" name="amtCaptured" id="fileDisclosureInput" required
                        @if ($existRecord) value="{{ capturedsuppliers::where('savedSupplierID', $itemId)->value('amount') }}" @endif>
                </div>
                @endif



                <div class="form-group">
                    <label for="firstName">Comment :</label>
                    <textarea style="white-space: pre-line;" class="form-control" id="memo" name="comment" placeholder="Enter comment" rows="2"> @if ($existRecord)@if(capturedsuppliers::where('savedSupplierID', $itemId)->value('comment') != null){{ capturedsuppliers::where('savedSupplierID', $itemId)->value('comment') }}@else No comment @endif @endif</textarea>                    
                </div> 

                <br>
                <div class="card">

                    <div class="card-body"  style="background-color: #f4f9f4">

                        <label for="firstName">Tax Clearance Valid: </label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="taxRadio1"
                            @if ($existRecord)  
                                @if (capturedsuppliers::where('savedSupplierID', $itemId)->value('taxClearance') == "yes")  
                                    checked
                                @endif
                            @endif
                            value="yes">
                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="taxRadio2"
                            @if ($existRecord)  
                                @if (capturedsuppliers::where('savedSupplierID', $itemId)->value('taxClearance') == "no")  
                                    checked
                                @endif
                            @endif 
                           value="no">
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>

                        <!-- Hidden field to store the selected value -->
                        <input type="hidden" id="taxClearanceHidden" name="taxClearanceHidden">

                    </div>


                </div>


        </div>

        <div class="modal-footer justify-content-center">
            <!-- Add space between buttons -->
            <button type="submit" class="btn btn-primary">SAVE</button>
        </div>
        </form>

        </div>
    </div>
</center>

        </div>
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







    @endsection
