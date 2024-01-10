@extends('layouts.layout')
@section('title', 'Catalogue Maintenance')
@section('content')
<main>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-12">
                <div class="page-titles">
                    <h4>Catalogue Maintenance</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Catalogue Maintenance</a></li>

                    </ol>
                </div>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-12 mb-3">
                <div class="row justify-content-center g-4">
                    @can('category-list')
                    <div class="col-12 col-lg-6">
                        <div class="school-dashboard-wrap">
                            <a href="{{ route('stockcategories.index') }}" class="btn btn-primary-outline btn-lg">Item
                                Category</a>
                        </div>
                    </div>
                    @endcan
                    @can('item-list')
                    <div class="col-12 col-lg-6">
                        <div class="school-dashboard-wrap ">
                            <a href="{{ route('stockitems.index') }}" class="btn btn-primary btn-lg">Item Description</a>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</main>
@endsection