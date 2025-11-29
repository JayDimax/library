<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Library Management System - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo e(asset('vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js')); ?>"></script>
    <script src="<?php echo e(asset('https://unpkg.com/html5-qrcode')); ?>" type="text/javascript"></script>

    <!-- Custom styles for this template-->
    <link href="<?php echo e(asset('css/sb-admin-2.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('//cdn.datatables.net/2.2.2/js/dataTables.min.js')); ?>">
    <link href="<?php echo e(asset('vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css')); ?>" rel="stylesheet" />
 
    <!-- Include SweetAlert2 CSS and JS -->
    <script src="<?php echo e(asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')); ?>"></script>
    <script src="<?php echo e(asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js')); ?>"></script>
    <script>src="<?php echo e(asset('https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap4.min.js')); ?>"</script>
        <!-- Select2 CSS -->
    <link href="<?php echo e(asset('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css')); ?>" rel="stylesheet" />

    <link href="<?php echo e(asset('css/bootstrap_custom_sidebar.css')); ?>" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"> <!-- Laravel CSRF Token -->
</head>

<body id="page-top ">
    <?php
        $user = Auth::user();
        $isAdmin = ($user->role === 'admin') || ($user->branches_id == 4);  // ✅ branch_id 4 = admin
        $branchId = $user->branches_id;
        $branchName = match($branchId) {
            1 => 'Kalayaan Branch',
            2 => 'GM Branch',
            3 => 'Trinity Branch',
            4 => 'Administrator',
            default => 'Library Branch',
        };
    ?>


    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-text mx-3">Library <sup>Management System</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Dashboard -->
            <?php
                $routes = [
                    1 => 'librarian.kalayaan.dashboard',
                    2 => 'librarian.gm.dashboard',
                    3 => 'librarian.trinity.dashboard',
                    4 => 'admin.dashboard',
                ];
                $dashboardRoute = $routes[$branchId] ?? 'librarian.dashboard';
            ?>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route($dashboardRoute)); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Books Section -->
            <div class="sidebar-heading">Books</div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseT"
                    aria-expanded="true" aria-controls="collapseT">
                    <i class="fas fa-fw fa-bookmark"></i>
                    <span>Books Module</span>
                </a>
                <div id="collapseT" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Books Section</h6>
                        <a class="collapse-item" href="<?php echo e(route('book.index')); ?>">List of Books</a>
                        <a class="collapse-item" href="<?php echo e(route('type.index')); ?>">Types of Material</a>
                        <a class="collapse-item" href="<?php echo e(route('section.index')); ?>">Library Section</a>
                    </div>
                </div>
            </li>

            <!-- Branch Section -->
            <?php if(auth()->check() && auth()->user()->branches_id == 4): ?>
                <div class="sidebar-heading">Branches</div>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTT"
                        aria-expanded="true" aria-controls="collapseTT">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Branch Module</span>
                    </a>
                    <div id="collapseTT" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Branch Section</h6>
                            <a class="collapse-item" href="<?php echo e(route('branch.index')); ?>">List of Branches</a>
                        </div>
                    </div>
                </li>

                <div class="sidebar-heading">Librarian</div>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#librarianCollapse"
                        aria-expanded="true" aria-controls="librarianCollapse">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Librarian Module</span>
                    </a>
                    <div id="librarianCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Custom Librarian</h6>
                            <a class="collapse-item" href="<?php echo e(route('librarians.index')); ?>">List of Librarians</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>


            <!-- Students Section -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Students Module</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Students:</h6>
                        <a class="collapse-item" href="<?php echo e(route('student.index')); ?>">Students List</a>
                        <a class="collapse-item" href="<?php echo e(route('student-login.index')); ?>">Students Logins</a>
                        <a class="collapse-item" href="<?php echo e(route('qr.index')); ?>">Scan QR Code</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <!-- Transactions -->
            <div class="sidebar-heading">Transactions</div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Book Collections</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Collection Records:</h6>
                        <a class="collapse-item" href="<?php echo e(route('book-collection.index')); ?>">List of Borrowers</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <!-- Reports -->
            <div class="sidebar-heading">Downloadables</div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="true" aria-controls="collapseThree">
                    <i class="fa-regular fa-file-pdf"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseThree" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Report Records:</h6>
                        <a class="collapse-item" href="<?php echo e(route('report.index')); ?>">Cash Collections</a>
                        <a class="collapse-item" href="<?php echo e(route('report.books')); ?>">Total Books</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="<?php echo e(asset('img/hccd.png')); ?>" alt="logo">
                <p class="mt-0">Developer: JBD</p>
                <p class="mt-0">0955 2315 522</p>
            </div>

        </ul>


        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand-md navbar-dark navbar-gradient shadow-none mb-3 rounded-2">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Breadcrumbs -->
                    
                    
                    

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray medium"><?php echo e(Auth::user()->name); ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo e(asset('img/undraw_profile.svg')); ?>" style="height: 40px; width: 40px;">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <?php echo $__env->yieldContent('content'); ?>
                    <?php echo $__env->yieldPushContent('modals'); ?>
                    <?php echo $__env->yieldPushContent('scripts'); ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; JBD</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    
                    <!-- Logout Button -->
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn bg-gradient-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (must come first) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 4 (matches SB Admin 2) -->
    <script src="<?php echo e(asset('vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>

    <!-- Core plugin JavaScript -->
    <script src="<?php echo e(asset('vendor/jquery-easing/jquery.easing.min.js')); ?>"></script>

    <!-- SB Admin 2 scripts -->
    <script src="<?php echo e(asset('js/sb-admin-2.min.js')); ?>"></script>

    <!-- DataTables -->
    <script src="<?php echo e(asset('vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

    <!-- DataTables initialization -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html><?php /**PATH D:\laragon\www\library\resources\views/layouts/librarian.blade.php ENDPATH**/ ?>