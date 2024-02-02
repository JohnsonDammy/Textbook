@extends('layouts.layout')
@section('title', 'Manage Inbox')
@section('content')
    <main>
       
        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center border-bottom border-2">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Manage Inbox</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('Funds.index') }}">Inbox</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('Funds.index') }}">Allocated Funds</a></li>
 
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
 
            <div class="row align-items-center border-bottom border-2">
                <div class="table-responsive">
                    <br><br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Reference Number </th>
                                <th>Request Type</th>
                                <th>Allocation</th>
                                <th>Status</th>
                                <th>Activity</th>
                            </tr>
                        </thead>
 
                        @if (count($data) < 1)
                            <tbody>
                                <tr class="text-center text-dark">
                                    <td colspan="9">Proccess Complete</td>
                                </tr>
                            </tbody>
                        @else
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->referenceNo }}</td>
                                        <td>{{ $item->requestType }}</td>
                                        <td> R {{ number_format($item->allocation, 2, '.', ',') }}</td>
                                        <td>{{ $item->status }}</td>
 
                                        <td>
                                           
                                           
                                           
                                            <a 
                                            @if($item->activity_name == "Request Quote") class="myModalLink" @endif 
                                            style="color:green; text-decoration: underline; font-style:italic"
                                            @if($item->activity_name == "Create Quote")
                                              
                                                @if($item->requestType == "Textbook")
                                                href="{{ route('textbookCat', ['requestType' => $item->requestType , 'idInbox' =>$item->Id ]) }}"
                                                @else
                                                href="{{ route('stationeryCat', ['requestType' => $item->requestType , 'idInbox' =>$item->Id ]) }}"
                                                @endif
                                            @elseif($item->activity_name == "Request Quote")
                                            
                                                @if (session('countSuppliers') < 3 || session("countComitee") < 1)
                                                    href="#"
                                                @else
                                                href="{{ route('chooseSupplier', ['requestType' => $item->requestType, 'MinQuotes' => 'None']) }} "
                                                @endif
                                            
                                            @elseif($item->activity_name == "Create New Quote")
                                            href="{{ route('stationeryCatNew', ['requestType' => $item->requestType , 'idInbox' =>$item->Id ]) }}"

                                            @else
                                          
                                            href="{{ route('receiveQuotes', ['requestType' => $item->requestType ]) }} "
                                            @endif
                                             class="toggleLink" data-toggle="{{ $item->Id }}">{{ $item->activity_name }}  </a>
                                         
 
 
                                         
                                        </td>
 
                                    </tr>
                                @endforeach
 
 
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>

           
             {{-- Model Indicating suppliers and comitees info need to be filled out --}}
             <div class="modal fade" id="exampleWarning" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered popup-alert">
                 <div class="modal-content">
                     <div class="modal-body">
                         <div class="text-center">
                             <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5">
                             <h4 class="modal-title"></h4>
                             <p class="modal-title_des">
                                Please setup supplier and/or commitee members 
                             </p>
                         </div>

                     </div>
                     <div class="modal-footer justify-content-around text-center">
                         <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">Ok</button>

                     </div>
                 </div>
             </div>
         </div>



         <script>
             // Use jQuery to handle the click event
             $('.myModalLink').click(function (event) {
              
        
                 // Show the modal if the condition is true
                 @if ((session('countSuppliers') < 3 || session("countComitee") < 1 ) ) {
                     $('#exampleWarning').modal('show');
                 }
                 @endif
        
                
             });
         </script>
 
            @endsection