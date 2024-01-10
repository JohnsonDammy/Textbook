@extends('layouts.layout')
@section('title', 'View Supplier Documents')
@section('content')
    <style>
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
    </style>
    <main>
        <link href="path/to/bootstrap-datepicker.min.css" rel="stylesheet">
        <script src="path/to/jquery.min.js"></script>
        <script src="path/to/bootstrap.min.js"></script>
        <script src="path/to/bootstrap-datepicker.min.js"></script>

        <div class="container">
            <!-- breadcrumb -->

            {{-- , 'fundsId' => session('fundsId')]) --}}
            <br>
            <a href="{{ route('AdminCaptureSupplierOrder', ['requestType' => session('requestType'), 'emis' => session('emis') , 'fundsId' => session('fundsId')]) }}">
                <i class="fa fa-arrow-circle-left" style="font-size: 30px;" aria-hidden="true"></i>
            </a>

            <br><br>
            <center>
                <h3> View and download documents </h3>
                <div class="card" style="background-color: white; width:650px;">
                    <div class="card-body">

                        <input type="hidden" id="hiddenFieldValue" name="hiddenFieldValue" value="">


                        <div class="form-group" >

                            <label for="firstName">Quote Form:</label>
                            <p class="form-control" style="text-align: left;" >
                                <i class="fa fa-download" aria-hidden="true"></i><a href="{{ route('downloadQuoteAdmin', ['fileName' => $supplierRec->quoteForm]) }}"
                                style="color:green; text-decoration: underline; font-style:italic"
                                onmouseover="this.style.color='grey'"
                                onmouseout="this.style.color='green'"> Download<a>
                            </p>


                        </div>

                        <div class="form-group" >

                            <label for="firstName">SBD4 Form:</label>
                            <p class="form-control" style="text-align: left;" >
                                <i class="fa fa-download" aria-hidden="true"></i><a href="{{ route('downloadSBD4Admin', ['fileName' => $supplierRec->disclosureForm]) }} "
                                style="color:green; text-decoration: underline; font-style:italic"
                                onmouseover="this.style.color='grey'"
                                onmouseout="this.style.color='green'"> Download<a>
                            </p>


                        </div>

                        <div class="form-group" >

                            <label for="firstName">Disclosure Form:</label>
                           <p class="form-control" style="text-align: left;">
                            <i class="fa fa-download" aria-hidden="true"></i><a href=" {{ route('downloadDisclosureAdmin', ['fileName' => $supplierRec->sbd4Form]) }} "
                                style="color:green; text-decoration: underline; font-style:italic"
                                onmouseover="this.style.color='grey'"
                                onmouseout="this.style.color='green'"> Download<a>
                            <p>
                            


                        </div>

                        <div class="form-group">

                            <label for="firstName">Tax clearance Form:</label>
                            <p class="form-control" style="text-align: left;">
                                <i class="fa fa-download" aria-hidden="true"></i>
                                <a href="{{ route('downloadTaxAdmin', ['fileName' => $supplierRec->taxClearanceForm]) }}"
                                   style="color:green; text-decoration: underline; font-style: italic; "
                                   onmouseover="this.style.color='grey'"
                                   onmouseout="this.style.color='green'">Download</a>
                            </p>
                            

                        </div>

                       <div class="form-group">
                            <label for="firstName">Mark Up % :</label>
                            <input  style="background-color: #f4f9f4;" type="text" class="form-control" name="markUp" disabled value="{{ $supplierRec->markUp }}">
                        </div> 

                        <div class="form-group">
                            <label for="firstName">Amount :</label>
                            <input style="background-color: #f4f9f4;" type="text" disabled class="form-control" name="amtCaptured" id="fileDisclosureInput"
                                value="{{ $supplierRec->amount }}">
                        </div>




                        <div class="form-group">
                            <label for="firstName">Comment :</label>
                            <textarea style="background-color: #f4f9f4;"  disabled style="white-space: pre-line;" class="form-control" id="memo" name="comment" placeholder="Enter comment"
                                rows="2"> @if ($supplierRec->comment != null){{ $supplierRec->comment }}
                                @else
                                No comment
                                @endif 
                            </textarea>
                        </div>

                        <br>
                       

                            <div class="form-group" >

                                <label for="firstName">Tax Clearance Valid: </label>
                                @if ($supplierRec->taxClearance == 'yes')
                                <p style="background-color: #f4f9f4; text-align: left;"  class="form-control" >  YES  <p>
                                @else
                                <p style="background-color: #f4f9f4; text-align: left;" class="form-control" > No <p>
                                @endif
                                

                            </div>


                        


                    </div>



                </div>
        </div>
        </center>

        </div>







    @endsection
