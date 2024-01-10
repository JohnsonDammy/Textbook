@extends('layouts.layout')
@section('title', 'Manage Funding')
@section('content')
    <main>
        <style>
            .check {
                width: 50px;
                height: 20px;
            }

            .no-spinner::-webkit-inner-spin-button,
.no-spinner::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.no-spinner {
    -moz-appearance: textfield;
}

        </style>
        <div class="container">
          

            <!-- breadcrumb -->
            <div class="row align-items-center border-bottom border-2">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Manage Funding</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('request.index') }}">Procurement</a></li>
                            @if($NoDeclaration != 'Yes')
                            <li class="breadcrumb-item active"><a href="">Allocated Funds</a>
                            <li class="breadcrumb-item"><a href="{{ route('Request_History.index') }}">History</a></li>
                            @endif

                            </li>
                        </ol>
                    </div>
                </div>

              <br>

              @if($NoDeclaration != 'Yes')
              <h4 style="color: #198754 ">
                Procurement Process
            </h4><br>
                <div class="row align-items-center border-bottom border-2">
                    <div class="process row align-items-center text-center">
                        <div class="col content-col active">
                            <div class="circle-icon-container">
                                <i class="ri-add-fill"></i>
                            </div>
                            <p>Allocate funds</p>
                        </div>
                        <div class="col arrow-col ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                                <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                            </svg>
    
                        </div>
                        <div class="col content-col ">
                            <div class="circle-icon-container">
                                <i class="ri-layout-top-2-fill"></i>
                            </div>
                            <p>Generate Quotation</p>
                        </div>
                        <div class="col arrow-col ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                                <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                            </svg>
    
                        </div>
                        <div class="col content-col">
                            <div class="circle-icon-container">
                                <i class="ri-hammer-fill"></i>
                            </div>
                            <p>Upload Quotation</p>
                        </div>
                        <div class="col arrow-col ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                                <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                            </svg>
    
                        </div>
                        <div class="col content-col">
                            <div class="circle-icon-container">
                                <i class="ri-truck-fill"></i>
                            </div>
                            <p>Deliver Items</p>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            @endif
            
            <div class="row justify-content-center">
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
                                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                        onclick="hidePopup()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                        <h4 class="popup-alert_title">Manage Request Funding</h4>
                                        <p class="popup-alert_des">{{ $message }}</p>
                                    </div>

                                </div>
                                <div class="modal-footer text-center justify-content-center p-3 border-0">
                                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                        onclick="hidePopup()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($message = Session::get('alert'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5"
                                            alt="">
                                        <h4 class="popup-alert_title">Manage Request Funding</h4>
                                        <p class="popup-alert_des">{{ $message }}</p>
                                    </div>

                                </div>
                                <div class="modal-footer text-center justify-content-center p-3 border-0">
                                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                        onclick="hidePopup()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                
                    <div class="container">
                        <!-- breadcrumb -->

                      @if($NoDeclaration == 'Yes')
                         <p>No Declaration for this year.</p>
                      @else
                      <br><br>
                      <i class="fa fa-download" aria-hidden="true"></i><a  href="{{ route('document.download', ['documentId' => $circular_id]) }}" style="text-decoration: underline; font-size: 18px;" >Download Circular</a>
                      <br><br>
                      <div class="row align-items-center border-bottom border-2">
                            <form action="{{ route('request.funds') }}" method="POST">
                                @csrf
                                <h4 style="color: #198754 ">
                                    @if ($StationaryProcument=='Yes' && $TextBoookProcument=='Yes')
                                    {{ $currentYear }} Allocated Funds For Textbook And Stationery
                                    @elseif($TextBoookProcument=='Yes')
                                    {{ $currentYear }} Allocated Funds For Textbook
                                    @elseif ($StationaryProcument=='Yes')
                                    {{ $currentYear }} Allocated Funds For Stationery
                                    @endif
                                   </h4><br>
                                <div class="row">

                                    <input type="hidden" name="broken_items[]" id="broken_array" value="">
                                    <div class="col-12 col-md-12 my-3">
                                        <div class="row g-4">
                                            <div class="form-group col-12 col-md-6 col-xl-3">
                                                <input type="text" name="School" class="form-control form-control-lg"
                                                    disabled required="required" value="{{ Auth::user()->name }}"
                                                    placeholder=" ">
                                                <label>School Name</label>
                                                <input type="hidden" value="{{ Auth::user()->name }}"
                                                    name="SchoolName">
                                            </div>
                                            <div class="form-group col-12 col-md-6 col-xl-2">
                                                <input type="text" name="Emis" class="form-control form-control-lg"
                                                    value="{{ Auth::user()->username }}" disabled required="required"
                                                    placeholder=" ">
                                                <input type="hidden" value="{{ Auth::user()->username }}"
                                                    name="SchoolEmis">
                                                <label>School EMIS Number</label>
                                            </div>

                                            @if( $TextBoookProcument=='Yes')
                                            <div class="form-group col-12 col-md-6 col-xl-2">
                                                <input type="text"  disabled  value="R {{ number_format($AllocatedTextbook, 2, '.', ',') }} " class="form-control form-control-lg decimal-input"  style="box-shadow:0 0 0 0.25rem #7cbf7a" required="required" placeholder="R" >
                                                <input type="hidden"  value="{{ $AllocatedTextbook }} "  name="firstAmount">
                                                <span class="text-danger" style="display: none;" id="counterrorTextbook" role="alert">
                                                    <strong id="counterrormsgTextbook"></strong>
                                                </span>
                                                <label>Textbook Amount</label>
                                            </div>
                                            @endif

                                            @if( $StationaryProcument=='Yes')
                                            <div class="form-group col-12 col-md-6 col-xl-2">
                                                <input type="text" disabled  value="R {{ number_format($AllocatedStationery, 2, '.', ',') }} " class="form-control form-control-lg decimal-input" style="box-shadow:0 0 0 0.25rem #7cbf7a" required="required" placeholder="R" >
                                                <input type="hidden"  value="{{ $AllocatedStationery }}"  name="secondAmount" >
                                                <span class="text-danger" style="display: none;" id="counterrorStationery" role="alert">
                                                    <strong id="counterrormsgStationery"></strong>
                                                </span>
                                                <label>Stationery Amount</label>
                                            </div>
                                            @endif
                                            
                                
                                        <center>
                                        <div class="col-12 mt-4 mb-2">
                                            <button id="requestButton" style="width:150px;" class="btn" type="submit">
                                                OK
                                        </button>
                                   
                                            
    
                                        </div> 
                                    </center>
                                 
                                    </div>  
                            </form>
                            <br>
                        </div>
    
                            {{-- Update form --}}

                        {{--     <form action="{{ route('requestUpdate.funds') }}" method="POST">
                                @csrf
                                <h4 style="color: #198754 ">
                                    @if ($StationaryProcument=='Yes' && $TextBoookProcument=='Yes')
                                    Create stationery and textbook fund request for {{ $currentYear }}
                                    @elseif($TextBoookProcument=='Yes')
                                    Create textbook fund request for {{ $currentYear }}
                                    @elseif ($StationaryProcument=='Yes')
                                    Create stationery fund request for {{ $currentYear }}
                                    @endif
                                   </h4>
                                <div class="row">
                                    <div class="col-12 my-3">
                                        <div class=" bg-light fw-bold py-4 color-primary px-5">
                                            <p class="mb-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="checkbox" onchange="toggleButton()" class="check"
                                                        id="checkbox1" name="Textbook" value="Textbook" 
                                                        @if($existingRecords)
                                                        checked
                                                        @endif

                                                        required>
                                                    <label for="checkbox1"><b><a
                                                                style="color:blue; text-decoration: underline; "
                                                                href="{{ asset('public/pdf/School-Based Procurement.pdf') }}"
                                                                target="_blank">Read Allocation Circular: <b>PDF</b></a>
                                                        </b><b style="color:brown"></b></label>
                                                </div>

                                            </div>

                                            </p>
                                        </div>
                                    </div>

                                    <input type="hidden" name="broken_items[]" id="broken_array" value="">
                                    <div class="col-12 col-md-12 my-3">
                                        <div class="row g-4">
                                            <div class="form-group col-12 col-md-6 col-xl-3">
                                                <input type="text" name="School" class="form-control form-control-lg"
                                                    disabled required="required" value="{{ Auth::user()->name }}"
                                                    placeholder=" ">
                                                <label>School Name</label>
                                                <input type="hidden" value="{{ Auth::user()->name }}"
                                                    name="SchoolName">
                                            </div>
                                            <div class="form-group col-12 col-md-6 col-xl-3">
                                                <input type="text" name="Emis" class="form-control form-control-lg"
                                                    value="{{ Auth::user()->username }}" disabled required="required"
                                                    placeholder=" ">
                                                <input type="hidden" value="{{ Auth::user()->username }}"
                                                    name="SchoolEmis">
                                                <label>School EMIS Number</label>
                                            </div>

                                            @if( $TextBoookProcument=='Yes')
                                            <div class="form-group col-12 col-md-6 col-xl-4">
                                                <input type="text" class="form-control form-control-lg"
                                                name="firstAmount" style="box-shadow:0 0 0 0.25rem #7cbf7a"
                                                required="required" placeholder="Enter Textbook Request Amount" 
                                                @if($existingRecords)
                                                value="{{ $fundTextbook}}" @endif>
                                                <span class="text-danger" style="display: none;" id="counterror"
                                                    role="alert">
                                                    <strong id="counterrormsg">Funds Amount is required</strong>
                                                </span>
                                                <label>Textbook Funds Amount</label>
                                            </div>
                                            @endif

                                            @if( $StationaryProcument=='Yes')
                                            <div class="form-group col-12 col-md-6 col-xl-4">
                                                <input type="text" class="form-control form-control-lg"
                                                name="secondAmount" style="box-shadow:0 0 0 0.25rem #7cbf7a"
                                                required="required" placeholder="Enter Stationery Request Amount"
                                                @if($existingRecords)
                                                value="{{$fundStationery}}"@endif>
                                                <span class="text-danger" style="display: none;" id="counterror"
                                                    role="alert">
                                                    <strong id="counterrormsg">Funds Amount is required</strong>
                                                </span>
                                                <label>Stationery Funds Amount</label>
                                            </div>
                                            @endif
                                            
                                
                                        <div class="col-12 mt-4 mb-2">
                                            <button id="requestButton" style="display: none" class="btn" type="button"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                                @if($existingRecords)
                                                Update request 
                                                @else
                                                Create request 
                                                @endif
                                            </button>
    
                                        </div>
                                 
                                    </div>
                              
                                    
                            </form> --}}


                     <div class="modal fade" id="exampleModal1" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered popup-alert">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center">
                                    <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                        class="img-fluid mb-5" alt="">
                                    <h4 class="modal-title popup-alert_des fw-bold"> 
                                        @if($TextBoookProcument=='Yes')
                                          Textbook Funds Request
                                        @elseif ($StationaryProcument=='Yes')
                                          Stationery Funds Request
                                        @elseif ($StationaryProcument=='Yes' && $TextBoookProcument=='Yes')
                                          Stationery and Textbook Funds Request
                                        @endif
                                    </h4>
                                    <p class="modal-title_des">Are you sure of your selection</p>
                                </div>

                            </div>
                            <div class="modal-footer justify-content-around text-center">
                                <button type="button" class="btn btn--dark px-5"
                                    data-bs-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-secondary px-5">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Model pop up to show request cant be created for the current year if it exiists --}}
        
                        @endif
                     
                    </div>
           
       

            </div>
            <br><br>


            {{-- <div class="col-12">
                @if ($message = Session::get('searcherror'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $message }}
                    </div>
                @endif

                <h4 style="color: #198754 ">
                
                    View Request {{ $currentYear }}
    
                </h4><br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Reference No.</th>
                                <th>Request Type</th>
                                @if($StationaryProcument == 'Yes' && $TextBoookProcument=='Yes')
                                    <th>Stationey Amount</th>
                                    <th>Textbook Amount</th>
                                @elseif ($StationaryProcument == 'Yes')
                                    <th>Stationey Amount</th>
                                @elseif ( $TextBoookProcument == 'Yes')
                                     <th>Textbook Amount</th>
                                @endif
                                <th>Year</th>
                                <th>Circular</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        @if (count($data) < 1) <tbody>
                            <tr class="text-center text-dark">
                                <td colspan="9">No Stationery request has been created for the current year</td>
                            </tr>
                            </tbody>
                        @else
                        <tbody>
                          @foreach ($data as $item)
                                <tr> 
                                    <td>{{ $item->References_Number }}</td>
                                    <td>{{ $item->RequestType }}</td>
                                    @if($StationaryProcument == 'Yes' && $TextBoookProcument=='Yes')
                                        <td>R {{ number_format($item->amount_textbook, 2, '.', ',') }}</td> 
                                        <td>R {{ number_format($item->amount_stationery, 2, '.', ',') }}</td> 
                                    @elseif ($StationaryProcument == 'Yes')
                                        <td>R {{ number_format($item->amount_stationery, 2, '.', ',') }}</td>
                                    @elseif ( $TextBoookProcument == 'Yes')
                                       <td>R {{ number_format($item->amount_textbook, 2, '.', ',') }}</td> 
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($item->date)->year }}</td>
                                    <td > <i class="fa fa-download" aria-hidden="true"></i><a  href="{{ route('document.download', ['documentId' => $circular_id]) }}" >Download Circular</a></td>

                                    <td>{{ $item->Status }}</td>
                                </tr>
                           
                            @endforeach


                        </tbody>
                     @endif
                    </table>
                </div>
            </div>
        </div> --}}
  
      </div>
    </main>
    </div>
    </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    @if ($message = Session::get('error'))
        <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    @if ($message = Session::get('alert'))
        <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif

 
    <script>
        function hidePopup() {
            $("#exampleModal").fadeOut(200);
            $('.modal-backdrop').remove();
            console.log("hidePop")
        }

        $(function() {
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();

            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;
            $('.dates').attr('max', maxDate);
        });
    </script>

    <script>
        function toggleButton() {
            var checkbox = document.getElementById('checkbox1');
            var requestButton = document.getElementById('requestButton');

            if (checkbox.checked) {
                requestButton.style.display = 'block';
            } else {
                requestButton.style.display = 'none';
            }
        }
    </script>

    {{-- Show model pop up if the record exists --}}
    <script>
        $(document).ready(function() {
            // Listen for the button click event
            $('#requestButton').on('click', function() {
                // Trigger the modal with the specified ID
                @if($existingCurrentRequest)  
                $('#ModelCreateCheck').modal('show');
                @endif
            });
        });
    </script>

 
    {{-- Format the textboxes amounts as currency value --}}
    <script>
        $(document).ready(function() {
            $('.decimal-input').on('input', function() {
                @if($existingCurrentRequest)  
                $('#ModelCreateCheck').modal('show');
                @endif
                var inputValue = $(this).val();
                var numericValue = parseFloat(inputValue.replace(/[^0-9.]/g, ''));
                var id = $(this).attr('name'); // Get the name attribute
                var errorElement = $(this).next('span.text-danger'); // Locate the next error message
    
                if (isNaN(numericValue) && inputValue.trim() !== "") {
                    // Handle non-numeric input (but not for empty fields)
                    $(this).css('border-color', 'red');
                    errorElement.text('Invalid, Please enter a number.');
                    errorElement.show();
                } else {
                    // Revert to normal style and hide the error message
                    $(this).css('border-color', '');
                    errorElement.hide();
                }
            });
        });
    </script>
    
    
    
    
    

    </main>
@endsection
