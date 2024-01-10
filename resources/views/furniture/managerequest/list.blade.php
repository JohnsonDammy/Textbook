@extends('layouts.layout')
@section('title', 'Manage Request')
@section('content')
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center border-bottom border-2">
            <div class="col-12 col-md-4">
                <div class="page-titles">
                    <h4>Manage Request</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('manage-requests.index') }}">Manage Request</a>
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
                                <h4 class="popup-alert_title">Manage Request</h4>
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
                                <h4 class="popup-alert_title">Manage Request</h4>
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
                                <h4 class="popup-alert_title">Manage Request</h4>
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
                            <a href="{{ route('manage-requests.index') }}" type="reset" class="px-4 fs-3 text-decoration-underline">Clear</a>
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
                        @if (count($data) < 1) <tbody>
                            <tr class="text-center text-dark">
                                <td colspan="9">No Collection Requests Found</td>
                            </tr>
                            </tbody>
                            @else
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
                            @endif
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