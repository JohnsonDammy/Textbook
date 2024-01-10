@extends('layouts.layout')
@section('title', 'Transactions Status Report')
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Transactions Status Report</a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="offset-xl-5 text-end col-12 col-md-6 col-xl-3 mb-3">
                    <div class="form-group">
                        <select class="form-control form-control-lg fs-4 wide rounded-0" id="furniture-category">
                            <option value="/reports/replenishment">Replenishment Report</option>
                            <option value="/reports/disposal">Disposal Report</option>
                            @if (Auth::user()->organization != 2)
                                <option value="/reports/stock">Catalogue Report
                                </option>
                            @endif
                            <option value="/reports/furniture-count">LTSM Count Report</option>
                            <option value="/reports/repairment">Repairment Report</option>
                            <option value="/reports/transaction-summary">Transactions Summary Report</option>
                            <option value="/reports/transaction-status" selected>Transactions Status Report</option>
                        </select>
                        <label class="bg-white fs-5 px-1 top--7">Select Report</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                @if ($message = Session::get('error'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5"
                                            alt="">
                                        <h4 class="popup-alert_title">Transactions Status Report</h4>
                                        <p class="popup-alert_des">{{ $message }}</p>
                                    </div>

                                </div>
                                <div class="modal-footer text-center justify-content-center p-3 border-0">
                                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                        onclick="hidePopup()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-12 col-md-9 my-3">
                    <p class="filter-title">Filters</p>
                    <form class="row  g-4" action="/reports/transaction-status/search">
                        @if (Auth::user()->organization != 2)
                            <div class="col-12 col-md-6 col-xl-4">
                                <input type="text" class="form-control rounded-0" name="school_name"
                                    placeholder="School Name">
                            </div>
                            <div class="col-12 col-md-6 col-xl-4">
                                <select class="form-select form-control rounded-0" name="district_office">
                                    <option selected value="">District Office</option>
                                    @foreach (getListOfAllDistricts() as $district)
                                        <option value="{{ $district->id }}">{{ ucwords($district->district_office) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-12 col-md-6 col-xl-4">
                            <select class="form-select form-control rounded-0" name="status_id">
                                <option selected value="">Transaction Status</option>
                                @foreach (getStatusList() as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                            <input type="text" name="start_date" id="start_date"
                                class="form-control date-input rounded-0" placeholder="Start Date">
                            <p class="text-danger" role="alert">
                                <strong id="dateError"></strong>
                            </p>
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                            <input type="text" name="end_date" id="end_date" class="form-control date-input rounded-0"
                                placeholder="End Date">
                        </div>


                </div>
                <div class="col-12 col-md-3 my-3">
                    <div class="col-12 ">
                        <button type="button" class="btn btn-primary w-100 " id="submitValid">Search</button>
                        <input type="submit" hidden class="btn btn-primary w-100 " id="submitBtn" value="Search">
                    </div>
                    <div class="col-12 mt-4 d-flex align-items-center justify-content-center">
                        <a href="/reports/transaction-status"
                            class="px-4 fs-3 btn-reset text-decoration-underline">Reset</a>
                    </div>
                </div>
                </form>
            </div>
            <div class="text-end submit-btn my-4">
                @if (!empty($data['records']))
                    <button type="submit" class="mx-4  btn btn-md btn-primary" id="download_report" value="">Download
                        Report</button>
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
                                <th>Transaction Status</th>
                                <th>Collection Proof </th>
                                <th>Disposal Proof</th>
                                <th>Replenishment Proof</th>
                                <th>Delivery Note</th>
                            </tr>
                        </thead>
                        @if (empty($data['records']))
                            <tbody>
                                <tr class="text-center text-dark">
                                    <td colspan="9">No Transactions Found</td>
                                </tr>
                            </tbody>
                        @else
                            @foreach ($data['records'] as $key => $request)
                                <tbody>
                                    <tr>
                                        <td>{{ $request['school_name'] }}</td>
                                        <td>{{ $request['school_emis'] }}</td>
                                        <td>{{ $request['district_office'] }}</td>
                                        <td>{{ $request['ref_number'] }}</td>
                                        <td>{{ $request['transaction_date'] }}</td>
                                        <td>{{ $request['transaction_status'] }}</td>
                                        {{-- evidence image preview --}}
                                        <td class="text-center">
                                            @if (is_array($request['evidence_images']))
                                                @if (!empty($request['evidence_images']))
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#image_preview_{{ $request['ref_number'] }}">Preview</button>

                                                    <div class="modal fade"
                                                        id="image_preview_{{ $request['ref_number'] }}" tabindex="-1"
                                                        aria-labelledby="image_previewLabel" aria-modal="true"
                                                        role="dialog">
                                                        <div class="modal-dialog model-xl modal-dialog-centered">
                                                            <div class="modal-content models__content">
                                                                <div class="models__header">
                                                                    <div class="models__header_text">
                                                                        <h2>Evidence proof images</h2>
                                                                    </div>
                                                                    <a type="button" data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <i class="ri-close-fill"></i>
                                                                    </a>
                                                                </div>

                                                                <div class="model-body">
                                                                    <div class="row">
                                                                        @foreach ($request['evidence_images'] as $evidence)
                                                                            <div class="col-md-4 p-4">
                                                                                <img height="200px"
                                                                                    title="click to download"
                                                                                    width="100%"
                                                                                    src="{{ $evidence['path'] }}"
                                                                                    target="_blank"
                                                                                    data-id="{{ 'collection_proof_' . $request['ref_number'] . '_' . $evidence['id'] . '.' . $evidence['file_type'] }}"
                                                                                    onclick="downloadImage(this)">
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="models__footer">
                                                                    <button type="button" class="btn btn-secondary px-5"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    NA
                                                @endif
                                            @else
                                                {{ $request['evidence_images'] }}
                                            @endif

                                        </td>
                                        {{-- evidence image preview ends --}}
                                        {{-- write-offs images --}}
                                        <td class="text-center">
                                            @if (is_array($request['disposal_images']))
                                                @if (!empty($request['disposal_images']))
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#write_offs_image_preview_{{ $request['ref_number'] }}">Preview</button>

                                                    <div class="modal fade"
                                                        id="write_offs_image_preview_{{ $request['ref_number'] }}"
                                                        tabindex="-1" aria-labelledby="image_previewLabel"
                                                        aria-modal="true" role="dialog">
                                                        <div class="modal-dialog model-xl modal-dialog-centered">
                                                            <div class="modal-content models__content">
                                                                <div class="models__header">
                                                                    <div class="models__header_text">
                                                                        <h2>Evidence proof images</h2>
                                                                    </div>
                                                                    <a type="button" data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <i class="ri-close-fill"></i>
                                                                    </a>
                                                                </div>

                                                                <div class="model-body">
                                                                    <div class="row">
                                                                        @foreach ($request['disposal_images'] as $evidence)
                                                                            <div class="col-md-4 p-4">
                                                                                <img height="200px"
                                                                                    title="click to download"
                                                                                    width="100%"
                                                                                    src="{{ $evidence['path'] }}"
                                                                                    target="_blank"
                                                                                    data-id="{{ 'disposal_proof_' . $request['ref_number'] . '_' . $evidence['id'] . '.' . $evidence['file_type'] }}"
                                                                                    onclick="downloadImage(this)">
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="models__footer">
                                                                    <button type="button" class="btn btn-secondary px-5"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    NA
                                                @endif
                                            @else
                                                {{ $request['disposal_images'] }}
                                            @endif

                                        </td>
                                        {{-- write-offs images ends --}}
                                        {{-- Replenishment proof download --}}
                                        <td class="text-center">
                                            @if (is_array($request['replenishment_proof']))
                                                <a href="{{ $request['replenishment_proof']['path'] }}" target="_blank"
                                                    class="btn btn-primary"
                                                    download="{{ $request['ref_number'] . '_' . $request['replenishment_proof']['id'] . '.' . $request['replenishment_proof']['file_type'] }}">Download</a>
                                            @else
                                                {{ $request['replenishment_proof'] }}
                                            @endif

                                        </td>
                                        {{-- Replenishment proof download ends --}}
                                        {{-- Delivery note download --}}
                                        <td class="text-center">
                                            @if (is_array($request['delivery_note']))
                                                <a class="btn btn-primary"
                                                    href="{{ $request['delivery_note']['path'] }}"
                                                    download="{{ $request['ref_number'] . '_' . $request['delivery_note']['id'] . '.' . $request['delivery_note']['file_type'] }}"
                                                    target="_blank">Download</a>
                                            @else
                                                {{ $request['delivery_note'] }}
                                            @endif

                                        </td>
                                        {{-- Delivery note download ends --}}

                                    </tr>
                                </tbody>
                            @endforeach
                        @endif
                    </table>
                </div>
                <nav class="pagination-wrap">
                    <ul class="pagination">
                        <li class="page-item ">
                            @if (!empty($data['previous_page']))
                                <a class="{{ $data['previous_page'] ? null : 'disabled' }}"
                                    href="{{ $data['previous_page'] }}">
                                    <i class="ri-arrow-left-s-line me-4"></i>
                                    Previous</a>
                            @else
                                <a class="disabled" href="#">
                                    <i class="ri-arrow-left-s-line me-4"></i>
                                    Previous</a>
                            @endif
                        </li>

                        <li class="page-item">
                            @if (!empty($data['next_page']))
                                <a class="{{ $data['next_page'] ? null : 'disabled' }}"
                                    href="{{ $data['next_page'] }}">Next
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

        $('#submitValid').on('click', function() {
            if ($('#end_date').val() != '' && $('#start_date').val() == '') {
                $('#dateError').text('Start date is required')
            } else {
                $('#submitBtn').click()
            }
        });

        $('#furniture-category').change(function() {
            var report = $("#furniture-category").val();
            window.location.href = report
        });

        $('#download_report').on('click', function() {
            var url = new URL(window.location.href);
            var school_name = url.searchParams.get("school_name");
            var district_office = url.searchParams.get("district_office");
            var status_id = url.searchParams.get("status_id");
            var start_date = url.searchParams.get("start_date");
            var end_date = url.searchParams.get("end_date");
            $.ajax({
                url: "/reports/transaction-status/download",
                type: "get",
                data: {
                    school_name: school_name,
                    district_office: district_office,
                    status_id: status_id,
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
                    link.download = `Transactions Status Report.xls`;
                    link.click();
                    console.log('success')
                },
                error: function(err) {
                    console.log('error')
                }
            });

        });

        function downloadImage(e) {
            var name = e.getAttribute("data-id");
            var a = $("<a>")
                .attr("href", e.src)
                .attr("download", name)
                .appendTo("body");

            a[0].click();
            a.remove();
        }
    </script>
@endsection
