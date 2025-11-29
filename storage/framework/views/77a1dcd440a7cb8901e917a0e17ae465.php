<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books Report</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
            text-align: center;
        }
        h3, h4, h5, h6 {
            margin: 0;
            text-align: center;
            line-height: 1.2;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header img {
            width: 100px;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: left;
        }
        .footer small {
            display: block;
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="<?php echo e(public_path('hccd.jpg')); ?>" alt="Logo">
        <h3>HOLY CHILD COLLEGE OF DAVAO</h3>
        <h5 class="mb-2">E. Jacinto St. Davao City</h5>
        
        <h4>
            Branch: 
            <span class="text-primary">
                <?php if(Auth::user()->role === 'admin'): ?>
                    Administrator
                <?php else: ?>
                    <?php echo e(Auth::user()->branch->name ?? 'N/A'); ?>

                <?php endif; ?>
            </span>
        </h4>
        <h5>Books Report</h5>
    </div>

   <?php if($books->count() > 0): ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                <th>Section</th>
                <th>Publisher</th>
                <th>Copies</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($book->title); ?></td>
                    <td><?php echo e($book->author); ?></td>
                    <td><?php echo e($book->section->name ?? 'Uncategorized'); ?></td>
                    <td><?php echo e($book->publisher); ?></td>
                    <td><?php echo e($book->copies); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No books available for this branch.</p>
    <?php endif; ?>



    <div class="footer">
        <strong>Prepared by:</strong><br><br>       
        <small><strong><?php echo e(Auth::user()->name); ?></strong></small>
        <small>Note: This is a computer-generated document. No signature required.</small>
    </div>

</body>
</html>
<?php /**PATH F:\laragon\www\library\resources\views/pdf/books.blade.php ENDPATH**/ ?>