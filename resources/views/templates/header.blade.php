<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content="PT. Mensa Bina Sukses" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DMS V.2021 3.0.1 | @yield('title')</title>
    <link id='page_favicon' href="{{asset('assets/dist/img/mbs_logo.ico')}}" rel='icon' type='image/x-icon' />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Toast style -->
    {{-- <link rel="stylesheet" href="{{asset('assets/dist/css/toastr.min.css')}}"> --}}
    {{-- Toaster --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        #s2id_element_id .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            color: rgba(51, 51, 51, 1) ;
        }
        .dataTables_processing{
            position: absolute;
            top: 10%;
            left: 50%;
            background-color: rgba(0,0,0, .6);
            padding: 20px;
            padding-bottom: 10px !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
