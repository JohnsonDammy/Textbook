@extends('layouts.layout')
@section('title', 'Dashboard')
@section('content')
<!-- main -->
<main>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- breadcrumb -->
                <div class="page-titles">
                    <h4>Dashboard</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>

                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span style="cursor: pointer;" id="download_ytd_statuses_count">YTD Status Count <img title="click to download" class="img-fluid download-icon" src="{{asset('img/download.svg')}}" alt="download" srcset=""> </span>
                                </h5>
                                <figure class="highcharts-figure">
                                    <div id="graph-1"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Progress % from Collections</h5>
                                <figure class="highcharts-figure">
                                    <div id="graph-2"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card shadow-none">
                            <div class="card-body px-0">
                                <h5 class="card-title">
                                    <span style="cursor: pointer;" id="download_pending_collections">Pending Collections <img title="click to download" class="" width="3%" src="{{asset('img/download.svg')}}" alt="" srcset=""></span>
                                </h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>School</th>
                                                <th>Collection Count</th>
                                                <th>Date Created</th>
                                                <th>Days in Waiting</th>
                                            </tr>
                                        </thead>
                                        @if (empty($pending_collections['records'])) <tbody>
                                            <tr class="text-center text-dark">
                                                <td colspan="4">No Pending Collections</td>
                                            </tr>
                                        </tbody>
                                        @else
                                        @foreach ($pending_collections['records'] as $key => $item)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-nowrap text-decoration-underline mb-0">{{ $item['school_name'] }}
                                                    </a>
                                                </td>
                                                <td>{{ $item['collection_count'] }}</td>
                                                <td>{{ $item['date_created'] }}</td>
                                                <td>{{ $item['days_in_waiting'] }}</td>

                                            </tr>

                                        </tbody>
                                        @endforeach
                                        @endif
                                    </table>
                                </div>
                                <nav class="pagination-wrap">
                                    <ul class="pagination">
                                        <li class="page-item ">
                                            @if(!empty($pending_collections['previous_page']))
                                            <a class="{{ $pending_collections['previous_page'] ? null :'disabled' }}" href="{{ $pending_collections['previous_page'] }}">
                                                <i class="ri-arrow-left-s-line me-4"></i>
                                                Previous</a>
                                            @else
                                            <a class="disabled" href="#">
                                                <i class="ri-arrow-left-s-line me-4"></i>
                                                Previous</a>
                                            @endif
                                        </li>

                                        <li class="page-item">
                                            @if(!empty($pending_collections['next_page']))
                                            <a class="{{ $pending_collections['next_page'] ? null :'disabled' }}" href="{{ $pending_collections['next_page'] }}">Next
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
                </div>
            </div>
            <div class="col-xl-4">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="dashboard-card warning">
                            <p class="mb-0">Pending Collections - {{ $count['pending_collection'] }}</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="dashboard-card success">
                            <p class="mb-0">Total Deliveries - {{ $count['total_deliveries'] }}</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="dashboard-card danger">
                            <p class="mb-0">Pending Repairs - {{ $count['pending_repairs'] }}</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="dashboard-card primary">
                            <p class="mb-0">Pending Deliveries - {{ $count['pending_deliveries'] }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="dashboard-card info">
                            <p class="mb-0">Pending Replenishments - {{ $count['pending_replenishments'] }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span style="cursor: pointer;" id="download_previous_year_count">Previous Year Status <img title="click to download" class="img-fluid download-icon" src="{{asset('img/download.svg')}}" alt="" srcset=""></span>
                                </h5>
                                <figure class="highcharts-figure">
                                    <div id="graph-3"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

@endsection
@section('dash-script')
<script>
    Highcharts.chart('graph-1', {
        chart: {
            type: 'bar'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: [
                 'Pending Collection', 'Collection Accepted', 'Pending Repairs', 'Repair Completed', 
                 'Pending Replenishment Approval', 'Replenishment Approved', 'Replenishment Rejected',
                 'Partial Replenishment', 'Pending Delivery', 'Delivery Confirmed'
            ]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Count'
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'Count',
            data: <?php
                    if ($ytd_status_count) {
                        echo $ytd_status_count;
                    }
                    ?>
        }],
        credits: {
            enabled: false
        }
    });
    // Build the chart
    Highcharts.chart('graph-2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: null
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Progress',
            colorByPoint: true,
            data: <?php
                    if ($progress_percent) {
                        echo $progress_percent;
                    }
                    ?>
        }],
        credits: {
            enabled: false
        }
    });
    

    Highcharts.chart('graph-3', {
        chart: {
            type: 'column'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: [


            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Count'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: <?php
                if ($previous_year_count) {
                    echo $previous_year_count;
                }
                ?>,
        credits: {
            enabled: false
        }

    });



    $('#download_pending_collections').on('click', function() {
        $.ajax({
            url: "/dashboard/pending-collections",
            type: "get",
            data: {
                all: true
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = `Pending Collections.xlsx`;
                link.click();
                console.log('success')
            },
            error: function(err) {
                console.log('error')
            }
        });

    });
    $('#download_ytd_statuses_count').on('click', function() {
        $.ajax({
            url: "/dashboard/ytd-count",
            type: "get",
            data: {
                all: true
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = `Year-To-Date Statuses Count.xlsx`;
                link.click();
                console.log('success')
            },
            error: function(err) {
                console.log('error')
            }
        });

    });
    $('#download_previous_year_count').on('click', function() {
        $.ajax({
            url: "/dashboard/previous-count",
            type: "get",
            data: {
                all: true
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = `Previous Year Statuses.xlsx`;
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