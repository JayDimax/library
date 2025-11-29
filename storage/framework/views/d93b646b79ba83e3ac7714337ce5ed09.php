
<?php $__env->startSection('content'); ?>

<div id="content">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="h4 mb-0 text-gradient-primary">Welcome <?php echo e(Auth::user()->name); ?></h4>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-3" id="dashboardTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary" role="tab">Summary</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab">Statistics</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="books-tab" data-toggle="tab" href="#books" role="tab">Books List</a>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="dashboardTabsContent">

            <!-- Summary Cards -->
            <div class="tab-pane fade show active" id="summary" role="tabpanel">
                <div class="row g-3 text-center mb-3">
                    <?php
                        $cards = [
                            ['label' => 'Books', 'value' => $totalbooks, 'icon' => 'fa-book', 'color' => 'primary'],
                            ['label' => 'Students', 'value' => $totalStudents, 'icon' => 'fa-users', 'color' => 'success'],
                            ['label' => 'Total Collections (₱)', 'value' => number_format($totalPayables, 2), 'icon' => 'fa-money-bill', 'color' => 'info'],
                            ['label' => 'Collectibles (₱)', 'value' => number_format($totalCollectibles, 2), 'icon' => 'fa-coins', 'color' => 'warning'],
                        ];
                    ?>

                    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-md-3">
                            <div class="card border-light shadow-sm text-center h-100">
                                <div class="card-body py-3">
                                    <i class="fas <?php echo e($card['icon']); ?> text-<?php echo e($card['color']); ?> fa-2x mb-2"></i>
                                    <div class="text-muted small"><?php echo e($card['label']); ?></div>
                                    <div class="h5 text-dark font-weight-bold"><?php echo e($card['value']); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="row mb-4">
                    <div class="col-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h6 class="font-weight-bold text-dark m-0">Books per Branch</h6>
                            </div>
                            <div class="card-body" style="height: 300px;">
                                <canvas id="booksBranchLineChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h6 class="font-weight-bold text-dark m-0">Students per Branch</h6>
                            </div>
                            <div class="card-body" style="height: 300px;">
                                <canvas id="studentsBranchBarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance / Statistics Visuals -->
            <div class="tab-pane fade" id="attendance" role="tabpanel">
                <div class="row g-3 mb-4 text-center">

                    <!-- Top Borrower -->
                    <div class="col-md-3 col-6">
                        <div class="card border-light shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-user-graduate fa-2x text-primary mb-2"></i>
                                <div class="small text-muted">Top Borrower</div>
                                <h6 class="fw-bold text-dark"><?php echo e($topBorrower ? $topBorrower->fname . ' ' . $topBorrower->lname : 'N/A'); ?></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Top Attendee -->
                    <div class="col-md-3 col-6">
                        <div class="card border-light shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-calendar-week fa-2x text-success mb-2"></i>
                                <div class="small text-muted">Weekly Top Attendee</div>
                                <h6 class="fw-bold text-dark"><?php echo e($weeklyStudentName); ?></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Top Attendee -->
                    <div class="col-md-3 col-6">
                        <div class="card border-light shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-calendar-alt fa-2x text-info mb-2"></i>
                                <div class="small text-muted">Monthly Top Attendee</div>
                                <h6 class="fw-bold text-dark"><?php echo e($monthlyStudentName); ?></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Yearly Top Attendee -->
                    <div class="col-md-3 col-6">
                        <div class="card border-light shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-calendar fa-2x text-warning mb-2"></i>
                                <div class="small text-muted">Yearly Top Attendee</div>
                                <h6 class="fw-bold text-dark"><?php echo e($yearlyStudentName); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add a Chart for Attendance Trends -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="font-weight-bold text-dark m-0">Attendance Trends</h6>
                    </div>
                    <div class="card-body" style="height: 300px;">
                        <canvas id="attendanceTrendChart"></canvas>
                    </div>
                </div>
            </div>


            <!-- Books List -->
            <div class="tab-pane fade" id="books" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                        <h6 class="font-weight-bold text-dark m-0">List of Books</h6>
                        <button class="btn btn-outline-secondary btn-sm" type="button" data-toggle="collapse" data-target="#booksTable">
                            Show / Hide Table
                        </button>
                    </div>
                    <div class="collapse show" id="booksTable">
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0" id="dataTable" width="100%" cellspacing="0">
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
                </div>
            </div>

        </div> <!-- /.tab-content -->

    </div> <!-- /.container-fluid -->
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('booksBranchLineChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($branchNames, 15, 512) ?>,
        datasets: [{
            label: 'Number of Books',
            data: <?php echo json_encode($booksCount, 15, 512) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true }, x: { beginAtZero: true } }
    }
});

const ctxStudents = document.getElementById('studentsBranchBarChart').getContext('2d');
new Chart(ctxStudents, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($branchNames, 15, 512) ?>,
        datasets: [{
            label: 'Number of Students',
            data: <?php echo json_encode($studentsCount, 15, 512) ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true }, x: { beginAtZero: true } }
    }
});

// Attendance Trends Chart (example data)
const ctxAttendance = document.getElementById('attendanceTrendChart').getContext('2d');
new Chart(ctxAttendance, {
    type: 'line',
    data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        datasets: [{
            label: 'Attendance Count',
            data: [12, 19, 8, 15], // Replace with actual attendance counts if available
            backgroundColor: 'rgba(153, 102, 255, 0.3)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true } }
    }
});

</script>


<?php echo $__env->make('chat.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views/librarian/index.blade.php ENDPATH**/ ?>