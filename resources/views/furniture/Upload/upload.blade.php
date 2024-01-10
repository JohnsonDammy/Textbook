@extends('layouts.layout')
@section('title', 'Upload Documents')
@section('content')
    <main>
        <style>

        </style>
        <div class="container">
            <div class="row justify-content-center">
                @if ($message = Session::get('success'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                        <h4 class="popup-alert_title">{{ $message }}</h4>
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

                @if ($message = Session::get('successD'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                        <h4 class="popup-alert_title">{{ $message }}</h4>
                                        {{-- <p class="popup-alert_des">{{ $message }}</p> --}}
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
            </div>
            <div class="row">
                @if ($message = Session::get('status'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="assets/img/popup-check.svg" class="img-fluid" alt="">
                                        <h4 class="popup-alert_title">Password Reset</h4>
                                        <p class="popup-alert_des"> {{ $message }}</p>
                                    </div>

                                </div>
                                <div class="modal-footer text-center">
                                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                        onclick="hidePopup()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="text-center mt-4">

                            @if (Auth::user()->getOrganization->id == 1)
                                <div class="col-12 mb-3">
                                    <br>
                                    <h4>Please carefully upload for <b>2023</b> Funds Allocation, Textbook, Stationary
                                        document <b>Section
                                            21 C</b></h4><br><br>
                                    <center>
                                        <label>Select Below:</label>
                                        <select class="form-control" name="UploadType" id="UploadType" style="width:30%"
                                            onchange="selectType()">
                                            <option>Select Upload Type</option>
                                            <option value="FundAllocation">Fund Allocation</option>
                                            <option value="TextC">Textbook Catalogue</option>
                                            <option value="Station">Stationary Catalogue</option>

                                        </select>
                                        <br>

                                        <form action="{{ route('upload-data') }}" method="post"
                                            enctype="multipart/form-data" id="fundAllocationForm" style="display: none;">
                                            @csrf
                                            <div class="container">
                                                <div class="row justify-content-center ">
                                                    <div class="col-md-4 form-control" style="width: 34%;"
                                                        class="form-control">
                                                        <label for="reference-number">Upload Funds Allocation</label>
                                                        <div class="input-group">
                                                            <input type="file" name="file"
                                                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, application/vnd.ms-excel.sheet.macroEnabled.12, application/vnd.ms-excel.sheet.binary.macroEnabled.12">
                                                        </div>
                                                        <hr>
                                                        <br>

                                                        <button class="btn btn-primary" id="proceedbtn" type="submit">
                                                            Upload Bulk
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                        <br>

                                        <form action="{{ route('upload-catalogue') }}" method="post"
                                            enctype="multipart/form-data" id="textbookCatalogueForm" style="display: none;">
                                            @csrf
                                            <div class="container">
                                                <div class="row justify-content-center ">
                                                    <div class="col-md-4 form-control" style="width: 34%;"
                                                        class="form-control">
                                                        <label for="reference-number">Upload Bulk Textbook
                                                            Catalogue</label>
                                                        <div class="input-group">
                                                            <input type="file" name="Textbookfile"
                                                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, application/vnd.ms-excel.sheet.macroEnabled.12, application/vnd.ms-excel.sheet.binary.macroEnabled.12">
                                                        </div>
                                                        <hr>

                                                        <br>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <button class="btn btn-primary" id="proceedbtn" type="submit">
                                                            Upload Bulk
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                        <br>
                                        <form action="{{ route('upload-stationary') }}" method="post"
                                            enctype="multipart/form-data" id="stationaryCatalogueForm"
                                            style="display: none;">
                                            @csrf
                                            <div class="container">
                                                <div class="row justify-content-center ">
                                                    <div class="col-md-4 form-control" style="width: 34%;"
                                                        class="form-control">

                                                        <label for="reference-number">Upload Bulk Stationary
                                                            Catalogue</label>
                                                        <div class="input-group">
                                                            <input type="file" name="Stationaryfile"
                                                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, application/vnd.ms-excel.sheet.macroEnabled.12, application/vnd.ms-excel.sheet.binary.macroEnabled.12">
                                                        </div>
                                                        <input type="hidden" name="SchoolEmis"
                                                            value="{{ Auth::user()->username }}">
                                                        <input type="hidden" name="SchoolName"
                                                            value="{{ Auth::user()->name }}">

                                                        {{-- Upload button for a circular document --}}

                                                        <br>
                                                        <button class="btn btn-primary" id="proceedbtn" type="submit">
                                                            Upload Bulk
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <br>
                                        <br>
                                        <br>
                                </div>
                        </div>
                    </div>

                </div>
                <br>
                {{-- <a href="{{ route('Funds.index') }}" class="btn btn-primary btn-lg"
                                        style="background-color: green">Proceed</a> --}}


                {{-- <input type="hidden" name="_method" value="DELETE"> --}}



                <br><br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Description.</th>
                                <th>File.</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- //INSERT INTO `fundsrequest`(`id`, `References_Number`, `School_Emis`, `School_Name`, `FundsAmount`, `RequestType`, `Status`, `Action_By`, `Message`, `year`, `date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]') --}}
                            @foreach ($data as $record)
                                <tr>
                                    <td>{{ $record->id }}</td>
                                    <td>{{ $record->Description }}</td>
                                    {{-- Section 21 C Funds Allocation_653d1480ac558_Allocation.xlsx --}}
                                    <td>
                                        {{-- C:\xampp\htdocs\Project\Textbook\public\public\ApprovePdf --}}
                                        @if ($record->file)
                                            <a href="{{ asset('public/ApprovePdf/' . $record->file) }}" download>
                                                <i class="fa fa-download"></i> Download File
                                            </a>
                                        @else
                                            <!-- Handle the case where 'documentRequest' is not available -->
                                        @endif
                                    </td>
                                    <td>

                                        <form action="{{ route('action2') }}" method="POST">
                                            @csrf

                                            <input type="hidden" value="{{ $record->id }}" name="del">

                                            <input type="hidden" value="{{ $record->Description }}" name="Descript">


                                            <!-- Button trigger modal -->
                                            <button class="btn-reset" type="button" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $record->id }}">
                                                <i class="ri-delete-bin-7-fill"></i>
                                            </button>

                                            <div class="modal fade" id="exampleModal{{ $record->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered popup-alert">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                                <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                                                    class="img-fluid mb-5" alt="">
                                                                <h4 class="modal-title">Delete</h4>
                                                                <p class="modal-title_des">Are you sure you want to
                                                                    delete
                                                                    this?</p>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer justify-content-around text-center">
                                                            <button type="button" class="btn btn--dark px-5"
                                                                data-bs-dismiss="modal">No</button>
                                                            <button type="submit"
                                                                class="btn btn-primary px-5">Yes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered popup-alert">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center">
                                    <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5"
                                        alt="">
                                    <p class="modal-title_des initial-message">Are you sure about
                                        document</p>
                                    <p class="modal-title_des error-message" style="display: none">
                                        Please select an option to proceed</p>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-around text-center">
                                <button type="button" class="btn btn--dark px-5" id="NoBtnModel"
                                    data-bs-dismiss="modal">No</button>
                                <button type="button" class="btn btn--dark px-5" style="display: none" id="OkBtnModel"
                                    data-bs-dismiss="modal">OK</button>
                                <button type="submit" class="btn btn-secondary px-5" id="yesBtnModel">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            @endif


        </div>

        </div>

        </div>
        </div>
        </div>


        </div>

        @if ($message = Session::get('status'))
            <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
        @endif
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
            }
        </script>

        <script>
            $('.check').on('change', function() {
                $('#selectedOption').val($(this).val());
            });
        </script>

        {{-- Ensure that user can only  --}}
        <script>
            // Attach a click event listener to the "Proceed" button
            document.querySelector('#proceedbtn').addEventListener('click', function() {
                if (!document.querySelector('input[name="options"]:checked')) {
                    // No option is selected, so show the "Please select an option to proceed" message
                    document.querySelector('.initial-message').style.display = 'none';
                    document.querySelector('#yesBtnModel').style.display = 'none';
                    document.querySelector('#NoBtnModel').style.display = 'none';
                    document.querySelector('.error-message').style.display = 'block';
                    document.querySelector('#OkBtnModel').style.display = 'block';
                } else {
                    // No option is selected, so show the "Please select an option to proceed" message
                    document.querySelector('.initial-message').style.display = 'block';
                    document.querySelector('#yesBtnModel').style.display = 'block';
                    document.querySelector('#NoBtnModel').style.display = 'block';
                    document.querySelector('.error-message').style.display = 'none';
                    document.querySelector('#OkBtnModel').style.display = 'none';
                }




            });
        </script>
        <script>
            function selectType() {
                var selectedOption = document.getElementById('UploadType').value;
                var fundAllocationForm = document.getElementById('fundAllocationForm');
                var textbookCatalogueForm = document.getElementById('textbookCatalogueForm');
                var stationaryCatalogueForm = document.getElementById('stationaryCatalogueForm');

                // Hide all forms initially
                fundAllocationForm.style.display = 'none';
                textbookCatalogueForm.style.display = 'none';
                stationaryCatalogueForm.style.display = 'none';

                // Show the selected form based on the dropdown value
                if (selectedOption === 'FundAllocation') {
                    fundAllocationForm.style.display = 'block';
                } else if (selectedOption === 'TextC') {
                    textbookCatalogueForm.style.display = 'block';
                } else if (selectedOption === 'Station') {
                    stationaryCatalogueForm.style.display = 'block';
                }
            }
        </script>

{{-- <script>
    $('#fundAllocationForm').on('submit', function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: '{{ route('upload-data') }}',
        data: formData,
        contentType: false,
        processData: false,
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener('progress', function (e) {
                if (e.lengthComputable) {
                    var percentage = (e.loaded / e.total) * 100;
                    $('.progress-bar').css('width', percentage + '%');
                }
            });

            return xhr;
        },
        success: function (data) {
            // Handle success response and hide the progress bar
            $('.progress-bar').css('width', '0%');
            // You can show a success message or perform any other actions here
        },
        error: function (error) {
            // Handle error response and hide the progress bar
            $('.progress-bar').css('width', '0%');
            // Display an error message or handle the error as needed
        },
    });
});

</script> --}}
    </main>
    
@endsection
