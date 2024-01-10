
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- meta -->
    <!-- icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon//apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon//favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon//favicon-16x16.png') }}">

    <meta name="theme-color" content="#349933">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css?cb=1644833916086 ') }}" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        input::-webkit-calendar-picker-indicator {
            opacity: 0;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('vendor/jQuery/jquery.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    
    

    <script src="https://kit.fontawesome.com/8ef4d80466.js" crossorigin="anonymous"></script>

    @yield('head-script')
</head>

<body>
    <!-- preloader -->
    <div id="preloader">
        <div class="kw-three-bounce">
            <div class="kw-child kw-bounce1"></div>
            <div class="kw-child kw-bounce2"></div>
            <div class="kw-child kw-bounce3"></div>
        </div>
    </div>
    <!-- header -->
    <header>
        <nav class="container navbar app__navbar border-bottom border-2 pb-3">
            <div class="app__navbar-logo">
                <a href="{{ route('home') }}">
                    <img class="img-fluid" src="{{ asset('img/logo.png') }}" alt="">
                </a>
            </div>
            <div class="siderbar-pop-btn" data-bs-toggle="modal" data-bs-target="#siderbarModal">
                <a href="#">
                    <i class="ri-menu-fill"></i>
                </a>
            </div>
        </nav>
    </header>
    <!-- main -->
    @yield('content')
    <!-- footer -->
    <footer>

    </footer>
    <!-- siderbar -->
    <div class="modal right fade" id="siderbarModal" tabindex="-1" aria-labelledby="myModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="account-profile">
                        <div class="d-flex align-items-center">
                            <i class="ri-account-circle-fill"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <div class="sidebar-close">
                            <a href="#" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ri-close-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="sidebar-navigation">
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('img/home-icon.svg') }}" class="img-fluid" alt="">
                                    <span> Home</span>
                                </a>
                            </li>
                            @can('dashboard-list')
                            <li>
                                <a href="/dashboard">
                                    <img src="{{ asset('img/dashboard-icon.svg') }}" class="img-fluid" alt="">
                                    <span> dashboard</span>
                                </a>
                            </li>
                            @endcan
                            @if (Auth::user()->getOrganization->id == 2)
                            
                            <li>
                                <a href="{{ route('request.index') }}">
                                    <i class="fas fa-book" style="font-size:20px; color: green" ></i>
                                    <span style="margin-left:-7px">Request Procurement</span>
                                </a>
                            </li>
                         
                            @if ($existSelection == true && $existSelection != null )
                            @if($HideForNoDeclaration == false)
                            <li>
                              

                                <a href="{{ route('inboxSchool') }}">
                                    <i class="fa fa-inbox" style="font-size:20px; color: green" ></i>
                                    <span style="margin-left:-7px">Inbox</span>
                                </a>
                            </li>
                            @endif
                            @endif

                            <li>
 
                                <a href="{{ route('Suppliyer.list') }}">
                                    <img src="{{ asset('img/maintenance-icon.svg') }}" class="img-fluid" alt="">
                                    <span style="">Supplier</span>
                                   
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('Member.list') }}">
                                    <img src="{{ asset('img/manage-users.svg') }}" class="img-fluid" alt="">
                                    <span>Committee Member</span>
                                </a>
                            </li>
                            @if ($existSelection == true && $existSelection != null )
                            @if($hideDelivery=="Approved")
                            
                            <li>
                                <a href="{{ route('Delivery.list') }}">
                                    <i class="fas fa-shipping-fast" style="font-size:20px; color: green" ></i>
                                    <span style="margin-left:-7px">Upload Delivery</span>
                                </a>
                            </li>
                            @endif
                            @endif


                            @if ($AllowProcurement == true && $AllowProcurement != null )
    
                      
                            @if($HideForNoDeclaration == false)
                            <li>
                                <a href="#">
                                    <i class="fa fa-history" style="font-size:20px; color: green" ></i>
                                    <span style="margin-left:-7px">History</span>
                                    <em class="ri-arrow-down-s-fill"></em>
                                </a>
                                <ul>
                                 
                                    <li>
                                         <a href="{{ route('Request_History.index') }}">
                                            <i class="fas fa-chevron-circle-right"></i>
                                            <span style="margin-left:-7px">Fund Requests</span>
                                        </a>
                                    </li>
                               
                                    <li><a href="{{ route('stock-maintenance') }}">
                                        <i class="fas fa-chevron-circle-right"></i>
                                        <span style="margin-left:-7px">Transactions</span>
                                        </a>
                                    </li>
 
                                </ul>
                            </li>
                            @endif


                            @endif
                            @endif

                            @if (Auth::user()->getOrganization->id == 1)

                            <li>
                                <a href="{{ route('UploadR') }}">
                                    {{-- <i class="fas fa-dollar-sign" style="font-size:20px; color: green"></i> --}}
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    <span style="margin-left:-7px">Upload funds Allocation</span>
                                </a>
                            </li>
                   

                            <li>
                                <a href="#">
                                  <img
                                    src="{{ asset('img/maintenance-icon.svg') }}"
                                    class="img-fluid"
                                    alt=""
                                  />
                                  <span>Roles</span>
                                  <em class="ri-arrow-down-s-fill"></em>
                                </a>
                                <ul>
                                  {{-- <li>
                                    <a href="{{ route('Roles') }}">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                      <span> Add Role</span>
                                    </a>
                                  </li> --}}
                                  <li>
                                    <a href="{{route('editRoless')}}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>

                                      <span>View Role</span>
                                    </a>
                                  </li>
                                </ul>
                              </li>

                              
                            <li>
 
                                <a href="{{ route('Suppliyer.list') }}">
                                    <img src="{{ asset('img/maintenance-icon.svg') }}" class="img-fluid" alt="">
                                    <span style="">Supplier</span>
                                   
                                </a>
                            </li>
                              
                            @endif


                            @if (Auth::user()->getOrganization->id == 3)
                            <li>
                                <a href="{{ route('notification') }}">
                                    {{-- {{$count}} --}}
                                <i class="fa fa-bell" style=" color: green"><span style="color:red; font-size:14px"><strong>2</strong></span></i>
                                <span style="margin-left:-7px">Notification</span>
                            </a>
                            </li>
                                       
                            {{-- <li>
                              

                                <a href="{{ route('InboxSchoolDistrict') }}">
                                    <i class="fa fa-inbox" style="font-size:20px; color: green" ></i>
                                    <span style="margin-left:-7px">Inbox</span>
                                </a>
                            </li> --}}

                            {{-- <li>
                                <a href="{{ route('AdminViewFundRequest.index') }}">
                                    <i class="fas fa-dollar-sign" style="font-size:20px; color: green" ></i>
                                    <span style="margin-left:-7px">View Funds Request</span>
                                </a>
                            </li> --}}

                            <li>
                                <a href="{{ route('AdminDelivery.list') }}">
                                    <i class="fas fa-shipping-fast" style="font-size:20px; color: green" ></i>
                                    <span style="margin-left:-7px">Capture Delivery</span>
                                </a>
                            </li>

                            <li>
 
                                <a href="{{ route('InboxSchoolDistrict') }}">
                                    <img src="{{ asset('img/maintenance-icon.svg') }}" class="img-fluid" alt="">
                                    <span style="">View School Request</span>
                                   
                                </a>
                            </li>
                            @endif


                            @can('manage_quote_list')
                            <li>
                                <a href="{{ route('qu.index') }}">
                                    <i class="fas fa-dollar-sign" style="font-size:20px; color: green" ></i>
                                    <span style="margin-left:-7px">Request Funds</span>
                                </a>
                            </li>
                            @endcan

                    
                  
                            @if (Auth::user()->getOrganization->id == 1)

                            @canany(['district-list', 'school-list', 'cmc-list',
                            'circuit-list', 'subplace-list', 'category-list', 'item-list'])
                            <li>
                                <a href="#">
                                    <img src="{{ asset('img/maintenance-icon.svg') }}" class="img-fluid" alt="">
                                    <span>maintenance</span>
                                    <em class="ri-arrow-down-s-fill"></em>
                                </a>
                                <ul>
                                    @canany(['district-list', 'school-list', 'cmc-list',
                                    'circuit-list', 'subplace-list'])
                                    <li>
                                        <a href="{{ route('school-maintenance') }}">
                                            <img src="{{ asset('img/school-icon.svg') }}" class="img-fluid" alt="">
                                            <span> school</span>
                                        </a>
                                    </li>
                                    @endcanany
                                    @canany(['category-list', 'item-list'])
                                    <li><a href="{{ route('stock-maintenance') }}">
                                            <img src="{{ asset('img/stocks-icon.svg') }}" class="img-fluid" alt="">
                                            <span>Catalogue</span>
                                        </a></li>
                                    @endcanany

                                </ul>
                            </li>
                            @endcanany
                            @can('user-list')
                            <li>
                                <a href="{{ route('users.index') }}">
                                    <img src="{{ asset('img/manage-users.svg') }}" class="img-fluid" alt="">
                                    <span> manage users</span>
                                </a>
                            </li>
                            @endcan

                            @endif

                            @can('report-list')
                            <li>
                                <a href="/reports">
                                    <img src="{{ asset('img/Reports.svg') }}" class="img-fluid" alt="">
                                    <span> Reports</span>
                                </a>
                            </li>
                            @endcan
                            <li>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <img src="{{ asset('img/signout-icon.svg') }}" class="img-fluid" alt="">
                                    <span> {{ __('Logout') }}</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Js Files -->

    <script src="{{ asset('vendor/jQuery/jquery.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('vendor/uploader/image-uploader.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/Nice-Select/js/nice-select2.js') }}"></script>
    <script src="{{ asset('vendor/highcharts/highchart.js') }}"></script>
    <script src="{{ asset('vendor/highcharts/heatmap.js') }}"></script>
    <script src="{{ asset('vendor/highcharts/treemap.js') }}"></script>
    <script src="{{ asset('vendor/highcharts/exporting.js') }}"></script>
    <script src="{{ asset('vendor/highcharts/export-data.js') }}"></script>
    <script src="{{ asset('vendor/highcharts/accessibility.js') }}"></script>

    @yield("foot-script")
    <script>
        $('.input-images').imageUploader();
        // $(document).ready(function () {
        //     $('input[type="file"]').imageuploadify();
        // })
        // 
    </script>

    <script>
        NiceSelect.bind(document.getElementById("furniture-category"));
    </script>
    @yield('dash-script')

</body>

</html>