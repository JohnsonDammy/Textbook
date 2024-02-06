@extends('layouts.layout')
@section('title', 'School Choose Stationery Report')
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Number of school that choose Stationery</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="offset-xl-5 text-end col-12 col-md-6 col-xl-3 mb-3">
    
                <div class="form-group">
                    <select class="form-control form-control-lg fs-4 wide rounded-0" id="furniture-category">
                        <option value="/reports">Select Report Type</option>
                        <option value="/reports/NOSTextbookReport">NOS - Textbook Report</option>
                        <option value="/reports/NOSStationeryReport" selected>NOS - Stationery Report</option>
                        <option value="/reports/stock">NOS Textbook & Stationery
                        </option>
                        <option value="/reports/furniture-count">Allocation Funds Report</option>
                        <option value="/reports/repairment">NOS Request Quote Report</option>
                        <option value="/reports/transaction-summary">NOS Recieve Funds</option>
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
                                <h4 class="popup-alert_title">Replenishment Report</h4>
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
                <form class="row  g-4" action="/reports/replenishment/search">
                    <p class="filter-title">Filters</p>
                    <div class="col-12 col-md-6 col-xl-4">
                        <input type="text" class="form-control rounded-0" name="school_name" placeholder="School Name">
                    </div>
         
                        
                    <div class="col-12 col-md-6 col-xl-4">
                        <input type="text" name="start_date" id="start_date" class="form-control date-input rounded-0" placeholder="Start Date" autocomplete="off">
                        <p class="text-danger" role="alert">
                            <strong id="dateError"></strong>
                        </p>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <input type="text" name="end_date" id="end_date" class="form-control date-input rounded-0" placeholder="End Date" autocomplete="off">
                    </div>

            </div>
            <div class="col-12 col-md-3 my-3">
                <div class="col-12 ">
                    <button type="button" class="btn btn-primary w-100 " id="submitValid">Search</button>
                    <input type="submit" hidden class="btn btn-primary w-100 " id="submitBtn" value="Search">
                </div>
                <div class="col-12 mt-4 d-flex align-items-center justify-content-center">
                    <a href="/reports/NOSTextbookReport" class="px-4 fs-3 btn-reset text-decoration-underline">Reset</a>
                </div>
            </div>
            </form>
        </div>

        <div class="text-end submit-btn my-4">
            @if (!empty($data))
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
                <table class="table table-nnowrap"  id="reportTable">
                    <thead>
                        <tr>
                            <th>School Name</th>
                            <th>School EMIS Number</th>
                            <th>RequestType</th>
                            <th>Date</th>
                 
                        </tr>
                    </thead>
                    @if (empty($data)) <tbody>
                        <tr class="text-center text-dark">
                            <td colspan="12">No Transactions Found</td>
                        </tr>
                    </tbody>
                    @else
                    @foreach ($data as $key => $item)
                    <tbody>
                        <tr>
                            <td>{{ $item['SchoolName'] }}</td>
                            <td>{{ $item['School_Emis'] }}</td>
                            <td>{{ $item['RequestType'] }}</td>
                            <td>{{ $item['Date'] }}</td>
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

    $('#submitValid').on('click', function() {
        if ($('#end_date').val() != '' && $('#start_date').val() == '') {
            $('#dateError').text('Start date is required')
        } else {
            $('#submitBtn').click()
        }
    });

</script>

<script>
    document.getElementById('download_report').addEventListener('click', function () {
        // Call the function to export data to Excel
        exportToExcel('reportTable', 'NOStationery_Report');
    });

    function exportToExcel(tableId, filename) {
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableId);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename ? filename + '.xls' : 'excel_data.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

            // Setting the file name
            downloadLink.download = filename;

            // Triggering the function
            downloadLink.click();
        }
    }
</script>
@endsection