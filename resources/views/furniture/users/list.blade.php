@extends('layouts.layout')
@section('title', 'Manage User')
@section('content')
@php
$Organization = getListOfAllOrganization();
@endphp
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center">
            <div class="col-12 col-md-4">
                <div class="page-titles">
                    <h4>Manage Users</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Manage Users</a></li>
                    </ol>
                </div>
            </div>
            <div class="offset-xl-3 col-12 col-md-4 col-xl-2 mb-3">
                @can('user-create')
                <a href="{{ route('users.create') }}" class="btn btn-primary w-100">+ Add New User</a>
                @endcan
            </div>
            <div class="col-12 col-md-4 col-xl-3 mb-3">
                <div id="search-btn">
                    <form class="d-flex" method="GET" action="/users-search">
                        <input type="search" name="query" class="form-control border-0 shadow-none" value="{{ old('query') }}" placeholder="Search">
                        <button href="#" class="btn-reset color-primary shadow-none">
                            <i class="ri-search-line fs-2"></i></button>
                    </form>
                    </a>
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
                                <h4 class="popup-alert_title">Manage Users</h4>
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
                                <h4 class="popup-alert_title">Manage Users</h4>
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
                                <h4 class="popup-alert_title">Manage Users</h4>
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
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Username</th>
                                <th>Email id</th>
                                <th>Organisation</th>
                                <th></th>
                            </tr>
                        </thead>
                        @if(count($data) < 1) <tbody>
                            <tr class="text-center text-dark">
                                <td colspan="9">No active users found</td>
                            </tr>
                            </tbody>
                            @else
                            @foreach ($data as $key => $user)
                            <tbody>
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->surname }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @php
                                            $organizationNames = [
                                                1 => 'Admin Dept',
                                                2 => 'School',
                                                3 => 'District Officer',
                                                5 => 'Super Admin',
                                                6 => 'Furniture Deport',
                                                8 => 'Department of Education',
                                                9 => 'FurnAdmin',

                                            ];
                                        @endphp
                                    
                                        {{ $organizationNames[$user->organization] }}
                                    </td>
                                     <td>
                                        <div class="d-flex">
                                            @can('user-edit')
                                            <a href="{{ route('users.edit',$user->id) }}" class="color-primary me-4 fs-2">
                                                <i class="ri-pencil-fill"></i>
                                            </a>
                                            @endcan
                                            @can('user-delete')
                                            @if ($user->id == 1)
                                                
                                            @else
                                            <form action="{{  route('users.destroy',$user->id) }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <!-- Button trigger modal -->
                                                <button class="btn-reset" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$user->id}}">
                                                    <i class="ri-delete-bin-7-fill"></i>
                                                </button>

                                                <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered popup-alert">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5" alt="">
                                                                    <h4 class="modal-title popup-alert_des fw-bold">Delete</h4>
                                                                    <p class="modal-title_des">Are you sure you want to delete <br /> the user profile for {{ $user->username }}</p>
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
                                            @endif
                                            
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
            console.log("hidePop")
        }
    </script>
</main>
@endsection