@extends('layouts.layout')
@section('title', 'Transaction')
@section('content')
<!-- main -->
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Reference Number-{{ $data->ref_number }}</a>
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
                    <div class="col content-col success">
                        <div class="circle-icon-container">
                            <i class="ri-truck-fill"></i>
                        </div>
                        <p>Deliver Items</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-3">
                <div class=" bg-light fw-bold py-4 color-primary px-5">
                    <p class="mb-0">
                        Transaction
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
                            Transaction Details
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <p class="text-danger" role="alert">
                    <strong id="validate_error"></strong>
                </p>
                <div class="table-responsive">
                    <table class="table" id="furnitureCountTable">
                        <thead>
                            <tr>
                                <th>Item Category</th>
                                <th>Item Description</th>
                                <th>Item <br> Full Count</th>
                                <th>School <br> Collection <br> Count</th>
                                <th>Collected <br> Count</th>
                                <th>Repairable <br> Count</th>
                                <th>Replenish<br>Request Count</th>
                                <th>Replenishment <br> Approved Count</th>
                                <th>Replenishment <br> Rejected Count</th>
                                <th>Delivered <br> count </th>
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
                                <td class="fw-bold replenish_count">
                                    {{ $item->delivered_count }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

    </div>
</main>
<!-- footer -->
<footer>
</footer>

@endsection