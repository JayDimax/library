

<?php $__env->startSection('content'); ?>
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="h3 mb-0 text-gray-800">Books Module</h3>
                        
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-gradient-primary">List of Books</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Action :</div>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#" data-bs-target="#addModal">Add Book</a>                                   
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#" data-bs-target="#batchUpload">Batch Upload</a>                                         
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
                                                    <th>Library Branch</th>
                                                    <th>Title</th>
                                                    <th>Author</th>
                                                    <th>Section</th>
                                                    <th>Publisher</th>
                                                    <th>Copies</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e($book->branch?->name ?? 'N/A'); ?></td>
                                                    <td><?php echo e($book->title); ?></td>
                                                    <td><?php echo e($book->author); ?></td>
                                                    <td><?php echo e($book->section?->name ?? 'Uncategorized'); ?></td>
                                                    <td><?php echo e($book->publisher); ?></td>
                                                    <td><?php echo e($book->copies); ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($book->id); ?>"><i class="fas fa-pen"></i></a>
                                                        <?php if(auth()->check() && auth()->user()->branches_id == 4): ?>
                                                            <form action="<?php echo e(route('book.destroy', $book->id)); ?>" method="POST" style="display:inline;"
                                                                onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit" class="btn btn-sm btn-gradient-primary">
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

                        <!-- Add Book Modal -->
                        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document"> <!-- Added modal-xl for extra width -->
                                <div class="modal-content">
                                    <div class="modal-header bg-gradient-primary text-white">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Entry</h5>
                                        <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo e(route('book.store')); ?>" method="POST" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row mb-3">
                                                <label for="book_code" class="col-sm-3 col-form-label">Book Code:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="book_code" name="book_code" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="call_no" class="col-sm-3 col-form-label">Call No.:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="call_no" name="call_no">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="accession_no" class="col-sm-3 col-form-label">Accession No:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="accession_no" name="accession_no">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="isbn_issn" class="col-sm-3 col-form-label">ISBN / ISSN:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="isbn_issn" name="isbn_issn">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="title" class="col-sm-3 col-form-label">Book Title:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="title" name="title">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="author" class="col-sm-3 col-form-label">Author:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="author" name="author">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="publisher" class="col-sm-3 col-form-label">Publisher:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="publisher" name="publisher">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="copyright" class="col-sm-3 col-form-label">Copyright:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="copyright" name="copyright">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="edition" class="col-sm-3 col-form-label">Edition:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edition" name="edition">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="no_pages" class="col-sm-3 col-form-label">No. of Pages:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="no_pages" name="no_pages">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="subjects" class="col-sm-3 col-form-label">Subjects:</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="subjects" name="subjects"></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="type" class="col-sm-3 col-form-label">Select Material Type:</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="type" name="types_id">
                                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="copies" class="col-sm-3 col-form-label">Copies:</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="copies" name="copies">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="section" class="col-sm-3 col-form-label">Select Library Section:</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="section" name="sections_id">
                                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($section->id); ?>"><?php echo e($section->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="section" class="col-sm-3 col-form-label">Select Branch</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="branch" name="branches_id">
                                                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Book Modal -->
                        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="modal fade" id="editModal<?php echo e($book->id); ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo e($book->id); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-gradient-primary text-white">
                                        <h5 class="modal-title" id="editModalLabel<?php echo e($book->id); ?>">Edit Book</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo e(route('book.update', $book->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>

                                            <div class="row mb-3">
                                                <label for="book_code" class="col-sm-3 col-form-label">Book Code:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="book_code" name="book_code" value="<?php echo e($book->book_code); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="call_no" class="col-sm-3 col-form-label">Call No.:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="call_no" name="call_no" value="<?php echo e($book->call_no); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="accession_no" class="col-sm-3 col-form-label">Accession No:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="accession_no" name="accession_no" value="<?php echo e($book->accession_no); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="isbn_issn" class="col-sm-3 col-form-label">ISBN / ISSN:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="isbn_issn" name="isbn_issn" value="<?php echo e($book->isbn_issn); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="title" class="col-sm-3 col-form-label">Book Title:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo e($book->title); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="author" class="col-sm-3 col-form-label">Author:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="author" name="author" value="<?php echo e($book->author); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="publisher" class="col-sm-3 col-form-label">Publisher:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo e($book->publisher); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="copyright" class="col-sm-3 col-form-label">Copyright:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="copyright" name="copyright" value="<?php echo e($book->copyright); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="edition" class="col-sm-3 col-form-label">Edition:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edition" name="edition" value="<?php echo e($book->edition); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="no_pages" class="col-sm-3 col-form-label">No. of Pages:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="no_pages" name="no_pages" value="<?php echo e($book->no_pages); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="subjects" class="col-sm-3 col-form-label">Subjects:</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="subjects" name="subjects"><?php echo e(old('subjects', $book->subjects)); ?></textarea>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="type" class="col-sm-3 col-form-label">Select Material Type:</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="type" name="types_id">
                                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($type->id); ?>" <?php echo e($book->types_id == $type->id ? 'selected' : ''); ?>>
                                                                <?php echo e($type->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="copies" class="col-sm-3 col-form-label">Copies:</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="copies" name="copies" value="<?php echo e($book->copies); ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="section" class="col-sm-3 col-form-label">Select Library Section:</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="section" name="sections_id">
                                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($section->id); ?>" <?php echo e($book->sections_id == $section->id ? 'selected' : ''); ?>>
                                                                <?php echo e($section->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="section" class="col-sm-3 col-form-label">Select Library Branch:</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="branch" name="branches_id">
                                                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($branch->id); ?>" <?php echo e($book->branches_id == $branch->id ? 'selected' : ''); ?>>
                                                                <?php echo e($branch->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn bg-gradient-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <!-- Batch Upload Book Modal -->
                        <div class="modal fade" id="batchUpload" tabindex="-1" aria-labelledby="batchUploadLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow-lg rounded">
                                    <!-- Modal Header -->
                                    <div class="modal-header bg-gradient-primary text-white">
                                        <h5 class="modal-title" id="batchUploadLabel">
                                            <i class="fas fa-upload"></i> Upload Books
                                        </h5>
                                        <!-- <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form action="<?php echo e(route('book.batchUpload')); ?>" method="POST" enctype="multipart/form-data">
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
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Cancel
                                        </button>
                                        <button type="submit" class="btn bg-gradient-primary">
                                            <i class="fas fa-cloud-upload-alt"></i> Upload
                                        </button>
                                    </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </div><!-- End of Main Content -->
            </div>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('scripts.books', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views/book/index.blade.php ENDPATH**/ ?>