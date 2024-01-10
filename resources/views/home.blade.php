@extends('layouts.layout')
@section('content')
    <main>
        <style>
            .check {
                width: 50px;
                height: 30px;
            }
        </style>
        <div class="container">
            <div class="row">
                
                    @if ($message = Session::get('success'))
                        <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            style="display: block;" aria-modal="true" role="dialog">
                            <div class="modal-dialog modal-dialog-centered popup-alert">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                            <h4 class="popup-alert_title">Funds Suceesfully Requested</h4>
                                            <p class="popup-alert_des">{{ $message }}</p>
                                        </div>
    
                                    </div>
                                    <div class="modal-footer text-center justify-content-center p-3 border-0">
                                        <a href="{{ route('Funds.index') }}" class="btn btn-secondary px-5">OK</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

             {{--    @if ($message = Session::get('status'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="assets/img/popup-check.svg" class="img-fluid" alt="">
                                        <h4 class="popup-alert_title">Password Reset</h4>
                                        <p class="popup-alert_des"> {{ $message }}</p>
                                    </div>

                                </div>
                                <div class="modal-footer text-center">
                                    <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"
                                        onclick="hidePopup()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif --}}
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="text-center mt-4">

                            <h1 class="text-uppercase fw-bold">
                                Welcome,<span class="color-primary"> {{ Auth::user()->name }}
                                    {{ Auth::user()->surname }}  </span>
                            </h1>
                            {{-- {{ Auth::user()->District_Id }} --}}
                            <h2>{{ Auth::user()->getOrganization->name }}</h2>
                            <br><br>

                            @if (Auth::user()->getOrganization->id == 2)


                                {{-- <div class="col-12 mb-3">
                                    <h3>Please carefully choose from the procurement outlined in <b>Section 21 C</b> for either textbook, stationery, or both, as per your specific requirements</h3><br>
                                    <div class="row justify-content-center g-4">
                                        <div class="col-12 col-lg-4">
                                            <div class="school-dashboard-wrap_mini">
                                                <input class="check" type="checkbox" value="Textbook procurement">
                                                <h2 style="color: darkgreen">Textbook procurement</h2>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="school-dashboard-wrap_mini">
                                                <input class="check" type="checkbox" value="Stationary procurement">
                                                <h2 style="color: darkgreen">Stationery procurement</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <a href="{{ route('Funds.index') }}" class="btn btn-primary btn-lg"
                                        style="background-color: green">Proceed</a>
                                </div>
                     --}}


                            @endif




                        </div>

                    </div>
                </div>
            </div>


        </div>
        <!-- main -->
        <main>
            <div class="container">

            </div>

        </main>
        @if ($message = Session::get('status'))
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
