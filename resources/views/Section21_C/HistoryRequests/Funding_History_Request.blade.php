
@extends('layouts.layout')
@section('title', 'History Requests')
@section('content')
    <main>
      
        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center border-bottom border-2" >
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Manage Funding</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('request.index') }}">Funds Procurement</a></li>
                            <li class="breadcrumb-item active"><a href="#"> History </a>
                            <li class="breadcrumb-item"><a href="{{ route('Funds.index') }}">Allocated Funds</a></li>

                            </li>
                        </ol>
                    </div>
                </div>
            </div>
               <br><br>
               <div class="row align-items-center border-bottom border-1" style="display: none;">
                <form action="{{ route('requestUpdate.funds') }}" method="POST">
                    @csrf
                    <h4 style="color: #198754 ">
                      {{--   @if ($StationaryProcument=='Yes' && $TextBoookProcument=='Yes')
                        Create stationery and textbook fund request for {{ $currentYear }}
                        @elseif($TextBoookProcument=='Yes')
                        Create textbook fund request for {{ $currentYear }}
                        @elseif ($StationaryProcument=='Yes')
                        Create stationery fund request for {{ $currentYear }}
                        @endif --}}

                        Update Request 
                       </h4><br>
                {{--     <div class="row">
        
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
        
                             @if($textbook_amount != null)
                                <div class="form-group col-12 col-md-6 col-xl-2">
                                    <input type="text" class="form-control form-control-lg decimal-input" name="firstAmount" style="box-shadow:0 0 0 0.25rem #7cbf7a" required="required" placeholder="R" value="{{ $textbook_amount }}">
                                    <span class="text-danger" style="display: none;" id="counterrorTextbook" role="alert">
                                        <strong id="counterrormsgTextbook"></strong>
                                    </span>
                                    <label>Textbook Amount</label>
                                </div>
                            @endif
                            
                            @if($stationery_amount != null)
                                <div class="form-group col-12 col-md-6 col-xl-2">
                                    <input type="text" class="form-control form-control-lg decimal-input" name="secondAmount" style="box-shadow:0 0 0 0.25rem #7cbf7a" required="required" placeholder="R" value="{{ $stationery_amount }}">
                                    <span class="text-danger" style="display: none;" id="counterrorStationery" role="alert">
                                        <strong id="counterrormsgStationery"></strong>
                                    </span>
                                    <label>Stationery Amount</label>
                                </div>
                            @endif
                            
                               
                                
                            </div>
                            <div class="col-12 mt-4 mb-2">
                                <button id="requestButton"  class="btn" type="submit">
                                    Update Request
                                </button>

                            </div>
                            <br>
                     
                        </div>
                    </div> --}}
                        
                </form> 
            </div>
             <br>
                <h4 style="color: #198754 ">
                    View Funding Requests Yearly
                    </h4><br>

                     <br>
                     @if ($message = Session::get('success'))
                     <div class="alert alert-success">
                       {{ $message  }}
                      </div>
                      @elseif ($message = Session::get('failed'))
                      <div class="alert alert-danger">
                        {{ $message  }}
                       </div>
                      @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
        
                                    <th>Reference No.</th>
                                    <th>Request Type</th>
                                        <th>Stationey Amount</th>
                                        <th>Textbook Amount</th>
                                    <th>Year</th>
                                    <th>Circular</th>
                                    <th>Status</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            {{-- @foreach ($data as $key => $value) --}}
                            
                            @if (count($data) < 1) <tbody>
                                <tr class="text-center text-dark">
                                    <td colspan="9">No request for funding has been made</td>
                                </tr>
                                </tbody>
                            @else
                            <tbody>
    
                                @foreach ($data as $item)
                             
                                    <tr  @if(($item->year)  == $yearnow )  style="background-color:#e6ffee" @endif >
                            
                                        <td>{{ $item->References_Number }}</td>
                                        <td>{{ $item->RequestType }}</td>
                                        @if(is_null($item->amount_stationery) )
                                        <td> N/A</td>
                                        @else
                                        <td>R {{ number_format($item->amount_stationery, 2, '.', ',') }}</td>
                                        @endif 
                                        @if(is_null($item->amount_textbook))
                                        <td>N/A</td>
                                        @else
                                        <td>R {{ number_format($item->amount_textbook, 2, '.', ',') }}</td> 
                                        @endif
                                       
                                        <td>{{ $item->year }}</td>
                                        
                                        <td > <i class="fa fa-download" aria-hidden="true"></i><a  href="{{ route('document.download', ['documentId' => $circular_id]) }}" >Download Circular</a></td>
                                        <td>{{ $item->Status }}</td>
                                        <td>
                                            @if( \Carbon\Carbon::parse($item->date)->year == $item->year  && $item->Status!="Approved" )
                                            <div class="d-flex">
                                
                                        {{--     <i class="ri-pencil-fill color-primary me-4 fs-2" id="editIcon"></i> --}}
                                               
                                         
                                            <form   action="{{  route('requestDelete.funds', ['deleteId'=> $item->School_Emis]) }} "  method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <button class="btn-reset" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}">
                                                    <i class="ri-delete-bin-7-fill"></i>
                                                </button>

                                                <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered popup-alert">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5" alt="">
                                                                    <h4 class="modal-title">Delete</h4>
                                                                    <p class="modal-title_des">Are you sure you want to delete?</p>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer justify-content-around text-center">
                                                                <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                                                                <button type="submit" class="btn btn-primary px-5">Yes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                            @endif
    
                                        </td>
                                    </tr>
                                @endforeach
    
    
                            </tbody>
                            @endif
    
                        </table>
                    </div>
                    <nav class="pagination-wrap">
                        <ul class="pagination">
                            <li class="page-item ">
                                <a class="" href="#">
                                    <i class="ri-arrow-left-s-line me-4"></i>
                                    Previous</a>
                            </li>
    
                            <li class="page-item">
                                <a class="" href="#">Next
                                    <i class="ri-arrow-right-s-line ms-4"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
       
    <main>

        <script>
            $(document).ready(function() {
                // Select the icon by its ID
                $('#editIcon').click(function() {
                    // Select the div by its class
                    var $editDiv = $('.row.align-items-center.border-bottom.border-1');
        
                    // Toggle the visibility of the div
                    $editDiv.toggle();
                });
            });
        </script>

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


 @endsection