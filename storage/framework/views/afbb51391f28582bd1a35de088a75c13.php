

<?php $__env->startSection('content'); ?>
<!-- Main Content -->
<div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h3 class="h3 mb-0 text-gray-800">Branch Module</h3>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-gradient-primary">Library Branches</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Action :</div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-bs-toggle="modal" href="#" data-bs-target="#addModal">Add Branch</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Branch Name</th>
                                        <th>Contact Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($branch->name); ?></td>
                                        <td><?php echo e($branch->phone ?? 'N/A'); ?></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal"
                                                data-bs-target="#editModal<?php echo e($branch->id); ?>">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form action="<?php echo e(route('branch.destroy', $branch->id)); ?>" method="POST" style="display:inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-gradient-primary">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Branch Modal -->
                                    <div class="modal fade" id="editModal<?php echo e($branch->id); ?>" tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel<?php echo e($branch->id); ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-gradient-primary text-white">
                                                    <h5 class="modal-title" id="editModalLabel<?php echo e($branch->id); ?>">Edit Branch</h5>
                                                    <button class="close" type="button" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?php echo e(route('branch.update', $branch->id)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <div class="row mb-3">
                                                            <label for="name<?php echo e($branch->id); ?>" class="col-sm-3 col-form-label">Branch Name :</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control mb-2" id="name<?php echo e($branch->id); ?>"
                                                                    name="name" value="<?php echo e($branch->name); ?>" required>
                                                            </div>

                                                            <label for="address<?php echo e($branch->id); ?>" class="col-sm-3 col-form-label">Contact Number :</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control mb-2" id="phone<?php echo e($branch->id); ?>"
                                                                    name="phone" value="<?php echo e($branch->phone); ?>" required>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
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

            <!-- Add Branch Modal -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary text-white">
                            <h5 class="modal-title" id="exampleModalLabel">Add Branch</h5>
                            <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo e(route('branch.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-3 col-form-label">Branch Name :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control mb-2" id="name" name="name" required>
                                    </div>

                                        <label for="phone" class="col-sm-3 col-form-label">Contact Number :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="phone" name="phone" required>
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
<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views//branch/index.blade.php ENDPATH**/ ?>