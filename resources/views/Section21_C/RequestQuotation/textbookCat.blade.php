@extends('layouts.layout')
@section('title', 'Manage Catalogue')
@section('content')
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



            /* Add your CSS styles for the progress bar here */
            .spinner-container {
                display: none;
                text-align: center;
            }
        </style>

        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center border-bottom border-2">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Manage Catalogue</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a
                                    href="{{ route('textbookCat', ['requestType' => 'Textbook', 'idInbox' => 1]) }}">Textbook
                                    Catalogue</a></li>
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
                                            <span class="sr-only">Please wait...</span>
                                        </div>
                                        <p> Please wait... </p>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="tabs">

                


                    @if (session('quoteStatus') == 'Allocated Funds')
                        <a href="#" class="tab-link {{ session('activeTab') == 'tab2' ? 'active' : '' }}"
                            data-tab="tab2" data-toggle="2">Textbook Catalogue</a>
                    @endif


                    <a href="#" class="tab-link {{ session('activeTab') == 'tab3' ? 'active' : '' }}" data-tab="tab3"
                        data-toggle="3">View Items</a>

                    <!-- Your tab content here -->
                    @if (session('quoteStatus') == 'Allocated Funds')
                        <div class="tab-content " data-toggle="2" id="tab2">
                            <div class="col-12 col-md-12 my-3" id="textbooks-container">

                                @if (session('quoteStatus') != 'Allocated Funds')
                                    <br>
                                    <p style="color: red; font-weight: bold;"> Please note quote has been created for
                                        {{ date('Y') }}. All actions on this form has been disabled. </p>
                                    <br>
                                @endif


                                <form action="{{ route('filterTextbook') }}" method="get">
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
                                <form id="saveItemsForm" action="{{ route('saveCheckedItems') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="UncheckedItems" value="">

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
                                                    <th>Quantity</th>

                                                </tr>
                                            </thead>


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
                                                                {{-- <input type="checkbox" class="checkbox" data-item-id="{{ $item->id }}" name="checkItem" value="{{ $item->id }}"> --}}
                                                                <input type="checkbox" class="checkbox"
                                                                    id="Checkbox_{{ $item->id }}"
                                                                    name="selectedItems[]"
                                                                    @if ($dataSavedTextbook->contains('ISBN', $item->ISBN)) @if ($dataSavedTextbook->where('school_emis', $emis)) checked @endif
                                                                    @endif
                                                                value="{{ $item->id }}"
                                                                @if (session('quoteStatus') != 'Allocated Funds') disabled @endif>




                                                            </td>
                                                            <td> {{ $item->ISBN }} </td>
                                                            <td> {{ $item->Grade }} </td>
                                                            <td>

                                                                <div class="short-text" title="{{ $item->Title }}">
                                                                    {{ Str::limit($item->Title, 40) }}
                                                                </div>

                                                            </td>

                                                            <td>{{ $item->Publisher }}</td>
                                                            <td>{{ $item->Subject }}</td>
                                                            <td> R
                                                                {{ $item->Price }}</td>
                                                            


                                                            <td>

                                                                <input type="number"
                                                                    class="form-control input-sm quantity-input input"
                                                                    name="selectedQuantities[{{ $item->id }}]"
                                                                    id="Quantity_{{ $item->id }}"
                                                                    style="box-shadow: 0 0 0 0.25rem #7cbf7a; width: 60px; height: 20px;"
                                                                    min="0" required
                                                                    @if ($dataSavedTextbook->contains('ISBN', $item->ISBN)) @if ($dataSavedTextbook->where('school_emis', $emis))
                                                             value="{{ $dataSavedTextbook->where('ISBN', $item->ISBN)->first()->Quantity }}" @endif
                                                                    @endif
                                                                @if ($dataSavedTextbook->contains('ISBN', $item->ISBN)) enabled 
                                                            @else
                                                                disabled @endif
                                                                @if (session('quoteStatus') != 'Allocated Funds') disabled @endif
                                                                onblur="validateInput(this)"
                                                                >
                                                                </span>


                                                            </td>



                                                        </tr>
                                                    @endforeach


                                                </tbody>
                                            @endif

                                        </table>

                                        <style>
                                            .pagination-wrap a {
                                                margin-right: -70px;
                                                /* Adjust this value to add more or less space */
                                            }

                                            .pagination-wrap a:last-child {
                                                margin-right: 70;
                                                /* Remove margin from the last link to avoid extra space */
                                            }
                                        </style>
                                        @if (count(session('textbooksData')) > 1)
                                            <div id="pagination-links">
                                                <center>
                                                    <nav class="pagination-wrap">
                                                        <ul class="pagination">
                                                            <li class="page-item ">

                                                                <a class="{{ $textbooksData->previousPageUrl() ? 'next-page-link' : 'disabled' }}"
                                                                    href="#" style="margin-left: -100;">
                                                                    {{-- <i class="ri-arrow-left-s-line me-4"></i> --}}
                                                                    <input type="hidden" name="previousPage"
                                                                        value="">
                                                                    <button type="submit" class="page-link"
                                                                        id="PreviousButton">
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
                                                                    <button type="submit" class="page-link"
                                                                        id="NextButton">
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
                                                <div class="row justify-content-center align-items-center g-4"
                                                    style="margin-right: -90px;">
                                                    <div class="col-6 col-md-6 col-xl-2">
                                                        <input type="submit" id="submitFormButton"
                                                            class="btn btn-primary btn-sm" value="Save & Continue"
                                                            @if (session('quoteStatus') != 'Allocated Funds') disabled @endif>
                                                        {{--  <button type="submit" id="NextButton"> <i class="ri-arrow-right-s-line ms-4"></i></button> --}}
                                                    </div>
                                                </div>
                                            </center>
                                        @endif


                                    </div>



                                </form>
                            </div>

                    @endif
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
                                @php
                                    $TotalAccumalated = 0;
                                @endphp

                               <center> <span style="color:red; display:none" id="ShowMessage"><b>The order amount is greater than your allocated funds, please reduse your quantity to continue</b></span></center><br>
                                <table class="table">
                                    <thead>
                                        <tr>

                                            <th> ISBN </th>
                                            <th>Grade</th>
                                            <th>Title</th>
                                            <th>Price</th>
                                            <th>Quantity</th>

                                            <th>Total Price</th>

                                            @if (session('quoteStatus') == 'Allocated Funds')
                                                <th> Action </th>
                                            @endif
                                        </tr>
                                    </thead>

                                    @if (count($dataSavedTextbook) < 1)
                                        <tbody>
                                            <tr class="text-center text-dark">
                                                <td colspan="9">There is no saved Items to be displayed.
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody>
                                            @foreach ($dataSavedTextbook as $item)
                                                <tr>

                                                    <td> {{ $item->ISBN }} </td>
                                                    <td> {{ $item->Grade }} </td>


                                                    <td class="col-md-4">
                                                        <div class="short-text" title="{{ $item->Title }}">
                                                            {{ Str::limit($item->Title, 40) }}
                                                        </div>
                                                    </td>
                                                    @php
                                                        $price =$item->Price;
                                                    @endphp
                                                    <td> R {{ number_format($price, 2, '.', ',') }} </td>
                                                    <td>
                                                        <form class="updateQuantityForm"
                                                            action="{{ route('textbookItemUpdate', ['ISBN' => $item->ISBN, 'Price'=> $price ]) }}"
                                                            method="POST">
                                                            @csrf

                                                            <input type="number"
                                                                class="form-control input-sm quantity-input input"
                                                                name="newQuantity"
                                                                style="box-shadow: 0 0 0 0.25rem #7cbf7a; width: 60px; height: 20px;"
                                                                min="0" required value="{{ $item->Quantity }}"
                                                                oninput="submitForm(this)" readonly
                                                                id="newQuantity">
                                                        </form>


                                                    </td>
                                                    @php
                                                        $TotalAccumalated = $TotalAccumalated + $item->TotalPrice;

                                                        if($TotalAccumalated > session('AllocatedAmt')){
                                                            echo "<script>document.getElementById('ShowMessage').style.display='block';</script>";
                                                        }
                                                    @endphp
                                                    <td> R {{ number_format($item->TotalPrice, 2, '.', ',') }} </td>

                                                    @if (session('quoteStatus') == 'Allocated Funds')
                                                        <td>
                                                            <style>
                                                                .form-container {
                                                                    display: inline-block;
                                                                    margin-right: 10px;
                                                                    /* Adjust the margin as needed */
                                                                }


                                                                .btn-reset-outside-form {
                                                                    display: inline-block;
                                                                    border: none;
                                                                    /* Remove the border */
                                                                }
                                                            </style>

                                                            <div class="form-container">
                                                                <form
                                                                    action="{{ route('textbookItemDelete', ['deleteId' => $item->id]) }}"
                                                                    method="POST">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <input type="hidden" name="_token"
                                                                        value="{{ csrf_token() }}">

                                                                    @if (session('quoteStatus') != 'Quote Created')
                                                                        <button class="btn-reset" type="submit">
                                                                            <i class="ri-delete-bin-7-fill"></i>
                                                                        </button>
                                                                    @endif
                                                                </form>
                                                            </div>

                                                            <button class="btn-reset-outside-form" type="button" onclick="enableInput(this)">
                                                                <i class="ri-pencil-fill"></i>
                                                            </button>


                                                        </td>
                                                    @endif

                                                </tr>
                                            @endforeach
                                    @endif



                                    </tbody>

                                </table>


                                <center>

                                    {{--  <div class="row justify-content-center align-items-center g-4">
                                         --}}

                                    @if (count($dataSavedTextbook) > 1)

                                        <table class="table">
                                            <thead>
                                                <tr>

                                                    @if (session('quoteStatus') == 'Allocated Funds')
                                                        <th class="col-md"> Action </th>
                                                    @endif
                                                    <th>View</th>
                                                    @if (session('quoteStatus') == 'Allocated Funds')
                                                        <th class="col-md">Status</th>
                                                    @endif

                                                    <th class="col-md">Number Of Pages</th>

                                                    <th class="col-md">Total </th>

                                                    @if (session('quoteStatus') == 'Allocated Funds')
                                                        <th class="col-md">Delete</th>
                                                    @endif

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr class="pt-1 px-1">
                                                    @if (session('quoteStatus') == 'Allocated Funds')

                                                        <td class="col-md">
                                                            <small style="color: red; display:none;" id="ShowError"> Please generate quote</small><br>

                                                            <form action=" {{ route('generateQuote') }} " method="post"
                                                                onsubmit="setInProgress()">
                                                                @csrf

                                                                <input type="hidden" name="orderedAmount"
                                                                    value="{{ $TotalAccumalated }}">
                                                                <input type="submit" class="buttonGenerate"
                                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                    @if (session('quoteStatus') != 'Allocated Funds' || session('status') == 'Generated') disabled @endif
                                                                    @if($TotalAccumalated > session('AllocatedAmt')) disabled @endif
                                                                    value="Generate Quote" onclick="CheckGen()">
                                                            </form>

                                                            <!-- Progress Bar -->

                                                        </td>
                                                    @endif
                                                    <td class="col-md">
                                                        <small id="DownloadQuote" style="color:red; display:none;">Next download Quote</small><br>
                                                        <a id="viewQuoteLink" href="{{ route('viewQuotes') }}" target="_blank"
                                                            style="color: @if (session('quoteStatus') != 'Allocated Funds' || session('status') == 'Generated') green @else grey @endif;
                                                               text-decoration: underline; font-style: italic;
                                                               @if (session('quoteStatus') != 'Quote Created' && session('status') != 'Generated') pointer-events: none; @endif">
                                                            View Quote
                                                        </a>
                                                    <input type="hidden" id="myTextbox" name="myTextbox" value="">


                                                    </td>

                                                    @php
                                                    if(session('message') =='OK'){

                                                    }
                                                   @endphp


                                                    @if (session('quoteStatus') == 'Allocated Funds')
                                                        <td class="col-md">

                                                            @if (session('status') != null)

                                                                {{ session('status') }}
                                                           
                                                            @else
                                                                Not Generated

                                                               

                                                            @endif

                                                          
                                                            {{-- @php
                                                            if (session('status') != 'Generated') {
                                                                session(['status' => 'Not Generated']);
                                                            }

                                                        @endphp
                                                        <p id="statusParagraph"> {{ session('status') }} </p> --}}


                                                        </td>
                                                    @endif

                                                    <td class="col-md">

                                                        @if (session('TotalPages') != null)

                                                            {{ session('TotalPages') }}
                                                        @else
                                                            0
                                                        @endif





                                                    </td>
                                                    <td class="col-md"
                                                        style="color: {{ $TotalAccumalated > session('AllocatedAmt') ? 'red' : 'green' }}">
                                                        R {{ number_format($TotalAccumalated, 2, '.', ',') }}
                                                    </td>

                                                    @if (session('quoteStatus') == 'Allocated Funds')
                                                        <td class="col-md">



                                                            <form action="{{ route('quoteTextbookDelete') }} "
                                                                method="POST">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token"
                                                                    value="{{ csrf_token() }}">

                                                                <button class="btn-reset" type="button"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal{{ $item->id }}">
                                                                    <i class="ri-delete-bin-7-fill"></i>
                                                                </button>

                                                                <div class="modal fade"
                                                                    id="exampleModal{{ $item->id }}" tabindex="-1"
                                                                    aria-labelledby="exampleModalLabel"
                                                                    aria-hidden="true">
                                                                    <div
                                                                        class="modal-dialog modal-dialog-centered popup-alert">
                                                                        <div class="modal-content">
                                                                            <div class="modal-body">
                                                                                <div class="text-center">
                                                                                    <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                                                                        class="img-fluid mb-5"
                                                                                        alt="">
                                                                                    <h4 class="modal-title">Delete</h4>
                                                                                    <p class="modal-title_des">Are you sure
                                                                                        you
                                                                                        want to delete?</p>
                                                                                </div>

                                                                            </div>
                                                                            <div
                                                                                class="modal-footer justify-content-around text-center">
                                                                                <button type="button"
                                                                                    class="btn btn--dark px-5"
                                                                                    data-bs-dismiss="modal">No</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary px-5">Yes</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                    {{--     </div>  --}}


                                    <br><br>
                                    @if (session('quoteStatus') != 'Quote Created')
                                        <form action="{{ route('submitSavedItemsFF') }}" method="post">
                                            @csrf

                                            <button @if (session('quoteStatus') != 'Allocated Funds' || count($dataSavedTextbook) < 1) disabled @endif
                                            class="btn btn-primary btn-sm" id="sumitbutttonsss" type="button">
                                            SUBMIT
                                    </button>
                                

                                            <div class="modal fade" id="exampleModal5" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered popup-alert">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                                <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                                                    class="img-fluid mb-5" alt="">
                                                                <h4 class="modal-title">SUBMIT</h4>
                                                                <p class="modal-title_des">Are you sure you want to submit
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
                                    @endif

                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($message = Session::get('successD'))
            <div class="modal fade show" id="exampleModalD" tabindex="-1" aria-labelledby="exampleModalLabel"
                style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">Generation failed</h4>
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

         function CheckGen(){
            document.getElementById('DownloadQuote').style.display="none";
                 }
    </script>
    <!-- Add this in the head section of your HTML file -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function submitForm(element) {
            // Find the parent form using jQuery's closest method
            var form = $(element).closest('.updateQuantityForm');

            // Submit the form using jQuery
            form.submit();
        }
    </script>

<script>
    function enableInput(button) {
        var row = button.closest('tr'); // Find the closest parent row
        var input = row.querySelector('.quantity-input'); // Find the input within the row
        input.removeAttribute('readonly');
        input.focus();
    }
</script>
{{-- 
@if(session('activeTab') == 'tab3')
    

@else
<script>alert('No code')</script>

@endif
 --}}




@if(isset($activeTab) && $activeTab == 'tab3')
    {{-- Your code for tab3 --}}
    <script>  
                $(document).ready(function() {
                    $(".tab-link[data-toggle='3']").addClass('active');

            $("#tab3").show();
        });

    </script>
@endif


@if(isset($activeTab) && $activeTab == 'tab2')
    {{-- Your code for tab3 --}}
    <script>  
                $(document).ready(function() {
                    $(".tab-link[data-toggle='2']").addClass('active');

            $("#tab2").show();
        });

    </script>
@endif




    {{-- Dynamically change status  --}}
    {{-- <script>
        function setInProgress() {
            // Set session status to "In Progress"
            sessionStorage.setItem('status', 'In Progress');

            // Update the content of the paragraph tag
            document.getElementById('statusParagraph').innerText = 'In Progress';

            document.getElementById('progressBar').style.display = 'block';

            // Stop showing the progress bar based on a condition
            // Example: Hiding the progress bar after 5 seconds (5000 milliseconds)
            setTimeout(function() {
                document.getElementById('progressBar').style.display = 'none';
            }, 5000);

            return true; // Continue with form submission
        }
    </script> --}}
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

<script>
$(document).ready(function() {

    $("#viewQuoteLink").click(function(e) {
  
        $("#myTextbox").val("2");
    });

    $("#sumitbutttonsss").click(function() {
        @if (session('status') == null)
            document.getElementById('ShowError').style.display = 'block';
            $('#ShowError').focus();
        @elseif(session('status') == 'Generated')
            // Check if the "View Quote" link has been clicked
            if (!localStorage.getItem('viewQuoteClicked')) {
                $('#DownloadQuote').css('display', 'inline');
            } else {
               // $('#exampleModal5').modal('show');
            }
        @endif


        if($("#myTextbox").val() == "2"){
            $('#exampleModal5').modal('show');       
         }
    });
});

</script>


 @if ($message = Session::get('successD'))
 <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
 @endif


 <script>
    function hidePopup() {
        $("#exampleModalD").fadeOut(200);
        $("#exampleModal").fadeOut(200);

        $('.modal-backdrop').remove();
    }
</script>
    {{-- Show and Hide Tabs Dynamically --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            


            // @if (session('activeTab') != 'tab3')


            //     $(".tab-link[data-toggle='2']").addClass('active');
            //     $("#tab2").show();
            //     // $("#tab3").hide();
            //     localStorage.clear();
            // @elseif (session('activeTab') === 'tab3')
            //     $("#tab3").show();
            //     // $("#tab1").hide();
            // @endif

            @if (session('activeTab') === 'tab3')
            $(".tab-link[data-toggle='3']").addClass('active');

            $("#tab2").show();

            @elseif (session('activeTab')  === '')
            $(".tab-link[data-toggle='3']").addClass('active');
           $("#tab3").show();

            @endif



            @if (session('quoteStatus') != 'Allocated Funds')
                $(".tab-link[data-toggle='3']").addClass('active');
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
    <script></script>







@endsection
