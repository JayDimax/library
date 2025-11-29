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
    <style>
        /* Floating Chat Icon */
        .chat-floating-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #007bff;
            color: white;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            cursor: pointer;
            z-index: 1051;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .chat-floating-btn:hover {
            background: #0056b3;
            transform: scale(1.1);
        }

        /* Chatbox */
        .chatbox-wrapper {
            position: fixed;
            bottom: 110px;  /* sits right above the button */
            right: 25px;
            width: 340px;
            height: 460px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            z-index: 1050;
            opacity: 0;
            pointer-events: none;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .chatbox-wrapper.active {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }
    </style>


</head>

<body id="page-top ">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-text mx-3">Library <sup>Management System</sup></div>
            </a>

            <hr class="sidebar-divider my-0">


            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('librarian.dashboard')); ?>">
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
                                <a class="dropdown-item" href="<?php echo e(route('profile.index')); ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>

                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a> -->
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

        function updateClock() {
            const now = new Date();
            const optionsDate = { month: 'long', day: '2-digit', year: 'numeric' };
            const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true, timeZone: 'Asia/Singapore' };

            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', optionsDate);
            document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', optionsTime);
        }

        // Update every second
        setInterval(updateClock, 1000);
        updateClock();

        async function fetchVerseOfTheDay() {
            try {
                const response = await fetch('https://beta.ourmanna.com/api/v1/get/?format=json');
                const data = await response.json();
                const verse = data.verse.details.text;
                const reference = data.verse.details.reference;

                document.getElementById('bibleVerse').textContent = `${verse} – ${reference}`;
            } catch (error) {
                console.error('Failed to fetch verse:', error);
                document.getElementById('bibleVerse').textContent = "Unable to load verse.";
            }
        }

        // Initial load
        fetchVerseOfTheDay();

        // Optionally refresh verse daily (86400000 ms = 24 hours)
        setInterval(fetchVerseOfTheDay, 86400000);

        // Optional: Update time every second
        function updateTime() {
            const now = new Date();
            const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
            document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', options);
            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>

    <!-- Messenger -->
    <script>
        const chatBox = document.getElementById('chatbox');
        const toggleBtn = document.getElementById('toggleChatbox');
        const chatMessages = document.getElementById('chatMessages');
        const chatForm = document.getElementById('chatForm');
        const chatInput = document.getElementById('chatInput');

        // Toggle minimize (entire chatbox)
        toggleBtn.addEventListener('click', () => {
            if (chatBox.classList.contains('minimized')) {
                // Restore
                chatBox.style.height = '450px';
                chatMessages.style.display = 'block';
                chatForm.style.display = 'flex';
                toggleBtn.innerHTML = '<i class="fas fa-minus"></i>';
                chatBox.classList.remove('minimized');
            } else {
                // Minimize
                chatBox.style.height = '45px';
                chatMessages.style.display = 'none';
                chatForm.style.display = 'none';
                toggleBtn.innerHTML = '<i class="fas fa-plus"></i>';
                chatBox.classList.add('minimized');
            }
        });

        // Load messages
        function loadMessages() {
            fetch('/librarian/messages')
                .then(response => response.json())
                .then(messages => {
                    chatMessages.innerHTML = '';
                    messages.forEach(msg => {
                        const div = document.createElement('div');

                        // Admin messages styling
                        const isCurrentUser = msg.user_id === <?php echo e(Auth::id()); ?>;
                        const isAdmin = msg.user_name.toLowerCase().includes('admin');

                        div.className = `mb-1 p-1 rounded ${
                            isCurrentUser
                                ? 'text-end'
                                : 'text-start'
                        }`;

                        let bubbleStyle = '';
                        if (isAdmin) {
                            bubbleStyle = 'background: gold; color: black; font-weight: bold;';
                        } else if (isCurrentUser) {
                            bubbleStyle = 'background: #007bff; color: white;';
                        } else {
                            bubbleStyle = 'background: #f1f1f1; color: black;';
                        }

                        div.innerHTML = `
                            <div class="d-inline-block px-2 py-1 rounded" style="${bubbleStyle}">
                                <small><strong>${msg.user_name}</strong>: ${msg.message}</small>
                            </div>
                        `;

                        chatMessages.appendChild(div);
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                });
        }

        // Send message
        chatForm.addEventListener('submit', e => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            fetch('/librarian/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ message })
            }).then(() => {
                chatInput.value = '';
                loadMessages();
            });
        });

        // Auto-refresh every 5s
        setInterval(loadMessages, 5000);
        loadMessages();

        // Draggable chatbox
        (function() {
            const chatHeader = document.getElementById('chatHeader');
            let offsetX = 0, offsetY = 0;
            let isDragging = false;

            chatHeader.addEventListener('mousedown', (e) => {
                isDragging = true;
                offsetX = e.clientX - chatBox.offsetLeft;
                offsetY = e.clientY - chatBox.offsetTop;
                chatHeader.style.cursor = 'grabbing';
            });

            document.addEventListener('mouseup', () => {
                isDragging = false;
                chatHeader.style.cursor = 'move';
            });

            document.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                const x = e.clientX - offsetX;
                const y = e.clientY - offsetY;

                const maxX = window.innerWidth - chatBox.offsetWidth;
                const maxY = window.innerHeight - chatBox.offsetHeight;
                chatBox.style.left = `${Math.min(Math.max(x, 0), maxX)}px`;
                chatBox.style.top = `${Math.min(Math.max(y, 0), maxY)}px`;
                chatBox.style.right = 'auto';
            });
        })();
    </script>


    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html><?php /**PATH F:\laragon\www\library\resources\views/layouts/librarian.blade.php ENDPATH**/ ?>