@extends('layouts.layout')
@section('title', 'View Funds Request')
@section('content')
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center border-bottom border-2">
            <div class="col-12 col-md-4">
                <div class="page-titles">
                    <h4>School Funds Request</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('furniture-replacement.index') }}">Transactions</a>
                        </li>
                    </ol>
                </div>
            </div>
            @can('collection-request-create')
            <div class="offset-xl-6 col-12 col-md-4 col-xl-2 mb-3">
                <a href="{{ route('furniture-replacement.create') }}" class="btn btn-primary w-100">+ Create New
                    Request</a>
            </div>
            @endcan

        </div>
        <div class="row justify-content-center">
            @if ($message = Session::get('success'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">Transaction</h4>
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
                                <h4 class="popup-alert_title">Transaction</h4>
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
                                <h4 class="popup-alert_title">Transaction</h4>
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
            <div class="col-12 col-md-12 my-3">
                <p class="filter-title">Request Search</p>
                <form method="get" action="/furniture-replacement-search">
                    <div class="row justify-content-center align-items-center g-4">
                        <div class="col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control rounded-0" name="ref_number" placeholder="Reference Number">
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control date-input rounded-0 dates" name="start_date" placeholder="Start Date" autocomplete="off">
                            @if ($errors->has('start_date'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <input type="text" class="form-control search-input rounded-0" name="school_name" placeholder="School Name">
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <select class="form-select form-control rounded-0" name="status_id" aria-label="Default select example">
                                <option selected value="">Status</option>
                                @foreach (getStatusList() as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control date-input rounded-0 dates" name="end_date" placeholder="End Date" autocomplete="off">
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control rounded-0" name="emis" placeholder="EMIS Number">
                        </div>
                        <div class="col-6 col-md-6 col-xl-1 text-end">
                            <a type="reset" href="{{ route('furniture-replacement.index') }}" class="btn-reset px-4 text-decoration-underline" value="Clear">Clear </a>
                     
                        </div>
                        <div class="col-6 col-md-6 col-xl-2">
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
                                <th>Reference No.</th>
                                <th>Status</th>
                                <th>EMIS Number</th>
                                <th>Funds Type</th>
                                <th>Amount Request</th>
                                <th>Status</th>
                                <th>Message</th>
                                <th>Date Created</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- //INSERT INTO `fundsrequest`(`id`, `References_Number`, `School_Emis`, `School_Name`, `FundsAmount`, `RequestType`, `Status`, `Action_By`, `Message`, `year`, `date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]') --}}
                            @foreach ($data as $record)
                                <tr>
                                    <td>{{ $record->School_Name }}</td>
                                    <td>{{ $record->References_Number }}</td>
                                    <td>{{ $record->Status }}</td>
                                    <td>{{ $record->School_Emis }}</td>
                                    <td>{{ $record->RequestType }}</td>
                                    <td>{{ $record->funds_amount }}</td>
                                    <td>{{ $record->Status }}</td>
                                    <td>{{ $record->Message }}</td>
                                    <td>{{ $record->date }}</td>
                                    <td>
                                        <!-- Add your manage buttons or actions here -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <nav class="pagination-wrap">
                    <ul class="pagination">
                        <li class="page-item ">
                            <a class="{{ $data->previousPageUrl() ? '' : 'disabled' }}" href="{{ $data->previousPageUrl() }}">
                                <i class="ri-arrow-left-s-line me-4"></i>
                                Previous</a>
                        </li>

                         <li class="page-item">
                            <a class="{{ $data->nextPageUrl() ? '' : 'disabled' }}" href="{{ $data->nextPageUrl() }}">Next
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
    </script>
</main>
@endsection