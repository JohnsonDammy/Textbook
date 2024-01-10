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
            <div class="row mb-5">
                <div class="align-items-center">
                    <form class="" enctype="multipart/form-data" method="post" action="{{ route('AddDeliverys') }}"
                        data-parsley-validate>
                        @csrf()

                        <table class="table">

                            <thead>
                                <tr>
                                    {{-- {{$CheckValueTextbook }} {{$CheckValueStationary}} --}}
                                    <th>School Name</th>
                                    <th>School EMIS</th>
                                    <th>Supplier Name</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                    <!-- Add more table headers as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allData as $school)
                                    <tr>
                                        <td>{{ $school->name }}</td>
                                        <td>{{ $school->emis }}</td>
                                        <td>Adams</td>
                                        <td>8989888888</td>
                                        <td>Admam@gmail.com </td>
                                        <!-- Add more table cells as needed -->
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>

                        <br>
                        {{-- {{$CheckValueTextbook }} {{$CheckValueStationary}} --}}
                        <label>Please Select Request Type<span class="text-danger">*</span></label>
                        <select name="requestType" id="requestType" class="form-control" required>
                            <option></option>

                            
                            @if($CheckValueTextbook == 'Yes' && $CheckValueStationary == 'Yes')
                                <option>Textbook</option>
                                <option>Stationery</option>
                            @endif
                            
                            @if($CheckValueTextbook == 'Yes' && $CheckValueStationary != 'Yes')
                                <option>Textbook</option>
                            @endif
                            
                            @if($CheckValueTextbook != 'Yes' && $CheckValueStationary == 'Yes')
                                <option>Stationery</option>
                            @endif
                        </select>
                        
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

        </div>
        <script>
            function hidePopup() {
                $("#exampleModal").fadeOut(200);
                $('.modal-backdrop').remove();
                console.log("hidePop")
            }
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
