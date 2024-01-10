@extends('layouts.layout')
@section('title', 'Committee Member List')
@section('content')
<!-- main -->
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center">
            <div class="col-12 col-md-4">
                <div class="page-titles">
                    <h4>Committee Members Lists</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        {{-- <li class="breadcrumb-item"><a href="{{ route('school-maintenance') }}">School Maintenance</a></li> --}}
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Committee List</a></li>
                    </ol>
                </div>
            </div>
            <div class="offset-xl-3 col-12 col-md-4 col-xl-2 mb-3">
                <a href="{{ route('Member.Add') }}" class="btn btn-primary w-100">+ Add New Member</a>
            </div>
            <div class="col-12 col-md-4 col-xl-3 mb-3">
                <div id="search-btn">
                    <form class="d-flex" method="GET" action="{{ route('membersupplier.search') }}">
                        <input type="search" name="query" class="form-control border-0 shadow-none" value="{{ old('query') }}" placeholder="Search">
                        <button type="submit" class="btn-reset color-primary shadow-none">
                            <i class="ri-search-line fs-2"></i>
                        </button>
                    </form>
                </div>
                @if($errors->has('query'))
                <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('query') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="row">
            
            @if ($message = Session::get('success'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
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
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="hidePopup()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            

            @if ($message = Session::get('successD'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
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
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="hidePopup()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if ($message = Session::get('errorMessage'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">{{ $message }}</h4>
                                {{-- <p class="popup-alert_des">{{ $message }}</p> --}}
                            </div>

                        </div>
                        <div class="modal-footer justify-content-around text-center">
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
                                <h4 class="popup-alert_title">School Maintenance - School Circuit</h4>
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
                                <h4 class="popup-alert_title">School Maintenance - School Circuit</h4>
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
            <div class="col-12">
                @if ($message = Session::get('searcherror'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                </div>
                @endif
                {{-- INSERT INTO `suppliyer`(`Id`, `email`, `CompanyName`, `CompanyAddress`, `CompanyContact`, `ISActive`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]') --}}
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Contact No</th>
                                <th> Email</th>
                                <th class="text-end">Manage</th>
                            </tr>
                        </thead>
                        @if(isset($data) && count($data) < 1)
                        <tbody>
                            <tr class="text-center text-dark">
                                <td colspan="7">No member Found</td>
                            </tr>
                            </tbody>
                            @else
                            @foreach ($data as $key => $member)
                            <tbody>
                                <tr>
                                    <td>{{ $member->Name }}</td>
                                    <td>{{ ucwords($member->Designation) }}</td>
                                    <td>{{ ucwords($member->Contact_No) }}</td>
                                    <td>{{ ucwords($member->email) }}</td>

                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('schoolmember.edit', ['id' => $member->Id]) }}" class="color-primary me-4 fs-2">
                                                <i class="ri-pencil-fill"></i>
                                            </a>
                                            
                                            <form action="{{  route('schoolmember.destroy') }}" method="POST">
                                                @csrf()

                                                <input type="hidden" name="DelVal" value="{{ $member->Id }}">

                                                <!-- Button trigger modal -->
                                                <button class="btn-reset" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$member->Id}}">
                                                    <i class="ri-delete-bin-7-fill"></i>
                                                </button>

                                                <div class="modal fade" id="exampleModal{{$member->Id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered popup-alert">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5" alt="">
                                                                    <h4 class="modal-title popup-alert_des fw-bold">Delete</h4>
                                                                    <p class="modal-title_des">Are you sure you want to delete?</p>
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
                            <a class="{{ $data->previousPageUrl() ?'' :'disabled' }}" href="{{ $data->previousPageUrl() }}">
                                <i class="ri-arrow-left-s-line me-4"></i>
                                Previous</a>
                        </li>

                        <li class="page-item">
                            <a class="{{ $data->nextPageUrl() ?'' :'disabled' }}" href="{{ $data->nextPageUrl() }}">Next
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
        }
    </script>
</main>
@endsection