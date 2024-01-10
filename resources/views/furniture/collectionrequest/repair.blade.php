@extends('layouts.layout')
@section('title', 'Repair/ Replenish')
@section('head-script')
<script>
    var replenish_status = "{{ $data->replenishment_status }}";
    var ref_number = "{{ $data->ref_number }}";
    var local_ref_number, decision;
    if (replenish_status != '') {
        local_ref_number = 'exists'
        if (replenish_status == 1) {
            decision = 'pending'
        } else {
            decision = 'done'
        }
        var accept_array = window.localStorage.getItem(ref_number) != null ? JSON.parse(window.localStorage.getItem(
            ref_number)) : null;
    } else {
        local_ref_number = window.localStorage.getItem(ref_number) != null ? JSON.parse(window.localStorage.getItem(
            ref_number)) : null;
    }

    var __token = "{{ csrf_token() }}"; // creating token for to use repairrRequest.js
</script>
@endsection
@section('content')
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center border-bottom border-2">
            <div class="col-12 col-md-12 col-xl-12">
                <div class="page-titles">
                    <h4>Transaction</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('furniture-replacement.index') }}">Transactions</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Reference Number -
                                {{ $data->ref_number }}</a>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-3">
                <div class="process row align-items-center text-center">
                    <div class="col content-col">
                        <button class="btn-reset" type="button" data-bs-toggle="modal" data-bs-target="#transmodal">
                            <div class="circle-icon-container">
                                <i class="ri-list-check"></i>
                            </div>
                            <p>Transactions List</p>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="process row align-items-center text-center">
                    <div class="col content-col success">
                        <div class="circle-icon-container">
                            <i class="ri-add-fill"></i>
                        </div>
                        <p>Create Request</p>
                    </div>
                    <div class="col arrow-col ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                            <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                        </svg>

                    </div>
                    <div class="col content-col success">
                        <div class="circle-icon-container">
                            <i class="ri-layout-top-2-fill"></i>
                        </div>
                        <p>Collect Items</p>
                    </div>
                    <div class="col arrow-col ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                            <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                        </svg>

                    </div>
                    <div class="col content-col active">
                        <div class="circle-icon-container">
                            <i class="ri-hammer-fill"></i>
                        </div>
                        <p>Repair/ Replenish</p>
                    </div>
                    <div class="col arrow-col">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                            <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                        </svg>

                    </div>
                    <div class="col content-col">
                        <div class="circle-icon-container">
                            <i class="ri-truck-fill"></i>
                        </div>
                        <p>Deliver Items</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- transaction list modal model popup -->
        <div class="modal fade" id="transmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5" alt="">
                            <h4 class="modal-title popup-alert_des fw-bold">Transaction</h4>
                            <p class="modal-title_des">Information that is not saved will be lost, are you sure you want
                                to
                                leave the current
                                page?</p>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-around text-center">
                        <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                        <a href="{{ route('furniture-replacement.index') }}"><button type="button" class="btn btn-secondary px-5">Yes</button></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- end modal --}}
        <div class="row">
            <div class="col-12 my-3">
                <div class=" bg-light fw-bold py-4 color-primary px-5">
                    <p class="mb-0">
                        Repair/ Replenish Transaction
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-12 my-3">
                <input type="hidden" id="ref_number" name="ref_number" value="{{ $data->ref_number }}">
                <div class="row g-4">
                    <div class="form-group col-12 col-md-6 col-xl-3">
                        <input type="text" class="form-control" required="required" value="{{ $data->school_name }}" disabled placeholder=" ">
                        <label>School Name</label>
                    </div>
                    <div class="form-group col-12 col-md-6 col-xl-3">
                        <input type="text" class="form-control" value="{{ $data->emis }}" disabled required="required" placeholder=" ">
                        <label>School EMIS Number</label>
                    </div>
                    <div class="form-group col-12 col-md-6 col-xl-4">
                        <input type="text" class="form-control" value="{{ $data->total_furniture }}" disabled required="required" placeholder=" ">
                        <label>Learner Enrolment Count</label>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="row g-0 d-flex bg-light align-items-center justify-content-between color-primary py-4  px-5">
                    <div class="col-12 col-md-6  fw-bold ">
                        <p class="mb-0">
                            Repair/ Replenish Items
                        </p>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3 text-end mt-4 mt-md-0">

                    </div>
                </div>
            </div>
            <div class="col-12">

                <div class="table-responsive">
                    <table class="table" id="furnitureCountTable">
                        <thead>
                            <tr>

                                <th>Item Category</th>
                                <th>Item Description</th>
                                <th>Item <br> Full Count</th>
                                <th>School <br> Collection Count</th>
                                <th>Confirmed <br> Collected Count</th>
                                @can('repair-furniture-create')
                                <th>Repairable <br> Count</th>
                                <th>Replenish<br>Request Count</th>
                                @if ($data->replenishment_status >= App\Models\ReplenishmentStatus::PENDING)
                                <th>Replenishment <br> Approved Count</th>
                                <th>Replenishment <br> Rejected Count</th>
                                @endif
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->getBrokenItems as $key => $item)
                            <tr>
                                <td class="catname">{{ $item->getCategoryDetails->name }}
                                    <input type="hidden" class="item_id" value="{{ $item->id }}">
                                </td>
                                <td class="itemname">{{ $item->getItemDetails->name }}</td>
                                <td>{{ $item->item_full_count }}</td>
                                <td class="actual_count">{{ $item->count }}</td>
                                <td class="fw-bold confirm_count">
                                    {{ $item->confirmed_count }}
                                </td>
                                @can('repair-furniture-create')
                                <td>
                                    <script>
                                        document.write(`
                                    <input class="p-3 border-0 getdiff repair_count width-100" type="number" data-id="{{ $item->id }}"
                                    value="${local_ref_number == null ? '' : local_ref_number == 'exists' ? {{ $item->repaired_count }} : local_ref_number[{{ $key }}][{{ $item->id }}]}"
                                    min="0" oninput="this.value =
                                                                     !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder="Enter Value">
                                                                     `)
                                    </script>
                                    <p class="text-danger" role="alert">
                                        <strong class="repairerror "></strong>
                                    </p>
                                </td>
                                <td>
                                    <input class="p-3 border-0 difference_count width-100" type="text" readonly value="0" placeholder="">

                                </td>
                                @if ($data->replenishment_status >= App\Models\ReplenishmentStatus::PENDING)
                                <td>
                                    <script>
                                        document.write(`
                                                            <input class="p-3 border-0 getrepdiff accept_count width-100" type="number" data-id="{{ $item->id }}"
                                                            value="${decision == 'done' ? {{ $item->approved_replenished_count }} : accept_array == null ? '' : accept_array[{{ $key }}][{{ $item->id }}]}"
                                                            min="0" oninput="this.value =
                                                                                            !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder="Enter Value">
                                                                                            `)
                                    </script>
                                    <p class="text-danger" role="alert">
                                        <strong class="approvereplenisherror "></strong>
                                    </p>
                                </td>
                                <td>
                                    <input class="p-3 border-0 reject_count width-100" type="text" readonly value="0" placeholder="">
                                </td>
                                @endif
                                @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <p class="text-danger" role="alert">
                    <strong id="validate_error"></strong>
                </p>

            </div>
            @can('repair-furniture-create')
            <div class="col-12 mb-4">
                <div class="row g-4 align-items-center">
                    <div class="row g-4 align-items-center">

                    </div>

                    <div class="row g-4 align-items-center" style="display: none;" id="disposal_div">
                        <div class="col-12 col-md-6 col-xl-3">
                            <button type="button" class="btn fs-5 w-100" id="disposal_button"><i class="ri-printer-fill"></i> Print Disposal
                                Certificate</button>
                        </div>
                        <p class="text-danger pb-2" role="alert">
                            <strong id="disposalerror"></strong>
                        </p>
                    </div>
                    <div class="row g-4 align-items-center" id="Replenishmentform" style="display: none;">

                        <div class="row">
                            <div class="col-3">
                                <a type="button" class="btn-reset btn-add-photo w-100" id="btn_addphoto_disposal" data-bs-toggle="modal" data-bs-target="#add-photo-popup">+add
                                    write-offs images</a>
                            </div>
                        </div>
                        <p class="text-danger" role="alert">
                            <strong id="disposalimgerror"></strong>
                        </p>

                        <form method="post" enctype="multipart/form-data" action="/furniture-replacement/collect/disposalimages" id="uploadDisposalImages">
                            @csrf
                            <input type="hidden" name="ref_number" value="{{ $data->ref_number }}">
                            <div class="modal fade" id="add-photo-popup" tabindex="-1" aria-labelledby="add-photo-popupLabel" aria-modal="true" role="dialog">
                                <div class="modal-dialog model-xl modal-dialog-centered">
                                    <div class="modal-content models__content">
                                        <div class="models__header">
                                            <div class="models__header_text">
                                                <h5 class="modal-title">Add/ Remove Photos</h5>
                                                <p class="mb-0">You can browse &amp; drag n drop photos of your
                                                    choice.</p>
                                            </div>
                                            <a type="button" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="ri-close-fill"></i>
                                            </a>
                                        </div>
                                        <input type="file" class="form-control" id="upload_disposal" name="disposal_images[]" onchange="preview_image();" required multiple accept="image/*" />
                                        <div id="image_preview"></div>
                                        <div class="models__footer">
                                            @can('repair-furniture-create')
                                            <button type="button" onclick="removeImg()" class="btn-reset text-decoration-underline">Cancel</button>
                                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" id="imageuploadbtn">Add</button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-12 col-md-6 col-xl-3">
                            <button type="button" class="btn fs-5 w-100" id="replenishbtn">Email and Print
                                Replenishment
                                Request Form</button>
                        </div>
                        <p class="text-danger" role="alert">
                            <strong id="replenisherror"></strong>
                        </p>
                    </div>
                    <form method="post" action="/furniture-replacement/collect/uploadproof" enctype="multipart/form-data" id="imageUpload">
                        @csrf
                        <input type="hidden" name="ref_number" value="{{ $data->ref_number }}">
                        <input type="hidden" id="accept_replenish_count" name="accept_array">
                        <div class="row g-4 align-items-center">
                            @if ($data->replenishment_status >= App\Models\ReplenishmentStatus::PENDING)
                            <div class="col-12 col-md-6 col-xl-3">
                                <button type="button" class="btn fs-5 w-100" id="btn_addphoto" data-bs-toggle="modal" data-bs-target="#add-photoproof-popup">Upload Proof of
                                    Replenishment Decision</button>
                                <p class="text-danger" role="alert">
                                    <strong id="imgerror"></strong>
                                </p>
                            </div>

                            <div class="modal fade" id="add-photoproof-popup" tabindex="-1" aria-labelledby="add-photoproof-popupLabel" aria-modal="true" role="dialog">
                                <div class="modal-dialog model-xl modal-dialog-centered">
                                    <div class="modal-content models__content">
                                        <div class="models__header">
                                            <div class="models__header_text">
                                                <h5 class="modal-title">Upload Proof of Replenishment Decision
                                                </h5>
                                            </div>
                                            <a type="button" onclick="removeImg()" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="ri-close-fill"></i>
                                            </a>
                                        </div>
                                        <input type="file" class="form-control" id="upload_file" name="upload_proof" onchange="preview_image();" required accept="image/*, application/pdf" />
                                        <div id="image_preview"></div>

                                        <div class="models__footer my-3">
                                            @can('repair-furniture-create')
                                            <button type="button" onclick="removeImg()" class="btn-reset text-decoration-underline">Cancel</button>
                                            <button type="button" onclick="uploadImg()" class="btn btn-secondary px-5" data-bs-dismiss="modal">Upload</button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end photo model popup -->
                    </form>
                    @endif
                    <div class="col-12 col-md-12 col-xl-12">
                        <div class="form-check">
                            <input class="form-check-input rounded-0 border border-success" type="checkbox" value="success" id="flexCheckDefault">
                            <label class="form-check-label ps-3 pt-2" for="flexCheckDefault">
                                Tick here when repairs are completed
                            </label>
                            <p class="text-danger p-2" role="alert">
                                <strong id="completeerror"></strong>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <button type="button" class="btn btn-primary ms-3" hidden id="saveSuccess" data-bs-toggle="modal" data-bs-target="#alret-pop">Save</button>
        <!--success save popup -->
        <div class="modal fade" id="alret-pop" tabindex="-1" aria-labelledby="alret-popLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                            <h4 class="popup-alert_title">Transaction</h4>
                            <p class="popup-alert_des">The captured information has been saved
                                successfully</p>
                        </div>

                    </div>
                    <div class="modal-footer text-center justify-content-center p-3 border-0">
                        <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!--submit popup -->
        <div class="modal fade" id="submit-pop" tabindex="-1" aria-labelledby="submit-popLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5" alt="">
                            <p class="popup-alert_des fw-bold">Transaction - Repair Items</p>
                            <p>Are you sure you submit?</p>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-around text-center">
                        <button type="button" id="closemodal" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                        <button type="button" id="submitrepair" class="btn btn-secondary px-5">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--cancel popup -->
        <div class="modal fade" id="cancel-pop" tabindex="-1" aria-labelledby="cancel-popLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <div class="text-center">
                            <p class="popup-alert_des fw-bold">Transaction</p>
                            <p>Are you sure you want to cancel?</p>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-around text-center">
                        <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                        <button type="button" onClick="window.location.reload();" class="btn btn-secondary px-5">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- transaction list modal model popup -->
        <div class="modal fade" id="transmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5" alt="">
                            <h4 class="modal-title popup-alert_des fw-bold">Transaction</h4>
                            <p class="modal-title_des">Information that is not saved will be lost, are you sure you
                                want to
                                leave the current
                                page?</p>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-around text-center">
                        <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                        <a href="{{ route('furniture-replacement.index') }}"><button type="button" class="btn btn-secondary px-5">Yes</button></a>
                    </div>
                </div>
            </div>
        </div>
        <!--success submit popup -->
        <div class="modal fade" id="alret-pop-success" tabindex="-1" aria-labelledby="alret-popLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                            <h4 class="popup-alert_title">Transaction</h4>
                            <p class="popup-alert_des">The changes have been submitted successfully!</p>
                        </div>

                    </div>
                    <div class="modal-footer text-center justify-content-center p-3 border-0">
                        <button type="button" class="btn btn-secondary px-5" id="success-pop-ok" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end submi-btn my-3">

            <button type="button" data-bs-toggle="modal" data-bs-target="#cancel-pop" class="btn-reset text-decoration-underline">Cancel</button>
            <button type="button" id="savebtn" hidden class="btn btn-primary ms-3">Save</button>
            <button type="button" id="saveDataBtn" class="btn btn-primary ms-3">Save</button>
            <button type="button" id="submitDataBtn" class="btn btn-primary ms-3">Submit</button>
            <button type="button" id="formSubmitPopUp" data-bs-toggle="modal" data-bs-target="#submit-pop" hidden></button>
            <button type="button" class="btn btn-primary ms-3" hidden id="success-popup" data-bs-toggle="modal" data-bs-target="#alret-pop-success"></button>
        </div>
        @endcan
    </div>
    </div>
    <script type="text/javascript">
        $(function() {
            var table = $('#furnitureCountTable'),
                difference, repCount, repdifference;
            var replenish_item_array = [];
            var approve_replenish_array = [];
            var ref_number = $("#ref_number").val();

            // get replenish count (replenish count = confirm count - repair count)
            $('.getdiff').on('change', function() {
                replenish_item_array = [];
                repCount = 0;
                table.find('tbody > tr').each(function() {
                    if (($(this).find('.repair_count').val()) == '') {
                        $(this).find('.repairerror').text("Repair count is required");
                    } else if (($(this).find('.repair_count').val() * 1) > $(this).find(
                            '.confirm_count').text() * 1) {
                        $(this).find('.repairerror').text("Repair count is invalid");
                    } else {
                        $(this).find('.repairerror').text("");
                    }

                    difference = ($(this).find('.confirm_count').text() * 1) - ($(this).find(
                        '.repair_count').val() * 1);
                    if ($(this).find('.repair_count').val() == '') {
                        $(this).find('.difference_count').val(0);
                    } else {
                        if ($(this).find('.confirm_count').text() * 1 == 0) {
                            if (difference < 0) {
                                $(this).find('.difference_count').val(0);
                            } else {
                                $(this).find('.difference_count').val(difference);
                                var arr = {
                                    "id": $(this).find('.item_id').val(),
                                    "category_name": $(this).find('.catname').text(),
                                    "item_name": $(this).find('.itemname').text(),
                                    "repair_count": $(this).find('.repair_count').val() * 1,
                                    "replenish_count": difference
                                };
                                replenish_item_array.push(arr);
                            }
                        } else if (difference == $(this).find('.confirm_count').text() * 1) {
                            if (difference < 0) {
                                $(this).find('.difference_count').val(0);
                            } else {
                                $(this).find('.difference_count').val(difference);
                                var arr = {
                                    "id": $(this).find('.item_id').val(),
                                    "category_name": $(this).find('.catname').text(),
                                    "item_name": $(this).find('.itemname').text(),
                                    "repair_count": $(this).find('.repair_count').val() * 1,
                                    "replenish_count": difference
                                };
                                replenish_item_array.push(arr);
                            }
                        } else if (difference < 0) {
                            $(this).find('.difference_count').val(0);
                        } else {
                            $(this).find('.difference_count').val(difference);
                            var arr = {
                                "id": $(this).find('.item_id').val(),
                                "category_name": $(this).find('.catname').text(),
                                "item_name": $(this).find('.itemname').text(),
                                "repair_count": $(this).find('.repair_count').val() * 1,
                                "replenish_count": difference
                            };
                            replenish_item_array.push(arr);
                        }
                    }

                    repCount += ($(this).find('.difference_count').val() * 1);
                });
                if (repCount > 0 && replenish_item_array.length == table.find('tbody > tr').length) {
                    $('#validate_error').html("")
                    $('#disposal_div').css('display', 'block')
                } else {
                    $('#validate_error').html("")
                    $('#disposal_div').css('display', 'none')
                }

            }).change();

            // get reject replenish count (reject replenish count = replenish count - approve replenish count)
            $('.getrepdiff').on('change', function() {
                approve_replenish_array = [];
                table.find('tbody > tr').each(function() {
                    if ($(this).find('.difference_count').val() == 0) {
                        $(this).find('.accept_count').val(0);
                    } else {
                        if (($(this).find('.accept_count').val()) == '') {
                            $(this).find('.approvereplenisherror').html(
                                "Approved replenishment <br>count is required");
                        } else if (($(this).find('.accept_count').val() * 1) > $(this).find(
                                '.difference_count').val() * 1) {
                            $(this).find('.approvereplenisherror').html(
                                "Approved replenishment <br>count is invalid");
                        } else {
                            $(this).find('.approvereplenisherror').text("");
                        }
                    }
                    repdifference = ($(this).find('.difference_count').val() * 1) - ($(this).find(
                        '.accept_count').val() * 1);
                    if ($(this).find('.accept_count').val() == '') {
                        $(this).find('.reject_count').val(0);
                    } else {
                        if ($(this).find('.difference_count').val() * 1 == 0) {
                            if (repdifference < 0) {
                                $(this).find('.reject_count').val(0);
                            } else {
                                $(this).find('.reject_count').val(repdifference);
                                var rep_arr = {
                                    "id": $(this).find('.item_id').val(),
                                    "accept_count": $(this).find('.accept_count').val() * 1,
                                    "reject_count": repdifference
                                };
                                approve_replenish_array.push(rep_arr);
                            }
                        } else if (repdifference == $(this).find('.difference_count').val() * 1) {
                            if (repdifference < 0) {
                                $(this).find('.reject_count').val(0);
                            } else {
                                $(this).find('.reject_count').val(repdifference);
                                var rep_arr = {
                                    "id": $(this).find('.item_id').val(),
                                    "accept_count": $(this).find('.accept_count').val() * 1,
                                    "reject_count": repdifference
                                };
                                approve_replenish_array.push(rep_arr);
                            }
                        } else if (repdifference < 0) {
                            $(this).find('.reject_count').val(0);
                        } else {
                            $(this).find('.reject_count').val(repdifference);
                            var rep_arr = {
                                "id": $(this).find('.item_id').val(),
                                "accept_count": $(this).find('.accept_count').val() * 1,
                                "reject_count": repdifference
                            };
                            approve_replenish_array.push(rep_arr);
                        }
                    }
                    $('#accept_replenish_count').val(JSON.stringify(approve_replenish_array))
                });
                if (approve_replenish_array.length == table.find('tbody > tr').length) {
                    $('#validate_error').text("");
                }
            }).change();

            // print disposal note pdf
            $('#disposal_button').on('click', function() {
                if (local_ref_number != 'exists') {
                    $('#preloader').css('display', 'block');
                    $.ajax({
                        url: "/furniture-replacement/collect/printannexureb",
                        type: "get",
                        data: {
                            ref_number: ref_number,
                            items: replenish_item_array
                        },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function(response) {
                            var blob = new Blob([response]);
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = `${ref_number} - Disposal Certificate.pdf`;
                            link.click();
                            localStorage.setItem('Annexure-B', ref_number);
                            $('#savebtn').click();
                            $('#disposalerror').css('display', 'none')
                            $('#Replenishmentform').css('display', 'block')
                            $('#preloader').css('display', 'none');

                        },
                        error: function(err) {
                            $('#preloader').css('display', 'none');
                        }
                    });
                } else {
                    console.log('Disposal report already printed!')
                }

            })

			//Start Added By Laksminarayana T
			/*$('#replenishbtn').on('click', function() {
                           $('#disposalimgerror').text("")
                            $('#preloader').css('display', 'block');
							alert(ref_number);
							//alert(replenish_item_array);
						   console.log('Test1');
						    console.log(replenish_item_array);
                            $.ajax({
                                url: "/furniture-replacement/collect/printemailannexurec",
                                type: "get",
                                data: {
                                    ref_number: ref_number,
                                    items: replenish_item_array
                                },
                                xhrFields: {
                                    responseType: 'blob'
                                },
                                success: function(response) {
									console.log(response);
									var blob = new Blob([response]);
                                    var link = document.createElement('a');
                                    link.href = window.URL.createObjectURL(blob);
                                    link.download =`${ref_number} - Replenishment Request Form.pdf`;
                                    link.click();
                                    $('#preloader').css('display', 'none');
                                    window.localStorage.removeItem(ref_number)
                                    localStorage.setItem('Annexure-C', ref_number);
                                    location.reload();
                                },
                                error: function(err) {
                                    $('#preloader').css('display', 'none');
                                }
                            });
			  
					
		})
*/			//End Added By Laksminarayana T	
			//imageuploadbtn
			
			//Start 1-Condition One Image Upload			
		$('#imageuploadbtn').on('click', function() {

			var disposal_images = $('#upload_disposal').val();
                  if (disposal_images == '' && local_ref_number != 'exists') {
$('#disposalimgerror').text("Add Disposal Images Proof")
                  }
				 
		    if ($('#uploadDisposalImages').submit()) {
              $('#disposalimgerror').text("")
              $('#preloader').css('display', 'block');
			}
			 });	
			//End 1-Condition One Image Upload
			
		// Start print and email replenish request note
			//jQuery.noConflict();
            $('#replenishbtn').on('click', function() {
//				debugger;
				if (local_ref_number != 'exists') {
                   // var disposal_images = $('#upload_disposal').val();
                   // if (disposal_images == '' && local_ref_number != 'exists') {
                      // $('#disposalimgerror').text("Add Disposal Images Proof")
                   // } else {						
						//if ($('#uploadDisposalImages').submit()) {
					//$("#uploadDisposalImages").submit(function(event) {
   					
							$('#disposalimgerror').text("")
                            $('#preloader').css('display', 'block');
							//alert(ref_number);
							//alert(replenish_item_array);
						  // console.log('Test1');
						    //console.log(replenish_item_array);
						//event.preventDefault(); // prevent default submit behaviour
                           $.ajax({
                                url: "/furniture-replacement/collect/printemailannexurec",
                                type: "get",
								cache: true,
								async: true,
                                data: {
                                    ref_number: ref_number,
                                    items: replenish_item_array
                                },
                                xhrFields: {
                                    responseType: 'blob'
                                },
                                success: function(response) {
								    console.log(response);
									var blob = new Blob([response]);
                                    var link = document.createElement('a');
                                    link.href = window.URL.createObjectURL(blob);
                                    link.download =`${ref_number} - Replenishment Request Form.pdf`;
                                    link.click();									
                                    $('#preloader').css('display', 'none');
                                    window.localStorage.removeItem(ref_number)
                                    localStorage.setItem('Annexure-C', ref_number);
                                    location.reload();									
									
                                },
                                error: function(err) {
                                    $('#preloader').css('display', 'none');
                                }
                            });
						
						//event.preventDefault();
					 //});
						   
					  // }
							
                     /* } else {
                            console.log("Error saving images and generating replenish request")
                        }
*/

                   // }
					
								
					
					

				} else {
                    console.log('Replenishment request form already printed!')
                }
            })
			
				// End print and email replenish request note 				  
								  
            // save counts in local storage
            $('#saveDataBtn').on('click', function() {
                // save repair count
                if (local_ref_number != 'exists') {
                    var values = $(".repair_count")
                        .map(function() {
                            var name = $(this).data("id");
                            var arr = {};
                            arr[name] = $(this).val();
                            return arr;
                        }).get();
                    localStorage.setItem(ref_number, JSON.stringify(values));
                }
                // save accept replenish count after replenish request raised
                if (decision != null && local_ref_number == 'exists') {
                    var values = $(".accept_count")
                        .map(function() {
                            var name = $(this).data("id");
                            var arr = {};
                            arr[name] = $(this).val();
                            return arr;
                        }).get();
                    localStorage.setItem(ref_number, JSON.stringify(values));
                }
                $('#saveSuccess').click();
            });

            $('#savebtn').on('click', function() {
                var values = $(".repair_count")
                    .map(function() {
                        var name = $(this).data("id");
                        var arr = {};
                        arr[name] = $(this).val();
                        return arr;
                    }).get();
                localStorage.setItem(ref_number, JSON.stringify(values));
            });

            // submit button validations and conditions
            $('#submitDataBtn').on('click', function() {
                if (local_ref_number == 'exists') {
                    if (decision == 'done') {
                        if ($("#flexCheckDefault").is(":checked")) {
                            $('#completeerror').text("")
                            $('#formSubmitPopUp').click()
                        } else {
                            $('#completeerror').text("Please tick the checkbox")
                        }
                    } else if (decision == 'pending') {
                        approve_replenish_array.length == table.find('tbody > tr').length ? $(
                            '#validate_error').text("") : $('#validate_error').text(
                            "Approved replenishment count for all items is required");
                        $('#upload_file').val() == '' ? $('#imgerror').text(
                            "Replenishment proof is required") : $('#imgerror').text("");
                        if (approve_replenish_array.length == table.find('tbody > tr').length && $(
                                '#upload_file').val() != '') {
                            $('#imgerror').text("Upload replenishment proof to continue");
                        }
                    } else {
                        console.log('Error occured!')
                    }
                } else {
                    if ($("#flexCheckDefault").is(":checked") && replenish_item_array.length == table.find(
                            'tbody > tr').length && repCount == 0) {
                        $('#completeerror').text("")
                        $('#validate_error').text("")
                        $('#formSubmitPopUp').click()
                    } else {
                        $("#flexCheckDefault").is(":checked") ? $('#completeerror').text("") : $(
                            '#completeerror').text("Please tick the checkbox");
                        replenish_item_array.length == table.find('tbody > tr').length ? $(
                            '#validate_error').text("") : $('#validate_error').text(
                            "Repairable count for all items is required");
                        if (window.localStorage.getItem('Annexure-B') == ref_number) {
                            $('#disposalerror').text("")
                            if (window.localStorage.getItem('Annexure-C') == ref_number) {
                                $('#replenisherror').text("")
                                $('#disposalimgerror').text("")
                            } else {
                                $('#replenisherror').text("Email and Print Replenishment Request")
                                $('#upload_disposal').val() == '' ? $('#disposalimgerror').text("Add Disposal Images Proof") : $('#disposalimgerror').text("")
                            }
                        } else {
                            $('#disposalerror').text("Print Disposal Certificate");
                        }
                    }
                }


            });

            // final submit repair process
            $('#submitrepair').on('click', function() {
                $('#closemodal').click()
                $('#preloader').css('display', 'block');
                $.ajax({
                    url: "/furniture-replacement/collect/submitrepair",
                    type: "post",
                    data: {
                        _token: __token, //accessing token from blade file
                        status: decision,
                        ref_number: ref_number,
                        items: replenish_item_array
                    },
                    success: function(response) {
                        window.localStorage.removeItem('Annexure-B')
                        window.localStorage.removeItem('Annexure-C')
                        window.localStorage.removeItem(ref_number)
                        $('#preloader').css('display', 'none');
                        $("#success-popup").click();
                    },
                    error: function(error) {
                        $('#preloader').css('display', 'none');
                        if (error.status == 422) {
                            $.map(error.responseJSON.errors, function(ele, key) {
                                $('#validate_error').text(ele);
                            });
                        }
                        console.log(error);
                    }
                });

            });

            $('#success-pop-ok').on('click', function() {
                window.location.href = "/furniture-replacement"
            });

            window.onload = new function() {
                $('.repairerror').text("");
                $('.approvereplenisherror').text("");
                if (window.localStorage.getItem('Annexure-B') == ref_number) {
                    $('.repair_count').prop('readonly', true);
                    $('#disposal_button').prop('disabled', true);
                    $('#Replenishmentform').css('display', 'block')
                }
                if (local_ref_number == 'exists') {
                    $('.repair_count').prop('readonly', true);
                    $('#Replenishmentform').css('display', 'block')
                    $('#btn_addphoto_disposal').css('display', 'none')
                    $('#replenishbtn').prop('disabled', true);
                    $('#disposal_button').prop('disabled', true);
                }
                if (decision == 'done') {
                    $('.accept_count').prop('readonly', true);
                    $('#btn_addphoto').prop('disabled', true);
                }
            }
        });

        function removeImg() {
            $('#image_preview').html('');
            $('#upload_file').val(null)

        }

        function uploadImg() {
            var image = $('#upload_file').val()
            var temparray = $('#accept_replenish_count').val()
            var tempcount = (JSON.parse(temparray)).length
            if (image != '' && tempcount == $('#furnitureCountTable').find('tbody > tr').length) {
                $('#imgerror').text("");
                $('#validate_error').text("")
                window.localStorage.removeItem(ref_number)
                $('#imageUpload').submit();

            } else {
                tempcount != $('#furnitureCountTable').find('tbody > tr').length ? $('#validate_error').text(
                    "Approved replenishment count for all items is required") : $('#validate_error').text("");
                image == '' ? $('#imgerror').text("Replenishment proof is required") : $('#imgerror').text("");
            }
        }

        function preview_image() {
            $('#image_preview').html('');
            var total_file = document.getElementById("upload_disposal").files.length;
            for (var i = 0; i < total_file; i++) {
                $('#image_preview').append("<img width='250px' height='250px' class='mx-2 my-2' src='" + URL
                    .createObjectURL(event.target
                        .files[i]) + "'>");
            }
        }
    </script>
</main>
<!-- footer -->
<footer>
</footer>
@endsection