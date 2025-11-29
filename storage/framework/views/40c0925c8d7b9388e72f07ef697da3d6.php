<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php if(session('success')): ?>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: `<?php echo session('success'); ?>`,
                showConfirmButton: false,
                timer: 3000,  // Duration of toast
                customClass: {
                    popup: 'custom-toast-success' // Apply custom styling
                },
                didOpen: (toast) => {
                    let progressBar = document.createElement('div');
                    progressBar.classList.add('custom-progress-bar');
                    toast.appendChild(progressBar);
                }
            });
        <?php endif; ?>

        <?php if(session('error')): ?>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: `<?php echo session('error'); ?>`,
                showConfirmButton: false,
                timer: 3000, 
                customClass: {
                    popup: 'custom-toast-error'
                },
                didOpen: (toast) => {
                    let progressBar = document.createElement('div');
                    progressBar.classList.add('custom-progress-bar');
                    toast.appendChild(progressBar);
                }
            });
        <?php endif; ?>
    });
</script>



<!-- Include SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Custom styling for success toast */
    .custom-toast-success {
        background-color: rgb(88, 167, 88) !important; /* Green background */
        color: rgb(250, 247, 247) !important; /* Black text */
        padding-bottom: 6px;
        position: relative;
    }

    /* Custom styling for error toast */
    .custom-toast-error {
        background-color: #dc3545 !important; /* Red background */
        color: white !important;
        padding-bottom: 8px;
        position: relative;
    }

    /* Progress bar styling */
    .custom-progress-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 200%;
        height: 4px;
        background: rgba(173, 233, 191, 0.8);
        animation: progressBar 3s linear forwards; /* 3s animation */
    }

    /* Progress bar animation */
    @keyframes progressBar {
        from {
            width: 100%;
        }
        to {
            width: 0%;
        }
    }
</style>

<?php $__env->stopPush(); ?>

<?php /**PATH D:\laragon\www\library\resources\views/scripts/books.blade.php ENDPATH**/ ?>