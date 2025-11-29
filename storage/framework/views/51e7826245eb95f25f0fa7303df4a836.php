
<?php $__env->startSection('content'); ?>
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="h3 mb-0 text-gray-600">Students Module</h3>
                    </div>

                    <!-- Content Row -->
                    <div class="row ">
                        <!-- Student Tables -->
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-gradient-primary">List of Registered Students</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Action :</div>
                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#addStudent">Register</a>                                                                       
                                            <!-- <a class="dropdown-item" data-toggle="modal" href="#" data-target="#uploadStudent">Upload Student</a>                                                                           -->
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>HCCD Branch</th>
                                                    <th>Student No.</th>
                                                    <th>Full Name</th>
                                                    <th>Grade Level</th>
                                                    <th>Contact Number</th>
                                                    <th>QR Code</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e($student->branch?->name ?? 'N/A'); ?></td>
                                                    <td><?php echo e($student->stu_no); ?></td>
                                                    <td><?php echo e($student->lname); ?>, <?php echo e($student->fname); ?></td>
                                                    <td><?php echo e($student->gradeLevel?->name ?? 'N/A'); ?></td>
                                                    <td><?php echo e($student->phone); ?></td>
                                                    <td>
                                                        <a href="#" class="qr-code-btn" 
                                                            data-student-id="<?php echo e($student->id); ?>" 
                                                            data-student-name="<?php echo e($student->lname); ?>, <?php echo e($student->fname); ?>" 
                                                            data-toggle="modal" data-target="#qrModal">
                                                            <i class="fa fa-qrcode"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-gradient-primary" data-toggle="modal" data-target="#editModal<?php echo e($student->id); ?>"><i class="fas fa-pen"></i></a>
                                                        <?php
                                                            $user = Auth::user();
                                                        ?>

                                                        <?php if($user->role === 'admin'): ?>
                                                            <form action="<?php echo e(route('student.destroy', $student->id)); ?>" method="POST" style="display:inline;">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit" class="btn btn-sm btn-gradient-danger"
                                                                        onclick="return confirm('Are you sure you want to delete this student?');">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                       
                    </div><!-- /.container-fluid -->
                </div><!-- End of Main Content -->
            </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        //QR Code Generation
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".qr-code-btn").forEach(button => {
                    button.addEventListener("click", function () {
                        let studentName = this.getAttribute("data-student-name");
                        let studentId = this.getAttribute("data-student-id");

                        // Update modal content
                        document.getElementById("studentName").innerText = studentName;

                        // Clear previous QR Code before generating a new one
                        document.getElementById("qrCodeLarge").innerHTML = "";

                        // Generate QR Code dynamically
                        new QRCode(document.getElementById("qrCodeLarge"), {
                            text: JSON.stringify({ students_id: studentId }),
                            width: 200,
                            height: 200
                        });
                    });
                });
            });

        //QR Scanning Attendance
        //     document.addEventListener("DOMContentLoaded", function () {
        //         function onScanSuccess(decodedText) {
        //             fetch('/process-qr', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Include CSRF token if needed
        //             },
        //             body: JSON.stringify({
        //                 students_id: scannedQRValue // Ensure this is just "13" and NOT {"students_id": "13"}
        //             })
        //         })
        //         .then(response => response.json())
        //         .then(data => console.log(data))
        //         .catch(error => console.error('Error:', error));
        //         }

        //     let scanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
        //     scanner.render(onScanSuccess);
        // });
        
    </script>
    <?php $__env->startPush('scripts'); ?>
         <?php echo $__env->make('scripts.books', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('modals'); ?>
<!-- Add Student Modal -->
    <div class="modal fade" id="addStudent" tabindex="-1" role="dialog" aria-labelledby="addStudentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="addStudentLabel">Add Student | Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?php echo e(route('student.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="stu_no" class="col-sm-3 col-form-label">Student | Employee No.:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="stu_no" name="stu_no" value="<?php echo e(old('stu_no')); ?>">
                                <?php $__errorArgs = ['stu_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 col-form-label">First Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo e(old('fname')); ?>">
                                <?php $__errorArgs = ['fname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lname" class="col-sm-3 col-form-label">Last Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo e(old('lname')); ?>">
                                <?php $__errorArgs = ['lname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email:</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-sm-3 col-form-label">Contact No.:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo e(old('phone')); ?>">
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">Address:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo e(old('address')); ?>">
                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="glevel" class="col-sm-3 col-form-label">Grade Level | Position:</label>
                            <div class="col-sm-9">
                                <select name="grade_level_id" id="grade_level_id" class="form-control" required>
                                    <option value="">-- Select Grade Level --</option>
                                    <?php $__currentLoopData = $gradeLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($level->id); ?>" 
                                            <?php echo e(old('grade_level_id', $student->grade_level_id ?? '') == $level->id ? 'selected' : ''); ?>>
                                            <?php echo e($level->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <!-- Branch select -->
                        <?php $user = auth()->user(); ?>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">HCCD Branch:</label>
                            <div class="col-sm-9">
                                <?php if($user->role === 'admin'): ?>
                                    <select name="branches_id" class="form-control" required>
                                        <option value="">-- Select --</option>
                                        <?php $__currentLoopData = $branches->where('id', '!=', 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($branch->id); ?>" <?php echo e(old('branches_id') == $branch->id ? 'selected' : ''); ?>>
                                                <?php echo e($branch->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['branches_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <?php else: ?>
                                    <input type="hidden" name="branches_id" value="<?php echo e($user->branches_id); ?>">
                                    <input type="text" class="form-control" value="<?php echo e(optional($branches->firstWhere('id', $user->branches_id))->name); ?>" disabled>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn bg-gradient-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- -- Edit student Modal -- -->
    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editModal<?php echo e($student->id); ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo e($student->id); ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title" id="editModalLabel<?php echo e($student->id); ?>">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('student.update', $student->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <div class="row mb-3">
                            <label for="stu_no<?php echo e($student->id); ?>" class="col-sm-3 col-form-label mb-2">Student No.:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="stu_no<?php echo e($student->id); ?>" name="stu_no" value="<?php echo e($student->stu_no); ?>">
                            </div>

                        <label for="branches_id<?php echo e($student->id); ?>" class="col-sm-3 col-form-label">Branch:</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="branches_id<?php echo e($student->id); ?>" name="branches_id" required>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>" <?php echo e($branch->id == $student->branches_id ? 'selected' : ''); ?>>
                                        <?php echo e($branch->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        </div>
                        <div class="row mb-3">
                            <label for="fname<?php echo e($student->id); ?>" class="col-sm-3 col-form-label">First Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="fname<?php echo e($student->id); ?>" name="fname" value="<?php echo e($student->fname); ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lname<?php echo e($student->id); ?>" class="col-sm-3 col-form-label">Last Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="lname<?php echo e($student->id); ?>" name="lname" value="<?php echo e($student->lname); ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="grade_level_id<?php echo e($student->id); ?>" class="col-sm-4 col-form-label text-sm-end">Grade Level:</label>
                            <div class="col-sm-9">
                                <select name="grade_level_id" id="grade_level_id<?php echo e($student->id); ?>" class="form-control" required>
                                    <option value="">-- Select Grade Level --</option>
                                    <?php $__currentLoopData = $gradeLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($level->id); ?>" 
                                            <?php echo e(old('grade_level_id', $student->grade_level_id ?? '') == $level->id ? 'selected' : ''); ?>>
                                            <?php echo e($level->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address<?php echo e($student->id); ?>" class="col-sm-3 col-form-label">Address:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address<?php echo e($student->id); ?>" name="address" value="<?php echo e($student->address); ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email<?php echo e($student->id); ?>" class="col-sm-3 col-form-label">Email Add:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email<?php echo e($student->id); ?>" name="email" value="<?php echo e($student->email); ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone<?php echo e($student->id); ?>" class="col-sm-3 col-form-label">Contact No.:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phone<?php echo e($student->id); ?>" name="phone" value="<?php echo e($student->phone); ?>">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn bg-gradient-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- Add login manual Modal -->
    <div class="modal fade" id="addlogin" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title" id="loginModalLabel">Log In</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('student-login.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row mb-3">
                            <label for="stu_no" class="col-sm-3 col-form-label">Student No.:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="student_id" name="students_id">
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($student->id); ?>"><?php echo e($student->lname); ?>,<?php echo e($student->fname); ?></option>
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
                    <button type="submit" class="btn btn-gradient-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Batch Student Upload -->
    <div class="modal fade" id="uploadStudent" tabindex="-1" aria-labelledby="batchUploadLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="batchUploadLabel">
                        <i class="fas fa-upload"></i> Upload Students
                    </h5>
                    <!-- <button type="button" class="btn-close text-white" data-dismiss="modal" aria-label="Close"></button> -->
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="<?php echo e(route('student.batchUpload')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-4">
                            <label for="book_file" class="form-label fw-bold">
                                <i class="fas fa-file-csv"></i> Select a CSV file
                            </label>
                            <input type="file" class="form-control form-control-lg" id="book_file" name="book_file" accept=".csv" required>
                            <small class="text-muted">Only CSV files are allowed. Ensure correct formatting.</small>
                        </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-cloud-upload-alt"></i> Upload
                    </button>
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
                    <h4 id="studentName"></h4> <!-- Display student name -->
                    <div class="d-flex justify-content-center">
                        <div id="qrCodeLarge"></div> <!-- QR Code will be injected here -->
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <h2 class="mt-2">Scan your Code</h2>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopPush(); ?>










<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views/students/index.blade.php ENDPATH**/ ?>