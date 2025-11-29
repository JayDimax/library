
<?php $__env->startSection('content'); ?>

<div id="content">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="h4 mb-0 text-gradient-primary">Trinity Branch Library</h4>
        </div>

        <!-- Dashboard Summary -->
        <div class="row text-center">
            <?php
                $cards = [
                    ['label' => 'Books', 'value' => $totalbooks, 'icon' => 'fa-book', 'color' => 'primary'],
                    ['label' => 'Students', 'value' => $totalStudents, 'icon' => 'fa-users', 'color' => 'success'],
                    ['label' => 'Total Collections (₱)', 'value' => number_format($totalPayables, 2), 'icon' => 'fa-money-bill', 'color' => 'info'],
                    ['label' => 'Collectibles (₱)', 'value' => number_format( $totalCollectibles, 2), 'icon' => 'fa-coins', 'color' => 'warning'],
                ];
            ?>

            <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3 mb-3 glass p-6 text-white">
                    <div class="card shadow-sm border-0 glass p-6 text-white">
                        <div class="card-body py-3">
                            <div class="mb-2">
                                <i class="fas <?php echo e($card['icon']); ?> text-<?php echo e($card['color']); ?> fa-lg"></i>
                            </div>
                            <div class="text-muted small"><?php echo e($card['label']); ?></div>
                            <div class="h5 text-dark font-weight-bold"><?php echo e($card['value']); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Attendance Highlights -->
        <div class="d-flex flex-wrap text-center glass p-6 text-white" style="display: flex; flex-wrap: wrap; text-align: center;">
            <?php
                $stats = [
                    ['label' => 'Top Borrower', 'value' => $topBorrower ? $topBorrower->fname . ' ' . $topBorrower->lname : 'N/A'],
                    ['label' => 'Weekly Top Attendee', 'value' => $weeklyStudentName],
                    ['label' => 'Monthly Top Attendee', 'value' => $monthlyStudentName],
                    ['label' => 'Yearly Top Attendee', 'value' => $yearlyStudentName],
                    ['label' => 'Top Section', 'value' => $mostUsedBookTitle],
                ];
            ?>
        

            <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="width: 20%; padding: 0.5rem; box-sizing: border-box; margin-bottom:1rem">
                    <div class="card shadow-sm border-0 glass p-6 text-white" style="height: 100%; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); border: none;">
                        <div class="card-body py-3" style="padding-top: 1rem; padding-bottom: 1rem;">
                            <div class="text-muted small" style="color: #6c757d; font-size: 0.875rem;"><?php echo e($stat['label']); ?></div>
                            <div class="h6 text-dark font-weight-bold" style="font-size: 1rem; color: #343a40; font-weight: 700;"><?php echo e($stat['value']); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <!-- List of Books Table -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold text-dark m-0"> List of Books</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Call No</th>
                                <th>Accession No</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Section</th>
                                <th>Status</th>
                                <th>Copies</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($book->call_no); ?></td>
                                <td><?php echo e($book->accession_no); ?></td>
                                <td><?php echo e($book->title); ?></td>
                                <td><?php echo e($book->author); ?></td>
                                <td><?php echo e($book->publisher); ?></td>
                                <td><?php echo e($book->section ? $book->section->name : 'Uncategorized'); ?></td>
                                <td>
                                    <span class="badge <?php echo e($book->remaining_copies > 0 ? 'bg-gradient-primary' : 'badge-danger'); ?>">
                                        <?php echo e($book->availability_status); ?> (<?php echo e(max($book->remaining_copies, 0)); ?> left)
                                    </span>
                                </td>
                                <td><?php echo e($book->copies); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- /.container-fluid -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views/librarian/trinity/dashboard.blade.php ENDPATH**/ ?>