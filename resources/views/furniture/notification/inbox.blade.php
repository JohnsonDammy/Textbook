@extends('layouts.layout')
@section('title', 'Notification')
@section('content')
    <main>
        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center border-bottom border-2">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Inbox</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('AdminViewFundRequest.index') }}">Inbox</a>
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
                @if ($message = Session::get('successa'))
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
                @if ($message = Session::get('success'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
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
                                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                        onclick="hidePopup()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
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
                                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                        onclick="hidePopup()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($message = Session::get('alert'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5"
                                            alt="">
                                        <h4 class="popup-alert_title">Transaction</h4>
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
                <div class="col-12 col-md-12 my-3">
                    <p class="filter-title">Inbox Search</p>
                    <form method="get" action="{{route('inbox-search')}}">
                        <div class="row justify-content-center align-items-center g-4">

                            <div class="col-12 col-md-6 col-xl-3">
                                <input type="text" class="form-control rounded-0" name="emis"
                                    placeholder="EMIS Number">
                            </div>

                            <div class="col-12 col-md-6 col-xl-6">
                                <input type="text" class="form-control search-input rounded-0" name="school_name"
                                    placeholder="School Name">
                            </div>
                         
                            {{-- <div class="col-12 col-md-6 col-xl-3">
                                <input type="text" class="form-control date-input rounded-0 dates" name="start_date"
                                    placeholder="Date" autocomplete="off">
                                @if ($errors->has('start_date'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-md-6 col-xl-3">
                                <select class="form-select form-control rounded-0" name="fundtype"
                                    aria-label="Default select example">
                                    <option selected>Request Type</option>
                                    <option value="Textbook">Textbook</option>
                                    <option value="Stationary">Stationary</option>

                                </select>
                            </div>
                  --}}
                            <div class="col-6 col-md-6 col-xl-1 text-end">
                                <a type="reset" href="{{ route('notification') }}"
                                    class="btn-reset px-4 text-decoration-underline" value="Clear">Clear </a>

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
                        
                                    <th>EMIS Number</th>
             
                                    <th>Message</th>
                                    <th>Date Created</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- INSERT INTO `inbox`(`Id`, `RequestFundsId`, `School_Emis`, `References_Number`, `SchoolName`, `District_Id`, `RequestType`, `Message`, `Date`, `year`, `Request`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]')                                 @foreach ($data as $record) --}}
                                @foreach ($data as $record)
                                    @if ($record->seen == '0')
                                        <tr style="background-color:rgb(196, 223, 232)">
                                 
                                            <td>{{ $record->School_Emis }}</td>
                                            <td>{!! nl2br(e($record->Message ?? 'N/A')) !!}</td>

                                            <td>{{ $record->DateTime }}</td>

                                            <td>
                                                <div class="d-flex">
                                                    {{-- <i class="fa fa-eye" aria-hidden="true"></i>   |  --}}
                                                    <form action="{{ route('MarkAsRead') }}" method="POST">
                                                        <input type="hidden" value="{{ $record->Id }}"
                                                            name="DelS">
                                                        @csrf
                                                        <button class="btn-reset" type="submit">
                                                            <i class="fa fa-envelope-o" title="Mark as read"
                                                                aria-hidden="true"></i> |
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('DeleteMessage') }}" method="POST">
                                                        @csrf

                                                        <input type="hidden" value="{{ $record->Id }}"
                                                            name="delNotification">

                                                        <!-- Button trigger modal -->
                                                        <button class="btn-reset" type="button" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{ $record->id }}">
                                                            <i class="ri-delete-bin-7-fill"></i>
                                                        </button>

                                                        <div class="modal fade" id="exampleModal{{ $record->id }}"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered popup-alert">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="text-center">
                                                                            <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                                                                class="img-fluid mb-5" alt="">
                                                                            <h4 class="modal-title">Delete</h4>
                                                                            <p class="modal-title_des">Are you sure you
                                                                                want to
                                                                                delete
                                                                                this?</p>
                                                                        </div>

                                                                    </div>
                                                                    <div
                                                                        class="modal-footer justify-content-around text-center">
                                                                        <button type="button" class="btn btn--dark px-5"
                                                                            data-bs-dismiss="modal">No</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary px-5">Yes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            {{-- <td>{{ $record->References_Number }}</td> --}}

                                            {{-- <td>{{ $record->SchoolName }}</td> --}}
                                            <td>{{ $record->School_Emis }}</td>

                                            {{-- <td>{{ $record->Request }}</td> --}}
                                            {{-- <td>{{ $record->RequestType }}</td> --}}




                                            <td>{!! nl2br(e($record->Message ?? 'N/A')) !!}</td>

                                            <td>{{ $record->DateTime }}</td>

                                            <td>
                                                <div class="d-flex">
                                                    {{-- <i class="fa fa-eye" aria-hidden="true"></i>   |  --}}
                                                    <form action="{{ route('MarkAsRead') }}" method="POST">
                                                        <input type="hidden" value="{{ $record->Id }}"
                                                            name="DelS">
                                                        @csrf
                                                        <button class="btn-reset" type="submit">
                                                            <i class="fa fa-envelope-o" title="Mark as read"
                                                                aria-hidden="true"></i> |
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('DeleteMessage') }}" method="POST">
                                                        @csrf

                                                        <input type="hidden" value="{{ $record->Id }}"
                                                            name="delNotification">

                                                        <!-- Button trigger modal -->
                                                        <button class="btn-reset" type="button" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{ $record->Id }}">
                                                            <i class="ri-delete-bin-7-fill"></i>
                                                        </button>

                                                        <div class="modal fade" id="exampleModal{{ $record->Id }}"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered popup-alert">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="text-center">
                                                                            <img src="{{ asset('img/confirmation-popup-1.svg') }}"
                                                                                class="img-fluid mb-5" alt="">
                                                                            <h4 class="modal-title">Delete</h4>
                                                                            <p class="modal-title_des">Are you sure you
                                                                                want to
                                                                                delete
                                                                                this?</p>
                                                                        </div>

                                                                    </div>
                                                                    <div
                                                                        class="modal-footer justify-content-around text-center">
                                                                        <button type="button" class="btn btn--dark px-5"
                                                                            data-bs-dismiss="modal">No</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary px-5">Yes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <nav class="pagination-wrap">
                        <ul class="pagination">
                            <li class="page-item ">
                                <a class="{{ $data->previousPageUrl() ? '' : 'disabled' }}"
                                    href="{{ $data->previousPageUrl() }}">
                                    <i class="ri-arrow-left-s-line me-4"></i>
                                    Previous</a>
                            </li>

                            <li class="page-item">
                                <a class="{{ $data->nextPageUrl() ? '' : 'disabled' }}"
                                    href="{{ $data->nextPageUrl() }}">Next
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
