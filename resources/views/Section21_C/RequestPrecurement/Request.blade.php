@extends('layouts.layout')
@section('title', 'Home')
@section('content')
    <main>
        <style>
          
        </style>
        <div class="container">
            @if($AllowProcurement)
            <div class="row justify-content-center">
                @if ($message = Session::get('success'))
                    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        style="display: block;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered popup-alert">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ asset('img/popup-check.svg') }}" class="img-fluid mb-5" alt="">
                                        <h4 class="popup-alert_title">Procurement Successfulluy Selected</h4>
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
            </div>
            <div class="row">
               {{--  @if ($message = Session::get('status'))
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
                <form action="{{ route('process.selection') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="text-center mt-4">

                                @if (Auth::user()->getOrganization->id == 2)
                                    <div class="col-12 mb-3">
                                       <br>
                                        <h4>Please carefully choose from your procurement method in terms of Section 21C 
                                            </h4><br><br><br><br>
                                            <div class="row justify-content-center g-2">
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-control">
                                                        <label>
                                                            {{-- <input class="check" type="radio"  class="form-check-input mt-0 me-3" name="options" value="Textbook procurement">
                                                            <span style="color: darkgreen">Textbook Only</span> --}}

                                                            <input type="radio" id="checkbox" data-toggle="modal" class="form-check-input mt-0 me-3 check" name="options" value="Textbook procurement"  data-bs-toggle="tab" data-bs-target="#profile"  role="button">
                                                            <label for="date-range">Textbook</label>
                                                        </label><br><br>
                                            
                                                        <label>
                                                            {{-- <input class="check" type="radio" name="options" value="Stationary procurement">
                                                            <span style="color: darkgreen">Stationary Only</span> --}}

                                                            <input type="radio" id="checkbox" data-toggle="modal" class="form-check-input mt-0 me-3 check" name="options" value="Stationary procurement"  data-bs-toggle="tab" data-bs-target="#profile" role="button">
                                                            <label for="reference-number">Stationery</label>
                                                        </label><br><br>
                                            

                                            
                                                        <label>
                                                            {{-- <input class="check" type="radio" name="options" value="TextbookAndStationary">
                                                            <span style="color: darkgreen">Textbook & Stationary</span> --}}

                                                            <input type="radio" id="checkbox" data-toggle="modal" class="form-check-input mt-0 me-3 check" name="options" value="TextbookAndStationary"  data-bs-toggle="tab" data-bs-target="#profile" role="button">
                                                            <label for="reference-number">Textbook & Stationery</label>

                                                        </label><br><br>

                                                        <label>
                                                            {{-- <input class="check" type="radio" name="options" value="No declaration">
                                                            <span style="color: darkgreen">No declaration for this year Only</span> --}}

                                                            <input type="radio" id="checkbox" data-toggle="modal" class="form-check-input mt-0 me-3 check" name="options" value="NoDeclaration"  data-bs-toggle="tab" data-bs-target="#profile" role="button">
                                                                <label for="reference-number">No declaration for this year</label>

                                                        </label><br><br>
                                            
                                                        <input type="hidden" name="options" id="selectedOption">
                                                   

                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            <br>

                                            <div class="container">
                                                <div class="row justify-content-center ">
                                                    <div class="col-md-4 form-control" style="width: 34%;" class="form-control">
                                                        <label for="reference-number" >Circular</label>
                                                        <div class="input-group">
                                                            <input type="file" name="file" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                    </div>
                                    <br>
                                    {{-- <a href="{{ route('Funds.index') }}" class="btn btn-primary btn-lg"
                                        style="background-color: green">Proceed</a> --}}


                                    {{-- <input type="hidden" name="_method" value="DELETE"> --}}

                                    <input type="hidden" name="SchoolEmis" value="{{ Auth::user()->username }}">
                                    <input type="hidden" name="SchoolName" value="{{ Auth::user()->name }}">
  
                                     {{-- Upload button for a circular document --}}
                            
                                
                                    <button class="btn btn-primary btn-lg" id="proceedbtn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal1">
                                    PROCEED
                                    </button>

                                    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered popup-alert">
                                          <div class="modal-content">
                                            <div class="modal-body">
                                              <div class="text-center">
                                                <img src="{{ asset('img/confirmation-popup-1.svg') }}" class="img-fluid mb-5" alt="">
                                                <p class="modal-title_des initial-message" >Are you sure of your selection</p>
                                                <p class="modal-title_des error-message" style="display: none">Please select an option to proceed</p>
                                              </div>
                                            </div>
                                            <div class="modal-footer justify-content-around text-center">
                                              <button type="button" class="btn btn--dark px-5" id="NoBtnModel" data-bs-dismiss="modal">No</button>
                                              <button type="button" class="btn btn--dark px-5" style="display: none" id="OkBtnModel" data-bs-dismiss="modal">OK</button>
                                              <button type="submit" class="btn btn-secondary px-5" id="yesBtnModel">Yes</button>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    
                  
                                      
                </form>
            </div>
            @endif


        </div>

        </div>

        </div>
        </div>
        </div>

        <div class="modal fade" id="ModelLoading" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered popup-alert">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="spinner-container" id="spinner">
                        <div class="spinner-border text-primary" role="status">
                        </div>
                        <label> Please wait... </label>
                    </div>

                </div>


            </div>

        </div>
    </div>
        </div>

        @if ($message = Session::get('status'))
            <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
        @endif

        @if ($message = Session::get('success'))
            <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
        @endif
        @if ($message = Session::get('error'))
            <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
        @endif
        @if ($message = Session::get('alert'))
            <div class="modal-backdrop fade show" onclick="hidePopup()"></div>
        @endif
        @else
        <br><br>
        <p>  {{ Auth::user()->name }} has no allocated funds to be procured </p>
        @endif
        <script>
            function hidePopup() {
                $("#exampleModal").fadeOut(200);
                $('.modal-backdrop').remove();
            }
        </script>

        <script>
            $('.check').on('change', function() {
                $('#selectedOption').val($(this).val());
            });
        </script>



<script>
    $(document).ready(function() {
        $("#yesBtnModel").click(function(){
        $('#ModelLoading').modal('show');

        })

    
    });
</script>

       {{-- Ensure that user can only  --}}
       <script>
        // Attach a click event listener to the "Proceed" button
        document.querySelector('#proceedbtn').addEventListener('click', function () {
          if (!document.querySelector('input[name="options"]:checked')) {
            // No option is selected, so show the "Please select an option to proceed" message
            document.querySelector('.initial-message').style.display = 'none';
            document.querySelector('#yesBtnModel').style.display = 'none';
            document.querySelector('#NoBtnModel').style.display = 'none';
            document.querySelector('.error-message').style.display = 'block';
            document.querySelector('#OkBtnModel').style.display = 'block';
          }
          else 
          {
            // No option is selected, so show the "Please select an option to proceed" message
            document.querySelector('.initial-message').style.display = 'block';
            document.querySelector('#yesBtnModel').style.display = 'block';
            document.querySelector('#NoBtnModel').style.display = 'block';
            document.querySelector('.error-message').style.display = 'none';
            document.querySelector('#OkBtnModel').style.display = 'none';
          }
        
        });
      </script>
    </main>
@endsection
