

<?php $__env->startSection('content'); ?>
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="h3 mb-0 text-gray-800">Students Module</h3>
                        <a href="<?php echo e(route('qr.index')); ?>" class="d-none d-sm-inline-block btn btn-sm bg-gradient-primary shadow-sm"><i
                                class="fa fa-qrcode fa-sm text-white-50"></i> Scan QR</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Left: Student Logins Table -->
                        <div class="col-lg-10">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-gradient-primary">Student Logins</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Action :</div>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" data-toggle="modal" href="#" data-target="#addlogin">Add Entry</a>                                                                          
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student Number</th>
                                                    <th>Full Name</th>
                                                    <th>Date</th>
                                                    <th>Time In</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e(($student->student != Null) ? $student->student->stu_no : 'N/A'); ?></td>
                                                    <td>
                                                        <?php echo e(($student->student != Null) ? $student->student->fname : 'N/A'); ?> 
                                                        <?php echo e(($student->student != Null) ? $student->student->lname : 'N/A'); ?> 
                                                    </td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($student->login_time)->format('F j, Y')); ?></td>
                                                    <td>
                                                        <?php echo e(\Carbon\Carbon::parse($student->login_time)->timezone('Singapore')->format('h:i A')); ?>

                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Blinking Date/Time Card -->
                        <div class="col-lg-2">
                           <div class="card shadow mb-4 ml-0" style="width: 16rem;">
                                <!-- Bible Verse as "top image" -->
                                <div class="card-img-top bg-gradient-primary text-white p-2 text-italic" id="bibleVerse">
                                    Loading verse...
                                </div>

                                <div class="card-body text-center">
                                    <!-- Current Date -->
                                    <h6 class="font-weight-bold">Current Date</h6>
                                    <h5 class="text-primary font-weight-bold blinking mb-3" id="currentDate">
                                        <?php echo e(\Carbon\Carbon::now()->format('F d, Y')); ?>

                                    </h5>

                                    <!-- Current Time -->
                                    <h6 class="font-weight-bold">Current Time</h6>
                                    <h5 class="text-success font-weight-bold blinking" id="currentTime">
                                        <?php echo e(\Carbon\Carbon::now()->timezone('Singapore')->format('H:i:s A')); ?>

                                    </h5>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Add login manual Modal -->
                        <div class="modal fade" id="addlogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-gradient-primary">
                                        <h5 class="modal-title" id="exampleModalLabel">Log In</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo e(route('student-login.store')); ?>" method="POST" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row mb-3">
                                                <label for="studentId" class="col-sm-3 col-form-label">Student No.:</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="studentId" name="students_id">
                                                        <?php $__currentLoopData = $slist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($student->id); ?>"><?php echo e($student->lname); ?>, <?php echo e($student->fname); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="login_time" class="col-sm-3 col-form-label">Time</label>
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" class="form-control" id="login_time" name="login_time">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
    
                        <!-- QR Modal -->
                        <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="qrModalLabel">Student QR Code</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <div class="d-flex justify-content-center">
                                            <div id="qrCodeLarge"></div> <!-- QR code will be generated here -->
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <h2 class="mt-2">Scan your Code</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div><!-- /.container-fluid -->
                </div><!-- End of Main Content -->
            </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // QR Code Generation when Modal is Shown
            $('#qrModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Get the button that triggered the modal
                var stuNo = button.data('stu-no');  // Get student number

                if (!stuNo) {
                    console.error("Student number is missing!");
                    return;
                }

                // Generate dynamic route for the QR code
                var qrCodeUrl = "<?php echo e(route('student.login', ['stu_no' => '__STUNO__'])); ?>".replace('__STUNO__', stuNo);

                console.log("QR Code URL:", qrCodeUrl);  // Debugging

                // Clear previous QR code before generating a new one
                $('#qrCodeLarge').empty();

                // Generate new QR code dynamically
                new QRCode(document.getElementById("qrCodeLarge"), {
                    text: qrCodeUrl,
                    width: 250,
                    height: 250
                });
            });
        });

        //QR Scanning Attendance
        function onScanSuccess(decodedText, decodedResult) {
            console.log("Scanned Data:", decodedText);

            // Assuming the QR code contains only students_id
            let studentsId = decodedText.trim();

            document.getElementById('scanned-id').innerText = studentsId;

            // Send the students_id to the backend
            fetch("<?php echo e(route('process.qr')); ?>", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ students_id: decodedText })
            })

            .then(response => response.json())
            .then(data => {
                console.log("Server Response:", data); // Debugging
                if (data.success) {
                    alert("Login recorded successfully!");
                } else {
                    alert("Error: " + (data.error || "Unknown error occurred"));
                }
            })
            .catch(error => console.error("Fetch Error:", error));

        }

    </script> 
<?php $__env->stopSection(); ?>









<?php echo $__env->make('scripts.books', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views/students/student_logins.blade.php ENDPATH**/ ?>