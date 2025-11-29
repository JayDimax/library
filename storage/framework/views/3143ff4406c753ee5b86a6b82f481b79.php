

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user-circle"></i> My Profile</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group mb-3">
                    <label for="name" class="font-weight-bold">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="font-weight-bold">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" class="form-control" required>
                </div>

                <hr>

                <div class="form-group mb-3">
                    <label for="password" class="font-weight-bold">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation" class="font-weight-bold">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>

                <div class="text-right">
                    <?php
                        $role = Auth::user()->role; // adjust if your column name is different
                        $dashboardRoute = $role === 'admin' ? 'admin.dashboard' : ($role === 'librarian' ? 'librarian.dashboard' : 'dashboard');
                    ?>

                    <a href="<?php echo e(route($dashboardRoute)); ?>" class="btn btn-secondary">Close</a>

                    <button type="submit" class="btn bg-gradient-primary"><i class="fas fa-save"></i> Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <?php $__env->startPush('scripts'); ?>
         <?php echo $__env->make('scripts.books', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\library\resources\views/profile/index.blade.php ENDPATH**/ ?>