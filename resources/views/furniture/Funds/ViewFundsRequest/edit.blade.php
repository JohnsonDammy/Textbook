@extends('layouts.layout')
@section('title', 'Update Request')
@section('content')
<!-- main -->
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center border-bottom border-2">
            <div class="col-12 col-md-12">
                <div class="page-titles">
                    <h4>Request Update</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('AdminViewFundRequest.index') }}">View Request</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Funds Request</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            @if ($message = Session::get('error'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">Funds Approvde - Updated Sucessfully</h4>
                                <p class="popup-alert_des">{{ $message }}</p>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-around text-center">
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="hidePopup()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
   


        </div>
        <form class="" method="post" action="{{ route('UpdateFundsRequest') }}"  data-parsley-validate enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="RecordID" value="{{$record->id}}">
            <input type="hidden" name="School_Emis" value="{{$record->School_Emis}}">
            <input type="hidden" name="RequestType" value="{{$record->RequestType}}">


  <div class="row justify-content-center mt-5">

<table class="table border-table">
    <tr><th>School Name </th> <th>School Emis</th> <th>Request Type</th></tr>
    <tr><td>{{$record->School_Name}}</td><td>{{$record->School_Emis}}</td><td>{{$record->RequestType}}</td></tr>
</table>

        <div class="col-md-6">
            <h4 >Request Type: <label style="color:brown">{{$record->RequestType}}</label></h4><br><br>

            @if( $record->amount_textbook != null ) 
            <div class="form-group">
            <input type="text" class="form-control" id="furniture-category-1" name="textbookAmt" value="{{ old('name' , 'R'.number_format($record->amount_textbook, 2, '.', ',')) }}" readonly required data-parsley-required-message="Funds Amount is required" placeholder=" ">
            <label for="furniture-category-1">Requested Textbook Amount:<span class="text-danger">*</span></label>
            </div>
            @endif


            @if( $record->amount_stationery != null ) 
            <div class="form-group">
            <input type="text" class="form-control" id="furniture-category-1" name="stationeryAmt" value="{{ old('name' ,'R'.number_format($record->amount_textbook, 2, '.', ',')) }} " readonly required data-parsley-required-message="Funds Amount is required" placeholder=" ">
            <label for="furniture-category-1">Requested Stationery Amount:<span class="text-danger">*</span></label>
            </div>
            @endif

            
            @if( $record->amount_textbook != null ) 
            <div class="form-group">
                <label for="status">Please Enter Approved Textbook: <span class="text-danger">*</span></label>
                <input type="text" class="form-control decimal-input" id="ApprovedAmountTextbook" name="ApprovedAmountTextbook" placeholder="" required data-parsley-required-message="Approved Amount is required">
                <span class="text-danger" style="display: none;" id="counterrorTextbook" role="alert">
                    <strong id="counterrormsgTextbook"></strong>
                </span>
            </div>
            @endif

            @if( $record->amount_stationery != null ) 
            <div class="form-group">
                <label for="status">Please Enter Approved Stationery: <span class="text-danger">*</span></label>
                <input type="text" class="form-control decimal-input" id="ApprovedAmountStationery" name="ApprovedAmountStationery" placeholder="" required data-parsley-required-message="Approved Amount is required">
                <span class="text-danger" style="display: none;" id="counterrorTextbook" role="alert">
                    <strong id="counterrormsgTextbook"></strong>
                </span>
            </div>
            @endif
       

                <div class="form-group">
                    <label for="status">Select Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Approved">Approve</option>
                        <option value="Pending">Pending</option>
                        <option value="Reject">Reject</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="file">Upload File:</label>
                    <input type="file" class="form-control" id="file" name="file">
                </div>

                <div class="form-group">
                    <button type="button"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary">Update</button>

                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="assets/img/popup-check.svg" class="img-fluid" alt="">
                                <h4 class="modal-title">Submit</h4>
                                <p class="modal-title_des">Are you sure you want to Update</p>
                            </div>
    
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary px-5">Yes</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    </div>
    @if ($message = Session::get('error'))
    <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    <script>
        function hidePopup() {
            $("#exampleModal").fadeOut(200);
            $('.modal-backdrop').remove();
            console.log("hidePop")
        }
    </script>



    {{-- Format the textboxes amounts as currency value --}}
    <script>
        $(document).ready(function() {
            var typingTimer; // Timer identifier
            var doneTypingInterval = 1000; // Time in milliseconds (1 second)
    
            $('.decimal-input').on('input', function() {
                var $this = $(this);
                clearTimeout(typingTimer); // Clear the previous timer
                var inputValue = $this.val();
                    var numericValue = parseFloat(inputValue.replace(/[^0-9.]/g, ''));
                    var id = $this.attr('name');
                    var errorElement = $this.next('span.text-danger');

                    if (isNaN(numericValue) && inputValue.trim() !== "") {
                        $this.css('border-color', 'red');
                        errorElement.text('Invalid, Please enter a number.');
                        errorElement.show();
                    } else {
                        $this.css('border-color', '');
                        errorElement.hide();
                    }
    
                // Set a new timer to format the value after the user has finished typing
                typingTimer = setTimeout(function() {
        
    
                    if (!isNaN(numericValue)) {
                         // Format the numeric value as South African Rand
                    var formattedValue = numericValue.toLocaleString('en-ZA', {
                        style: 'currency',
                        currency: 'ZAR'
                    });

                    // Update the input field with the formatted currency value
                    $this.val(formattedValue);
                    }
    
                }, doneTypingInterval);
            });
        });
    </script>
    
</main>
@endsection