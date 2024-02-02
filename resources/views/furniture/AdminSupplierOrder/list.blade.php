@extends('layouts.layout')
@section('title', 'Supplier List')
@section('content')
    <!-- main -->
    <main>

        <style>
            .buttonGenerate {
                display: inline-block;
                padding: 7px 7px;
                /* Adjust the padding for the desired height */
                text-decoration: none;

                /* Text color for the active tab */

                /* Blue text color for inactive tabs */
            }

            .buttonApprove {
                background: transparent linear-gradient(261deg, #85c286, #44a244);
                border: none;
                border-radius: 3.9rem;
                color: #fff;
                font-size: 1.6rem;
                font-weight: 700;
                line-height: 1;
                padding: 1.4rem 2rem;
                text-transform: capitalize;
                transition: all .3s ease-in;
            }

            .buttonDecline {
                background: transparent linear-gradient(261deg, #FF7F7F, #FF0000);
                border: none;
                border-radius: 3.9rem;
                color: #fff;
                font-size: 1.6rem;
                font-weight: 700;
                line-height: 1;
                padding: 1.4rem 2rem;
                text-transform: capitalize;
                transition: all .3s ease-in;
            }
        </style>


        <style>
            /* Font Definitions */
            @font-face {
                font-family: "Cambria Math";
                panose-1: 2 4 5 3 5 4 6 3 2 4;
            }

            @font-face {
                font-family: Calibri;
                panose-1: 2 15 5 2 2 2 4 3 2 4;
            }

            @font-face {
                font-family: "Arial Narrow";
                panose-1: 2 11 6 6 2 2 2 3 2 4;
            }

            @font-face {
                font-family: Tahoma;
                panose-1: 2 11 6 4 3 5 4 4 2 4;
            }

            /* Style Definitions */
            p.MsoNormal,
            li.MsoNormal,
            div.MsoNormal {
                margin: 0cm;
                font-size: 12.0pt;
                font-family: "Times New Roman", serif;
            }

            p.MsoHeader,
            li.MsoHeader,
            div.MsoHeader {
                mso-style-link: "Header Char";
                margin: 0cm;
                font-size: 12.0pt;
                font-family: "Times New Roman", serif;
            }

            p.MsoFooter,
            li.MsoFooter,
            div.MsoFooter {
                mso-style-link: "Footer Char";
                margin: 0cm;
                font-size: 12.0pt;
                font-family: "Times New Roman", serif;
            }

            p.MsoListParagraph,
            li.MsoListParagraph,
            div.MsoListParagraph {
                margin-top: 0cm;
                margin-right: 0cm;
                margin-bottom: 10.0pt;
                margin-left: 36.0pt;
                line-height: 115%;
                font-size: 11.0pt;
                font-family: "Calibri", sans-serif;
            }

            p.MsoListParagraphCxSpFirst,
            li.MsoListParagraphCxSpFirst,
            div.MsoListParagraphCxSpFirst {
                margin-top: 0cm;
                margin-right: 0cm;
                margin-bottom: 0cm;
                margin-left: 36.0pt;
                line-height: 115%;
                font-size: 11.0pt;
                font-family: "Calibri", sans-serif;
            }

            p.MsoListParagraphCxSpMiddle,
            li.MsoListParagraphCxSpMiddle,
            div.MsoListParagraphCxSpMiddle {
                margin-top: 0cm;
                margin-right: 0cm;
                margin-bottom: 0cm;
                margin-left: 36.0pt;
                line-height: 115%;
                font-size: 11.0pt;
                font-family: "Calibri", sans-serif;
            }

            p.MsoListParagraphCxSpLast,
            li.MsoListParagraphCxSpLast,
            div.MsoListParagraphCxSpLast {
                margin-top: 0cm;
                margin-right: 0cm;
                margin-bottom: 10.0pt;
                margin-left: 36.0pt;
                line-height: 115%;
                font-size: 11.0pt;
                font-family: "Calibri", sans-serif;
            }

            p.WW-Default,
            li.WW-Default,
            div.WW-Default {
                mso-style-name: WW-Default;
                margin: 0cm;
                font-size: 12.0pt;
                font-family: "Times New Roman", serif;
            }

            span.HeaderChar {
                mso-style-name: "Header Char";
                mso-style-link: Header;
                font-family: "Times New Roman", serif;
            }

            span.FooterChar {
                mso-style-name: "Footer Char";
                mso-style-link: Footer;
                font-family: "Times New Roman", serif;
            }

            .MsoChpDefault {
                font-family: "Calibri", sans-serif;
            }

            .MsoPapDefault {
                margin-bottom: 8.0pt;
                line-height: 107%;
            }

            /* Page Definitions */
            @page WordSection1 {
                size: 595.0pt 842.0pt;
                margin: 49.6pt 56.4pt 9.05pt 70.9pt;
            }

            div.WordSection1 {
                page: WordSection1;
            }

            /* List Definitions */
            ol {
                margin-bottom: 0cm;
            }

            ul {
                margin-bottom: 0cm;
            }
        </style>
        <style>
            .recommended-row {
                color:green;
                font-weight: bold;
            }
        </style>

        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Capture Select Supplier</h4>
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

            @if (session('StatusChange') == 'Request approved.' || session('StatusChange') == 'Request declined.')
                <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    style="display: block;" aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered popup-alert">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center">
                                    <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                    <p class="popup-alert_des"> {{ session('StatusChange') }}</p>
                                </div>

                            </div>

                            @if (session('StatusChange') == 'Request approved.')
                                <div class="modal-footer text-center justify-content-center p-3 border-0">
                                    <a href="{{ route('ApproveUploadOrderDistrict') }}">
                                        <button type="button" class="btn btn-secondary px-5">OK</button>
                                    </a>
                                @else
                                    <div class="modal-footer text-center justify-content-center p-3 border-0">

                                        <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                            onclick="ProccedNew()">OK</button>
                            @endif

                        </div>
                    </div>
                </div>
        </div>
        @endif

        @if (session('StatusChange') == 'Request Failed.')
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5"
                                    alt="">
                                <p class="popup-alert_des"> {{ session('StatusChange') }} , Please ensure you enter a
                                    comment to decline the request</p>
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
            <h5 class="card-header" style ="color:#14A44D">Recommend Captured Suppliers</h5>

            <div class="table-responsive">

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
                            @if (session('requestType') === "Textbook")
                            <th> Mark up (%) </th>
                            @endif
                            {{-- <th>Recommended</th> --}}
                            <th> Action </th>


                        </tr>
                    </thead>

                    @if (count(session('CapturedData')) < 1)
                        <tbody>

                            <tr class="text-center text-dark">
                                <td colspan="9">Please capture minumum of three suppliers
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                            @foreach (session('CapturedData') as $item)
                          
                                <tr @if ($item->Recommended === "yes") class="recommended-row" @endif>

                          
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


                                    @if ($item->Recommended === "yes")
                                    @php
                                        $recommendedAmount = $item->amount; // Set the recommended amount
                                        session(['percentages' => $item->markUp]);
                                        session(['amount' => $item->amount]);

                                    @endphp
                                    @endif


                                    </td>
                                    @if (session('requestType') === "Textbook")
                                    <td>
                                        {{ $item->markUp }}
                                    </td>

                                    @php
                                    // session(['amount' => $item->amount]);


                                    @endphp
                                    {{-- <td>                                   
                                        {{$item->Recommended}}

                                    </td> --}}
                                    @endif

                                    <td>
                                        <a href="{{ route('viewSupplierDetails', ['itemId' => $item->savedSupplierID]) }}"
                                            style="color:green; text-decoration: underline; font-style:italic"> View
                                            <a>
                                    </td>

                                </tr>
                            @endforeach
                    @endif



                    </tbody>


                </table>

            </div>
                {{-- Download and upload ef48 --}}
                {{-- Download and upload comittee PDF  --}}



        </div>

        {{-- Download EF58 --}}
        <div class="form-group col-12 col-md-6 col-xl-2">

            <i class="fas fa-download" style="color: green;"></i><a href="{{ route('downloadEF58') }}"
                style="color:green; text-decoration: underline; font-style: italic;">
                Download EF58
            </a>

        </div>



        <form action=" {{ route('DeclineRequest') }} " method="post">
            @csrf

            <div class="form-group">
                <label for="firstName">Comment :</label>
                <textarea style="background-color: #f4f9f4;" style="white-space: pre-line;" class="form-control" id="memo"
                    name="comment" placeholder="Enter comment" rows="1">
                    </textarea>
            </div>

            @if(session("deviationReason") != null)
            <div class="form-group">
                <label for="firstName">Deviation Reason</label>
                <textarea style="background-color: #f4f9f4;" style="white-space: pre-line;"  class="form-control" id="memo"
                    name="comments" placeholder="Enter comment" rows="1" >
                    {{ $deviationReason }}

                    </textarea>
                    {{-- <input type="text" value="{{$deviationReason}}"> --}}
            </div>
            @endif

            <div class="row align-items-center border-bottom border-2">
                <center style="margin-left: 300px">
                    <div class="row">
                        <div class="col-12 col-md-6 my-3">
                            {{--  <div class="row g-4"> --}}
                            {{-- <div class="form-group col-12 col-md-4 col-xl-3"> --}}

                           
                          {{--   <input type="submit" onclick="setAction('approve')" class="buttonApprove" value="APPROVE"> --}}
                            <input type="button" class="buttonApprove" value="APPROVE" data-bs-toggle="modal" data-bs-target="#modelChecklist">
                          
                            <input type="submit" onclick="setAction('decline')" class="buttonDecline" value="DECLINE">

                            {{--   </div> --}}
                            {{--   </div> --}}
                            <div>
                            </div>
                        </div>
                </center>
        </form>







    </main>

    {{-- Model --}}
    <div class="modal fade" id="modelChecklist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">


                    <!-- Hidden input field in the modal -->


                    <h5 class="modal-title" id="exampleModalLabel">CheckList</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">



                    <form action="{{ route('GenerateChecklistApprove') }}" method="post" >
                        @csrf
                   


                    
                      
                        <div style=" align-items: center; display: flex;">
                 
                            <label  style="margin-right: 10px;" for="firstName">  Have three quotes been obtained ? </label>
                            <select style="margin-left: 95px;" class="dropdown" id="quotesObtained" name ="quotesObtained" required>
                                <option value="" disabled selected>Select option</option>

                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                          
                        </div>
                        <hr>
                        <br>

                      
                        <div style=" align-items: center; display: flex;">
           
                            <label  style="margin-right: 10px;" for="firstName">  Does the recommended company have a valid tax clearance certificate ? </label>
                          
                            <select style="margin-right: 10px;" class="dropdown" id="taxClearance" name="taxClearance" required>
                                <option value="" disabled selected>Select option</option>

                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>

                        </div>
                        <hr>
                        <br>

        
                                <div style=" align-items: center; display: flex;">
                            
                                    <label  style="margin-right: 10px;" for="firstName">  Has the recommended company declared its interests? (SBD4) </label>
                                    <select style="margin-right: 10px;" class="dropdown" id="declaredInterest" name="declaredInterest" required>
                                        <option value="" disabled selected>Select option</option>

                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                  
                                </div>

                                <!-- Hidden field to store the selected value -->
                                <input type="hidden" id="declaredInterestsHidden" name="declaredInterestsHidden">

                            


                        <hr>
                        <br>

                        
                      
                        <div style=" align-items: center; display: flex;">
                 
                            <label  style="margin-right: 10px;" for="firstName"> Is the recommended quote the lowest offer?, If no selected please jusify below </label>
                            <select style="margin-right: 10px;" class="dropdown" id="lowestOffer" name="lowestOffer" onchange="toggleTextarea()" required>
                                <option value="" disabled selected>Select option</option>

                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                        <br>
                            
                        <div style="align-items: center; display: flex;  margin-left: 55px;"  id="JustifyReasonID">
                            <textarea style="margin-right: 20px; " class="form-control" id="JustifyReason" name="JustifyReason"
                            placeholder="Enter comment" rows="1"> </textarea>
                           
                              
                        </div>
                          
                      
                        <hr>
                        <br>


                     

                        <div style=" align-items: center; display: flex;">
           
                            <label  style="margin-right: 10px;" for="firstName"> Is the EF58 completed and signed off? </label>
                            <select style="margin-left: 77px;" class="dropdown" id="completedEF58" name="completedEF58" required>
                                <option value="" disabled selected>Select option</option>

                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                          
                        </div>

                       <hr>
                        <br>

                        <div style=" align-items: center; display: flex;">
                    
                            <label  style="margin-right: 10px;" for="firstName"> Has the Form: Details and Declaration of School LTSM Committee Members been submitted?</label>
                            <select style="margin-right: 10px;" class="dropdown" id="formSubmission" name="formSubmission" required>
                                <option value="" disabled selected>Select option</option>

                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                          
                        </div>
                       <hr>
                        <br>

                        <div style=" align-items: center; display: flex;">
                 
                            <label  style="margin-right: 10px;" for="firstName"> Has the Form: Disclosure of Interests; Confidentiality & Impartiality been completed by the principal; SGB Chairperson &SGB Treasurer?</label>
                          
                            <select style="margin-right: 10px;" class="dropdown" id="formCompletion" name="formCompletion" onchange="toggleValEdits()" required>
                                <option value="" disabled selected>Select option</option>

                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <br>
                        <div style=" align-items: center; display: flex;  margin-left: 55px;" id="values" >
                            <input type="number" class="form-control" name="quoteValue" value="{{ session('amount') }}" placeholder="Quotation value" style="margin-right: 10px;" id="quoteValue" disabled>
                         

                            {{-- <input   type="number" class="form-control" name="catValue"  placeholder="Catalogue Value" value=""   id="catValue" > --}}
                          
                          
                        </div>
                        <hr>
                        <br>

                             <div style=" align-items: center; display: flex;">
            
                            <label  style="margin-right: 10px;" for="firstName"> 
                                Funds have been utilized responsibly, prudently, and appropriately thereby ensuring that value for money has been obtained. 
                                @if (session('requestType') === 'Textbook')
                                Percentage Margin Over Catalogue Prices [does NOT exceed 27%]
                                @endif
                            </label>
                            <select style="margin-right: 10px;" class="dropdown" id="fundsObtained" name="fundsObtained" onchange="togglePercentagePrice()" required>
                                <option value="" disabled selected>Select option</option>

                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                          
                          
                        </div>
                        <br>

                        @if (session('requestType') === "Textbook")
                        <div style=" align-items: center; display: flex;  margin-left: 55px;"  >
                            <input type="number" step="any" class="form-control"  name="percentagePrice" value="{{ session('percentages') }}" placeholder="Percentage (%)" style="margin-right: 20px;" id="percentagePrice" disabled>
                          
                        </div>
                        @endif
                      
               

                        <hr>
                        <br>

                        <div style=" align-items: center; display: flex;">
                    
                            <label  style="margin-right: 10px;" for="firstName"> Is the recommendation supported? </label>
                          
                            <select style="margin-left: 85px;" class="dropdown" id="recommendation" name="recommendation" required>
                                <option value="" disabled selected>Select option</option>


                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                       



                </div>

                <div class="modal-footer justify-content-center">
                    <!-- Add space between buttons -->
                  {{--   <input type="submit" onclick="setAction('approve')" class="buttonApprove" value="APPROVE"> --}}
                    <button type="submit" class="btn btn-primary">Generate Checklist & Approve</button>
                </div>
                </form>

            </div>
        </div>
    </div>






    <script>
        function setAction(action) {
            document.getElementById('approveAction').value = action;
        }

        function ProccedNew(){
            window.location.href = "{{ route('InboxSchoolDistrict') }}";

        }

    </script>

<script>
    function toggleTextarea() {
        var dropdown = document.getElementById('lowestOffer');
        var textarea = document.getElementById('JustifyReason');

        if (dropdown.value === 'yes') {
            textarea.style.display = 'none';
        } else {
            textarea.style.display = 'block';
        }
    }

    // Initially hide the textarea on page load
    document.addEventListener('DOMContentLoaded', function () {
        toggleTextarea();
    });
</script>


<script>
    function toggleValEdits() {
        var dropdown = document.getElementById('formCompletion');
        var editQuoteVal = document.getElementById('quoteValue');
        var editCatVal = document.getElementById('catValue');

        if (dropdown.value === 'no') {
            editQuoteVal.style.display = 'none';
            editCatVal.style.display = 'none';
        } else {
            editQuoteVal.style.display = 'block';
            editCatVal.style.display =  'block';
        }
    }

    // Initially hide the textarea on page load
    document.addEventListener('DOMContentLoaded', function () {
        toggleValEdits();
    });
</script> 

<script>
    function togglePercentagePrice() {
        var dropdown = document.getElementById('fundsObtained');
        var textarea = document.getElementById('percentagePrice');

        if (dropdown.value === 'no') {
            textarea.style.display = 'none';
        } else {
            textarea.style.display = 'block';
        }
    }

    // Initially hide the textarea on page load
    document.addEventListener('DOMContentLoaded', function () {
        togglePercentagePrice();
    });
</script>


    <script>
        function hidePopup() {
            $("#exampleModal").fadeOut(200);
            $('.modal-backdrop').remove();
        }
    </script>
@endsection