
<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-lg">
                <div class="card-header bg-gradient-primary text-white text-center" style="height: 100px;">
                    <h1>QR Code Scanner</h1>
                </div>
                <div class="bg-white/20 backdrop-blur-md text-white rounded-lg shadow-md p-6 h-50 w-full max-w-md mx-auto text-center space-y-4">
                    <input
                        type="text"
                        id="qr-input"
                        name="qr_code"
                        placeholder="Scan QR Code Here..."
                        class="w-full px-4 py-3 text-center text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
                        autofocus
                    >
                    <input type="hidden" id="student_id">
                    <button
                        type="button"
                        onclick="submitQR()"
                        class="w-full px-4 py-3 bg-gradient-primary text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition duration-300">
                        Submit
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        // Manual QR input (keyboard or scanner)
        document.getElementById("qr-input").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                submitQR();
            }
        });

        function submitQR() {
            let scannedQRValue = document.getElementById("qr-input").value.trim();

            try {
                // ✅ Parse JSON only if necessary
                if (scannedQRValue.startsWith('{')) {
                    let parsedData = JSON.parse(scannedQRValue);
                    if (parsedData.students_id) {
                        scannedQRValue = parsedData.students_id;
                    }
                }

                document.getElementById("student_id").value = scannedQRValue;
                sendToServer(scannedQRValue);
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid QR Code!',
                    text: 'Please scan a valid QR Code.',
                    confirmButtonColor: '#d33'
                });

                // Clear invalid input
                document.getElementById("qr-input").value = "";
            }
        }

        function sendToServer(studentId) {
            fetch('/librarian/process-qr', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ students_id: studentId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful!',
                        text: 'Student login has been recorded.',
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => {
                        // ✅ Clear inputs after successful login
                        document.getElementById("qr-input").value = "";
                        document.getElementById("student_id").value = "";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: data.error || 'Please try again.',
                        confirmButtonColor: '#d33'
                    });
                    document.getElementById("qr-input").value = "";
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Connection Error',
                    text: 'An error occurred while logging in.',
                    confirmButtonColor: '#d33'
                });
                document.getElementById("qr-input").value = "";
            });
        }

        // Initialize camera scanner
        window.addEventListener('DOMContentLoaded', () => {
            const qrScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });

            qrScanner.render(
                function success(decodedText, decodedResult) {
                    // ✅ Decode and extract ID immediately
                    let scannedValue = decodedText.trim();
                    try {
                        if (scannedValue.startsWith('{')) {
                            let parsed = JSON.parse(scannedValue);
                            if (parsed.students_id) {
                                scannedValue = parsed.students_id;
                            }
                        }
                    } catch (e) {
                        // ignore parse errors
                    }

                    // Set and submit cleaned value
                    document.getElementById("qr-input").value = scannedValue;
                    submitQR();

                    // ✅ Clear input after slight delay
                    setTimeout(() => {
                        document.getElementById("qr-input").value = "";
                        document.getElementById("student_id").value = "";
                    }, 1000);

                    // ❌ Do NOT stop the scanner
                },
                function error(err) {
                    // Ignore scanning errors
                }
            );
        });
    </script>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.librarian', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\library\resources\views/students/qr.blade.php ENDPATH**/ ?>