@extends('layouts.layout')
@section('title', 'Repairment Report')
@section('content')
<!-- main -->
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center border-bottom border-2">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="page-titles">
                    <h4>Reports</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Repairment Report</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="offset-xl-5 text-end col-12 col-md-6 col-xl-3 mb-3">
                <div class="form-group">
                <select class="form-control form-control-lg fs-4 wide rounded-0" id="furniture-category">
                        <option value="/reports/replenishment">Replenishment Report</option>
                        <option value="/reports/disposal">Disposal Report</option>
                        @if(Auth::user()->organization != 2)
                        <option value="/reports/stock">Catalogue Report
                        </option>@endif
                        <option value="/reports/furniture-count">LTSM Count Report</option>
                        <option value="/reports/repairment" selected>Repairment Report</option>
                        <option value="/reports/transaction-summary">Transactions Summary Report</option>
                        <option value="/reports/transaction-status">Transactions Status Report</option>
                    </select>
                    <label class="bg-white fs-5 px-1 top--7">Select Report</label>
                </div>
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            @if ($message = Session::get('error'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">Repairment Report</h4>
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
            <div class="col-12 col-md-9 my-3">
                <p class="filter-title">Filters</p>
                <form class="row  g-4" method="GET" action="/reports/repairment/search">
                    @if(Auth::user()->organization != 2)
                    <div class="col-12 col-md-6 col-xl-4">
                        <input type="text" class="form-control rounded-0" name="school_name" placeholder="School Name">
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <select class="form-select form-control rounded-0" name="district_office">
                            <option selected value="">District Office</option>
                            @foreach (getListOfAllDistricts() as $district)
                            <option value="{{ $district->id }}">{{ ucwords($district->district_office) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="col-12 col-md-6 col-xl-4">

                        <select class="form-select form-control rounded-0 furniture-category" id="temp" name="category_id" onchange="getItems()">
                            <option selected disabled value="">Item Category</option>
                            @foreach (getListOfAllCategories() as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected="selected"' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <select class="form-select form-control rounded-0 furniture-items" name="item_id">
                            <option selected disabled value="">Item Descriptions</option>

                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <input type="text" name="start_date" id="start_date" class="form-control date-input rounded-0" placeholder="Start Date">
                        <p class="text-danger" role="alert">
                            <strong id="dateError"></strong>
                        </p>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <input type="text" name="end_date" id="end_date" class="form-control date-input rounded-0" placeholder="End Date">
                    </div>


            </div>
            <div class="col-12 col-md-3 my-3">
                <div class="col-12 ">
                    <button type="button" class="btn btn-primary w-100 " id="submitValid">Search</button>
                    <input type="submit" hidden class="btn btn-primary w-100 " id="submitBtn" value="Search">
                </div>
                <div class="col-12 mt-4 d-flex align-items-center justify-content-center">
                    <a href="/reports/furniture-count" class="px-4 fs-3 btn-reset text-decoration-underline">Reset</a>
                </div>
            </div>
            </form>
        </div>
        <div class="text-end submit-btn my-4">
            @if (!empty($data['records']))
            <button type="submit" class="mx-4  btn btn-md btn-primary" id="download_report" value="">Download Report</button>
            @endif
        </div>
        <div class="col-12">
            @if ($message = Session::get('searcherror'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-nnowrap">
                    <thead>
                        <tr>
                            <th>School Name</th>
                            <th>School EMIS Number</th>
                            <th>District Office</th>
                            <th>Transaction Reference Number</th>
                            <th>Transaction Date</th>
                            <th>Item Category</th>
                            <th>Item Description</th>
                            <th>Repair Count</th>
                            <th>Item Full Count</th>
                        </tr>
                    </thead>
                    @if (empty($data['records'])) <tbody>
                        <tr class="text-center text-dark">
                            <td colspan="9">No Transactions Found</td>
                        </tr>
                    </tbody>
                    @else
                    @foreach ($data['records'] as $key => $item)
                    <tbody>
                        <tr>
                            <td>{{ $item['school_name'] }}</td>
                            <td>{{ $item['school_emis'] }}</td>
                            <td>{{ $item['district_office'] }}</td>
                            <td>{{ $item['ref_number'] }}</td>
                            <td>{{ $item['transaction_date'] }}</td>
                            <td>{{ $item['furniture_category'] }}</td>
                            <td>{{ $item['furniture_item'] }}</td>
                            <td>{{ $item['repaired_count'] }}</td>
                            <td>{{ $item['item_full_count'] }}</td>
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
                        <a class="{{ $data['next_page'] ? null :'disabled' }}" href="{{ $data['next_page'] }}">Next
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
    @if ($message = Session::get('error'))
    <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
</main>
<script>
    function hidePopup() {
        $("#exampleModal").fadeOut(200);
        $('.modal-backdrop').remove();
        console.log("hidePop")
    }

    $('#furniture-category').change(function() {
        var report = $("#furniture-category").val();
        window.location.href = report
    });

    $('#submitValid').on('click', function() {
        if ($('#end_date').val() != '' && $('#start_date').val() == '') {
            $('#dateError').text('Start date is required')
        } else {
            $('#submitBtn').click()
        }
    });

    function getItems() {
        var catid = $(".furniture-category option:selected").val() == '' ? $(
            ".furniture-category-update option:selected").val() : $(".furniture-category option:selected").val();
        var itemId = $("#item-update").val() ? $("#item-update").val() : '';

        $.ajax({
            url: "/getstockitems",
            type: "get",
            data: {
                catid: catid
            },
            dataType: "json",

            success: function(response) {
                let itemdata = response;

                if (itemdata.length > 0) {
                    $(".furniture-items").html("")
                    var itemHtml = "<option selected disabled value=''>Item Description</option>"
                    $.each(itemdata, function(index, value) {

                        itemHtml +=
                            `<option value ="${value.id}" ${value.id == itemId ? selected="selected" : ''}>${value.name}</option>`
                    });
                    $(".furniture-items").html(itemHtml)

                }
            },
            error: function() {
                //alert('Error while request..');
                console.log("Error while request..");
            },
        });
    }

    $('#download_report').on('click', function() {
        var url = new URL(window.location.href);
        var school_name = url.searchParams.get("school_name");
        var district_office = url.searchParams.get("district_office");
        var category_id = url.searchParams.get("category_id");
        var item_id = url.searchParams.get("item_id");
        var start_date = url.searchParams.get("start_date");
        var end_date = url.searchParams.get("end_date");
        $.ajax({
            url: "/reports/repairment/download",
            type: "get",
            data: {
                school_name: school_name,
                district_office: district_office,
                category_id: category_id,
                item_id: item_id,
                start_date: start_date,
                end_date: end_date,
                all: true
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = `Repairment Report.xls`;
                link.click();
                console.log('success')
            },
            error: function(err) {
                console.log('error')
            }
        });

    });
</script>
@endsection