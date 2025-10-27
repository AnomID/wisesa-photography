<!-- Payment Modal -->
<div id="paymentModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Payment</h3>
                <button type="button" class="modal-close" onclick="closePaymentModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form Content -->
                <div id="form-content">
                    <form id="paymentForm" action="{{ route('booking.payment.store', $booking->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Payment Type Field -->
                        <div class="form-field">
                            <label for="jenis_payment" class="form-label">Jenis Payment</label>
                            <select name="jenis_payment" id="jenis_payment" class="form-input" required>
                                <option value="">Pilih Jenis Payment</option>
                                <option value="DP">DP (Down Payment)</option>
                                <option value="Fullpayment">Full Payment</option>
                            </select>
                        </div>

                        <!-- Amount Field -->
                        <div class="form-field">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="number" name="nominal" id="nominal" class="form-input"
                                placeholder="Masukkan nominal pembayaran" required>
                        </div>

                        <!-- File Upload Field -->
                        <div class="form-field">
                            <label for="bukti_transfer" class="form-label">Unggah Bukti Transfer</label>
                            <div class="file-upload-area" onclick="document.getElementById('bukti_transfer').click()">
                                <input type="file" name="bukti_transfer" id="bukti_transfer" class="file-input"
                                    accept="image/*" required>
                                <div class="file-upload-content">
                                    <div class="file-upload-icon">
                                        <i class="fas fa-mountain-sun"></i>
                                    </div>
                                    <div class="file-upload-text">Unggah Bukti Transfer</div>
                                    <div class="file-upload-hint">Klik untuk memilih file atau drag & drop</div>
                                </div>
                            </div>
                            <div id="file-preview" class="file-preview" style="display: none;">
                                <img id="preview-image" src="" alt="Preview" class="preview-image">
                                <div class="file-info">
                                    <div class="file-name"></div>
                                    <button type="button" class="remove-file" onclick="removeFile()">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closePaymentModal()">Batal</button>
                <button type="button" class="btn-save" onclick="submitPaymentForm()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Payment Modal Functions
    function openPaymentModal() {
        document.getElementById('paymentModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        resetPaymentForm();
    }

    function resetPaymentForm() {
        document.getElementById('paymentForm').reset();
        document.getElementById('file-preview').style.display = 'none';
        document.getElementById('bukti_transfer').value = '';
        // Show file upload area again when form is reset
        document.querySelector('.file-upload-area').style.display = 'block';
        document.getElementById('form-content').style.display = 'block';
        document.querySelector('.modal-footer').style.display = 'flex';
    }

    function submitPaymentForm() {
        const form = document.getElementById('paymentForm');
        const formData = new FormData(form);

        // Validate form
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Show loading state
        const saveBtn = document.querySelector('.btn-save');
        const originalText = saveBtn.textContent;
        saveBtn.textContent = 'Menyimpan...';
        saveBtn.disabled = true;

        // Submit form
        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal first
                    closePaymentModal();

                    // Show success alert using SweetAlert after modal is closed
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Payment berhasil disimpan! Terima kasih! Payment Anda sedang diproses oleh admin.',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#FFC60A',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }, 300); // Small delay to ensure modal is fully closed
                } else {
                    // Reset button for error case
                    saveBtn.textContent = originalText;
                    saveBtn.disabled = false;

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Terjadi kesalahan saat menyimpan payment',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Reset button for error case
                saveBtn.textContent = originalText;
                saveBtn.disabled = false;

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan payment',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            });
    }

    // File upload handling
    document.getElementById('bukti_transfer').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.querySelector('.file-name').textContent = file.name;
                document.getElementById('file-preview').style.display = 'block';
                // Hide file upload area when file is selected
                document.querySelector('.file-upload-area').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    function removeFile() {
        document.getElementById('bukti_transfer').value = '';
        document.getElementById('file-preview').style.display = 'none';
        // Show file upload area again when file is removed
        document.querySelector('.file-upload-area').style.display = 'block';
    }

    // Close modal when clicking outside
    document.getElementById('paymentModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePaymentModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePaymentModal();
        }
    });
</script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
