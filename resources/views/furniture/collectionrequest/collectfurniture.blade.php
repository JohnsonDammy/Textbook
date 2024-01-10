@extends('layouts.layout')
@section('title', 'Collect Items')
@section('head-script')
<script>
    var ref_number = "{{ $data->ref_number }}";
    var coll_status = "{{ $data->status_id }}";
    var local_ref_number = window.localStorage.getItem(ref_number) != null ? JSON.parse(window.localStorage.getItem(
        ref_number)) : null;
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
            <div class="offset-xl-4 text-end col-12 col-md-6 col-xl-4 mb-3">
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
                    <div class="col content-col active">
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
                    <div class="col content-col">
                        <div class="circle-icon-container">
                            <i class="ri-hammer-fill"></i>
                        </div>
                        <p>Repair/ Replenish</p>
                    </div>
                    <div class="col arrow-col ">
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
        <div class="row">
            @if ($message = Session::get('error'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">Transaction</h4>
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
            <div class="col-12 my-3">
                <div class=" bg-light fw-bold py-4 color-primary px-5">
                    <p class="mb-0">
                        Collect Transaction
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-12 my-3">
                <form method="post" action="/furniture-replacement/collect/store" enctype="multipart/form-data" id="collectform">
                    @csrf()
                    <div class="row g-4">
                        <div class="form-group col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control form-control-lg" required="required" value="{{ $data->school_name }}" disabled placeholder=" ">
                            <label>School Name</label>
                        </div>
                        <div class="form-group col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control form-control-lg" value="{{ $data->emis }}" disabled required="required" placeholder=" ">
                            <label>School EMIS Number</label>
                        </div>
                        <div class="form-group col-12 col-md-6 col-xl-4">
                            <input type="text" class="form-control form-control-lg" value="{{ $data->total_furniture }}" disabled required="required" placeholder=" ">
                            <label>Learner Enrolment Count</label>
                        </div>

                        <input type="hidden" name="ref_number" value="{{ $data->ref_number }}" id="ref_number">
                        <input type="hidden" name="request_id" value="{{ $data->id }}">
                        <div class=" form-group col-12 col-md-6 col-xl-2">
                            @can('collect-furniture-create')
                            <a type="button" class="btn-reset btn-add-photo w-100" id="btn_addphoto" data-bs-toggle="modal" style="display: none" data-bs-target="#add-photo-popup">+add
                                photo</a>
                            <span id="imageErrorSpan" class="text-danger" style="display: none;font-weight:bold">Add
                                at least one image</span>

                            <label>&nbsp;</label>
                            @if ($errors->has('images'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('images') }}</strong>
                            </span>
                            @endif
                            @if ($errors->has('images.*'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('images.*') }}</strong>
                            </span>
                            @endif
                            @endcan
                        </div>

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
                                    <input type="file" class="form-control" id="upload_file" name="images[]" onchange="preview_image();" required multiple accept="image/*" />
                                    <div id="image_preview"></div>
                                    <div class="models__footer">
                                        @can('collect-furniture-create')
                                        <button type="button" onclick="removeImg()" class="btn-reset text-decoration-underline">Cancel</button>
                                        <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal">Add</button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end photo model popup -->

                    </div>
            </div>
            <div class="col-12 mt-2">
                <div class="row g-0 d-flex bg-light align-items-center justify-content-between color-primary py-4  px-5">
                    <div class="col-12 col-md-6  fw-bold ">
                        <p class="mb-0">
                            Collect Items
                        </p>
                    </div>
                    <div class="col-12 col-md-6 text-end">
                        @can('collect-furniture-create')
                        @if ($data->status_id == App\Models\RequestStatus::COLLECTION_ACCEPTED)
                        <a onclick="payslip()" class="fw-normal me-5 printanchor">
                            <i class="ri-printer-line align-middle"></i>
                            <span class=" text-decoration-underline"> Print Pickup Slip</span><br>
                            <span class="text-danger p-2" id="printSlipErrSpan" style="display: none;font-weight:bold">Print
                                pickup slip first</span>
                        </a>
                        @endif
                        @if ($data->status_id == App\Models\RequestStatus::COLLECTION_PENDING)
                        <a href="/furniture-replacement/accept/{{ $data->id }}" class="btn"> Accept
                            Collection Request</a><br>
                        <span class="text-danger p-2" id="acceptErrSpan" style="display: none">
                            <strong>Accept the
                                collection request first</strong></span>
                        @endif
                        @endcan
                    </div>

                </div>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item Category</th>
                                <th>Item Description</th>
                                <th>Item Full Count</th>
                                <th>School Collection Count</th>
                                @can('collect-furniture-create')
                                <th>Confirm Collected Count</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data->getBrokenItems as $key => $item)
                            <tr>
                                <td>{{ $item->getCategoryDetails->name }}</td>
                                <td>{{ $item->getItemDetails->name }}</td>
                                <td>{{ $item->item_full_count }}</td>
                                <td>{{ $item->count }}</td>
                                @can('collect-furniture-create')
                                @php
                                $temp = 'confirm_count.' . $item->id;
                                @endphp
                                <td>
                                    <!-- <input type="number" class="form-control" name="confirm_count[{{ $item->id }}]" value="{{ old($temp) }}" /> -->
                                    <script>
                                        document.write(`
                                                                    <input class="p-3 border-0 confirm-count-input" type="number"
                                                                    name="confirm_count[{{ $item->id }}]" value="${local_ref_number != null ? local_ref_number[{{ $key }}][{{ $item->id }}] : ''}"
                                                                    placeholder="Enter Value"
                                                                    data-id="{{ $item->id }}" 
                                                                    ${local_ref_number != null ?(local_ref_number[{{ $key }}][{{ $item->id }}]  ? '' : 'readonly title="Print pickup slip first"') : 'readonly title="Print pickup slip first"'}
                                                                    data-parsley-required
                                                                    data-parsley-required-message="Organization is required"
                                                                    min="0"
                                                            oninput="this.value =
                                                                     !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                                                    >
                                                                    `)
                                    </script>
                                    <br>
                                    <span id="countErrSpan" class="text-danger " style="margin-left:10px;font-weight:bold"></span>
                                    @if ($errors->has($temp))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first($temp) }}</strong>
                                    </span>
                                    @endif
                                </td>
                                @endcan
                            </tr>
                            @endforeach

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


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="text-end submi-btn my-3">
            @can('collect-furniture-create')
            <button type="button" data-bs-toggle="modal" data-bs-target="#cancel-pop" class="btn-reset text-decoration-underline">Cancel</button>
            <button type="button" id="saveDataBtn" class="btn btn-primary ms-3">Save</button>
            <button type="button" class="btn btn-primary ms-3" onclick="formValidate()">Submit</button>
            <button type="button" id="formSubmitPopUp" data-bs-toggle="modal" data-bs-target="#submit-pop" hidden></button>
            <input type="submit" hidden id="submitcollectform" value="Submit">
            @endcan
        </div>

        <!--alret popup -->
        <div class="modal fade" id="submit-pop" tabindex="-1" aria-labelledby="submit-popLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-alert">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5" alt="">
                            <p class="popup-alert_des fw-bold">Transaction - Collect Items</p>
                            <p>Are you sure you submit?</p>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-around text-center">
                        <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                        <button type="button" onclick="validateCollect()" class="btn btn-secondary px-5">Yes</button>
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

        </form>
    </div>
    <!-- transaction list modal model popup -->
    <div class="modal fade" id="transmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered popup-alert">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5" alt="">
                        <h4 class="modal-title popup-alert_des fw-bold">Transaction</h4>
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

    <script src="{{ asset('js/collectFurniture.js') }}"></script>
    @if ($message = Session::get('error'))
    <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    <script>
        function hidePopup() {
            $("#exampleModal").fadeOut(200);
            $('.modal-backdrop').remove();
        }
    </script>
</main>
@endsection