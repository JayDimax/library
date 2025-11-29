

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
            <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-gradient-primary">Library Section</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Action :</div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-bs-toggle="modal" href="#" data-bs-target="#addModal">Add Section</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Library Section</th>
                                        <th>Fines Per Hour(₱)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($section->name); ?></td>
                                        <td><?php echo e($section->fines, 4); ?></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($section->id); ?>"><i class="fas fa-pen"></i></a>
                                             <?php if(auth()->check() && auth()->user()->branches_id == 4): ?>
                                                <form action="<?php echo e(route('section.destroy', $section->id)); ?>" method="POST" style="display:inline;"
                                                    onsubmit="return confirm('Are you sure you want to delete this section?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-gradient-primary">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <!-- Edit Section Modal -->
                                    <div class="modal fade" id="editModal<?php echo e($section->id); ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo e($section->id); ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-gradient-primary text-white">
                                                    <h5 class="modal-title" id="editModalLabel<?php echo e($section->id); ?>">Edit Section</h5>
                                                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?php echo e(route('section.update', $section->id)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <div class="row mb-3">
                                                            <label for="name<?php echo e($section->id); ?>" class="col-sm-3 col-form-label">Section Name :</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control mb-2" id="name<?php echo e($section->id); ?>" name="name" value="<?php echo e($section->name); ?>" required>
                                                            </div>

                                                            <label for="fines<?php echo e($section->id); ?>" class="col-sm-3 col-form-label">Assign Fines :</label>
                                                            <div class="col-sm-9">
                                                                <input type="number" step="0.0001" name="fines" value="<?php echo e(old('fines', $section->fines)); ?>" required>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn bg-gradient-primary">Update</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Section Modal -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary text-white">
                            <h5 class="modal-title" id="exampleModalLabel">Add Entry</h5>
                            <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo e(route('section.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-3 col-form-label">Section Name :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control mb-2" id="name" name="name" required>
                                        
                                    </div>
                                    <label for="fines" class="col-sm-3 col-form-label">Set Fines :</label>
                                    <div class="col-sm-9">
                                        <input type="number"  step="0.01" min="0" class="form-control" id="fines" name="fines" required>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
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
<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views/book/section.blade.php ENDPATH**/ ?>