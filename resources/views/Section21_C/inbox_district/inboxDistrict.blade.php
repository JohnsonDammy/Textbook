@extends('layouts.layout')
@section('title', 'Inbox Page')
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
            
 
            <div class="col-12 col-md-12 my-3">
                <p class="filter-title">Transactions Search</p>
                <form method="get" action="/TransactionSearchView">
                    <div class="row justify-content-center align-items-center g-4">
                        <div class="col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control rounded-0" name="ref_number" placeholder="Reference Number">
                        </div>
    
                        <div class="col-12 col-md-6 col-xl-6">
                            <input type="text" class="form-control search-input rounded-0" name="school_name" placeholder="School Name">
                        </div>
     

                        <div class="col-12 col-md-6 col-xl-3">
                            <select class="form-select form-control rounded-0" name="RequestType" aria-label="Default select example">
                                <option selected value="">Request Type</option>
                                <option value="Textbook">Textbook</option>
                                <option value="Stationery">Stationery</option>

                            </select>
                        </div>
             
                        <div class="col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control rounded-0" name="emis" placeholder="EMIS Number"    style="margin-left:-328px" >
                        </div>
                        <div class="col-6 col-md-6 col-xl-1 text-end">

                            <a type="reset" href="{{ route('InboxSchoolDistrict') }}" class="btn-reset px-4 text-decoration-underline" value="Clear">Clear </a>
                     
                        </div>
                        <div class="col-6 col-md-6 col-xl-2">
                            <input type="submit" class="btn btn-primary w-100 " value="Search">
                        </div>
                    </div>
                    @if(isset($messages))
                        <p>{{ $messages }}</p>
                    @endif
                </form>
            </div>
            
            <div class="row align-items-center border-bottom border-2">
                <div class="table-responsive">
                    <br><br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Reference Number </th>
                                <th> Emis </th>
                                <th> School Name</th>
                                <th>Request Type</th>
                                <th>Allocation</th>
                                <th>Download</th>
                                <th>Activity</th>
                            </tr>
                        </thead>
 
                        @if (count($data) < 1)
                            <tbody>
                                <tr class="text-center text-dark">
                                    <td colspan="9">Requests has not been made for funds allocation</td>
                                </tr>
                            </tbody>
                        @else
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->referenceNo }}</td>
                                        <td>{{ $item->school_emis }}</td>
                                        <td>
                                            @php
                                            $SchoolNames = $SchoolData
                                                ->where('emis', $item->school_emis)
                                                ->first(); // Use first() to get the first matching item

                                            // Check if $orderedAmt is not null before accessing the "ordered_amt" attribute
                                            $SName = $SchoolNames ? $SchoolNames->name : null;
                                            print $SName;
                                        @endphp
                                        <td>{{ $item->requestType }}</td>
                                        <td> R {{ number_format($item->allocation, 2, '.', ',') }}</td>
                                        
                                        <td>   <i class="fas fa-download"    {{-- @if ($capturedSupplierRecord != null) style="color: green ;" @else style="color:  grey;" @endif --}} ></i>
                                            <a
                                               @if ( $item->checkListName  != null)  
                                                href= " {{ route('downloadCheckList', ['emis' =>$item->school_emis, 'requestType' => $item->requestType ]) }} "
                                                style="color:green; text-decoration: underline; font-style: italic;"
                                                @else
                                                style="color: grey; text-decoration: none; cursor: not-allowed; font-style: normal;" @endif   >
                                                CheckList
                                            </a>
                                        </td>
 
                                        <td>

                                            @if ($item->requestType === "Stationery")
                                            <a href="{{route('AdminCaptureStatUnitPrice' , ['RequestTypes' => $item->requestType , 'Emis' => $item->school_emis , 'fundsId' => $item->funds_request_id ])}}"> <button>Capture Prices</button></a>                                           

                                            @elseif ($item->requestType === "Textbook")
                                            <a href="{{route('AdminCaptureSupplierOrder' , ['requestType' => $item->requestType , 'emis' => $item->school_emis , 'fundsId' => $item->funds_request_id ])}}"> <button>&nbsp;View Quote &nbsp;</button></a>                                           
                                            @endif
{{--                                            
                                            <a  style="color:green; text-decoration: underline; font-style:italic"
                                            @if($item->activity_name == "Create Quote")
                                                @if($item->requestType == "Textbook")
                                                href="{{ route('textbookCat', ['requestType' => $item->requestType , 'idInbox' =>$item->Id ]) }}"
                                                @else
                                                href="{{ route('stationeryCat', ['requestType' => $item->requestType , 'idInbox' =>$item->Id ]) }}"
                                                @endif
                                            @else
                                             href="{{ route('chooseSupplier', ['requestType' => $item->requestType ]) }} "
                                            @endif
                                             class="toggleLink" data-toggle="{{ $item->Id }}">{{ $item->activity_name }}  </a> --}}
                                         
 
                                         
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
                            <a class="{{ $data->previousPageUrl() ? '' : 'disabled' }}"
                                href="{{ $data->previousPageUrl() }}">
                                <i class="ri-arrow-left-s-line me-4"></i>
                                Previous</a>
                        </li>

                        <li class="page-item">
                            <a class="{{ $data->nextPageUrl() ? '' : 'disabled' }}"
                                href="{{ $data->nextPageUrl() }}">Next
                                <i class="ri-arrow-right-s-line ms-4"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
 
            @endsection