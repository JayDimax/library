

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">Books Report</h4>

            
            <?php if($user->role === 'admin'): ?>
                <div class="dropdown mb-3">
                    <button class="btn bg-gradient-primary dropdown-toggle btn-sm" type="button" id="branchDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo e($branchId ? ($branches->firstWhere('id', $branchId)->name ?? 'Select Branch') : 'Select Branch'); ?>

                    </button>

                    <div class="dropdown-menu" aria-labelledby="branchDropdown">
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="dropdown-item"
                            href="<?php echo e(route('report.books', ['branches_id' => $branch->id])); ?>">
                                <?php echo e($branch->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>


            <?php else: ?>
                
                <h5><span class="badge bg-gradient-primary text-white"><?php echo e($user->branch->name ?? 'My Branch'); ?></span></h5>
            <?php endif; ?>

            
            <?php if($books->count() > 0): ?>
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-bordered align-middle" id="dataTable">
                        <thead>
                            <tr>
                                <th>Branch Name</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Section</th>
                                <th>Type</th>
                                <th>Copies</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($book->branch->name ?? 'N/A'); ?></td>    
                                    <td><?php echo e($book->title); ?></td>
                                    <td><?php echo e($book->author); ?></td>
                                    <td><?php echo e($book->publisher); ?></td>
                                    <td><?php echo e($book->section->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($book->type->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($book->copies); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="text-end mt-3">
                    <a href="<?php echo e(route('report.books', ['branches_id' => $branchId, 'download' => 'pdf'])); ?>" class="btn bg-gradient-primary btn-sm">
                        <i class="fas fa-file-pdf"></i> Download PDF (All)
                    </a>
                </div>
            <?php elseif($user->role === 'admin' && !$branchId): ?>
                <div class="alert alert-info mt-3">Please select a branch to view its books.</div>
            <?php else: ?>
                <div class="alert alert-warning mt-3">No books found for this branch.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views/report/books.blade.php ENDPATH**/ ?>