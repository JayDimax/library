
<?php $__env->startSection('content'); ?>
<!-- Main Content -->
<div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h3 class="h4 mb-0 text-gradient-primary">Books Collection</h3>
        </div>
        <?php if($students->isEmpty()): ?>
            <div class="alert alert-warning text-center">
                No students found. Please register a student first before proceeding.
            </div>
        <?php endif; ?>


        <div class="row text-center">
            <?php
                $cards = [
                    ['label' => 'Total Collections (₱)', 'value' => number_format($totalPayables, 2), 'icon' => 'fa-coins', 'color' => 'info'],
                    ['label' => 'Collectibles (₱)', 'value' => number_format( $totalCollectibles, 2), 'icon' => 'fa-coins', 'color' => 'warning'],
                ];
            ?>

            <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm border-0">
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

    <!-- Pay All Books Table (This is above the main table) -->
    <?php $__currentLoopData = $bookCollections->groupBy('student_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $studentId => $collections): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $student = $collections->first()->student ?? null;
        ?>

        <?php if($student && $penaltiesByStudent->has($student->id)): ?>
            <!-- Pay All Books Table, collapsible above the main table -->
            <div class="collapse" id="penaltyCollapse<?php echo e($student->id); ?>">
                <div class="card card-body border-warning bg-light">
                    <h5 class="mb-2">
                        Books with Penalties for <?php echo e($student->lname); ?>, <?php echo e($student->fname); ?>

                    </h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Book Title</th>
                                <th>Date Returned</th>
                                <th>Penalty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $penaltiesByStudent[$student->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $penalty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($i + 1); ?></td>
                                    <td><?php echo e($penalty->book->title ?? 'Unknown Book'); ?></td>
                                    <td>
                                        <?php echo e($penalty->date_returned ? \Carbon\Carbon::parse($penalty->date_returned)->format('M d, Y') : 'N/A'); ?>

                                    </td>
                                    <td>₱<?php echo e(number_format($penalty->total_payable, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <form action="<?php echo e(route('book-collections.payAll', $student->id)); ?>" method="POST" onsubmit="return confirm('Pay all penalties for <?php echo e($student->lname); ?>?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn bg-gradient-primary">Confirm Pay All</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 col-sm">
                <div class="card shadow mb-4">
                    <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-gradient-primary">List of Transactions</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Action :</div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-toggle="modal" href="#" data-target="#addBorrowModal">Add Borrower</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Borrower</th>
                                        <th style="max-width: 200px;">Book Title</th>
                                        <!-- <th>Library Section / Area</th> -->
                                        <th>Date Borrowed</th>
                                        <th>Date Returned</th>
                                        <th>Total Hours</th>
                                        <th>Penalty ₱</th>
                                        <th>Total Payable ₱</th>
                                        <th>Payment Status</th>
                                        <th>Action</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $bookCollections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookCollection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td>
                                            <?php echo e($bookCollection->student ? $bookCollection->student->fname : 'N/A'); ?> 
                                            <?php echo e($bookCollection->student ? $bookCollection->student->lname : 'N/A'); ?>

                                        </td>
                                        <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($bookCollection->book ? $bookCollection->book->title : 'N/A'); ?></td>
                                        <!-- <td><?php echo e($bookCollection->section ? $bookCollection->section->name : 'Uncategorized'); ?></td> -->
                                        <td><?php echo e(date('M d, Y h:i A', strtotime($bookCollection->date_borrowed))); ?></td>
                                        <td>
                                            <?php if($bookCollection->date_returned): ?>
                                                <?php echo e(date('M d, Y h:i A', strtotime($bookCollection->date_returned))); ?>

                                            <?php else: ?>
                                                <span class="text-danger">Not Yet Returned</span>
                                            <?php endif; ?>
                                        </td>
                                        <?php
                                            $dateBorrowed = \Carbon\Carbon::parse($bookCollection->date_borrowed);
                                            $dateReturned = $bookCollection->date_returned ? \Carbon\Carbon::parse($bookCollection->date_returned) : null;
                    
                                            if ($dateReturned) {
                                                // If already returned, use saved values
                                                $totalHours = $bookCollection->total_hours;
                                                $penalty = $bookCollection->penalty;
                                                $totalPayable = $bookCollection->total_payable;
                                            } else {
                                                // Compute dynamically if not yet returned
                                                $dateReturned = \Carbon\Carbon::now();
                                                $totalHours = $dateBorrowed->diffInMinutes($dateReturned) / 60; 
                    
                                                $penaltyPerHour = ($bookCollection->section && $bookCollection->section->fines > 0) ? 2 : 0; 
                                                $penalty = 0;
                                                if ($totalHours > 24) { 
                                                    $extraHours = $totalHours - 24;
                                                    $penalty = $extraHours * $penaltyPerHour;
                                                }
                                                $totalPayable = $penalty;
                                            }
                                        ?>
                                        <td><?php echo e(number_format($totalHours, 2)); ?></td>
                                        <td><?php echo e(number_format($penalty, 2)); ?></td>
                                        <td><?php echo e(number_format($totalPayable, 2)); ?></td>
                                        <td>
                                            <?php if(is_null($bookCollection->penalty)): ?>
                                                <span class="badge bg-secondary text-white">Ongoing</span>
                                            <?php elseif($bookCollection->penalty == 0): ?>
                                                <span class="badge bg-info text-white">No Penalty</span>
                                            <?php elseif($bookCollection->payment_status === 'Paid'): ?>
                                                <span class="badge bg-gradient-primary text-white">Paid</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger text-white">Unpaid</span>
                                            <?php endif; ?>
                                        </td>                   
                                        <td>
                                            <div class="dropdown">
                                            <a class="btn btn-sm btn-gradient-primary" id="actionDropdown<?php echo e($bookCollection->id); ?>" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-pen "></i>
                                                <!-- <span class="text-white">Modify</span> -->
                                            </a>

                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo e($bookCollection->id); ?>">

                                                    
                                                    <?php if(is_null($bookCollection->date_returned)): ?>
                                                        <li>
                                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#editModal<?php echo e($bookCollection->id); ?>">
                                                                <i class="fas fa-cog me-1"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo e(route('book-collections.returnAll', $bookCollection->student->id)); ?>" class="dropdown-item text-danger">
                                                                <i class="fas fa-undo me-1"></i> Return All
                                                            </a>
                                                        </li>

                                                    
                                                    <?php elseif($bookCollection->payment_status == 'Unpaid'): ?>
                                                        <li>
                                                            <button class="dropdown-item text-muted" disabled>
                                                                <i class="fas fa-cog me-1"></i> Edit
                                                            </button>
                                                        </li>
                                                        <?php if($bookCollection->total_payable > 0): ?>
                                                            <li>
                                                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#paidModal<?php echo e($bookCollection->id); ?>">
                                                                    <i class="fas fa-coins me-1"></i> Pay This
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-warning" data-toggle="collapse" href="#payAllCollapse" role="button" aria-expanded="false" aria-controls="payAllCollapse">
                                                                    <i class="fas fa-layer-group me-1"></i> Pay All
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>

                                                    
                                                    <?php else: ?>
                                                        <li>
                                                            <button class="dropdown-item text-muted" disabled>
                                                                <i class="fas fa-cog me-1"></i> Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-muted" disabled>
                                                                <i class="fas fa-coins me-1"></i> Paid
                                                            </button>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                    <?php
                                        $studentsGrouped = $bookCollections->groupBy('students_id');
                                    ?>

                                    <?php $__currentLoopData = $studentsGrouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $studentId => $studentBooks): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $student = $studentBooks->first()->student; // Assuming every record has the student relationship loaded
                                        ?>
                                        <?php
                                            $totalPenalty = 0;
                                            $totalHours = 0;
                                            foreach ($studentBooks as $record) {
                                                if (!$record->date_returned) {
                                                    $borrowed = \Carbon\Carbon::parse($record->date_borrowed);
                                                    $now = \Carbon\Carbon::now();
                                                    $hours = $borrowed->diffInHours($now);
                                                    $penalty = $hours > 24 ? ($hours - 24) * 2 : 0;
                                                    $totalHours += $hours;
                                                    $totalPenalty += $penalty;
                                                }
                                            }
                                        ?>
                                        <!-- Return All MOdal -->
                                        <div class="modal fade" id="returnAllModal<?php echo e($studentId); ?>" tabindex="-1">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content shadow">
                                                    <div class="modal-header bg-gradient-primary text-white">
                                                        <h5 class="modal-title">
                                                            Return All Books for <?php echo e(optional($student)->fname ?? ''); ?> <?php echo e(optional($student)->lname ?? ''); ?>

                                                        </h5>

                                                    </div>
                                                    <form action="<?php echo e(url('book-collections/return-all/' . $studentId)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="modal-body">
                                                            <p><strong>Total Books to Return:</strong> <?php echo e($studentBooks->whereNull('date_returned')->count()); ?></p>
                                                            <ul>
                                                                <?php $__currentLoopData = $studentBooks->whereNull('date_returned'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li><?php echo e($book->book->title ?? 'Untitled Book'); ?></li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                            <p><strong>Total Hours:</strong> <?php echo e($totalHours); ?></p>
                                                            <p><strong>Total Penalty:</strong> ₱<?php echo e(number_format($totalPenalty, 2)); ?></p>

                                                            <input type="hidden" name="students_id" value="<?php echo e($studentId); ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button class="btn bg-gradient-primary" type="submit">Confirm Return All</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <!-- Payment Modal -->
                                    <div class="modal fade" id="paidModal<?php echo e($bookCollection->id); ?>" tabindex="-1" aria-labelledby="paidModalLabel<?php echo e($bookCollection->id); ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow-lg border-0 rounded-3">
                                                <!-- Header -->
                                                <div class="modal-header bg-gradient-primary text-white">
                                                    <h5 class="modal-title fw-bold">Process Payment</h5>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="fw-bold">Amount Due:</label>
                                                        <input type="text" class="form-control text-end" id="amountDue<?php echo e($bookCollection->id); ?>" value="<?php echo e($bookCollection->total_payable); ?>" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="fw-bold">Cash Tendered:</label>
                                                        <input type="number" class="form-control text-end cash-input" id="cashTendered<?php echo e($bookCollection->id); ?>" min="0" step="0.01">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="fw-bold">Change:</label>
                                                        <input type="text" class="form-control text-end" id="change<?php echo e($bookCollection->id); ?>" readonly>
                                                    </div>
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer d-flex justify-content-center border-0">
                                                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                    <form action="<?php echo e(route('book-collection.markPaid', $bookCollection->id)); ?>" method="POST" id="paymentForm<?php echo e($bookCollection->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <input type="hidden" name="cash_tendered" id="cashTenderedHidden<?php echo e($bookCollection->id); ?>">
                                                        <button type="submit" class="btn btn-success px-4 py-2" id="payButton<?php echo e($bookCollection->id); ?>" disabled>
                                                            <i class="fas fa-check"></i> Confirm Payment
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden Printable Receipt -->
                                    <div id="receipt<?php echo e($bookCollection->id); ?>" class="d-none">
                                        <div class="text-center">
                                            <h3>Library Payment Receipt</h3>
                                            <hr>

                                            <!-- Receipt Number -->
                                            <p><strong>Receipt No:</strong> #<?php echo e($bookCollection->id); ?></p>

                                            <!-- Payor Details -->
                                            <p><strong>Payor:</strong> <?php echo e(optional($bookCollection->student)->lname ?? 'N/A'); ?>, <?php echo e(optional($bookCollection->student)->fname ?? ''); ?></p>


                                            <!-- Date, Payment Details -->
                                            <p><strong>Date:</strong> <span id="receiptDate<?php echo e($bookCollection->id); ?>"></span></p>
                                            <p><strong>Amount Paid:</strong> ₱<span id="receiptAmount<?php echo e($bookCollection->id); ?>"></span></p>
                                            <p><strong>Cash Tendered:</strong> ₱<span id="receiptCash<?php echo e($bookCollection->id); ?>"></span></p>
                                            <p><strong>Change:</strong> ₱<span id="receiptChange<?php echo e($bookCollection->id); ?>"></span></p>
                                            
                                            <hr>

                                            <!-- Books Borrowed Section -->
                                            <h4>Books Borrowed</h4>
                                            <ul style="list-style-type: none; padding: 0; font-size: 14px;">
                                                <?php if($bookCollection->books->count() > 0): ?>
                                                    <?php $__currentLoopData = $bookCollection->books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>📖 <?php echo e($book->title); ?></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <li>No books borrowed.</li>
                                                <?php endif; ?>
                                            </ul>


                                            <hr>

                                            <!-- Librarian's Name -->
                                            <p><strong>Received by:</strong></p>
                                            <p>Ms. Daylane M. Palgan</p>
                                            <p>Librarian</p>

                                            <p>Thank you for your payment!</p>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            let amountDue = parseFloat(document.getElementById("amountDue<?php echo e($bookCollection->id); ?>").value);
                                            let cashTenderedInput = document.getElementById("cashTendered<?php echo e($bookCollection->id); ?>");
                                            let changeOutput = document.getElementById("change<?php echo e($bookCollection->id); ?>");
                                            let payButton = document.getElementById("payButton<?php echo e($bookCollection->id); ?>");
                                            let cashHiddenInput = document.getElementById("cashTenderedHidden<?php echo e($bookCollection->id); ?>");
                                            let paymentForm = document.getElementById("paymentForm<?php echo e($bookCollection->id); ?>");

                                            let isPrintConfirmed = false; // Track if the user completes printing

                                            // Handle cash input and enable/disable pay button
                                            cashTenderedInput.addEventListener("input", function () {
                                                let cashTendered = parseFloat(this.value) || 0;
                                                let change = cashTendered - amountDue;

                                                changeOutput.value = change >= 0 ? change.toFixed(2) : "Insufficient";
                                                payButton.disabled = cashTendered < amountDue;
                                                cashHiddenInput.value = cashTendered;
                                            });

                                            // Handle form submission with print logic
                                            paymentForm.addEventListener("submit", function (event) {
                                                event.preventDefault(); // Prevent default submission

                                                let cashTendered = parseFloat(cashTenderedInput.value);
                                                let change = cashTendered - amountDue;

                                                // Update receipt details
                                                document.getElementById("receiptDate<?php echo e($bookCollection->id); ?>").textContent = new Date().toLocaleString();
                                                document.getElementById("receiptAmount<?php echo e($bookCollection->id); ?>").textContent = amountDue.toFixed(2);
                                                document.getElementById("receiptCash<?php echo e($bookCollection->id); ?>").textContent = cashTendered.toFixed(2);
                                                document.getElementById("receiptChange<?php echo e($bookCollection->id); ?>").textContent = change.toFixed(2);

                                                // Open print window
                                                let receiptContent = document.getElementById("receipt<?php echo e($bookCollection->id); ?>").innerHTML;
                                                let printWindow = window.open("", "_blank");
                                                printWindow.document.write("<html><head><title>Receipt</title></head><body>");
                                                printWindow.document.write(receiptContent);
                                                printWindow.document.write("</body></html>");
                                                printWindow.document.close();

                                                // Handle print event
                                                printWindow.onafterprint = function () {
                                                    isPrintConfirmed = true; // Mark print as completed
                                                    printWindow.close(); // Close the print window
                                                    paymentForm.submit(); // Submit the form after successful printing
                                                };

                                                printWindow.onbeforeunload = function () {
                                                    if (!isPrintConfirmed) {
                                                        alert("Printing was canceled. Payment will not be finalized.");
                                                        return false; // Prevent accidental finalization
                                                    }
                                                };

                                                printWindow.print(); // Trigger print
                                            });
                                        });
                                    </script>


                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <div class="collapse mt-4" id="payAllCollapse">
                                <div class="card card-body border-warning">
                                    <h5 class="text-warning mb-3">Bulk Payment</h5>

                                    <?php if($students->isEmpty()): ?>
                                        <div class="alert alert-warning text-center">
                                            No students found. Please register a student first before proceeding.
                                        </div>
                                    <?php elseif(!$student): ?>
                                        <div class="alert alert-warning text-center">
                                            No active student record found for processing payment.
                                        </div>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('book-collections.payAll', $student->id)); ?>" method="POST" onsubmit="return confirm('Confirm full payment for all unpaid, returned books?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>

                                            <?php
                                                $totalPayable = $bookCollections
                                                    ->where('payment_status', 'Unpaid')
                                                    ->whereNotNull('date_returned')
                                                    ->sum('total_payable');
                                            ?>

                                            <?php if($totalPayable > 0): ?>
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Total Payable Amount:</strong></label>
                                                    <input type="text" class="form-control" value="₱<?php echo e(number_format($totalPayable, 2)); ?>" readonly>
                                                </div>

                                                <button type="submit" class="btn btn-success">Confirm Pay All</button>
                                            <?php else: ?>
                                                <div class="alert alert-info text-center">
                                                    No unpaid or returned books available for payment.
                                                </div>
                                            <?php endif; ?>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                     
                    <!-- Return All Books Section (Hidden by default) -->
                    <div id="returnAllSection" style="display:none;" class="mt-4">
                        <h3>Return All Books for <span id="borrowerName"></span></h3>
                        <p><strong>Total Books:</strong> <span id="totalBooks"></span></p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book Title</th>
                                    <th>Section</th>
                                    <th>Date Borrowed</th>
                                </tr>
                            </thead>
                            <tbody id="returnAllTableBody">
                                <!-- Rows will be injected here -->
                            </tbody>
                        </table>

                        <form id="returnAllForm" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-success">Confirm Return All</button>
                            <button type="button" class="btn btn-secondary" onclick="toggleReturnAll()">Cancel</button>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-sm">
                <div class="card shadow mb-4">
                    <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-gradient-primary">List of Unpaid Accounts</h6>
                        <h6 class="m-0 font-weight-bold text-gradient-primary">Subject For Clearance</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Borrower</th>
                                        <th>Book Title</th>
                                        <th>Section</th>
                                        <th>Date Borrowed</th>
                                        <th>Penalty ₱</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $unpaidCollections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($collection->student->fname); ?> <?php echo e($collection->student->lname); ?></td>
                                        <td><?php echo e($collection->book->title); ?></td>
                                        <td><?php echo e($collection->section ? $collection->section->name : 'Uncategorized'); ?></td>
                                        <td><?php echo e(date('M d, Y h:i A', strtotime($collection->date_borrowed))); ?></td>
                                        <td><?php echo e($collection->total_payable); ?></td>
                                        <td><?php echo e($collection->payment_status); ?></td> 
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div><!-- End of Card -->

            </div>

            <!-- Add Borrow Record Modal -->
            <div class="modal fade" id="addBorrowModal" tabindex="-1" aria-labelledby="addBorrowModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary text-white">
                            <h5 class="modal-title" id="addBorrowModalLabel">Add Borrow Record</h5>
                        </div>
                        <form action="<?php echo e(route('book-collection.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="modal-body">

                            <!-- Select Borrower -->
                            <div class="mb-3">
                                <label for="students_id" class="form-label">Select Borrower</label>
                                <select name="students_id" id="students_id" class="form-control" required>
                                    <option value="">-- Select Borrower --</option>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->id); ?>">
                                            <?php echo e($student->lname); ?>, <?php echo e($student->fname); ?>

                                            <?php if(Auth::user()->role === 'admin'): ?>
                                                (<?php echo e($student->branch->name ?? 'No Branch'); ?>)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>



                                <!-- Select Library Section -->
                                <div class="mb-3">
                                    <label for="sections_id" class="form-label">Select Section</label>
                                    <select name="sections_id" id="sections_id" class="form-control" required>
                                        <option value="">Select a Section</option>
                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($section->id); ?>"><?php echo e($section->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Select Books (Multiple Selection) -->
                                <div class="mb-3">
                                    <label for="books_id" class="form-label">Select Book(s)</label>
                                    <select name="books_id[]" id="books_id" class="form-control select2-books" multiple="multiple" required>
                                        <?php $__currentLoopData = $availableBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($book->id); ?>" data-section="<?php echo e($book->sections_id); ?>">
                                                <?php echo e($book->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <p id="noBooksMessage" class="text-danger mt-2" style="display: none;">No books available in this section.</p>
                                    
                                    <!-- Selected Books Display Area -->
                                    <div class="selected-books-container mt-3" style="display: none;">
                                        <h6>Selected Books:</h6>
                                        <ul class="list-group selected-books-list">
                                            <!-- Selected books will appear here -->
                                        </ul>
                                    </div>
                                </div>

                                <!-- Date Borrowed -->
                                <div class="mb-3">
                                    <label for="date_borrowed" class="form-label">Date Borrowed</label>
                                    <input type="datetime-local" name="date_borrowed" id="date_borrowed" class="form-control" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn bg-gradient-primary">Save Record</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <?php $__currentLoopData = $bookCollections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Return Book Modal -->
                <div class="modal fade edit-modal" id="editModal<?php echo e($record->id); ?>" 
                    data-borrowed="<?php echo e($record->date_borrowed); ?>" 
                    data-section="<?php echo e($record->sections_id); ?>">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content shadow-lg rounded">
                            <div class="modal-header bg-gradient-primary text-white">
                                <h5 class="modal-title">Return Book</h5>
                            </div>
                            <form action="<?php echo e(route('book-collections.update', $record->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?php echo e($record->id); ?>">

                                    <div class="mb-3">
                                        <label for="students_id" class="form-label">Student Name</label>
                                        <input type="hidden" class="form-control" name="students_id" value="<?php echo e($record->students_id); ?>" readonly>
                                        <p class="form-control-plaintext">
                                            <?php echo e(optional($record->student)->fname ?? 'N/A'); ?> <?php echo e(optional($record->student)->lname ?? ''); ?>

                                        </p>

                                    </div>
                                    <hr class="mt-0">
                                    <div class="mb-3">
                                        <label for="books_id" class="form-label">Book Title</label>
                                        <input type="hidden" class="form-control" name="books_id" value="<?php echo e($record->books_id); ?>" readonly>
                                        <p class="form-control-plaintext">
                                            <?php echo e(optional($record->book)->title ?? 'N/A'); ?>

                                        </p>

                                    </div>
                                    <hr class="mt-0">
                                    <div class="mb-3">
                                        <label for="date_borrowed" class="form-label">Date Borrowed</label>
                                        <input type="text" class="form-control" name="date_borrowed" value="<?php echo e($record->date_borrowed); ?>" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="date_returned" class="form-label">Date Returned</label>
                                        <input type="text" class="form-control" name="date_returned" 
                                            value="<?php echo e($record->date_returned ?? now()); ?>" readonly>
                                    </div>

                                    <?php
                                        // Determine the actual return time
                                        $actualReturnDate = $record->date_returned ?? now();
                                        $totalHours = \Carbon\Carbon::parse($record->date_borrowed)->diffInHours($actualReturnDate);
                                        $penalty = $totalHours > 24 ? ($totalHours - 24) * 2 : 0;
                                        $totalPayable = $penalty;
                                    ?>

                                    <input type="hidden" name="total_hours" value="<?php echo e($totalHours); ?>">
                                    <input type="hidden" name="penalty" value="<?php echo e($penalty); ?>">
                                    <input type="hidden" name="total_payable" value="<?php echo e($totalPayable); ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Total Hours</label>
                                        <input type="text" class="form-control" value="<?php echo e($totalHours); ?>" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Penalty (PHP)</label>
                                        <input type="text" class="form-control" value="<?php echo e($penalty); ?>" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Total Payable (PHP)</label>
                                        <input type="text" class="form-control" value="<?php echo e($totalPayable); ?>" readonly>
                                    </div>

                                    <button type="submit" class="btn bg-gradient-primary ">Confirm Return</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            


        </div><!-- End of Main Content -->
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const payAllLinks = document.querySelectorAll('[href="#payAllCollapse"]');
                payAllLinks.forEach(link => {
                    link.addEventListener("click", function () {
                        const target = document.querySelector("#payAllCollapse");
                        if (target) {
                            setTimeout(() => {
                                target.scrollIntoView({ behavior: "smooth", block: "start" });
                            }, 300); // Wait for collapse animation
                        }
                    });
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const sectionSelect = document.getElementById("sections_id");
                const bookSelect = document.getElementById("books_id");
                const studentIdInput = document.getElementById("students_id");
                const dateInput = document.getElementById("date_borrowed");
                const noBooksMessage = document.getElementById("noBooksMessage");
                const saveRecordButton = document.getElementById("saveRecordButton");

                // Store all book options initially
                const allBookOptions = [...bookSelect.options].map(option => ({
                    value: option.value,
                    text: option.textContent.trim(),
                    section: option.getAttribute("data-section") || ""
                }));

                // Function to update book options when a section is selected
                function updateBookOptions(selectedSection) {
                    if (!selectedSection) return;

                    // Store previously selected books
                    const previouslySelectedBooks = Array.from(bookSelect.selectedOptions).map(opt => opt.value);

                    // Filter and sort books by selected section
                    const booksArray = allBookOptions
                        .filter(book => book.section === selectedSection)
                        .sort((a, b) => a.text.localeCompare(b.text));

                    // Clear and repopulate the book dropdown
                    bookSelect.innerHTML = '';
                    booksArray.forEach(book => {
                        let option = new Option(book.text, book.value);
                        option.setAttribute("data-section", book.section); // Keep section reference
                        bookSelect.appendChild(option);
                    });

                    // Restore previously selected books if they are still valid
                    Array.from(bookSelect.options).forEach(option => {
                        if (previouslySelectedBooks.includes(option.value)) {
                            option.selected = true;
                        }
                    });

                    // Show/hide the "No Books Available" message
                    noBooksMessage.style.display = booksArray.length ? "none" : "block";

                    // Enable/disable the book dropdown
                    bookSelect.disabled = booksArray.length === 0;
                }

                // Function to auto-select section when a book is selected
                function updateSectionBasedOnBook() {
                    const selectedBooks = Array.from(bookSelect.selectedOptions);
                    if (selectedBooks.length > 0) {
                        // Get the section of the first selected book
                        const firstBookSection = selectedBooks[0].getAttribute("data-section");
                        sectionSelect.value = firstBookSection; // Automatically select section
                    }
                }

                // Handle section change event
                sectionSelect.addEventListener("change", function () {
                    updateBookOptions(this.value);
                });

                // Handle book selection event (auto-select its section)
                bookSelect.addEventListener("change", function () {
                    updateSectionBasedOnBook();
                    dateInput.disabled = bookSelect.selectedOptions.length === 0; // Enable date input only when books are selected
                });

                // Validate all fields before submission
                saveRecordButton.addEventListener("click", function (event) {
                    if (!studentIdInput.value || !sectionSelect.value || bookSelect.selectedOptions.length === 0 || !dateInput.value) {
                        event.preventDefault();
                        alert("Please fill out all fields before saving the record.");
                    }
                });

                // Initialize book filtering based on selected section
                updateBookOptions(sectionSelect.value);
            });
        </script>

        <script>
            document.getElementById('books_id').addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                let sectionId = selectedOption.getAttribute('data-section') || 0; // Default to 0 if null
                let sectionName = selectedOption.text.includes('(') 
                    ? selectedOption.text.split('(').pop().replace(')', '').trim() 
                    : 'Uncategorized';

                document.getElementById('sections_id').value = sectionId;
                document.getElementById('sections_id_display').value = sectionId == "0" ? "Uncategorized" : sectionName;
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                console.log("DOM fully loaded");

                function calculateValues(modal) {
                    console.log("Calculating values for modal:", modal);

                    let dateBorrowedAttr = modal.getAttribute("data-borrowed");
                    let sectionIdAttr = modal.getAttribute("data-section");

                    if (!dateBorrowedAttr || !sectionIdAttr) {
                        console.error("Missing required attributes in modal.");
                        return;
                    }

                    let dateBorrowed = new Date(dateBorrowedAttr);
                    let sectionId = parseInt(sectionIdAttr);
                    let dateReturned = new Date(); // Get current time
                    let totalMinutes = Math.ceil((dateReturned - dateBorrowed) / (1000 * 60)); // Convert milliseconds to minutes
                    let totalHours = totalMinutes / 60;

                    let penaltySections = [3, 4, 7, 13]; // Sections with fines
                    let penaltyPerHour = 2; // 2 pesos per hour
                    let penaltyPerMinute = penaltyPerHour / 60;
                    let penalty = 0;
                    let totalPayable = 0;

                    if (totalHours > 24 && penaltySections.includes(sectionId)) {
                        let extraMinutes = (totalHours - 24) * 60;
                        penalty = extraMinutes * penaltyPerMinute;
                        totalPayable = penalty;
                    }

                    // Check if input fields exist before setting values
                    let dateReturnedField = modal.querySelector(".date-returned");
                    let totalHoursField = modal.querySelector(".total-hours");
                    let penaltyField = modal.querySelector(".penalty");
                    let totalPayableField = modal.querySelector(".total-payable");

                    if (dateReturnedField) dateReturnedField.value = dateReturned.toISOString().slice(0, 16);
                    if (totalHoursField) totalHoursField.value = totalHours.toFixed(2);
                    if (penaltyField) penaltyField.value = penalty.toFixed(2);
                    if (totalPayableField) totalPayableField.value = totalPayable.toFixed(2);

                    console.log("Values set successfully.");
                }

                document.querySelectorAll(".edit-modal").forEach((modal) => {
                    modal.addEventListener("show.bs.modal", function () {
                        console.log("Modal is opening:", modal);
                        calculateValues(modal);
                    });
                });

                // Ensure proper modal cleanup
                document.querySelectorAll(".edit-modal").forEach((modal) => {
                    modal.addEventListener("hidden.bs.modal", function () {
                        let modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) {
                            modalInstance.dispose(); // Clean up to prevent conflicts
                            console.log("Disposed modal instance.");
                        }
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // Initialize Select2
                $('.select2-books').select2({
                    theme: 'bootstrap4',
                    placeholder: "Search and select books...",
                    width: '100%',
                    closeOnSelect: false,
                    templateSelection: function(data) {
                        // This hides the selected items from appearing as tags in the input
                        return '';
                    }
                });

                // Custom handling for selected books display
                $('#books_id').on('change', function() {
                    const selectedBooks = $(this).select2('data');
                    const container = $('.selected-books-container');
                    const list = $('.selected-books-list');
                    
                    list.empty(); // Clear previous selections
                    
                    if (selectedBooks.length > 0) {
                        // Add each selected book to our custom display
                        $.each(selectedBooks, function(index, book) {
                            list.append(`
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    ${book.text}
                                    <button type="button" class="btn btn-sm btn-danger remove-book" data-id="${book.id}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </li>
                            `);
                        });
                        container.show();
                    } else {
                        container.hide();
                    }
                });

                // Handle removal of books from our custom display
                $(document).on('click', '.remove-book', function() {
                    const bookId = $(this).data('id');
                    const select = $('#books_id');
                    const options = select.find('option');
                    
                    // Deselect the option
                    options.each(function() {
                        if ($(this).val() == bookId) {
                            $(this).prop('selected', false);
                        }
                    });
                    
                    // Trigger change to update Select2 and our display
                    select.trigger('change');
                });
            });
        </script>
    <?php $__env->startPush('scripts'); ?>
         <?php echo $__env->make('scripts.books', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopPush(); ?>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views/bookcollection/index.blade.php ENDPATH**/ ?>