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
    <title>Home | Furniture </title>
    <link rel="stylesheet" href="{{ asset('css/style.css?cb=1644833916086 ') }}" />
    <style>

    </style>
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
        <nav class="container navbar navbar-expand-lg ">
            <div class=" navbar-collapse d-flex justify-content-between border-bottom border-2 pb-3" id="navbarToggle">
                <ul class="navbar-nav left-nav align-items-center">
                    <div class="header-logo">
                        <a href="#">
                            <img class="img-fluid d-none d-lg-block " src="{{ asset('img/logo.png') }}" alt="">
                            <img class="img-fluid d-block d-lg-none" src="{{ asset('img/m-logo.png') }}" alt="">
                        </a>
                    </div>
                    <div class="header-line"></div>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                </ul>
                <ul class="navbar-nav right-nav">
                    <li class="nav-item siderbar-pop-btn" data-bs-toggle="modal" data-bs-target="#siderbarModal">
                        <a class="nav-link" href="#">
                            <i class="ri-menu-fill"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- main -->
    <main>

        <div class="container">
            <div class="row">
                @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-12 col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">YTD Statuses Count</h5>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Progress % from Collections</h5>

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card shadow-none">
                                <div class="card-body px-0">
                                    <h5 class="card-title">
                                        Pending Collections
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>School</th>
                                                    <th>Collected Counts</th>
                                                    <th>Date Created</th>
                                                    <th>Days in Waiting</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-nowrap text-decoration-underline mb-0">St Pauls
                                                            High School
                                                        </a>
                                                    </td>
                                                    <td>18</td>
                                                    <td>2021/05/1</td>
                                                    <td>174</td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-nowrap text-decoration-underline mb-0">St Pauls
                                                            High School
                                                        </a>
                                                    </td>
                                                    <td>18</td>
                                                    <td>2021/05/1</td>
                                                    <td>174</td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-nowrap text-decoration-underline mb-0">St Pauls
                                                            High School
                                                        </a>
                                                    </td>
                                                    <td>18</td>
                                                    <td>2021/05/1</td>
                                                    <td>174</td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-nowrap text-decoration-underline mb-0">St Pauls
                                                            High School
                                                        </a>
                                                    </td>
                                                    <td>18</td>
                                                    <td>2021/05/1</td>
                                                    <td>174</td>

                                                </tr>



                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="dashboard-card warning">
                                <p class="mb-0">Pending Collections - 360</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="dashboard-card success">
                                <p class="mb-0">Total Deliveries - 77</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="dashboard-card danger">
                                <p class="mb-0">Pending Repairs - 700</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="dashboard-card primary">
                                <p class="mb-0">Pending Deliveries - 32</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dashboard-card info">
                                <p class="mb-0">Pending Replenishments - 32</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Previous Year Statuses</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
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
                                <a href="#">
                                    <span> dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span> search</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span> furniture replacement</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>maintenance</span>
                                    <em class="ri-arrow-down-s-fill"></em>
                                </a>
                                <ul>
                                    <li><a href="#">school </a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{route('users.index')}}">
                                    <span> manage users</span>
                                </a>
                            </li>
                            <li>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
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
    
</body>

</html>