
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Reports List</h4>
                        <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Report</th>
                                        <th>Description</th>
                                        <th class="text-center"><i class="fas fa-download"></i> Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Collections</td>
                                        <td>This report contains all the cash collection from the start of this system in the database, which can be downloaded as a PDF or Excel file.</td>
                                        <td><a href="<?php echo e(route('totalcash.pdf')); ?>"><i class="fas fa-file-pdf"></i> PDF</a></td>
                                    </tr>
                                    <tr>
                                        <td>Monthly Collections</td>
                                        <td>This report contains all the cash collection from specific month which can be downloaded as a PDF or Excel file.</td>
                                        <td><a href="<?php echo e(route('monthlycash.pdf')); ?>"><i class="fas fa-file-pdf"></i> PDF</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views//report/index.blade.php ENDPATH**/ ?>