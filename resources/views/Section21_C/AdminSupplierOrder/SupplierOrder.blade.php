@extends('layouts.layout')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title', 'Supplier List')

@section('content')
    <!-- main -->
    <main>
 
        <style>
          
        </style>
 
        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Supplier Order Generate </h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            {{-- <li class="breadcrumb-item"><a href="{{ route('school-maintenance') }}">School Maintenance</a></li> --}}
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Delivery List</a></li>
                        </ol>
                    </div>
                </div>
                {{-- <div class="offset-xl-3 col-12 col-md-4 col-xl-2 mb-3">
                    <a href="{{ route('Deliverys.Add') }}" class="btn btn-primary w-100">+ Upload Delivery Note</a>
                </div> --}}
            </div>
     
            {{--Send Email--}}
            <div class="modal fade" id="exampleModalSentEmail" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                            <h4 class="modal-title">Successfully sent emails</h4>
                            <p class="modal-title_des">Email sent to recommended supplier
                            </p>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-around text-center">
                        <a href="{{ route('home') }}" class="btn btn--dark px-5">OK</a>

                    </div>
                </div>
            </div>
        </div>
 
            <form method="post" action="{{route('UploadOrderForm')}}"  enctype="multipart/form-data">
                @csrf

  
           
            {{-- Standard school and Emis --}}
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
                                    value="{{ session('emis') }}" disabled required="required" placeholder=" ">
                                <input type="hidden" value="{{ session('emis') }}" name="SchoolEmis">
                                <label>School EMIS Number</label>
                            </div>
                        </div>
 
                    </div>
 
                </div>
 
 
                <br> <br>
            </div>
 
 
            <div class="card" id="cardSupplier">
                <h5 class="card-header" style ="color:#14A44D">Recommended Supplier</h5>
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
                                <th> Mark Up (%) </th>
                              
                            </tr>
                        </thead>
 
                        @if (count(session('CapturedData')) < 1)
                            <tbody>
                                <tr class="text-center text-dark">
                                    <td colspan="9">No recommended supplier has been selected
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

                                    <input type="hidden" name="SupplierID" value="{{ $item->Id }}">
                                    <input type="hidden" name="Email" value="{{ $item->email }}">

 
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
 
 
                                       
 
                                    </tr>
                                @endforeach
                        @endif
 
 
 
                        </tbody>
 
 
                    </table>
 
                    {{-- Download and upload ef48 --}}
                    {{-- Download and upload comittee PDF  --}}
 
 
 
                </div>
            </div>

            {{--DATES--}}
            <div class="row align-items-center border-bottom border-2">
               
                <div class="row">
 
                    <div class="form-group col-12 col-md-6 col-xl-3">
                        <div class="input-group">

                                            <div style="display:none" id= "errorClosingDate" class="text-danger">Delivery Date 
                                            </div>
                                            <label for="exampleDate">Select delivery Date:</label>
                                            <input type="text" class="form-control datepicker" 
                                                name="deliveryDate" id="DeliveryDate" placeholder="MM/DD/YYYY" required>

                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-calendar" style="font-size:35px"></i>
                                                    </span>
                                                </div>
                        </div>
                    </div>


                    {{-- <div class="input-group">
                        <input type="text" class="form-control datepicker" id="exampleDate" name="closingDate" id="closingDateInput" required value="{{ old('closingDate', session('closingDate')) }}">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </span>
                        </div>
                    </div> --}}

                    <div class="form-group col-12 col-md-6 col-xl-3">

                        <div style="display:none" id= "errorClosingDate" class="text-danger">Fail to supply date</div>
                        <label for="exampleDate">Select failed to supply Date:</label>
                        <div class="input-group">

                        <input type="text" class="form-control datepicker" 
                            name="FailDate" id="closingDateInput" required placeholder="MM/DD/YYYY"  onclick="Select()"
                            >

                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar" style="font-size:20px"></i>
                                </span>
                            </div>
                        </div>


                  </div>
                </div>
            </div>

            {{--download order form and upload signed one--}}
              <div class="row align-items-center border-bottom border-2">
               
 
                <div class="row">
                    <div class="form-group col-12 col-md-6 col-xl-3">

                        {{-- <i class="fas fa-download" style="color: green;"></i><a
                            href=" {{ route('OrderLetter') }} "
                            style="color:green; text-decoration: underline; font-style: italic;"  onclick="enableUploadInput()">
                            Download Order Form
                        </a> --}}

                        <i class="fas fa-download" style="color: green;"></i>
                            <a href="javascript:void(0);" id="downloadLink" style="color:green; text-decoration: underline; font-style: italic;" onclick="reloadPageAndNavigate('{{ route('OrderLetter') }}')" disabled>
                                Download Order Form
                            </a>

                    </div>

                    <div class="form-group col-12 col-md-6 col-xl-3">
                        <div class="row justify-content-center ">
                            <div class="col-md-4 form-control" style="width400px:;" class="form-control">
                    <label for="reference-number">Upload Signed Order Form</label>
                    <div class="input-group">
                        <input type="file" name="fileOrder" id="fileComiteeInput" required
                            value="" disabled onclick="enableUploadInput()">
                        <div style="display:none" id= "errorComitee" class="text-danger">Please
                            select file
                        </div>

                    </div>
                </div>
            </div>
        </div>
                </div>
            </div>

            <center>
                <br> <br>
                <div class="col-6 col-md-6 col-xl-2">
                    <input type="submit" class="btn btn-primary w-100 " id="btnSub" onclick="validateFilesAndSubmit()"
                        value="SUBMIT ORDER FORM"  data-bs-toggle="modal"
                        data-bs-target="#exampleModalProgress" disabled>
                </div>
                <br> <br>
            </center>

        </form>
 
        
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>

function Select(){
    document.getElementById('downloadLink').style.pointerEvents = 'auto';

}

            $(document).ready(function() {
                $('.datepicker').change(function() {
                    var selectedDate = $("#DeliveryDate").val();
                    var closingDate = $("#closingDateInput").val();

                  //  alert('Selected Date: ' + selectedDate + ', Closing Date: ' + closingDate);
        
                    // AJAX request
                    $.ajax({
                        url: '{{ route("updateDeliveryDate") }}', // Use Laravel's route() helper function
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'), // Include CSRF token
                            deliveryDate: selectedDate,
                            closingDates:closingDate


                        },
                        success: function(response) {
                            console.log('Data updated successfully:', response);
                            // You can handle the response here if needed
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                });
            });
        </script>
        
        

  
            <script>
                $(document).ready(function() {

                    document.getElementById('downloadLink').style.pointerEvents = 'none';

                    $('.datepicker').datepicker({
                        startDate: new Date() // Set the start date to today
                    });
                });
                // Update the text input when a date is selected
                $('.datepicker').on('changeDate', function(e) {
                    $(this).val(e.format());
                });
            </script>


@if (session('sucessEmail') == true)
<script>
    $(document).ready(function() {
        $('#exampleModalSentEmail').modal('show');
    });
</script>

@endif


<script>
    function enableUploadInput() {
  document.getElementById('btnSub').disabled = false;


      

    }
</script>


<script>
    function reloadPageAndNavigate(route) {
        // Reload the page
        location.reload();

        // Navigate to the specified route after a short delay (adjust the delay as needed)
        setTimeout(function() {
            window.location.href = route;
        }, 500);  // 500 milliseconds delay, adjust as needed

      //  document.getElementById('btnSub').disabled = false;
        document.getElementById('fileComiteeInput').disabled = false;


    }
</script>
            
 
@endsection