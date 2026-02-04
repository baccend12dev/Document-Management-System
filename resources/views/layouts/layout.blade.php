<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('Template/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('Template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('Template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('Template/plugins/select2/css/select2.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('Template/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('Template/dist/css/adminlte.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <style>
    input[readonly] {
        background-color: #f0f0f0;
        /* ubah warna latar belakang */
        color: #555;
        /* ubah warna teks */
        border: 1px solid #ccc;
        /* opsional: ubah border */
    }
    </style>
    <title>QA - KKV</title>
    <link rel="icon" type="image/png" href="{{ asset('Template/dist/img/logo-otto.png') }}">
    <link rel="shortcut icon" href="{{ asset('Template/dist/img/logo-otto.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('Template/dist/img/logo-otto.png') }}">
    @yield('styles')
    @stack('styles')
</head>

<!-- <body class="hold-transition sidebar-mini layout-fixed"> -->
    <body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <!-- Navbar -->
        <!-- <header class="main-header" style=" top: 0; z-index: 1030;">
            <img src="{{ asset('Template/dist/img/headeredit.jpg') }}" class="img-fluid w-100" alt="Header Image">
        </header> -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#contactModal">Contact</a>
                </li>
            </ul>
            @if (Auth::check())
            
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ auth()->user()->photo ? asset(auth()->user()->photo)  : asset('Template/dist/img/avatar5.png') }}"
                            class="user-image img-circle elevation-2" alt="User Image"
                            style="width: 33px; height: 33px; object-fit: cover;">
                        <span class="d-none d-md-inline"><b>{{ Auth::user()->username }}</b></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="{{ auth()->user()->photo ? asset(auth()->user()->photo)  : asset('Template/dist/img/avatar5.png') }}"
                                class="img-circle elevation-2" alt="User Image"
                                style="width: 90px; height: 90px; object-fit: cover;">
                            <p>
                                {{ Auth::user()->email }}
                                <small>{{ Auth::user()->role }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="/profile" class="btn btn-default btn-flat">Settings</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>

                            <a href="#" class="btn btn-default btn-flat float-right"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/dashboard" class="brand-link">
                <img src="{{ asset('Template/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">QA - KKV</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="/dashboard" 
                             class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}"
                             data-toggle="tooltip"
                                data-placement="right"
                                title="Dashboard">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @if(auth()->user()->role == 'supervisor' || auth()->user()->role == 'admin')
                        <li class="nav-item has-treeview {{ request()->is('tools-registration*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('tools-registration*') ? 'active' : '' }}" 
                               data-toggle="tooltip" data-placement="right" title="Tools Registration">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Tools/Product Registration
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/tools-registration/equipment" class="nav-link {{ request()->is('tools-registration/equipment*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Equipment Qualification</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/tools-registration/utility" class="nav-link {{ request()->is('tools-registration/utility*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Utility Qualification</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/tools-registration/room" class="nav-link {{ request()->is('tools-registration/room*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Room Qualification</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/tools-registration/computer" class="nav-link {{ request()->is('tools-registration/computer*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Computerize System</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/tools-registration/process-mediafill" class="nav-link {{ request()->is('tools-registration/process-mediafill*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Process & Mediafill</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/tools-registration/cleaning" class="nav-link {{ request()->is('tools-registration/cleaning*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cleaning Validation</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/tools-registration/analytical-method" class="nav-link {{ request()->is('tools-registration/analytical-method*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Analytical Method</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <!-- Document Registration -->
                        @if(auth()->user()->role == 'technician' || auth()->user()->role == 'admin' || auth()->user()->role == 'supervisor')
                        <li class="nav-item">
                            <a href="/document-registration"
                            class="nav-link {{ request()->is('document-registration*') ? 'active' : '' }}"
                            data-toggle="tooltip"
                            data-placement="right"
                            title="Tools Registration">
                                <i class="nav-icon fas fa-file"></i>
                                <p>Document Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/masterlist-documents" 
                            class="nav-link {{ request()->is('masterlist-documents*') ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="right"
                                title="Kelola Alat">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Document MasterList</p>
                            </a>
                        </li>
                        <!-- Report Menu -->
                        <li class="nav-item has-treeview {{ request()->is('report-by-tools*', 'report-by-document*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('report-by-tools*', 'report-by-document*') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Reports">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Report
                                    <!-- <i class="right fas fa-angle-left"></i> -->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/report-by-tools" class="nav-link {{ request()->is('report-by-tools*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Report by Tools</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/report-by-document" class="nav-link {{ request()->is('report-by-document*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Report by Document</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/documents/scedule" 
                            class="nav-link {{request()->is('documents/scedule') ? 'active' : ''}} " data-toggle="tooltip" data-placement="right"
                                title="Kelola Alat">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Jadwal Qualifikasi</p>
                            </a>
                        </li>
                    @endif
                    <!-- admin menu user managament -->
                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'supervisor')
                        <li class="nav-item">
                                <a href="/usersmanagement" 
                                class="nav-link {{request()->is('usersmanagement') ? 'active' : ''}} " data-toggle="tooltip" data-placement="right"
                                    title="Kelola Alat">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>User Management</p>
                                </a>
                            </li>
                        <li class="nav-item">
                                <a href="/audit-trail" 
                                class="nav-link {{request()->is('audit-trail') ? 'active' : ''}} " data-toggle="tooltip" data-placement="right"
                                    title="Kelola Alat">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>Audit Trail </p>
                                </a>
                        </li>
                        <li class="nav-item">
                                <a href="/admin/list-pic" 
                                class="nav-link {{request()->is('admin/list-pic') ? 'active' : ''}} " data-toggle="tooltip" data-placement="right"
                                    title="Kelola Alat">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>List PIC</p>
                                </a>
                            </li>

                        @endif
                    </ul>
                </nav>
                @endif
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">

                <div class="container-fluid">
                    @if(request()->is('/', 'dashboard', 'home'))
                    <div class="col-12">
                        <img src="{{ asset('Template/dist/img/dashboard.jpg') }}" class="img-fluid w-100"
                            alt="Dashboard Image">
                    </div>
                    @endif
                    @yield('content')
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>

        <!-- //modal contact -->
        <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contactModalLabel">Contact Us</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <h1>Ada Masalah dengan Program?</h1>
                            <div class="contact-box">
                                Silakan hubungi Administrator IT melalui email berikut:<br />
                                <a href="mailto:karyadi.simamora@ottopharm.com" class="email">karyadi.simamora@ottopharm.com</a><br /><br />
                                Terima kasih.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <footer>
            <div class="container-fluid">
                <div class="row">
                    <div class="col text-center">
                        <p>&copy; 2025 OTTO Portal. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- jQuery -->
        <script src="{{ asset('Template/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('Template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('Template/dist/js/adminlte.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('Template/plugins/select2/js/select2.full.min.js') }}"></script>
        <!-- DataTables  & Plugins -->
        <script src="{{ asset('Template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('Template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('Template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('Template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('Template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('Template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('Template/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('Template/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('Template/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('Template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('Template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('Template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

        <!-- swift alert 2 -->
        <!-- CDN SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        //Initialize Select2 Elements
        $(document).ready(function() {
            $('.select2').select2(); // Pastikan class 'select2' ada di kedua <select>
        });
        </script>
        @if(Session::has('success'))
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '{{ Session::get("success") }}',
            confirmButtonColor: '#3085d6',
        });
        </script>
        @endif

        @if(Session::has('error'))
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ Session::get("error") }}',
            confirmButtonColor: '#d33',
        });
        </script>
        @endif


        <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
        </script>
<script>
function navigateToSubMenu(subMenu) {
    if (subMenu) {
        window.location.href = `/tools-registration/${subMenu}`;
    }
}
</script>


         @stack('scripts')
        @yield('scripts')
</body>

</html>