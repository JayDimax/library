
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Reports List</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
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
                                    <td>This report contains all cash collections stored in the system database.</td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('totalcash.pdf')); ?>" class="btn bg-gradient-primary btn-sm">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                        <a href="<?php echo e(route('totalcash.excel')); ?>" class="btn bg-gradient-success btn-sm text-white">
                                            <i class="fas fa-file-excel"></i> Excel
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Monthly Collections</td>
                                    <td>Select a month and year to generate a monthly collection report.</td>
                                    <td>
                                        <form action="<?php echo e(route('monthlycash.pdf')); ?>" method="GET" class="form-inline justify-content-center">
                                            <?php echo csrf_field(); ?>

                                            <select name="month" class="custom-select custom-select-sm mr-2" required>
                                                <option value="">Month</option>
                                                <?php for($m = 1; $m <= 12; $m++): ?>
                                                    <option value="<?php echo e($m); ?>"><?php echo e(date('F', mktime(0, 0, 0, $m, 1))); ?></option>
                                                <?php endfor; ?>
                                            </select>

                                            <select name="year" class="custom-select custom-select-sm mr-2" required>
                                                <option value="">Year</option>
                                                <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                                                    <option value="<?php echo e($y); ?>"><?php echo e($y); ?></option>
                                                <?php endfor; ?>
                                            </select>

                                            <button type="submit" class="btn bg-gradient-primary btn-sm">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </button>
                                            <button formaction="<?php echo e(route('monthlycash.excel')); ?>" formmethod="GET" class="btn bg-gradient-success btn-sm text-white ml-1">
                                                <i class="fas fa-file-excel"></i> Excel
                                            </button>
                                        </form>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views/report/index.blade.php ENDPATH**/ ?>