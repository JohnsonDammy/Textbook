@extends('layouts.layout')
@section('title', 'Supplier List')
@section('content')
    <!-- main -->
    <main>
 
        <style>
            .buttonGenerate {
                display: inline-block;
                padding: 7px 7px;
                /* Adjust the padding for the desired height */
                text-decoration: none;
 
                /* Text color for the active tab */
 
                /* Blue text color for inactive tabs */
            }

            .buttonApprove {
                background: transparent linear-gradient(261deg,#85c286,#44a244);
    border: none;
    border-radius: 3.9rem;
    color: #fff;
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1;
    padding: 1.4rem 2rem;
    text-transform: capitalize;
    transition: all .3s ease-in;
            }
 
            .buttonDecline 
            {
                background: transparent linear-gradient(261deg,#FF7F7F ,#FF0000);
    border: none;
    border-radius: 3.9rem;
    color: #fff;
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1;
    padding: 1.4rem 2rem;
    text-transform: capitalize;
    transition: all .3s ease-in;
            }
        </style>
 
        <div class="container">
            <!-- breadcrumb -->
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="page-titles">
                        <h4>Capture Select Supplier</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            {{-- <li class="breadcrumb-item"><a href="{{ route('school-maintenance') }}">School Maintenance</a></li> --}}
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Delivery List</a></li>
                        </ol>
                    </div>
                </div>
                {{-- <div class="offset-xl-3 col-12 col-md-4 col-xl-2 mb-3">
                    <a href="{{ route('Deliverys.Add') }}" class="btn btn-primary w-100">+ Upload Delivery Note</a>
                </div> --}}
            </div>
 
            @if (session('StatusChange') == 'Request approved.' || session('StatusChange') == 'Request declined.')
                <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    style="display: block;" aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered popup-alert">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center">
                                    <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                    <p class="popup-alert_des"> {{ session('StatusChange') }}</p>
                                </div>
 
                            </div>
 
                            @if (session('StatusChange') == 'Request approved.')
                            <div class="modal-footer text-center justify-content-center p-3 border-0">
                             <a href="{{route('ApproveUploadOrderDistrict' )}}">
                                <button type="button" class="btn btn-secondary px-5" >OK</button>
                            </a>  
                            @else

                            <div class="modal-footer text-center justify-content-center p-3 border-0">
                      
                                   <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                   onclick="hidePopup()">OK</button>
                            @endif
 
                            </div>
                        </div>
                    </div>
                </div>
            @endif
 
            @if (session('StatusChange') == 'Request Failed.')
                <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    style="display: block;" aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered popup-alert">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center">
                                    <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5"
                                        alt="">
                                    <p class="popup-alert_des"> {{ session('StatusChange') }} , Please ensure you enter a
                                        comment to decline the request</p>
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
            {{-- Standard school and Emis --}}
            <div class="row align-items-center border-bottom border-2">
                <br> <br> <br>
 
                <div class="row">
 
                    <input type="hidden" name="broken_items[]" id="broken_array" value="">
                    <div class="col-12 col-md-12 my-3">
                        <div class="row g-4">
                            <div class="form-group col-12 col-md-6 col-xl-3">
                                <input type="text" name="School" class="form-control form-control-lg" disabled
                                    required="required" value="{{ session('schoolname') }}" placeholder=" ">
                                <label>School Name</label>
                                <input type="hidden" value="{{ session('schoolname') }}" name="SchoolName">
                            </div>
                            <div class="form-group col-12 col-md-6 col-xl-2">
                                <input type="text" name="Emis" class="form-control form-control-lg"
                                    value="{{ session('emis') }}" disabled required="required" placeholder=" ">
                                <input type="hidden" value="{{ session('emis') }}" name="SchoolEmis">
                                <label>School EMIS Number</label>
                            </div>
                        </div>
 
                    </div>
 
                </div>
 
 
                <br> <br>
            </div>
 
 
            <div class="card" id="cardSupplier">
                <h5 class="card-header" style ="color:#14A44D">Recommend Captured Suppliers</h5>
                <div class="card-body">
 
 
                    <table class="table">
                        <input type="hidden" name="UncheckedItems" value="">
                        <thead>
                            <tr>
 
                                {{--  <th> </th> --}}
                                <th> Email </th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact No</th>
                                <th> Amount </th>
                                <th> Mark up (%) </th>
                                <th> Action </th>
 
 
 
 
 
                            </tr>
                        </thead>
 
                        @if (count(session('CapturedData')) < 1)
                            <tbody>
 
                                <tr class="text-center text-dark">
                                    <td colspan="9">Please capture minumum of three suppliers
                                    </td>
                                </tr>
                            </tbody>
                        @else
                            <tbody>
                                @foreach (session('CapturedData') as $item)
                                    {{--  @php
                                        use App\Models\capturedsuppliers;
 
                                        $existRecord = capturedsuppliers::where('savedSupplierID', $item->id)->exists();
                                    @endphp --}}
                                    <tr>
 
                                        {{--  <td> <input type="checkbox" class="checkbox" name="selectedItems[]"
                                            @if (session('savedSuppliers')->contains('supplierID', $item->Id)) checked @endif
                                            value={{ $item->Id }}>
                                    </td> --}}
 
                                        <td>{{ $item->email }} </td>
                                        <td>{{ $item->CompanyName }} </td>
                                        <td>
                                            <div class="short-text" title="{{ $item->CompanyAddress }} ">
                                                {{ Str::limit($item->CompanyAddress, 40) }}
                                            </div>
                                        </td>
 
                                        <td>{{ $item->CompanyContact }} </td>
 
                                        <td>
 
 
                                            @if ($item->markUp > 27)
                                                <span style="color:red">R
                                                    {{ number_format($item->amount, 2, '.', ',') }}</span>
                                            @else
                                                <span style="color:black">R
                                                    {{ number_format($item->amount, 2, '.', ',') }}</span>
                                            @endif
 
 
 
                                        </td>
 
                                        <td>
 
 
                                            {{ $item->markUp }}
 
                                        </td>
 
 
                                        <td>
                                            <a href="{{ route('viewSupplierDetails', ['itemId' => $item->savedSupplierID]) }}"
                                                style="color:green; text-decoration: underline; font-style:italic"> View
                                                <a>
                                        </td>
 
                                    </tr>
                                @endforeach
                        @endif
 
 
 
                        </tbody>
 
 
                    </table>
 
                    {{-- Download and upload ef48 --}}
                    {{-- Download and upload comittee PDF  --}}
 
 
 
                </div>
            </div>
 
            {{-- Download EF58 --}}
            <div class="form-group col-12 col-md-6 col-xl-2">
 
                <i class="fas fa-download" style="color: green;"></i><a href="{{ route('downloadEF58') }}"
                    style="color:green; text-decoration: underline; font-style: italic;">
                    Download EF58
                </a>
 
            </div>
 
 
 
            <form action=" {{ route('ApproveDeclineRequest') }}  " method="post">
                @csrf
 
                <div class="form-group">
                    <label for="firstName">Comment :</label>
                    <textarea style="background-color: #f4f9f4;" style="white-space: pre-line;" class="form-control" id="memo"
                        name="comment" placeholder="Enter comment" rows="1">
                    </textarea>
                </div>
                <div class="row align-items-center border-bottom border-2">
                    <center style="margin-left: 300px">
                        <div class="row">
                            <div class="col-12 col-md-6 my-3">
                                {{--  <div class="row g-4"> --}}
                                {{-- <div class="form-group col-12 col-md-4 col-xl-3"> --}}
 
                                <input type="hidden" name="action" id="approveAction" value="">
                                <input type="submit" onclick="setAction('approve')"
                                    class="buttonApprove" value="APPROVE">
                                <input   type="submit" onclick="setAction('decline')" 
                                    class="buttonDecline" value="DECLINE">
 
                                {{--   </div> --}}
                                {{--   </div> --}}
                                <div>
                                </div>
                            </div>
                    </center>
            </form>
 
 
 
 
 
 
 
    </main>
 
    <script>
        function setAction(action) {
            document.getElementById('approveAction').value = action;
        }
    </script>
 
 
    <script>
        function hidePopup() {
            $("#exampleModal").fadeOut(200);
            $('.modal-backdrop').remove();
        }
    </script>
@endsection