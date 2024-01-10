@extends('layouts.layout')
@section('title', 'Manage Funding')
@section('content')
<main>
    <style>
          .check {
                width: 50px;
                height: 20px;
            }
    </style>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center border-bottom border-2">
            <div class="col-12 col-md-4">
                <div class="page-titles">
                    <h4>Quotation</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="#">Manage Funding Request</a>
                        </li>
                    </ol>
                </div>
            </div>


        </div>
        <div class="row justify-content-center">
            @if ($message = Session::get('success'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">Manage Request Funding</h4>
                                <p class="popup-alert_des">{{ $message }}</p>
                            </div>

                        </div>
                        <div class="modal-footer text-center justify-content-center p-3 border-0">
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="hidePopup()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">Manage Request Funding</h4>
                                <p class="popup-alert_des">{{ $message }}</p>
                            </div>

                        </div>
                        <div class="modal-footer text-center justify-content-center p-3 border-0">
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="hidePopup()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if ($message = Session::get('alert'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">Manage Request Funding</h4>
                                <p class="popup-alert_des">{{ $message }}</p>
                            </div>

                        </div>
                        <div class="modal-footer text-center justify-content-center p-3 border-0">
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="hidePopup()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <main>
                <div class="container">
                    <!-- breadcrumb -->
            
                    <div class="row justify-content-center my-3">
                        <div class="col-12 col-md-3">
                            <div class="process row align-items-center text-center">
                                <div class="col content-col">
                                    <button class="btn-reset" type="button" data-bs-toggle="modal" data-bs-target="#transmodal">
                                        <div class="circle-icon-container">
                                            <i class="ri-list-check"></i>
                                        </div>
                                        <p>Transactions List</p>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-9">
                            <div class="process row align-items-center text-center">
                                <div class="col content-col active">
                                    <div class="circle-icon-container">
                                        <i class="ri-add-fill"></i>
                                    </div>
                                    <p>Create Funds Request</p>
                                </div>
                                <div class="col arrow-col ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                                        <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                                    </svg>
            
                                </div>
                                <div class="col content-col ">
                                    <div class="circle-icon-container">
                                        <i class="ri-layout-top-2-fill"></i>
                                    </div>
                                    <p>Generate Quotation</p>
                                </div>
                                <div class="col arrow-col ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                                        <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                                    </svg>
            
                                </div>
                                <div class="col content-col">
                                    <div class="circle-icon-container">
                                        <i class="ri-hammer-fill"></i>
                                    </div>
                                    <p>Upload Quotation</p>
                                </div>
                                <div class="col arrow-col ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                                        <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                                    </svg>
            
                                </div>
                                <div class="col content-col">
                                    <div class="circle-icon-container">
                                        <i class="ri-truck-fill"></i>
                                    </div>
                                    <p>Deliver Items</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 my-3">
                            <div class=" bg-light fw-bold py-4 color-primary px-5">
                                <p class="mb-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="checkbox" class="check" id="checkbox1" value="Textbook">
                                            <label for="checkbox1"  >Textbook Funds      :<b>Avaliable Funds Amount :</b><b style="color:brown">R100,000</b></label>
                                        </div>
                               
                                    </div>
                                    
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('furniture-replacement.store') }}" id="create-collection-form" method="POST">
                            @csrf
                            <input type="hidden" name="broken_items[]" id="broken_array" value="">
                            <div class="col-12 col-md-12 my-3">
                                <div class="row g-4">
                                    <div class="form-group col-12 col-md-6 col-xl-3">
                                        <input type="text" class="form-control form-control-lg" required="required" value="{{ Auth::user()->name }}" disabled placeholder=" ">
                                        <label>School Name</label>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-xl-3">
                                        <input type="text" class="form-control form-control-lg" value="{{ Auth::user()->username }}" disabled required="required" placeholder=" ">
                                        <label>School EMIS Number</label>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-xl-4">
                                        <input type="text" class="form-control form-control-lg" style="box-shadow:0 0 0 0.25rem #7cbf7a" required="required" placeholder="Enter Funds Amount">
            
                                        <span class="text-danger" style="display: none;" id="counterror" role="alert">
                                            <strong id="counterrormsg">Funds Amount is required</strong>
                                        </span>
            
                                        <label>Enter Textbook Funds Amount</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-12 mt-4 mb-2">
                            <a data-bs-toggle="modal" data-bs-target="#models" class="btn">Request Funds Now</a>
                        </div>
                    </div>
                   

                    <div class="row">
                        <div class="col-12 my-3">
                            <div class=" bg-light fw-bold py-4 color-primary px-5">
                                <p class="mb-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="checkbox" class="check" id="checkbox1" value="Textbook">
                                            <label for="checkbox1">Stationary Funds   :<b>Avaliable Funds Amount :</b><b style="color:brown">R700,000</b></label>
                                        </div>
                               
                                    </div>
                                    
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('furniture-replacement.store') }}" id="create-collection-form" method="POST">
                            @csrf
                            <input type="hidden" name="broken_items[]" id="broken_array" value="">
                            <div class="col-12 col-md-12 my-3">
                                <div class="row g-4">
                                    <div class="form-group col-12 col-md-6 col-xl-3">
                                        <input type="text" class="form-control form-control-lg" required="required" value="{{ Auth::user()->name }}" disabled placeholder=" ">
                                        <label>School Name</label>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-xl-3">
                                        <input type="text" class="form-control form-control-lg" value="{{ Auth::user()->username }}" disabled required="required" placeholder=" ">
                                        <label>School EMIS Number</label>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-xl-4">
                                        <input type="text" class="form-control form-control-lg" style="box-shadow:0 0 0 0.25rem #7cbf7a" required="required" placeholder="Enter Funds Amount">
            
                                        <span class="text-danger" style="display: none;" id="counterror" role="alert">
                                            <strong id="counterrormsg">Funds Amount is required</strong>
                                        </span>
            
                                        <label>Enter Stationary Funds Amount</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-12 mt-4 mb-2">
                            <a data-bs-toggle="modal" data-bs-target="#models" class="btn">Request Funds Now</a>
                        </div>
                    </div>
                </div>
                <br><br><br>
            </main>
            <div class="col-12 col-md-12 my-3">
                <form method="get" action="/search-manage-requests">
                    <input type="hidden" name="status_id" value="1">
                    <div class="row justify-content-center g-4">
                        <div class="col-12 col-md-4 col-xl-3 mb-3">
                            <input type="text" class="form-control rounded-0" name="ref_number" placeholder="Reference Number">
                        </div>
                        <div class="col-12 col-md-4 col-xl-2 mb-3">
                            <input type="text" class="form-control date-input rounded-0 dates" name="start_date" placeholder="Start Date">
                            @if ($errors->has('start_date'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-12 col-md-4 col-xl-2 mb-3">
                            <input type="text" class="form-control date-input rounded-0 dates" name="end_date" placeholder="End Date">
                        </div>
                        <div class="offset-xl-2 col-6 col-md-2 col-xl-1 text-end d-flex align-items-center justify-content-end">
                            <a href="#" type="reset" class="px-4 fs-3 text-decoration-underline">Clear</a>
                        </div>
                        <div class="col-6 col-md-2 col-xl-2">
                            <input type="submit" class="btn btn-primary w-100 " value="Search">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                @if ($message = Session::get('searcherror'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>School</th>
                                <th>Date Created</th>
                                <th>Reference No.</th>
                                <th>Status</th>
                                <th>EMIS Number</th>
                                <th>Learner Enrolment Count</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        {{-- @if (count($data) < 1) <tbody> --}}
                            <tr class="text-center text-dark">
                                <td colspan="9">No Collection Requests Found</td>
                            </tr>
                            </tbody>
                            {{-- @else
                            @foreach ($data as $key => $collRequest)
                            <tbody>
                                <tr>
                                    <td>{{ $collRequest->school_name }}</td>
                                    <td>{{ substr($collRequest->created_at, 0, 10) }}</td>
                                    <td>{{ $collRequest->ref_number }}</td>
                                    <td>{{ $collRequest->getRequestStatus->name }}</td>
                                    <td>{{ $collRequest->emis }}</td>
                                    <td>{{ $collRequest->total_furniture }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @can('manage-request-edit')
                                            <a href="{{ route('manage-requests.edit',$collRequest->id) }}" class="color-primary me-4 fs-2">
                                                <i class="ri-pencil-fill"></i>
                                            </a>
                                            @endcan
                                            @can('manage-request-delete')
                                            <form action="{{  route('manage-requests.destroy',$collRequest->id) }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <!-- Button trigger modal -->
                                                <button class="btn-reset" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$collRequest->id}}">
                                                    <i class="ri-delete-bin-7-fill"></i>
                                                </button>

                                                <div class="modal fade" id="exampleModal{{$collRequest->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered popup-alert">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5" alt="">
                                                                    <h4 class="modal-title">Delete</h4>
                                                                    <p class="modal-title_des">Are you sure you want to delete this request?</p>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer justify-content-around text-center">
                                                                <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                                                                <button type="submit" class="btn btn-primary px-5">Yes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                            @endif --}}
                    </table>
                </div>
                <nav class="pagination-wrap">
                    <ul class="pagination">
                        <li class="page-item ">
                            <a class="" href="#">
                                <i class="ri-arrow-left-s-line me-4"></i>
                                Previous</a>
                        </li>

                        <li class="page-item">
                            <a class="" href="#">Next
                                <i class="ri-arrow-right-s-line ms-4"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
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
            console.log("hidePop")
        }

        $(function() {
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();

            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;
            $('.dates').attr('max', maxDate);
        });
    </script>
</main>
@endsection