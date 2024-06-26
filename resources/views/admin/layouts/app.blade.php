<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ websiteInfo()->isNotEmpty() ? ucfirst(websiteInfo()->first()->name) : 'Admin' }} :: Administrative Panel</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/adminlte.min.css')}}">

    <link rel="stylesheet" href="{{asset('admin-assets/plugins/dropzone/min/dropzone.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/summernote/summernote.min.css')}}">

    <link rel="stylesheet" href="{{asset('admin-assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/css/datetimepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- Icon for browser tab -->
    <link rel="icon" type="image/png" href="{{ websiteInfo()->isNotEmpty() && websiteInfo()->first()->logo ? asset('logo/' . websiteInfo()->first()->logo) : asset('logo/d_logo.png') }}">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Right navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <div class="navbar-nav pl-2">
            <!-- <ol class="breadcrumb p-0 m-0 bg-white">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol> -->
        </div>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
                    <img src="{{asset('admin-assets/img/avatar5.png')}}" class='img-circle elevation-2' width="40" height="40" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                    <h4 class="h4 mb-0"><strong>{{Auth::guard('admin')->user()->name}}</strong></h4>
                    <div class="mb-3">{{Auth::guard('admin')->user()->email}}</div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-cog mr-2"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('admin.showChangePassword')}}" class="dropdown-item">
                        <i class="fas fa-lock mr-2"></i> Change Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('admin.logout')}}" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    @include('admin.layouts.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
            @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; {{ websiteInfo()->isNotEmpty() ? ucfirst(websiteInfo()->first()->name) : 'Company Name' }} 2024 </strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>{{ websiteInfo()->isNotEmpty() ? ucfirst(websiteInfo()->first()->quote) : 'Company Quotes' }}</b>
        </div>
    </footer>

</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->

<script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/summernote/summernote.min.js')}}"></script>

<script src="{{asset('admin-assets/plugins/dropzone/min/dropzone.min.js')}}"></script>


<script src="{{ asset('admin-assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/datetimepicker.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin-assets/js/demo.js')}}"></script>
@yield('customJs')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 250
        });
    });
    $(document).ready(function() {
        // Check for flashed session message and show Toastr notification
        @if(session()->has('success'))
        toastr.success('{{ session('success') }}');
        @elseif(session()->has('error'))
        toastr.error('{{ session('error') }}');
        @endif
    });
</script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this Data!",
            icon: "warning",
            showCancelButton: true, // Show cancel button
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel", // Text for the cancel button
            closeOnConfirm: false,
            closeOnCancel: true
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                // Submit the form
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

</body>
</html>
