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
 
            <div class="row align-items-center border-bottom border-2">
                <div class="table-responsive">
                    <br><br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Reference Number </th>
                                <th> Emis </th>
                                <th> School Name </th>

                                <th>Request Type</th>
                                <th>Allocation</th>
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

                                        @endphp
                                        {{$SName}}
                                        </td>
                                        <td>{{ $item->requestType }}</td>
                                        <td> R {{ number_format($item->allocation, 2, '.', ',') }}</td>
                                      
 
                                        <td>
                                           
                                            <a href="{{route('AdminCaptureSupplierOrder' , ['requestType' => $item->requestType , 'emis' => $item->school_emis , 'fundsId' => $item->funds_request_id ])}}"> <button>View Quote</button></a>                                           
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
            </div>
 
            @endsection