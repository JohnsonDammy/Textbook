@extends('layouts.layout')
@section('title', 'Add Item Description')
@section('content')
<!-- main -->

<main>
    <div class="container">
        <!-- breadcrumb -->
        <div class="row align-items-center border-bottom border-2">
            <div class="col-12 col-md-12">
                <div class="page-titles">
                    <h4>Catalogue Maintenance</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('stock-maintenance') }}">Catalogue Maintenance</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('stockitems.index') }}">Item Description</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Add new Item Description</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            @if ($message = Session::get('error'))
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered popup-alert">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('img/Error-Text.svg') }}" class="img-fluid mb-5" alt="">
                                <h4 class="popup-alert_title">Catalogue Maintenance - Add Item Description</h4>
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
            <form class="" method="post" action="{{route('stockitems.store')}}" data-parsley-validate>
                @csrf()
                <div class="col-12 col-md-12 my-5">
                    <div class="row g-5">
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="mb-5">
                                <div class="form-group">
                                    <select class="form-control form-control-lg wide rounded-0" id="item-category" name="category_id" required data-parsley-required-message="Item category is required">
                                        <option value="" selected disabled>Select Item Category</option>
                                        @foreach (getListOfAllCategories() as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected="selected"' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('category_id'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                    @endif
                                    <label for="item-category">Item Category<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="offset-xl-2 col-12 col-md-6 col-xl-3">
                            <div class="mb-5">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg wide rounded-0" id="furniture-categoryw" name="name" value="{{ old('name') }}" required data-parsley-required-message="Item Description name is required" placeholder=" ">
                                    @if($errors->has('name'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                    <label for="furniture-categoryw">Item Description Name<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-lg ">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    @if ($message = Session::get('error'))
    <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
    @endif
    <script>
        function hidePopup() {
            $("#exampleModal").fadeOut(200);
            $('.modal-backdrop').remove();
            console.log("hidePop")
        }
    </script>
</main>
@endsection