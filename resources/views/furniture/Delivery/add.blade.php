@extends('layouts.layout')
@section('title', 'Add Delivery')
@section('content')
    <!-- main -->
    <main>
        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>+ Add New Delivery Note</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/home">Home</a></li>
                            <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/Delivery/list">View Delivery Note</a>
                            </li>

                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add New Delivery</a>
                            </li>
                        </ol>
                    </div>
                </div>

            </div>

            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
                $(document).ready(function () {
                    // Listen for change event on the dropdown
                    $('#requestType').on('change', function () {
                        // Hide all forms
                        $('#TextbookForm, #StationeryForm').hide();
                        
                        // Show the selected form based on the dropdown value
                        if ($(this).val() === 'Textbook') {
                            $('#TextbookForm').show();
                        } else if ($(this).val() === 'Stationery') {
                            $('#StationeryForm').show();
                        }
                    });
                });
            </script>
            <div class="row mb-5">
                <div class="align-items-center">
                    <br>
                    {{-- {{$CheckValueTextbook }} {{$CheckValueStationary}} --}}
                    <label>Please Select Request Type<span class="text-danger">*</span></label>
                    <select id="requestType" class="form-control" required style="width: 350px"   >
                        <option>Select Below:                         </option>

                        
                        @if($CheckValueTextbook == 'Yes' && $CheckValueStationary == 'Yes')
                            <option value="Textbook">Textbook</option>
                            <option value="Stationery">Stationery</option>
                        @endif
                        
                        @if($CheckValueTextbook == 'Yes' && $CheckValueStationary != 'Yes')
                            <option value="Textbook">Textbook</option>
                        @endif
                        
                        @if($CheckValueTextbook != 'Yes' && $CheckValueStationary == 'Yes')
                            <option value="Stationery">Stationery</option>
                        @endif
                    </select>

                </div>

                    <br>
                    <br>

                    <form class="" enctype="multipart/form-data" method="post" action="{{ route('AddDeliverys') }}"
                        data-parsley-validate id="TextbookForm" style="display: none">
                        @csrf()

                        <table class="table">
                            <input type="hidden" value="Textbook" name="requestType">

                            <thead>
                                <tr>
                                    <th>Supplier ID</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Company Address</th>
                                    <th>Company Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allDataText as $supplier)
                                    <tr>
                                     <td>{{ $supplier->Id }}</td>

                                        <td>{{ $supplier->CompanyName }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->CompanyAddress }}</td>
                                        <td>{{ $supplier->CompanyContact }}</td>

                                    </tr>
                                    <input type="hidden" value="{{$supplier->Id}}" name="SupplierID">

                                @endforeach
                            </tbody>
                        </table>


                        <div class="form-group col-12 col-md-6 col-xl-3">

                            <div style="display:none" id="errorClosingDate" class="text-danger">Please closing
                                date</div>
                            <label for="exampleDate">Select a Delivery Date:</label>
                            <input type="text" class="form-control datepicker" id="exampleDate" placeholder="MM/DD/YYYY"
                                name="DeliveryDate" id="DeliveryDate" required >
                        </div>

                        <div class="form-group ">
                            <input type="file" class="form-control" name="filename" id="filename"
                                value="" placeholder=" " required style="width: 350px">
                            <label>Upload Delivery Note/Invoice<span class="text-danger">*</span></label>
                        </div>



                        <div class="text submit-btn my-4">
                            <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline"
                                value="Clear">Clear </button>
                            <input type="submit" class="mx-4  btn btn-lg btn-primary" value="Upload">
                        </div>
                    </form>




                    <div>
                            <form class="" enctype="multipart/form-data" method="post" action="{{ route('AddDeliverys') }}"
                            data-parsley-validate id="StationeryForm" style="display: none">
                            @csrf()

                            <table class="table">
                                <input type="hidden" value="Stationery" name="requestType">

                                <thead>
                                    <tr>
                                        <th>Supplier ID</th>
                                        <th>Company Name</th>
                                        <th>Email</th>
                                        <th>Company Address</th>
                                        <th>Company Contact</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allDataStationary as $supplier)
                                        <tr>
                                            <td>{{ $supplier->Id }}</td>

                                            <td>{{ $supplier->CompanyName }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>{{ $supplier->CompanyAddress }}</td>
                                            <td>{{ $supplier->CompanyContact }}</td>
                                        </tr>

                                     <input type="hidden" value="{{ $supplier->Id }}" name="SupplierID"> 

                                    @endforeach
                                </tbody>


                            </table>

                    
                            <div class="form-group col-12 col-md-6 col-xl-3">

                                <div style="display:none" id="errorClosingDate" class="text-danger">Please closing
                                    date</div>
                                <label for="exampleDate">Select a Delivery Date:</label>
                                <input type="text" class="form-control datepicker" id="exampleDate" placeholder="MM/DD/YYYY"
                                    name="DeliveryDate" id="DeliveryDate" required >
                            </div>
    
                            
                            <div class="form-group ">


                                <input type="file" class="form-control form-control-lg" name="filename" id="filename"
                                    value="" placeholder=" " required>
                                <label>Upload Delivery Note/Invoice<span class="text-danger">*</span></label>
                            </div>



                            <div class="text submit-btn my-4">
                                <button type="reset" class="btn-reset px-4 fs-3 text-decoration-underline"
                                    value="Clear">Clear </button>
                                <input type="submit" class="mx-4  btn btn-lg btn-primary" value="Upload">
                            </div>
                        </form>
                    </div>

            </div>

        </div>
        <script>
            function hidePopup() {
                $("#exampleModal").fadeOut(200);
                $('.modal-backdrop').remove();
                console.log("hidePop")
            }
        </script>

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
    </main>

    @if ($message = Session::get('error'))
    <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
@endif
<script>
    function hidePopup() {
        $("#exampleModal").fadeOut(200);
        $('.modal-backdrop').remove();
        console.log("hidePop")
    }
</script>
</main>
@endsection
