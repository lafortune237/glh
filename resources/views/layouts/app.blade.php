<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>GLH | @yield('title')</title>

@section('css')
    <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="/assets/dist/css/custom.css">
        <link rel="stylesheet" href="/assets/css/custom.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
        <style>
            @yield('custom-css')

        </style>

@show
<!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light navbar-white">
        <div class="container">
            <a href="/" class="navbar-brand">
                <img src="@guest /assets/dist/img/GLHLOGO.png @endguest @auth {{Auth::user()->photo}} @endauth" alt="Logo GLH" class="brand-image img-circle elevation-3" style="opacity: .8">
            </a>
            <ul class="navbar-nav">

                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">@guest Mon compte @endguest @auth {{Auth::user()->full_name}} @endauth</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        @guest
                            <li><a href="{{route('login')}}" class="dropdown-item">Se connecter</a></li>
                            <li><a href="{{route('register')}}" class="dropdown-item">S'inscrire</a></li>
                        @endguest

                        @auth
                            <?php $hostels = Auth::user()->hostels;?>
                            <li><a href="{{route('users.reservations')}}" class="dropdown-item">Mes réservations</a></li>

                            @if($hostels->isEmpty())

                                <li><a href="{{route('hostels')}}" class="dropdown-item">Mes hôtels</a></li>

                            @else
                                <li class="dropdown-submenu dropdown-hover">
                                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Mes hôtels</a>
                                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                        <li><a href="{{route('hostels')}}" class="dropdown-item">Liste des hôtels</a></li>
                                        <li class="dropdown-divider"></li>

                                        @foreach($hostels as $hostel)
                                            <li class="dropdown-submenu">
                                                <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{$hostel->name}}</a>
                                                <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                                    <li><a href="{{route('hostels.show',['id'=>$hostel->id])}}" class="dropdown-item">Gérer</a></li>
                                                    <li class="dropdown-divider"></li>

                                                    @foreach($hostel->rooms as $room)
                                                        <li><a href="{{route('hostels.rooms.show',['hostel'=>$hostel->id,'room'=>$room->id])}}" class="dropdown-item">{{$room->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                    @endforeach
                                    <!-- End Level three -->
                                    </ul>
                                </li>

                            @endif

                            <li><a href="{{route('users.profile')}}" class="dropdown-item">Mom compte</a></li>


                            @if(Auth::user()->isAdmin())
                                <li class="dropdown-submenu dropdown-hover">
                                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Administration</a>
                                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">

                                        <li class="dropdown-submenu">
                                            <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hôtels</a>
                                            <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                                <li><a href="{{route('admin.hostels',['option'=>'waiting'])}}" class="dropdown-item">Hôtels en attente de vérification</a></li>
                                                <li class="dropdown-divider"></li>
                                                <li><a href="{{route('admin.hostels',['option'=>'verified'])}}" class="dropdown-item">Hôtels vérifiés</a></li>
                                            </ul>
                                        </li>

                                        <li class="dropdown-submenu">
                                            <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Utilisateurs</a>
                                            <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                                <li><a href="" class="dropdown-item">Liste des utilisateurs</a></li>
                                            </ul>
                                        </li>

                                        <li class="dropdown-submenu">
                                            <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Réservations</a>
                                            <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">

                                                <li><a href="" class="dropdown-item">Liste</a></li>
                                               {{-- <li class="dropdown-divider"></li>

                                                <li><a href="" class="dropdown-item">En cours</a></li>
                                                <li><a href="" class="dropdown-item">À venir</a></li>
                                                <li><a href="" class="dropdown-item">Terminées</a></li>--}}


                                            </ul>
                                        </li>
                                        <!-- End Level three -->
                                    </ul>
                                </li>
                            @endif

                            <li class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Déconnexion') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>

                    @endauth
                    <!-- End Level two -->
                    </ul>
                </li>

            </ul>

            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Accueil</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#0" class="nav-link">Contactez-nous</a>
                </li>

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#0" class="nav-link">Faq</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#0" class="nav-link">Aide</a>
                </li>

                <li class="nav-item d-none d-sm-inline-block shadow">
                    <a href="{{route('hostels.create')}}" class="nav-link btn btn-default font-weight-bolder btn-call-action">Ajouter un Hôtel</a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">


                <a href="/" class="nav-link brand-text font-weight-ligh" style="font-size: 25px">GLH</a>

            </ul>
        </div>


    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"> @yield('title')</h1>
                    </div><!-- /.col -->

                    @yield('form-search')

                    @section('breadcrumb')
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <?php
                                $i = 0;
                                $breadcrumbs = Request::segments();
                                $count_breadcrumbs = count($breadcrumbs)?>
                                @foreach($breadcrumbs as $segment)
                                    <?php
                                    $segments = "";

                                    $segments.= '/'.$segment;

                                    ?>

                                    <?php if($i == $count_breadcrumbs - 1){?>
                                    <li class="breadcrumb-item active"><a href="">{{$segment}}</a></li>

                                    <?php }else{ ?>

                                    <li class="breadcrumb-item"><a href="{{$segments}}">{{$segment}}</a></li>
                                    <?php } $i++?>

                                @endforeach
                            </ol>
                        </div><!-- /.col -->
                    @show
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->

        <div class="content">
            <div class="container">

                @yield('content')
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <input
            id="message_handler"
            type="hidden"

            @if(\Session::has('general_error'))
            value="{{\Session::get('general_error')}}"
            data-type="error"
            @endif

            @if(\Session::has('info'))
            value="{{\Session::get('info')}}"
            data-type="info"
            @endif

            @if(\Session::has('success'))
            value="{{\Session::get('success')}}"
            data-type="success"
            @endif
    >

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Gestion de location d'hôtels
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2019 <a href="/">GLH</a>.</strong> Tous droits réservés.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@section('js')
    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <script src="/assets/js/app.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
@show
</body>
</html>
