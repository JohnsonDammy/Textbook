@extends('layouts.layout')
<script>
    var totalcount = 0
    var broken_item_array = []
    console.log(JSON.parse(window.localStorage.getItem("brokenItems")));
    broken_item_array = window.localStorage.getItem("brokenItems") ? JSON.parse(window.localStorage.getItem(
        "brokenItems")) : [];
    totalcount = window.localStorage.getItem("totalCount") ? window.localStorage.getItem(
        "totalCount") : 0;
    csrf_token = "{{ csrf_token() }}"
</script>

@section('title', 'Create New Request')
@section('content')
<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center border-bottom border-2">
            <div class="col-12 col-md-12 col-xl-12">
                <div class="page-titles">
                    <h4>Transactions</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('furniture-replacement.index') }}">Transactions</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Transaction - Create Request</a>
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
                    <div class="col content-col active">
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
                    <div class="col content-col ">
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
            <div class="col-12 my-3">
                <div class=" bg-light fw-bold py-4 color-primary px-5">
                    <p class="mb-0">
                        Create Request
                    </p>
                </div>
            </div>
            <form action="{{ route('furniture-replacement.store') }}" id="create-collection-form" method="POST">
                @csrf
                <input type="hidden" name="broken_items[]" id="broken_array" value="">
                <div class="col-12 col-md-12 my-3">
                    <div class="row g-4">
                        <div class="form-group col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control form-control-lg" required="required" value="{{ Auth::user()->name }}" disabled placeholder=" ">
                            <label>School Name</label>
                        </div>
                        <div class="form-group col-12 col-md-6 col-xl-3">
                            <input type="text" class="form-control form-control-lg" value="{{ Auth::user()->username }}" disabled required="required" placeholder=" ">
                            <label>School EMIS Number</label>
                        </div>
                        <div class="form-group col-12 col-md-6 col-xl-4">
                            <input type="number" class="form-control form-control-lg" style="box-shadow:0 0 0 0.25rem #7cbf7a" required="required" placeholder=" " id="total_furniture" value="" min="0" oninput="this.value =
                                                                                                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" name="total_furniture">

                            <span class="text-danger" style="display: none;" id="counterror" role="alert">
                                <strong id="counterrormsg">Learner Enrolment Count is required</strong>
                            </span>

                            <label>Learner Enrolment Count</label>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-12 mt-4 mb-2">
                <a data-bs-toggle="modal" data-bs-target="#models" class="btn">Report On Assets</a>
            </div>
            <div class="col-12 mt-2">
                <div class=" bg-light fw-bold py-4 color-primary px-5">
                    <p class="mb-0">
                    Damaged Items
                    </p>
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
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody id="broken-item-table">
                        </tbody>
                    </table>
                    <span style="display: none;" class="text-danger text-center" id="itemlisterr" role="alert">
                        <strong>At least one damaged item must be added</strong>
                    </span>
                </div>

            </div>
        </div>
        <div class="text-end submi-btn my-3">
            <button type="button" class="btn-reset text-decoration-underline" data-bs-toggle="modal" data-bs-target="#cancel-model-popup">Cancel</button>
            <button href="#" class="btn btn-primary ms-3" hidden id="listsuccess" data-bs-toggle="modal" data-bs-target="#alret-pop">Save</button>
            <button href="#" class="btn btn-primary ms-3" hidden id="success-popup" data-bs-toggle="modal" data-bs-target="#alret-pop-success"></button>
            <a class="btn btn-primary ms-3" onclick="saveBrokenItems()">Save</a>
            <button type="button" class="btn btn-primary ms-3" onclick="checkSubmitVal()">Submit</button>
            <button hidden class="btn-reset" type="button" id="submitvalidsuccess" data-bs-toggle="modal" data-bs-target="#submitvalidsuccessmodel">
            </button>
        </div>
    </div>
</main>

<!--success save popup -->
<div class="modal fade" id="alret-pop" tabindex="-1" aria-labelledby="alret-popLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered popup-alert">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                    <h4 class="popup-alert_title">Transaction</h4>
                    <p class="popup-alert_des">The captured information has been saved successfully</p>
                </div>

            </div>
            <div class="modal-footer text-center justify-content-center p-3 border-0">
                <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal">OK</button>
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
                    <h4 class="popup-alert_title">Transaction Recorded</h4>
                    <p class="popup-alert_des">Your Collection Request has been submitted successfully!
                        The Reference Number is <span id="ref_no_popup"></span></p>
                </div>

            </div>
            <div class="modal-footer text-center justify-content-center p-3 border-0">
                <button type="button" class="btn btn-secondary px-5" id="success-pop-ok" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- add broken item model popup -->
<div class="modal fade" id="models" class="models" tabindex="-1" aria-labelledby="modelsLabel" aria-hidden="true">
    <div class="modal-dialog model-xl modal-dialog-centered">
        <div class="modal-content models__content">
            <div class="models__header">
                <div class="models__header_text">
                    <h5 class="modal-title">+ Report On Assets</h5>
                </div>
                <button id="close-broken-item-btn-id" class="btn-reset" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ri-close-fill"></i>
                </button>
            </div>
            <div class="models__body">
                <div class="row">
                    <div class="col-12 col-md-12 my-5">
                        <div class="row g-5">
                            <div class="col-12 col-md-6 col-xl-3">
                                <select class="form-control form-control-lg wide furniture-category" id="temp" onchange="getItems()">
                                    <option selected disabled value="">Item Category</option>
                                    @foreach (getListOfAllCategories() as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected="selected"' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <span style="display: none;" class="text-danger" id="createcaterr" role="alert">
                                    <strong>Item category is required</strong>
                                </span>
                            </div>
                            <div class="col-12 col-md-6 col-xl-3">
                                <select class="form-control form-control-lg wide furniture-items">
                                    <option selected disabled value="">Item Description</option>
                                </select>

                                <span style="display: none;" class="text-danger" id="createitemerr" role="alert">
                                    <strong>Item description is required</strong>
                                </span>
                            </div>
                            <div class="form-group col-12 col-md-6 col-xl-3">
                                <label for="item_full_count">Item Full Count</label>
                                <br />
                                <div class="d-flex align-items-center">
                                    <div class="text-muted furniture-items-counter fs-2">
                                        <form>
                                            <div class="value-button decrease" id="decrease" onclick="decreaseValuetotal()" value="Decrease Value">-</div>

                                            <input type="number" id="item_full_count" name="item_full_count" class="full-count fullcount" value="0" min="0" oninput="this.value =
                                                                                                                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" />
                                            <div class="value-button" id="increase" onclick="increaseValuetotal()" value="Increase Value">+</div>
                                        </form>
                                      
                                        <span style="display: none;" class="text-danger fs-4 mt-3" id="createfullcounterr" role="alert">
                                            <strong>Item full count is required</strong>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6 col-xl-3">
                                <label class="mb-3">Damage Count</label>
                                <br />
                                <div class="d-flex align-items-center">

                                    <div class="text-muted furniture-items-counter fs-2">
                                        <form>
                                            <div class="value-button decrease" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                                            <input type="number" class="number" id="number" value="0" min="0" oninput="this.value =
                                                                                                                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" />
                                            <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                                        </form>
                                        <span style="display: none;" class="text-danger fs-4 mt-3" id="createcounterr" role="alert">
                                            <strong>Damage count is required</strong>
                                        </span>
                                        <span style="display: none;" class="text-danger fs-4 mt-3" id="validcreatecounterr" role="alert">
                                            <strong>Damage count should be less than or equal to Item Full Count</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- dyn -->
                <div class="row">
                    <div class="col-12 col-md-6 col-xl-3">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0">
                                <div class="d-flex ">
                                    <div class="flex-shrink-1 flex-grow-1">
                                    </div>
                                </div>

                            </li>

                        </ul>

                    </div>

                </div>
            </div>
            <div class="models__footer">
                <button type="button" onclick="clearAddBrokenItem()" class="btn btn--dark px-5">Clear</button>

                <button type=" button" class="btn btn-secondary px-5" data-bs-dismiss="" id="add-broken-item-btn-id">Add</button>
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
<!-- Cancel button model popup -->
<div class="modal fade" id="cancel-model-popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered popup-alert">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5" alt="">
                    <h4 class="modal-title popup-alert_des fw-bold">Transaction</h4>
                    <p class="modal-title_des">Are you sure you want to cancel?</p>
                </div>

            </div>
            <div class="modal-footer justify-content-around text-center">
                <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal" onclick="cancelButtonRefresh()">Yes</button>
            </div>
        </div>
    </div>
</div>
<!-- submit request modal popup -->
<div class="modal fade" id="submitvalidsuccessmodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered popup-alert">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="{{ asset('img/confirmation-popup.svg') }}" class="img-fluid mb-5" alt="">
                    <h4 class="modal-title popup-alert_des fw-bold">Transaction - Create Request</h4>
                    <p class="modal-title_des">Are you sure you submit this request?</p>
                </div>

            </div>
            <div class="modal-footer justify-content-around text-center">
                <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                <button type="button" id="collection-submit-btn" data-bs-dismiss="modal" class="btn btn-secondary px-5">Yes</button>
            </div>
        </div>
    </div>
</div>

<div id="update-broken-item-modal"></div>

<script>
    function editBrokenItemFromList(e) {
        console.log(broken_item_array[e]);

        $('#update-broken-item-modal').html(`
                 <div class="modal models-update fade show" id="models-update" tabindex="-1" aria-labelledby="modelsLabel" aria-modal="true" role="dialog" style="display: block; padding-left: 0px;">
                        <div class="modal-dialog model-xl modal-dialog-centered">
                            <div class="modal-content models__content">
                                <div class="models__header">
                                    <div class="models__header_text">
                                        <h5 class="modal-title">+ Update Damaged Item</h5>
                                    </div>
                                    <a type="button" data-bs-dismiss="models-update" onclick="closeModel()" aria-label="Close">
                                        <i class="ri-close-fill"></i>
                                    </a>
                                </div>
                                <div class="models__body">
                                    <div class="row">
                                        <div class="col-12 col-md-12 my-5">
                                            <div class="row g-5">
                                                <div class="col-12 col-md-6 col-xl-3">
                                                    <input type="hidden" value="${broken_item_array[e]['item_id']}" id="item-update">
                                                    <select class="form-control form-control-lg wide furniture-category-update"  onchange="getItems()">
                                                        <option selected disabled value="">Item Category</option>
                                                        @foreach (getListOfAllCategories() as $category)
                                                            <option value="{{ $category->id }}" ${broken_item_array[e]['category_id']=={{ $category->id }} ?
                                                                selected="selected" : '' }>
                                                                {{ $category->name }}</option>
                                                        @endforeach                                            
                                                    </select>
                                                    <span style="display: none;" class="text-danger" id="editcaterr" role="alert">
                                                        <strong>Item category is required</strong>
                                                    </span>
                                                </div>
                                                <div class="col-12 col-md-6 col-xl-3">
                                                    <select class="form-control form-control-lg wide furniture-items furniture-items-update" ><option selected="" disabled="" value="">Item Description</option></select>
                                                    <span style="display: none;" class="text-danger" id="edititemerr" role="alert">
                                                        <strong>Item description is required</strong>
                                                    </span>
                                                </div>
                                                <div class="form-group col-12 col-md-6 col-xl-3">
                                                    <label for="item_full_count">Item Full Count</label>
                                <br/>
                                <div class="text-muted furniture-items-counter fs-2">
                                <form>
                                    <div class="value-button decrease" id="decrease" onclick="decreaseValuetotal()" value="Decrease Value">-</div>
                               
                                    <input type="number" id="item_full_count-update" name="item_full_count" class="fullcount full-count-update" value="${broken_item_array[e]['item_full_count']}" min="0" oninput="this.value =
                                                                                                                                            !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" />
                                <div class="value-button" id="increase" onclick="increaseValuetotal()" value="Increase Value">+</div>
                            </form>
                                
                                <span style="display: none;" class="text-danger fs-4 mt-3" id="editfullcounterr" role="alert">
                                    <strong>Item full count is required</strong>
                                </span>
                                </div>
                                                </div>
                                            
                                            <div class="form-group col-12 col-md-6 col-xl-3">
                                                <label class="mb-3">Damage Count</label>
                                <br />
                                <div class="d-flex align-items-center">

                                    <div class="text-muted furniture-items-counter fs-2">
                                                <form>
                                                                        <div class="value-button decrease" id="decrease"  onclick="decreaseValue(1)" value="Decrease Value">-</div>
                                                                        <input type="number" id ="number"   class="number number-update"  value="${broken_item_array[e]['count']}" min="0" oninput="this.value = 
                                                    !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"/>
                                                                        <div class="value-button" id="increase"  onclick="increaseValue(1)" value="Increase Value">+</div>
                                                                    </form>
                                                                <span style="display: none;" class="text-danger fs-4 mt-3" id="editcounterr" role="alert">
                                                                    <strong>Damage count is required</strong>
                                                                </span>
                                                                <span style="display: none;" class="text-danger fs-4 mt-3" id="valideditcounterr" role="alert">
                                            <strong>Damage count should be less than or equal to Item Full Count</strong>
                                        </span>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                </div>
                                    <!-- dyn -->
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="furniture-category-item">
                                                </span>
                                            </div>

                                        </div>
                                     
                                    </div>
                                </div>
                                <div class="models__footer">
                                    <button type="button" id="close-broken-item-btn-id" class="btn btn--dark px-5" data-bs-dismiss="models-update" onclick="clearEditBrokenItem()">Clear</button>
                                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="" id="add-broken-item-btn-id" onclick="updateBrokenItem(${e})">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-backdrop fade show"></div>
              `);

        getItems();
    }
</script>
@endsection
@section('foot-script')
<script src="{{ asset('js/addRequest.js') }}"></script>
@endsection