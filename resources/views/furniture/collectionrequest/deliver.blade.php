@extends('layouts.layout')
@section('title', 'Deliver Furniture')
@section('head-script')
<script>
    var collection_status = "{{ $data->status_id }}";
    console.log(collection_status);
    var ref_number = "{{ $data->ref_number }}";
    var local_ref_number
    if (collection_status >= 5) {
        var delivery = 'pending';
    } else {
        local_ref_number = window.localStorage.getItem(ref_number) != null ? JSON.parse(window.localStorage.getItem(
            ref_number)) : null;
    }
</script>
@endsection
@section('content')
<!-- main -->
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center border-bottom border-2">
            <div class="col-12 col-md-12 col-xl-12">
                <div class="page-titles">
                    <h4>Furniture Replacement</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('furniture-replacement.index') }}">Furniture
                                Replacement
                                Process</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Reference Number-{{ $data->ref_number }}</a>
                        </li>
                    </ol>
                </div>
            </div>
            <!--cancel popup -->
            <div class="modal fade" id="cancel-pop" tabindex="-1" aria-labelledby="cancel-popLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content rounded-0">
                        <div class="modal-body">
                            <div class="text-center">
                                <p class="popup-alert_des fw-bold">Furniture Replacement Process</p>
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

        </div>
        @if ($message = Session::get('error'))
        <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                            <h4 class="popup-alert_title">Furniture Replacement - Deliver Items</h4>
                            <p class="popup-alert_des">{{ $message }}</p>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-around text-center">
                        <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="hidePopup()">OK</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
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
                        <p>Collect Furniture Items</p>
                    </div>
                    <div class="col arrow-col ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                            <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                        </svg>

                    </div>
                    <div class="col content-col success">
                        <div class="circle-icon-container">
                            <!-- <i class="ri-hammer-line"></i> -->
                            <i class="ri-hammer-fill"></i>
                        </div>
                        <p>Repair/ Replenish</p>
                    </div>
                    <div class="col arrow-col">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35.439" height="17.42" viewBox="0 0 35.439 17.42">
                            <path id="Icon_awesome-long-arrow-alt-right" data-name="Icon awesome-long-arrow-alt-right" d="M24.834,15.8H.949A.949.949,0,0,0,0,16.753v4.43a.949.949,0,0,0,.949.949H24.834v3.643a1.9,1.9,0,0,0,3.241,1.342l6.808-6.808a1.9,1.9,0,0,0,0-2.685l-6.808-6.808a1.9,1.9,0,0,0-3.241,1.342Z" transform="translate(0 -10.258)" />
                        </svg>

                    </div>
                    <div class="col content-col active">
                        <div class="circle-icon-container">
                            <i class="ri-truck-fill"></i>
                        </div>
                        <p>Deliver Furniture Items</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-3">
                <div class=" bg-light fw-bold py-4 color-primary px-5">
                    <p class="mb-0">
                        Deliver Furniture Items
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
                        <label>School Full Furniture Count - Including Working Furniture</label>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="row g-0 d-flex bg-light align-items-center justify-content-between color-primary py-4  px-5">
                    <div class="col-12 col-md-6  fw-bold ">
                        <p class="mb-0">
                            Broken Furniture Items
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table" id="furnitureCountTable">
                        <thead>
                            <tr>
                                <th>Furniture Category</th>
                                <th>Furniture Item</th>
                                <th>Item <br> Full <br> Count</th>
                                <th>School <br> Collection <br> Count</th>
                                <th class="text-fluid ">Confirmed <br> Collected <br> Count</th>
                                <th>Repairable <br> Count</th>
                                <th>Replenished <br> Count</th>
                                <th>Replenishment <br> Approved Count</th>
                                <th>Replenishment <br> Rejected Count</th>
                                @can('deliver-furniture-create')
                                <th>Delivered count </th>
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
                                <td>{{$item->item_full_count}}</td>
                                <td class="actual_count">{{ $item->count }}</td>
                                <td class="fw-bold confirm_count">
                                    {{ $item->confirmed_count }}
                                </td>
                                <td class="fw-bold repair_count">
                                    {{ $item->repaired_count }}
                                </td>
                                <td class="fw-bold replenish_count">
                                    {{ $item->replenished_count }}
                                </td>
                                <td class="fw-bold accept_count">
                                    {{ $item->approved_replenished_count }}
                                </td>
                                <td class="fw-bold reject_count">
                                    {{ $item->rejected_replenished_count }}
                                </td>

                                @can('deliver-furniture-create')
                                <td>
                                    {{-- <script>
                                        document.write(`
                                    <input class="p-3 border-0 getdel deliver_count width-100" type="number" data-id="{{ $item->id }}"
                                    value="${ delivery == 'pending' ? {{ $item->delivered_count }} : local_ref_number != null ? local_ref_number[{{ $key }}][{{ $item->id }}] : ''}" placeholder="Enter Value"
                                    min="0"
                                                            oninput="this.value =
                                                                     !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                                    `)
                                    </script> --}}
                                    <input data-id="{{ $item->id }}" value="{{ $item->delivered_count }}" class="p-3 border-0 getdel deliver_count width-100" readonly  >
                                    
                                </td>
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
            @can('deliver-furniture-create')
            <button type="button" class="btn btn-primary ms-3" hidden id="saveSuccess" data-bs-toggle="modal" data-bs-target="#alret-pop">Save</button>
            <!--success save popup -->
            <div class="modal fade" id="alret-pop" tabindex="-1" aria-labelledby="alret-popLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">Furniture Replacement</h4>
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
            <div class="col-12 mb-4">
                <div class="row g-4 align-items-center">
                    <div class="row g-4 align-items-center" id="readydelivery">
                        <div class="form-check">
                            <input class="form-check-input rounded-0 border border-success" type="checkbox" value="" id="readyflexCheckDefault">
                            <label class="form-check-label ps-3 pt-2" for="readyflexCheckDefault">
                                Tick here when furniture items are ready for delivery
                            </label>
                        </div>
                        <p class="text-danger" role="alert">
                            <strong id="readyerror"></strong>
                        </p>
                    </div>
                    <div class="row g-4 align-items-center">
                        <div class="col-12 col-md-12 col-xl-4">
                            <button type="button" id="download-delivery-note" style="display:none" class="btn fs-5 w-100"><i class="ri-printer-fill"></i> Print Delivery Note</button>
                        </div>
                    </div>

                    <div class="row g-4 align-items-center">
                        <div class="col-12 col-md-12 col-xl-4">
                            @if($data->status_id >= App\Models\RequestStatus::DELIVERY_PENDING )
                            <button type="button" class="btn fs-5 w-100" data-bs-toggle="modal" data-bs-target="#add-photo-popup">Uploaded Signed Delivery Note</button>
                            <p class="text-danger pt-2" role="alert">
                                <strong id="fileerror"></strong>
                            </p>
                        </div>

                        <div class="modal fade" id="add-photo-popup" tabindex="-1" aria-labelledby="add-photo-popupLabel" aria-modal="true" role="dialog">
                            <div class="modal-dialog model-xl modal-dialog-centered">
                                <div class="modal-content models__content">
                                    <div class="models__header">
                                        <div class="models__header_text">
                                            <h5 class="modal-title">Upload Signed Delivery Note</h5>
                                        </div>
                                        <a type="button" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ri-close-fill"></i>
                                        </a>
                                    </div>
                                    {{-- <div class="models__body">
                                        <div class="input-images">
                                        </div>

                                    </div> --}}
                                    <form method="post" enctype="multipart/form-data" action="/furniture-replacement/collect/submitdelivery" id="delivery_form">
                                        @csrf
                                        <input type="hidden" name="ref_number" value="{{ $data->ref_number }}">
                                        <input type="file" class="form-control" id="upload_file" name="upload_file" onchange="" required accept="image/*, application/pdf" />
                                    </form>
                                    <div id="image_preview"></div>

                                    <div class="models__footer my-3">
                                        @can('deliver-furniture-create')
                                        <button type="button" onclick="removeImg()" class="btn-reset text-decoration-underline">Cancel</button>
                                        <button type="button" onclick="" class="btn btn-secondary px-5" data-bs-dismiss="modal">Upload</button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end photo model popup -->

                    </div>
                    <div class="row g-4 align-items-center">
                        <div class="form-check">
                            <input class="form-check-input rounded-0 border border-success" type="checkbox" id="deliverflexCheck">
                            <label class="form-check-label ps-3 pt-2" for="deliverflexCheck">
                                The Furniture Items have been Delivered
                            </label>
                        </div>
                        <p class="text-danger" role="alert">
                            <strong id="checkerror"></strong>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @endcan
        </div>
        @can('deliver-furniture-create')
        <div class="text-end submi-btn my-3">
            <button type="button" data-bs-toggle="modal" data-bs-target="#cancel-pop" class="btn-reset text-decoration-underline">Cancel</button>
            <button type="button" id="saveDataBtn" class="btn btn-primary ms-3">Save</button>
            <button type="button" id="submitDataBtn" class="btn btn-primary ms-3">Submit</button>
            <button type="button" id="formSubmitPopUp" data-bs-toggle="modal" data-bs-target="#submit-pop" hidden></button>
        </div>
        @endcan
        <!-- transaction list modal model popup -->
        <div class="modal fade" id="transmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5" alt="">
                            <h4 class="modal-title popup-alert_des fw-bold">Furniture Replacement Process</h4>
                            <p class="modal-title_des">Information that is not saved will be lost, are you sure you want to
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
        <!--submit popup -->
        <div class="modal fade" id="submit-pop" tabindex="-1" aria-labelledby="submit-popLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5" alt="">
                            <p class="popup-alert_des fw-bold">Furniture Replacement Process - Deliver Items</p>
                            <p>Are you sure you submit?</p>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-around text-center">
                        <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                        <button type="button" id="submitrepair" class="btn btn-secondary px-5">Yes</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
<!-- footer -->
<footer>
</footer>
<script type="text/javascript">
    $(function() {
        var table = $('#furnitureCountTable'),
            difference, repCount;
        var deliver_item_array = [];
        var ref_number = $("#ref_number").val();



        $('#readyflexCheckDefault').on('click', function() {
            if (delivery == 'pending') {
                $('#readyflexCheckDefault').prop("checked", true)
            }
            if ($("#readyflexCheckDefault").is(":checked")) {
                $('#download-delivery-note').css('display', 'block')
            } else {
                $('#download-delivery-note').css('display', 'none')
            }

        });

        $('#download-delivery-note').on('click', function() {
            $('#preloader').css('display', 'block');
            console.log('ready');
            $.ajax({
                url: "/furniture-replacement/collect/printannexured",
                type: "get",
                data: {
                    ref_number: ref_number,
                    items: deliver_item_array
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = `${ref_number} - Delivery Note.pdf`;
                    link.click();
                    $('#preloader').css('display', 'none');
                    window.localStorage.removeItem(ref_number)
                    location.reload()
                },
                error: function(err) {
                    $('#preloader').css('display', 'none');
                }
            });
        });

        $('#saveDataBtn').on('click', function() {
            if (delivery != 'pending') {
                var values = $(".deliver_count")
                    .map(function() {
                        var name = $(this).data("id");
                        var arr = {};
                        arr[name] = $(this).val();
                        return arr;
                    }).get();
                // console.log(JSON.stringify(values));
                localStorage.setItem(ref_number, JSON.stringify(values));
            }
            $('#saveSuccess').click();
        });

        $('#submitDataBtn').on('click', function() {
            if (delivery == 'pending') {
                if ($("#deliverflexCheck").is(":checked") && $("#upload_file").val() != '') {
                    $('#readyerror').text("");
                    $('#checkerror').text("");
                    $('#fileerror').text("");
                    $('#validate_error').text("")
                    $('#formSubmitPopUp').click()
                } else {
                    $("#deliverflexCheck").is(":checked") ? $('#checkerror').text("") : $('#checkerror').text("Please Tick the checkbox");
                    $("#upload_file").val() != '' ? $('#fileerror').text("") : $('#fileerror').text("Signed delivery note is required");
                }
            } else {
                if ($("#readyflexCheckDefault").is(":checked") && deliver_item_array.length == table.find('tbody > tr').length) {
                    $('#readyerror').text("");
                    $('#validate_error').text("")
                } else {
                    $("#readyflexCheckDefault").is(":checked") ? $('#readyerror').text("") : $('#readyerror').text("Please Tick the checkbox");
                    deliver_item_array.length == table.find('tbody > tr').length ? $('#validate_error').text("") : $('#validate_error').text("Deliverable count for all furniture items is required");
                }
            }
            // if ($("#readyflexCheckDefault").is(":checked") && $("#deliverflexCheck").is(":checked") && $("#upload_file").val() != '' && deliver_item_array.length == table.find('tbody > tr').length) {
            //     $('#readyerror').text("");
            //     $('#checkerror').text("");
            //     $('#fileerror').text("");
            //     $('#validate_error').text("")
            //     $('#formSubmitPopUp').click()
            // } else {
            //     console.log('error');
            //     $("#readyflexCheckDefault").is(":checked") ? $('#readyerror').text("") : $('#readyerror').text("Please Tick the checkbox");
            //     $("#deliverflexCheck").is(":checked") ? $('#checkerror').text("") : $('#checkerror').text("Please Tick the checkbox");
            //     $("#upload_file").val() != '' ? $('#fileerror').text("") : $('#fileerror').text("Signed delivery note is required");
            //     deliver_item_array.length == table.find('tbody > tr').length ? $('#validate_error').text("") : $('#validate_error').text("Deliverable count for all furniture items is required");
            // }
        });

        $('#submitrepair').on('click', function() {
            $('#delivery_form').submit()
        });

        window.onload = new function() {

            $('#readydelivery').css('display', 'block')
            if (delivery == 'pending') {
                $('#readyflexCheckDefault').prop("checked", true)
                $('#readyflexCheckDefault').prop('disabled', true);
                $('#download-delivery-note').css('display', 'block')
                $('#download-delivery-note').prop('disabled', true);
                // $('.deliver_count').prop('readonly', true);
            } else {
                table.find('tbody > tr').each(function() {
                    var deliver_count = 0
                    deliver_count = ($(this).find('.repair_count').text() * 1 + $(this).find('.accept_count').text() * 1)
                    $(this).find('.deliver_count').val(deliver_count)
                    var arr = {
                        "id": $(this).find('.item_id').val(),
                        "deliver_count": $(this).find('.deliver_count').val() * 1,
                    };
                    deliver_item_array.push(arr);
                });
                // $('.deliver_count').prop('readonly', true);
            }
        }
    });
</script>
<script>
    function removeImg() {
        $('#image_preview').html('');
        $('#upload_file').val(null)

    }
</script>

@endsection

{{-- @section('foot-script')
<script src="{{ asset('js/deliverRequest.js') }}"></script>
@endsection --}}