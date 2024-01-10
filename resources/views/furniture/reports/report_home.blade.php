@extends('layouts.layout')
@section('title', 'Reports')
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Reports</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="offset-xl-5 text-end col-12 col-md-6 col-xl-3 mb-3">
                <div class="form-group">
                    <select class="form-control form-control-lg fs-4 wide rounded-0" id="furniture-category">
                        <option value="/reports" selected>Select Report Type</option>
                        <option value="/reports/replenishment">Replenishment Report</option>
                        <option value="/reports/disposal">Disposal Report</option>
                        @if(Auth::user()->organization != 2)
                        <option value="/reports/stock">Catalogue Report
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
</main>
<script>
    $('#furniture-category').change(function() {
      var report = $("#furniture-category").val();
      window.location.href = report
  });
  </script>
@endsection
