@extends('layouts.layout')
@section('title', 'Choose Supplier')
@section('content')
    <main>
        <link href="path/to/bootstrap-datepicker.min.css" rel="stylesheet">
        <script src="path/to/jquery.min.js"></script>
        <script src="path/to/bootstrap.min.js"></script>
        <script src="path/to/bootstrap-datepicker.min.js"></script>

        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center border-bottom border-2">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Choose Supplier</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#"> Choose Suppliers </a>
                                @if ($requestType == 'Textbook')
                            <li class="breadcrumb-item"><a
                                    href="{{ route('textbookCat', ['requestType' => 'Textbook', 'idInbox' => 1]) }}">View
                                    Items</a></li>
                        @else
                            <li class="breadcrumb-item"><a
                                    href="{{ route('stationeryCat', ['requestType' => 'Stationery', 'idInbox' => 2]) }}">View
                                    Items</a></li>
                            @endif



                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="modal fade show" id="exampleModalProgress" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-modal="true" role="dialog">
             <div class="modal-dialog modal-dialog-centered popup-alert">
                 <div class="modal-content">
                     <div class="modal-body">
                         <div class="text-center">

                             <div class="spinner-container" id="spinner">
                                 <div class="spinner-border text-primary" role="status">
                                     <span class="sr-only">Loading...</span>
                                 </div>
                                 <p> Sending Email... </p>
                             </div>

                         </div>

                     </div>
                     
                 </div>
             </div>
         </div>

  
            <br>
            @if($MinQuotes=="false")
            <p style="font-weight: bold; color: red;">Minimum of 3 quotes required</p>

            @endif
            
      
            {{-- Exeeded Max suppliers message --}}
            <div class="modal fade" id="exampleModalExceed" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5"
                                    alt="">
                                <h4 class="modal-title">Minumum of 3 suppliers required</h4>
                                <p class="modal-title_des">Please ensure you select minimum of three suppliers to proceed
                                </p>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-around text-center">
                            <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">Ok</button>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Exeeded Max suppliers message --}}
            <div class="modal fade" id="exampleModalExceed" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5"
                                    alt="">
                                <h4 class="modal-title">Minumum of 3 suppliers required</h4>
                                <p class="modal-title_des">Please ensure you select minimum of three suppliers to proceed
                                </p>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-around text-center">
                            <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">Ok</button>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Sucess email sent --}}
            <div class="modal fade" id="exampleModalSentEmail" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="modal-title">Successfully sent emails</h4>
                                <p class="modal-title_des">All emails sent to respective selected suppliers with attachments
                                </p>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-around text-center">
                            <a href="{{ route('inboxSchool') }}" class="btn btn--dark px-5">OK</a>

                        </div>
                    </div>
                </div>
            </div>
            <br>
            {{-- Standard school and Emis --}}
            <div class="row align-items-center border-bottom border-2">
                <br> <br> <br>

                <div class="row">

                    <input type="hidden" name="broken_items[]" id="broken_array" value="">
                    <div class="col-12 col-md-12 my-3">
                        <div class="row g-4">
                            <div class="form-group col-12 col-md-6 col-xl-3">
                                <input type="text" name="School" class="form-control form-control-lg" disabled
                                    required="required" value="{{ Auth::user()->name }}" placeholder=" ">
                                <label>School Name</label>
                                <input type="hidden" value="{{ Auth::user()->name }}" name="SchoolName">
                            </div>
                            <div class="form-group col-12 col-md-6 col-xl-2">
                                <input type="text" name="Emis" class="form-control form-control-lg"
                                    value="{{ Auth::user()->username }}" disabled required="required" placeholder=" ">
                                <input type="hidden" value="{{ Auth::user()->username }}" name="SchoolEmis">
                                <label>School EMIS Number</label>
                            </div>
                        </div>
                    </div>

                </div>

                <br> <br>
            </div>

            <br>
            {{-- Date and View Quote --}}
            <div class="row align-items-center border-bottom border-2">
                <br>

                <form id="yourFormId" action=" {{ route('requestQuote') }} " method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">


                        <div class="col-12 col-md-12 my-3">
                            <div class="row g-4">
                                <div class="form-group col-12 col-md-6 col-xl-3">

                                    <div style="display:none" id= "errorClosingDate" class="text-danger">Please closing
                                        date</div>
                                    <label for="exampleDate">Select a Closing Date:</label>
                                    <div class="input-group">
                                        <input type="text" placeholder="MM/DD/YYYY" class="form-control datepicker" id="exampleDate" name="closingDate" id="closingDateInput" required value="{{ old('closingDate', session('closingDate')) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar" style="font-size: 20px;" ></i>
                                            </span>
                                        </div>
                                    </div>
                                    

                                </div>

                                @if(session('requestType') == "Textbook")

                                <div class="form-group col-12 col-md-6 col-xl-2">
                                    <a href="{{ route('viewQuotess') }}"
                                        style="color:green; text-decoration: underline; font-style: italic;">
                                        View Quote Textbook
                                    </a>
                                </div>
                                @else

                                <div class="form-group col-12 col-md-6 col-xl-2">
                                    <a href="{{ route('viewQuotesStats') }}"  
                                        style="color:green; text-decoration: underline; font-style: italic;">
                                        View Quote Stationery
                                    </a>
                                </div>
                                @endif

                                <input type="text" class="datepicker">
                            </div>

                        </div>

                        <br>
                    </div>


                    {{-- Suppplier Grid --}}

                    <div class="row align-items-center border-bottom border-2">

                        <br>


                        <div style="max-height: 400px; overflow-y: auto;">
                            <div class="mt-2">
                                <input type="checkbox" id="checkAll" class="checkbox">
                                <label for="checkAll">Select All</label>
                                <input type="hidden" id="checkAllStatus" name="checkAllStatus" value="false">
                            </div>
                            <br>

                            <table class="table">
                                <input type="hidden" name="UncheckedItems" value="">
                                <thead>
                                    <tr>

                                        <th> </th>
                                        <th> Email </th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Contact No</th>




                                    </tr>
                                </thead>

                                @if (count(session('supplierData')) < 1)
                                    <tbody>
                                        <tr class="text-center text-dark">
                                            <td colspan="9">There is no saved Items to be displayed.
                                            </td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        @foreach (session('supplierData') as $item)
                                            <tr>

                                                <td> <input type="checkbox" class="checkbox" name="selectedItems[]"
                                                        @if (session('savedSuppliers')->contains('supplierID', $item->Id)) checked @endif
                                                        value={{ $item->Id }}>
                                                </td>

                                                <td>{{ $item->email }} </td>
                                                <td>{{ $item->CompanyName }} </td>
                                                <td>{{ $item->CompanyAddress }} </td>
                                                <td>{{ $item->CompanyContact }} </td>

                                            </tr>
                                        @endforeach
                                @endif



                                </tbody>

                            </table>
                        </div>

                    </div>



                    {{-- <div class="form-group col-12 col-md-6 col-xl-2">

                        <i class="fas fa-download" style="color: green;"></i><a
                            href="{{ route('downloadEF58') }}"
                            style="color:green; text-decoration: underline; font-style: italic;"
                            onclick="enableUploadInput()">
                            Download EF48
                        </a>

                    </div> --}}


                    {{-- <div class="form-group col-12 col-xl-4 col-xl-2">
                        <div class="row justify-content-center ">
                            <div class="col-md-4 form-control" style="width: 100%;" class="form-control">
                                <label for="reference-number">Upload EF48 Form</label>
                                <div class="input-group">
                                    <input type="file" name="fileEF48" id="fileEF48" required
                                        value="" required disabled>
                                </div>


                            </div>
                        </div>
                    </div> --}}

                    
                    {{-- Download and upload comittee PDF  --}}
                    <div class="row align-items-center border-bottom border-2">

                        <div class="row g-4">
                            <div class="form-group col-12 col-md-6 col-xl-3">

                                <i class="fas fa-download" style="color: green;"></i><a
                                    href=" {{ route('downloadComitee') }} "
                                    style="color:green; text-decoration: underline; font-style: italic;" onclick="enableUploadInputCommittee()">
                                    Commitee Form
                                </a>

                            </div>
                            <div class="form-group col-12 col-xl-4 col-xl-2">
                                <div class="row justify-content-center ">
                                    <div class="col-md-4 form-control" style="width: 100%;" class="form-control">
                                        @php
                                            use App\Models\doc_commitee;
                                        @endphp
                                        @if (doc_commitee::where('emis', session('emis'))->where('requestType', session('requestType'))->where('status', 'signed')->exists())
                                            <label for="reference-number">Uploaded Committee PDFs</label>
                                            @php
                                                $fileName = doc_commitee::where('emis', session('emis'))
                                                    ->where('requestType', session('requestType'))
                                                    ->where('status', 'signed')
                                                    ->value('fileName');
                                            @endphp
                                            <p> {{ $fileName }} </p>
                                        @else
                                            <label for="reference-number">Upload Committee</label>
                                            <div class="input-group">
                                                <input type="file" name="fileComitee" id="fileComiteeInput" required
                                                    value="{{ old('fileCommiteeName', session('fileCommiteeName')) }}" disabled>
                                                <div style="display:none" id= "errorComitee" class="text-danger">Please
                                                    select file</div>

                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>


                            <input type="text" class="datepicker">
                        </div>

                    </div>

                    {{-- Download and upload of Disclosure form --}}
                    <div class="row align-items-center border-bottom border-2">

                        <div class="row g-4">
                            <div class="form-group col-12 col-md-6 col-xl-3">

                                <i class="fas fa-download" style="color: green;"></i><a
                                    href=" {{ route('downloadDisclosure') }}"
                                    style="color:green; text-decoration: underline; font-style: italic;" onclick="enableUploadInputDisclosure()">
                                    Disclosure Form
                                </a>

                            </div>
                            <div class="form-group col-12 col-xl-4 col-xl-2">
                                <div class="row justify-content-center ">
                                    <div class="col-md-4 form-control" style="width: 100%;" class="form-control">
                                        @php
                                            use App\Models\doc_disclosure;
                                        @endphp
                                        @if (doc_disclosure::where('emis', session('emis'))->where('requestType', session('requestType'))->exists())
                                            <label for="reference-number">Uploaded Disclosure PDF</label>
                                            @php
                                                $fileName = doc_disclosure::where('emis', session('emis'))
                                                    ->where('requestType', session('requestType'))
                                                    ->value('fileName');
                                            @endphp
                                            <p> {{ $fileName }} </p>
                                        @else
                                            <label for="reference-number">Upload Disclosure </label>
                                            <div class="input-group">
                                                <input type="file" name="fileDisclosure" id="fileDisclosureInput"
                                                    required
                                                    value="{{ old('fileDisclosureName', session('fileDisclosureName')) }}" disabled>
                                                <div style="display:none" id= "errorDisclosure" class="text-danger">
                                                    Please
                                                    select file</div>



                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>




                            <input type="text" class="datepicker">
                        </div>

                    </div>

                    <center>
                        <br> <br>
                        <div class="col-6 col-md-6 col-xl-2">
                            <input type="submit" id="btnSub" class="btn btn-primary w-100 " onclick="validateFilesAndSubmit()"
                                value="Request Quotes"  data-bs-toggle="modal" disabled
                                data-bs-target="#exampleModalProgress">
                        </div>
                        <br> <br>
                    </center>
                </form>

            
            </div>






        </div>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.datepicker').datepicker({
                    startDate: new Date() // Set the start date to today
                });
            });
            // Update the text input when a date is selected
            $('.datepicker').on('changeDate', function(e) {
                $(this).val(e.format());
            });


        </script>


  {{-- Enable upload only once the download is clicked --}}
  <script>
    function enableUploadInputCommittee() {
        document.getElementById('fileComiteeInput').disabled = false;
    }

    function enableUploadInputDisclosure() {
        document.getElementById('fileDisclosureInput').disabled = false;
        document.getElementById('btnSub').disabled = false;


    }


//     if (($('#fileDisclosureInput').prop('disabled')) && ($('#fileComiteeInput').prop('disabled'))) {
//     console.log('Element is disabled and another condition is true');
// } else {
//     console.log('Element is not disabled or another condition is false');
// }
</script>

        {{-- Checked all ticked , check all checkboxes within table --}}
        <script>
            $(document).ready(function() {
                // Handle the "Check All" checkbox
                $('#checkAll').change(function() {
                    $('.checkbox').prop('checked', $(this).prop('checked'));

                    // Update the hidden input value based on the checkbox state
                    $('#checkAllStatus').val($(this).prop('checked').toString());
                });
            });
        </script>

        @if (session('belowMinSelection') == true)
            <script>
                $(document).ready(function() {
                    $('#exampleModalExceed').modal('show');
                });
            </script>
        @endif

        @if (session('successEmail') == true)
            <script>
                $(document).ready(function() {
                    $('#exampleModalSentEmail').modal('show');
                });
            </script>
        @endif

        <script>
            document.getElementById('fileComiteeInput').addEventListener('blur', function() {
                var fileInput = this;
                var errorDiv = document.getElementById('fileComiteeError');

                // Check if the file input is empty
                if (fileInput.value.trim() === '') {
                    // Show the error message
                    errorDiv.style.display = 'block';
                } else {
                    // Hide the error message
                    errorDiv.style.display = 'none';
                }
            });
        </script>

        <script>
            function validateFilesAndSubmit() {
                // Get the file input elements
                var fileComiteeInput = document.getElementById('fileComiteeInput');
                var fileDisclosureInput = document.getElementById('fileDisclosureInput');

                // Get the error message elements
                var errorComitee = document.getElementById('errorComitee');
                var errorDisclosure = document.getElementById('errorDisclosure');

                /*  var closingDateInput = document.getElementById('closingDateInput');
                 var errorClosingDate = document.getElementById('errorClosingDate'); */

                // Check if a file is selected for fileComitee
                if (fileComiteeInput.files.length === 0) {
                    // Display the error message for fileComitee
                    errorComitee.style.display = 'block';
                    return false; // Prevent the form from being submitted
                } else {
                    // If a file is selected for fileComitee, hide the error message
                    errorComitee.style.display = 'none';
                }

                // Check if a file is selected for fileDisclosure
                if (fileDisclosureInput.files.length === 0) {
                    // Display the error message for fileDisclosure
                    errorDisclosure.style.display = 'block';
                    return false; // Prevent the form from being submitted
                } else {
                    // If a file is selected for fileDisclosure, hide the error message
                    errorDisclosure.style.display = 'none';
                }

                // Check if a closing date is selected
                /*  if (closingDateInput.value.trim() === '') {
                            // Display the error message for the closing date
                            errorClosingDate.style.display = 'block';
                            return false; // Prevent the form from being submitted
                        } else {
                            // If a closing date is selected, hide the error message
                            errorClosingDate.style.display = 'none';
                        }
         */
                // Optionally, you can submit the form programmatically
                document.getElementById('yourFormId').submit();

                // Return false to prevent the form from being submitted by default
                return false;
            }
        </script>



        {{-- <script>
   function validateForm() {
        // Validate the file input
        var fileInput = document.getElementById('fileComiteeInput');
        var errorDiv = document.getElementById('fileComiteeError');

        // Check if the file input is empty
        if (fileInput.value.trim() === '') {
            // Show the error message
            errorDiv.style.display = 'block';
            // Prevent the form from submitting
            return false;
        } else {
            // Hide the error message
            errorDiv.style.display = 'none';
            // Allow the form to submit
            return true;
        } 

        var fileInput1 = document.getElementById('fileDisclosureInput');
        var errorDiv1= document.getElementById('fileDisclosureError');

        // Check if the file input is empty
        if (fileInput1.value.trim() === '') {
            // Show the error message
            errorDiv1.style.display = 'block';
            // Prevent the form from submitting
            return false;
        } else {
            // Hide the error message
            errorDiv1.style.display = 'none';
            // Allow the form to submit
            return true;
        }

        var fileInput2 = document.getElementById('closingDateInput');
        var errorDiv2 = document.getElementById('closingDateError');

        // Check if the file input is empty
        if (fileInput2.value.trim() === '') {
            // Show the error message
            errorDiv2.style.display = 'block';
            // Prevent the form from submitting
            return false;
        } else {
            // Hide the error message
            errorDiv2.style.display = 'none';
            // Allow the form to submit
            return true;
        }
    }
</script> --}}


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
           <script>
            function setInProgress() {
                // Show the spinner
                document.getElementById('spinner').style.display = 'block';
        
                // Example: Simulating a delay of 5 seconds (5000 milliseconds)
                setTimeout(function () {
                    // Hide the spinner after the process is complete
                    document.getElementById('spinner').style.display = 'none';
                }, 5000);
            }
        </script>
    @endsection
