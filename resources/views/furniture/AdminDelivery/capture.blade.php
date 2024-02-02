@extends('layouts.layout')
@section('title', 'Capture Requests')
@section('content')

    @php
        $totalLoops = 0;
        $totalPriceForSchool = 0;
        $totalPriceCapturedQuantity = 0;
        $statement = '';
        $OutStandingAmount = 0;
        $totalCapturedQuantity =0;
        $totalPriceCapturedQuantityNew = 0;

        $totalQuantity =0;
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

            .custom-table tbody tr {
                height: 10px;
                /* Adjust the height as needed */
            }

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
                        <h4>Capture Delivered Items</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a
                                    href="{{ route('textbookCat', ['requestType' => 'Textbook', 'idInbox' => 1]) }}">Capture
                                    Data</a></li>
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
                <div class="tabs">
                    <a href="#" style="display:none"
                        class="tab-link {{ session('activeTab') == 'tab2' ? 'active' : '' }}" data-tab="tab2"
                        data-toggle="2">Capture Delivery Note</a>

                    <a href="#" class="tab-link {{ session('activeTab') == 'tab1' ? 'active' : '' }}" data-tab="tab1"
                        data-toggle="1">Ordered Items</a>

                    <a href="#" class="tab-link {{ session('activeTab') == 'tab3' ? 'active' : '' }}" data-tab="tab3"
                        data-toggle="3">View Items</a>

                    <!-- Your tab content here -->
                    <div class="tab-content " data-toggle="1" id="tab1" id="textbooks-container">
                        <div class="col-12 col-md-12 my-3" id="textbooks-container">

                            @if (session('quoteStatus') == 'Quote Created')
                                <br>
                                <p style="color: red; font-weight: bold;"> Please note quote has been created for
                                    {{ date('Y') }}. All actions on this form has been disabled. </p>
                                <br>
                            @endif

                            <form action="{{ route('filterTextbookAdmin') }}" method="get">
                                <div class="row justify-content-center align-items-center g-4">


                                    <div class="col-12 col-md-6 col-xl-3">
                                        <select class="form-select form-control rounded-0" id="C" name="Grade"
                                            aria-label="Default select example" required>
                                            <option value="default"> ALL Grades</option>
                                            {{-- Grade drop down list for combined schools --}}
                                            @if ($schoolLevel == 3)
                                                <option value="1"
                                                    {{ session('selectedGrade') == '1' ? 'selected' : '' }}>1
                                                </option>
                                                <option value="2"
                                                    {{ session('selectedGrade') == '2' ? 'selected' : '' }}>2
                                                </option>
                                                <option value="3"
                                                    {{ session('selectedGrade') == '3' ? 'selected' : '' }}>3
                                                </option>
                                                <option value="4"
                                                    {{ session('selectedGrade') == '4' ? 'selected' : '' }}>4
                                                </option>
                                                <option value="5"
                                                    {{ session('selectedGrade') == '5' ? 'selected' : '' }}>
                                                    5
                                                </option>
                                                <option value="6"
                                                    {{ session('selectedGrade') == '6' ? 'selected' : '' }}>
                                                    6
                                                </option>
                                                <option value="7"
                                                    {{ session('selectedGrade') == '7' ? 'selected' : '' }}>
                                                    7
                                                </option>

                                                <option value="8"
                                                    {{ session('selectedGrade') == '8' ? 'selected' : '' }}>
                                                    8
                                                </option>
                                                <option value="9"
                                                    {{ session('selectedGrade') == '9' ? 'selected' : '' }}>
                                                    9
                                                </option>
                                                <option value="10"
                                                    {{ session('selectedGrade') == '10' ? 'selected' : '' }}>10
                                                </option>
                                                <option value="11"
                                                    {{ session('selectedGrade') == '11' ? 'selected' : '' }}>11
                                                </option>
                                                <option value="12"
                                                    {{ session('selectedGrade') == '12' ? 'selected' : '' }}>12
                                                </option>
                                                {{-- Grade drop down list for Primary schools --}}
                                            @elseif ($schoolLevel == 1)
                                                <option value="1"
                                                    {{ session('selectedGrade') == '1' ? 'selected' : '' }}>
                                                    1
                                                </option>
                                                <option value="2"
                                                    {{ session('selectedGrade') == '2' ? 'selected' : '' }}>
                                                    2
                                                </option>
                                                <option value="3"
                                                    {{ session('selectedGrade') == '3' ? 'selected' : '' }}>
                                                    3
                                                </option>
                                                <option value="4"
                                                    {{ session('selectedGrade') == '4' ? 'selected' : '' }}>
                                                    4
                                                </option>
                                                <option value="5"
                                                    {{ session('selectedGrade') == '5' ? 'selected' : '' }}>
                                                    5
                                                </option>
                                                <option value="6"
                                                    {{ session('selectedGrade') == '6' ? 'selected' : '' }}>
                                                    6
                                                </option>
                                                <option value="7"
                                                    {{ session('selectedGrade') == '7' ? 'selected' : '' }}>
                                                    7
                                                </option>
                                                {{-- Grade drop down list for Secondary schools --}}
                                            @else
                                                <option value="8"
                                                    {{ session('selectedGrade') == '8' ? 'selected' : '' }}>
                                                    8
                                                </option>
                                                <option value="9"
                                                    {{ session('selectedGrade') == '9' ? 'selected' : '' }}>
                                                    9
                                                </option>
                                                <option value="10"
                                                    {{ session('selectedGrade') == '10' ? 'selected' : '' }}>10
                                                </option>
                                                <option value="11"
                                                    {{ session('selectedGrade') == '11' ? 'selected' : '' }}>11
                                                </option>
                                                <option value="12"
                                                    {{ session('selectedGrade') == '12' ? 'selected' : '' }}>12
                                                </option>
                                            @endif

                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-3">
                                        <select class="form-select form-control rounded-0" name="Subject"
                                            aria-label="Default select example">
                                            <option selected value="default">ALL Subjects</option>
                                            @foreach ($Subjects as $Subject)
                                                <option value="{{ $Subject }}"
                                                    {{ old('Subject', session('selectedSubject')) == $Subject ? 'selected' : '' }}>
                                                    {{ $Subject }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-6 col-xl-3">
                                        <select class="form-select form-control rounded-0" name="Publisher"
                                            aria-label="Default select example">
                                            <option selected value="default"> ALL Publishers</option>
                                            @foreach ($Publishers as $Publisher)
                                                <option value="{{ $Publisher }}"
                                                    {{ old('Publisher', session('selectedPublisher')) == $Publisher ? 'selected' : '' }}>
                                                    {{ $Publisher }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-6 col-md-6 col-xl-1 text-end">

                                        <a type="reset"
                                            href="{{ route('textbookCat', ['requestType' => $requestType, 'idInbox' => $idInbox]) }}"
                                            class="btn-reset px-4 text-decoration-underline" value="Clear">Clear </a>


                                    </div>
                                    <div class="col-6 col-md-6 col-xl-2">
                                        <input type="submit" class="btn btn-primary w-100 " value="Filter">
                                        <br>

                                    </div>
                                </div>
                            </form>
                            {{-- Textbook Catalogue Table --}}
                            <br>
                            @if (session('activeTab') != 'tab3')
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        {{ $message }}
                                    </div>
                                @elseif ($message = Session::get('failed'))
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                @endif
                            @endif
                            <form id="saveItemsForm" action="{{ route('saveCheckedItemsForTextbookQuantity') }} " onsubmit="submitForm()"
                                method="post">
                                @csrf
                                <input type="hidden" name="UncheckedItems" value="">
                                    <center>  <span id="EllaEatBreatAndSource" style="color: red; display:none;">Execeeded expected quantity</span></center>
                                <div {{-- class="table-responsive" --}}>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th> </th>
                                                <th> ISBN </th>
                                                <th>Grade</th>
                                                <th>Title</th>
                                                <th>Publisher</th>
                                                <th>Subject</th>
                                                <th>Price</th>
                                                <th>Ordered Quantity</th>
                                                <th>Delivered Quantity</th>

                                            </tr>
                                        </thead>

                                        <p> {{ session('selectedItemsString') }} </p>
                                        @if (count(session('textbooksData')) < 1)
                                            <tbody>
                                                <tr class="text-center text-dark small">
                                                    <td colspan="9">There is no records that matches your filter
                                                        criteria
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @else
                                            <tbody>
                                                @foreach (session('textbooksData') as $item)
                                                    <tr class="pt-1 px-1">
                                                        <td>
                                                            <input type="checkbox" class="checkbox"
                                                                id="Checkbox_{{ $item->id }}" name="selectedItems[]"
                                                                value="{{ $item->id }}" {{-- @if (session('textbookDataFromDatabase')->contains('ISBN', $item->ISBN)) checked @endif --}}>

                                                        </td>
                                                        <td><input type="hidden" name="ISBN"
                                                                value="{{ $item->ISBN }}"> {{ $item->ISBN }} </td>
                                                        <td><input type="hidden" name="Grade"
                                                                value="{{ $item->Grade }}"> {{ $item->Grade }} </td>
                                                        <td>

                                                            <div class="short-text" title="{{ $item->Title }}">
                                                                {{ Str::limit($item->Title, 40) }}
                                                                <input type="hidden" name="Title"
                                                                    value="{{ $item->Title }}">
                                                            </div>
                                                        </td>

                                                        <td> <input type="hidden" name="Publisher"
                                                                value="{{ $item->Publisher }}"> {{ $item->Publisher }}
                                                        </td>
                                                        <td><input type="hidden" name="Subject"
                                                                value="{{ $item->Subject }}"> {{ $item->Subject }}</td>
                                                        <td><input type="hidden" name="Price"
                                                                value="{{ $item->Price }}"> {{ $item->Price }}</td>

                                                                @php
                                                                $deliveredQuantity= $item->Quantity ;
                                                                $totalCapturedQuantity=  session('allTextbookItemsSaved')->where('ISBN', $item->ISBN)->sum('Captured_Quantity');
                                                            @endphp

                                                        <td>

                                                            <input type="hidden"
                                                                name="selectedQuantities[{{ $item->id }}]"
                                                                value="{{ $item->Quantity ?? '' }}" id="ItemQuantity" >

                                                            <input type="number" class="form-control"
                                                                name="selectedQuantities[{{ $item->id }}]"
                                                                id="QuantitySelected_{{ $item->id }}"
                                                                style="box-shadow: 0 0 0 0.25rem #7cbf7a; width: 60px; height: 20px;"
                                                                min="" required disabled
                                                                value="{{ $item->Quantity ?? '' }}"
                                                                @if (session('quoteStatus') == 'Quote Created') disabled @endif
                                                               >
                                                            </span>


                                                        </td>

                                                        @php
                                                      //  $totalQuantity = $item->Quantity;

                                                        $totalQuantity += $item->Quantity;

                                                      // or {{$totalQuantity}} if this is within a Blade template
                                                       @endphp
                                                        <td>

                                                            {{-- <input type="number" class="form-control input-sm quantity-input input" name="CapturedQuantity[{{ $item->id }}]" id="Quantity_{{ $item->id }}" style="box-shadow: 0 0 0 0.25rem #7cbf7a; width: 60px; height: 20px;" min="0" disabled required> --}}
                                                                
                                                            <input type="number"
                                                                class="form-control input-sm quantity-input input"
                                                                name="CapturedQuantity[{{ $item->id }}]"
                                                                id="QuantityCaptured_{{ $item->id }}"
                                                                value="{{-- {{ session('textbookDataFromDatabase')->where('ISBN', $item->ISBN)->first()->Captured_Quantity ?? '' }} --}}"
                                                                style="box-shadow: 0 0 0 0.25rem #7cbf7a; width: 60px; height: 20px;"
                                                                max="{{ $item->Quantity }}"
                                                                oninput="highlightIfMax(this, {{ $item->Quantity }}, {{ $totalCapturedQuantity }}, {{ $deliveredQuantity }}, event);"
                                                                onblur="validateInput(this)" disabled
                                                                
                                                                required>

                                                        </td>
                                                    </tr>

                                                    @php
                                                    $price = $item->Price;
                                                    $Quantitys = $item->Quantity;
                                                    $totalPriceCapturedQuantityNew = $price * $Quantitys;

                                                    @endphp

                                                @endforeach

                                                @php
                                                     // echo $totalQuantity; 

                                                      session(['totalQuantityNew' => $totalQuantity ]);
                                                @endphp

                                                <input type="hidden" value="{{$totalPriceCapturedQuantityNew}}" name="TPCapQuantity">

                                            </tbody>

                                    </table>

                                    <style>
                                        .pagination-wrap a {
                                            margin-right: -70px;
                                            /* Adjust this value to add more or less space */
                                        }
                                        .pagination-wrap a:last-child{
                                            margin-right: 70;
                                            /* Remove margin from the last link to avoid extra space */
                                        }
                                    </style>
                                    <div id="pagination-links">
                                        <center>
                                            <nav class="pagination-wrap">
                                                <ul class="pagination">
                                                    <li class="page-item ">

                                                        <a class="{{ $textbooksData->previousPageUrl() ? 'next-page-link' : 'disabled' }}"
                                                            href="#" style="margin-left: -100;">
                                                            {{-- <i class="ri-arrow-left-s-line me-4"></i> --}}
                                                            <input type="hidden" name="previousPage" value="">
                                                            <button type="submit" class="page-link" id="PreviousButton">
                                                                <i class="ri-arrow-left-s-line me-4"></i>
                                                                Previous
                                                            </button>
                                                        </a>
                                                    </li>
                                                    @php
                                                        $currentPage = session('textbooksData')->currentPage();
                                                        $totalPages = session('textbooksData')->lastPage();
                                                    @endphp
                                                    <center style="margin-right: -60px; margin-top: 10px;">
                                                        Page: {{ $currentPage }}/{{ $totalPages }}
                                                    </center>
                                                    <li class="page-item">
                                                        <a class="{{ $textbooksData->nextPageUrl() ? 'next-page-link' : 'disabled' }}"
                                                            href="#">
                                                            {{--  <i class="ri-arrow-right-s-line ms-4"></i> --}}
                                                            <input type="hidden" name="nextPage" value="">
                                                            <button type="submit" class="page-link" id="NextButton">
                                                                <i class="ri-arrow-right-s-line ms-4"></i>
                                                                Next
                                                            </button>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </center>

                                    </div>

                                    <center>
                                        {{-- <div class="card" id="minQuotesSelection">
                                            <h5 class="card-header" style =" color:#14A44D">Check for final capture </h5>
                                            <div class="card-body">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="inlineRadioOptions" id="inlineRadio2" value="Yes">
                                                    <label class="form-check-label" for="inlineRadio2">Final
                                                        Capture</label>
                                                </div>
                                                <br>
                                            </div>
                                        </div> --}}
                                </div>



                                

                                <div class="row justify-content-center align-items-center g-4"
                                    style="margin-right: -90px;">
                                    <div class="col-6 col-md-6 col-xl-2">
                                        <input type="hidden" id="preventSubmission" name="preventSubmission" value="">
                                        <input style="margin-left: 30px" type="submit" id="submitFormButton"
                                            class="btn btn-primary btn-sm" value="SUBMIT"
                                            @if (session('quoteStatus') == 'Quote Created') disabled @endif><br>

                                    </div>

                                </div>

                          

                            </div>

                                </center>


                        </div>


                        @endif

                        </form>
                    </div>

                </div>

                <div class="tab-content" data-toggle="2" id="tab2" id="textbooks-container">

                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>RequestType</th>
                            <th>Delivery Note</th>
                            <th>Date</th>
                        </tr>
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

                                </tbody>
                            @endforeach
                        @endif

                    </table>
                </div>


                <div class="tab-content" data-toggle="3" id="tab3">
                    <div class="col-12 col-md-12 my-3" id="textbooks-container">

                        <div class="row justify-content-center align-items-center g-4">
                            <br><br>
                            {{-- Display Saved Items of Textbook Catalogue --}}
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                </div>
                            @elseif ($message = Session::get('failed'))
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @endif
                            <style>
                                .scrollable-table {
                                    max-height: 700px;
                                    /* Adjust the height as needed */
                                    overflow-y: auto;
                                }
                            </style>
                            <div class="scrollable-table">
                                <div class="table-responsive">
                                    <table class="table">

                                        <thead>
                                            <tr>

                                                {{-- <th> Emis </th> --}}
                                                <th>ISBN</th>
                                                <th>Grade</th>
                                                <th>Title</th>
                                                <th>Publisher</th>
                                                <th>Subject</th>
                                                <th>Price</th>
                                                <th>

                                                    <div class="short-text" title="Ordered Quantity">
                                                        {{ Str::limit('O / Q', 40) }}
                                                    </div>
                                                </th>
                                                <th>

                                                    <div class="short-text" title="Delivered Quantity">
                                                        {{ Str::limit('D / Q', 40) }}
                                                    </div>

                                                </th>
                                                <th>
                                                    <div class="short-text" title="Remaining Quantity">
                                                        {{ Str::limit('R / Q', 40) }}
                                                    </div>
                                                </th>

                                                <th> Action </th>
                                            </tr>
                                        </thead>

                                        @if (count(session('textbookDataFromDatabase')) < 1)
                                            <tbody>
                                                <tr class="text-center text-dark">
                                                    <td colspan="9">There is no saved Items to be displayed.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @else
                                            <tbody>
                                                @foreach (session('textbookDataFromDatabase') as $item)
                                                    <tr>
                                                        {{-- <td> {{ $item->Emis }} </td> --}}
                                                        <td> {{ $item->ISBN }} </td>
                                                        <td> {{ $item->Grade }} </td>
                                                        <td class="col-md-4">
                                                            <div class="short-text" title="{{ $item->Title }}">
                                                                {{ Str::limit($item->Title, 40) }}
                                                            </div>
                                                        </td>
                                                        <td> {{ $item->Publisher }} </td>
                                                        <td> {{ $item->Subject }} </td>


                                                        @php
                                                            $price = (float) str_replace(['R', ',', ' '], '', $item->Price);
                                                            $Quantity = $item->Quantity;
                                                            $totalPriceForSchool = $price * $Quantity;

                                                            $totalDeliveredQuantity=  session('allTextbookItemsSaved')->where('ISBN', $item->ISBN)->sum('Captured_Quantity');

                                                        @endphp

                                                        <td> R {{ number_format($item->Price, 2, '.', ',') }} </td>
                                                        <td> {{ $item->Quantity }} </td>
                                                        <td> {{ $totalDeliveredQuantity}} </td>


                                                        @php
                                                            $price = (float) str_replace(['R', ',', ' '], '', $item->Price);
                                                            $Quantity = $item->Captured_Quantity;
                                                            $totalPriceCapturedQuantity =   $totalPriceCapturedQuantity +$price * $Quantity;

                                                            $RealQuantity = $item->Quantity;
                                                            $CapturedQuantity = $item->Captured_Quantity;

                                                            $totalCapturedQuantitys=  session('allTextbookItemsSaved')->where('ISBN', $item->ISBN)->sum('Captured_Quantity');



                                                            $OutStandingAmount = $RealQuantity - $totalCapturedQuantitys;
                                                        @endphp



                                                        <td><span style="color: red">{{ $OutStandingAmount }} </span></td>

                                                        <td>
                                                            <form
                                                                action="{{ route('textbookItemDeleteAdmins', ['deleteId' => $item->Id]) }} "
                                                                method="POST">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token"
                                                                    value="{{ csrf_token() }}">

                                                                <button class="btn-reset"
                                                                    @if (session('quoteStatus') == 'Quote Created') disabled @endif
                                                                    type="submit">{{-- data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}" --}}
                                                                    <i class="ri-delete-bin-7-fill"></i>
                                                                </button>

                                                            </form>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                        @endif
                                        <form action="{{ route('submitSavedItemsForTextBook') }}" method="post">


                                            @php
                                                if ($totalPriceCapturedQuantity > $OrderAmount) {
                                                    $statement = 'The total Captured Quantity Amount is greater than order amount';
                                                }
                                            @endphp


                                            <input type="hidden" name="totalPriceForSchool"
                                                value="{{ $totalPriceForSchool }}">
                                            <input type="hidden" name="totalPriceCapturedQuantity"
                                                value="{{ $totalPriceCapturedQuantity }}">
                                            <input type="hidden" name="statement" value="{{ $statement }}">
{{-- 
                                            <center><label><b>School Total Order Amount: </b> <b
                                                        style="color:blue">R{{ $OrderAmount }}</b> </label>
                                                &nbsp; &nbsp; <label><b>Total Captured Quantity Amount:</b> <b
                                                        style="color:green">R{{ $totalPriceCapturedQuantity }}</b>
                                                    &nbsp; &nbsp; <label><b>Statement:</b> <b
                                                            style="color:red">{{ $statement }}</b></label>


                                            </center> --}}


                                            </tbody>
                                </div>
                            </div>
                            </table>
                            <center>


                                <br><br>

                                @csrf

                                {{-- <button @if (session('quoteStatus') == 'Quote Created' || count($dataSavedTextbook) < 1) disabled @endif class="btn btn-primary btn-sm"
                                    id="sumitbuttton" type="button" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    SUBMIT
                                </button> --}}

                                <div class="col-6 col-md-6 col-xl-2">
                                    <u><a href="{{ route('AdminDelivery.list') }}" >Continue Capture Delivery</a></u>


                                </div>
                        
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered popup-alert">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                                        class="img-fluid mb-5" alt="">
                                                    <h4 class="modal-title">SUBMIT</h4>
                                                    <p class="modal-title_des">Are you sure you want to
                                                        submit
                                                        these items for Quote Generation?</p>
                                                </div>

                                            </div>
                                            <div class="modal-footer justify-content-around text-center">
                                                <button type="button" class="btn btn--dark px-5"
                                                    data-bs-dismiss="modal">No</button>
                                                <button type="submit" id="sumitbuttton"
                                                    class="btn btn-primary px-5">Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>

                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </main>


    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function highlightIfMax(inputElement, max, totalCapturedQuantity, deliveredQuantity, event) {
        var inputValue = parseInt(inputElement.value, 10);
        var totCapturedSecondAmt = inputValue + totalCapturedQuantity;

    

        // Check if the input value exceeds the maximum or totalCapturedQuantity exceeds deliveredQuantity
        if (inputValue > max || totCapturedSecondAmt > deliveredQuantity) {
            inputElement.style.boxShadow = "0 0 0 0.25rem #ff0000";
            document.getElementById("preventSubmission").value = "true";
//alert('Code')
//document.querySelector('form[name="saveItemsForm"] input[type="submit"]').disabled = true;
            document.getElementById("EllaEatBreatAndSource").style.display ='block';

          document.getElementById("submitFormButton").disabled = true;
        } else {
            inputElement.style.boxShadow = "0 0 0 0.25rem #7cbf7a";
            document.getElementById("preventSubmission").value = "false";
            document.getElementById("submitFormButton").disabled = false;
           document.getElementById("EllaEatBreatAndSource").style.display ='none';

        }
    }
    
    function submitForm() {
        var preventSubmissionInput = document.getElementById("preventSubmission");

        // Check the value of the hidden input before submitting the form
        if (preventSubmissionInput.value === "true") {
            // You can optionally perform additional actions here or remove the alert.
        } else {
            // Submit the form
            document.forms["saveItemsForm"].submit();
        }
    }
    
       
    </script>
    


    <script>
        function validateInput(input) {

            // var value = input.value;

            // // Check if the value is blank or below 1
            // if (value !== '' && parseInt(value) > 0) {
            //     // Set the border color to red
            //     input.style.boxShadow = '0 0 0 0.25rem #7cbf7a';



            // } else {

            //     input.style.boxShadow = '0 0 0 0.25rem red';
            //     document.getElementById("submitFormButton").disabled = true;

            // }

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
    <script>
        $(document).ready(function() {


            @if (session('activeTab') != 'tab3')
                $(".tab-link[data-toggle='1']").addClass('active');
                $("#tab1").show();
                localStorage.clear();
            @else
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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // $(document).ready(function() {

        //     // Listen for changes in the checkbox state
        //     $(".checkbox").change(function() {
        //         var input = $(this).closest("tr").find(".input");
        //         if (this.checked) {
        //             // Checkbox is checked, enable the input
        //             input.prop("disabled", false);
        //         } else {
        //             // Checkbox is unchecked, clear and disable the input
        //             //    input.prop("disabled", true);
        //             input.val('').prop("disabled", true);

        //         }
        //     });
        // });


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
@endsection
