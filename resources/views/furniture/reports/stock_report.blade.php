@extends('layouts.layout')
@section('title', 'Catalogue Report')
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Catalogue Report</a>
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
                        <option value="/reports/stock" selected>Catalogue Report
                        </option>@endif
                        <option value="/reports/furniture-count">LTSM Count Report</option>
                        <option value="/reports/repairment">Repairment Report</option>
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
                                <h4 class="popup-alert_title">Catalogue Report</h4>
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
                <form class="row  g-4" action="/reports/stock/search" method="GET">
                    <div class="col-12 col-md-6 col-xl-4">

                        <select class="form-select form-control rounded-0 furniture-category" id="temp" onchange="getItems()" name="category">
                            <option selected disabled value="">Item Category</option>
                            @foreach (getListOfAllCategories() as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected="selected"' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <select class="form-select form-control rounded-0 furniture-items" name="item">
                            <option selected disabled value="">Item Description</option>

                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <button type="submit" class="btn btn-primary w-100 ">Search</button>
                    </div>
                </form>

            </div>
            <div class="col-12 col-md-3 my-3">
                <div class="col-12 mt-5 d-flex align-items-center justify-content-center">
                    <button type="reset" class="px-4 fs-3 btn-reset text-decoration-underline">Reset</button>
                </div>
            </div>

        </div>
        <div class="text-end submit-btn my-4">
            @if (!empty($data['records']))
            <button type="button" class="mx-4  btn btn-md btn-primary exportToExcel" id="download_report" value="">Download Report</button>
            @endif
        </div>
        <div class="col-12">
            @if ($message = Session::get('searcherror'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-nnowrap table2excel">
                    <thead>
                        <tr>
                            <th>Item Category</th>
                            <th>Item Description</th>
                        </tr>
                    </thead>
                    @if (empty($data['records'])) <tbody>
                        <tr class="text-center text-dark">
                            <td colspan="2">No Transactions Found</td>
                        </tr>
                    </tbody>
                    @else
                    @foreach ($data['records'] as $key => $item)
                    <tbody>
                        <tr>
                            <td>{{ $item['furniture_category'] }}</td>
                            <td>{{ $item['furniture_item'] }}</td>
                        </tr>
                    </tbody>
                    @endforeach
                    @endif
                </table>
                <table class="table table-nnowrap table2excel" style="display:none" id="studentTable">
                    <thead>
                        <tr>
                            <th>Item Category</th>
                            <th>Item Description</th>
                        </tr>
                    </thead>
                    @if (empty($data['records'])) <tbody>
                        <tr class="text-center text-dark">
                            <td colspan="2">No Transactions Found</td>
                        </tr>
                    </tbody>
                    @else
                    @foreach ($data['records'] as $key => $item)
                    <tbody>
                        <tr>
                            <td>{{ $item['furniture_category'] }}</td>
                            <td>{{ $item['furniture_item'] }}</td>
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
        // window.open(url);
        // return true;
        var category = url.searchParams.get("category");
        var item = url.searchParams.get("item");
        $.ajax({
            url: "/reports/stock/download",
            type: "get",
            data: {
                category: category,
                item: item,
                all: true
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = `Catalogue Report.xls`;
                link.click();
                console.log('success')
            },
            error: function(err) {
                console.log('error')
            }
        });

    });
</script>

<script>
    //     $(document).ready(function() {
    //         $.noConflict();
    //     $('#export-btn').on('click', function(e){
    //         e.preventDefault();
    //         ResultsToTable();
    //     });

    //     function ResultsToTable(){    
    //         $("#studentTable").table2excel({
    //             exclude: ".noExl",
    //             name: "Results"
    //         });
    //     }
    // });
</script>

<script>
    //        $(document).ready(function() {
    //     $.noConflict();
    //        $(function() {
    //   $(".exportToExcel").click(function(event) {
    //     console.log("Exporting XLS");
    //     $(".table2excel").table2excel({
    //       exclude: ".excludeThisClass",
    //       name: $(".table2excel").data("tableName"),
    //       filename: "StudentTable.xls",
    //       preserveColors: false
    //     });
    //   });
    // });
    // });
</script>
<script>
    // $(document).ready(function() {
    //     // $('.dataTables_wrapper').hide();
    //     $.noConflict();
    //     $('#studentTable').DataTable({
    //         dom: 'Bfrtip',
    //         buttons: [
    //             'excel',
    //         ]
    //     });
    // });

    // function downloadexcel() {
    //     $('.buttons-excel').click();
    // }
</script>
<!-- {{-- <script>
        $(document).ready(function () {
            $("#studentTable").table2excel({
                filename: "Employees.xls"
            });
        });
    </script> --}} -->
@endsection