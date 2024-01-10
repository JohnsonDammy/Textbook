@extends('layouts.layout')
@section('title', 'Search - Home')
@section('content')
<!-- main -->
<main>
    <div class="container">
        <div class="row mt-3 justify-content-center">

            <div class="col-12 col-md-11 mb-5">
                <p class="filter-title">Select Search Option</p>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <input type="radio" class="form-check-input mt-0 me-3" name="search-tab" id="date-range" data-bs-toggle="tab" data-bs-target="#home" checked role="button">
                        <label for="date-range">Date Range</label>
                    </li>
                    <li class="nav-item ms-5" role="presentation">
                        <input type="radio" class="form-check-input mt-0 me-3" name="search-tab" id="reference-number" data-bs-toggle="tab" data-bs-target="#profile" role="button">
                        <label for="reference-number">Reference Number</label>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="date-range">
                        <div class="row">
                            <form class="row" method="get" action="/search/date-range" data-parsley-validate>
                                <div class="col-12 col-md-4 col-xl-3 mb-3">
                                    <input type="text" class="form-control date-input rounded-0 dates" name="start_date" placeholder="Start Date" autocomplete="off" value="{{ old('start_date') }}" required data-parsley-required-message="Start date is required">
                                    @if ($errors->has('start_date'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-12 col-md-4 col-xl-3 mb-3">
                                    <input type="text" class="form-control date-input rounded-0 dates" name="end_date" placeholder="End Date" autocomplete="off" value="{{ old('end_date') }}" required data-parsley-required-message="End date is required">
                                    @if ($errors->has('end_date'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('end_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="offset-xl-3 col-6 col-md-2 col-xl-1 text-end d-flex align-items-center justify-content-end">
                                    <a type="reset" href="/search/home" class="px-4 fs-3 btn-reset text-decoration-underline">Clear</a>
                                </div>
                                <div class="col-6 col-md-2 col-xl-2">
                                    <input type="submit" class="btn btn-primary w-100 " value="Search">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="reference-number">
                        <form class="row" method="get" action="/search/reference" data-parsley-validate>
                            <div class="col-12 col-md-6 col-xl-3 mb-3">
                                <input type="text" class="form-control rounded-0" name="ref_number" placeholder="Reference Number" value="{{ old('ref_number') }}" required data-parsley-required-message="Reference number is required">
                                @if ($errors->has('ref_number'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('ref_number') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="offset-xl-6 col-6 col-md-3 col-xl-1 text-end d-flex align-items-center justify-content-end">
                                <a type="reset" href="/search/home" class="px-4 fs-3 btn-reset text-decoration-underline">Clear</a>
                            </div>
                            <div class="col-6 col-md-3 col-xl-2">
                                <input type="submit" class="btn btn-primary w-100 " value="Search">
                            </div>

                        </form>
                    </div>
                </div>



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
                                <th>EMIS Number</th>
                                <th>Reference No.</th>
                                <th>Date Created</th>
                                <th>Item Category</th>
                                <th>Item Description</th>
                                <th>Item Count</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        @if (empty($data['records'])) <tbody>
                            <tr class="text-center text-dark">
                                <td colspan="8">No Transactions Found</td>
                            </tr>
                        </tbody>
                        @else
                        @foreach ($data['records'] as $key => $item)
                        <tbody>
                            <tr>
                                <td>{{ $item['school_name'] }}</td>
                                <td>{{ $item['emis'] }}</td>
                                <td>{{ $item['ref_number'] }}</td>
                                <td>{{ $item['created_at'] }}</td>
                                <td>{{ $item['category_name'] }}</td>
                                <td>{{ $item['item_name'] }}</td>
                                <td>{{ $item['count'] }}</td>
                                <td>{{ $item['status'] }}</td>
                            </tr>
                        </tbody>
                        @endforeach
                        @endif
                    </table>
                </div>
                <nav class="pagination-wrap">
                    <ul class="pagination">
                        <li class="page-item ">
                            @if(!empty($data['previous_page']))
                            <a class="{{ $data['previous_page'] ? null :'disabled' }}" href="{{ $data['previous_page'] }}">
                                <i class="ri-arrow-left-s-line me-4"></i>
                                Previous</a>
                            @else
                            <a class="disabled" href="#">
                                <i class="ri-arrow-left-s-line me-4"></i>
                                Previous</a>
                            @endif
                        </li>

                        <li class="page-item">
                            @if(!empty($data['next_page']))
                            <a class="{{ $data['next_page'] ? null :'disabled' }}" href="{{ $data['next_page'] }}"> Next
                                <i class="ri-arrow-right-s-line ms-4"></i>
                            </a>
                            @else
                            <a class="disabled" href="#">
                                <i class="ri-arrow-right-s-line ms-4"></i>
                                Next</a>
                            @endif
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script>
        var url = location.pathname;
        if (url == '/search/reference') {
            $("#reference-number").attr('checked', true);
            $('#home').removeClass('show active');
            $('#profile').addClass('show active')
        }
    </script>
</main>
@endsection