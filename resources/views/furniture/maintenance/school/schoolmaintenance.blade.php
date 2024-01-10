@extends('layouts.layout')
@section('title', 'School Maintenance')
@section('content')

 <!-- main -->
 <main>
    <div class="container">
           <!-- breadcrumb -->
           <div class="row align-items-center">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="page-titles">
                    <h4>School Maintenance</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">School Maintenance</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 mb-3">

            <div class="row justify-content-center g-4">
                @can('district-list')
                <div class="col-12 col-lg-4">
                    <div class="school-dashboard-wrap_mini ">
                        <a href="{{ route('schooldistricts.index') }}" class="btn btn-primary btn-lg">School District</a>
                    </div>
                </div>
                @endcan
                @can('cmc-list')
                <div class="col-12 col-lg-4">
                    <div class="school-dashboard-wrap_mini ">
                        <a href="{{ route('schoolcmc.index') }}" class="btn btn-primary btn-lg">CMC</a>
                    </div>
                </div>
                @endcan
                @can('circuit-list')
                <div class="col-12 col-lg-4">
                    <div class="school-dashboard-wrap_mini">
                        <a href="{{ route('schoolcircuit.index') }}" class="btn btn-primary btn-lg">Circuit</a>
                    </div>
                </div>
                @endcan
                @can('subplace-list')
                <div class="col-12 col-lg-4">
                    <div class="school-dashboard-wrap_mini ">
                        <a href="{{ route('schoolsubplace.index') }}" class="btn btn-primary btn-lg">Sub Place</a>
                    </div>
                </div>
                @endcan
                @can('school-list')
                <div class="col-12 col-lg-4">
                    <div class="school-dashboard-wrap_mini">
                        <a href="{{ route('school.index') }}" class="btn btn-primary btn-lg">School</a>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</main>
@endsection