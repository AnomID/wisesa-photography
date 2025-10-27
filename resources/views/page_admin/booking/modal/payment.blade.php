<!-- Modal Payment Detail -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <div>
                    <h5 class="modal-title mb-0" id="paymentModalLabel">Payment</h5>
                    <span id="payment_status_badge" class="badge mt-2" style="display: none;"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Jenis Payment -->
                <div class="mb-3">
                    <label for="jenis_payment" class="form-label">Jenis Payment</label>
                    <input type="text" class="form-control" id="jenis_payment" readonly value="">
                </div>

                <!-- Nominal -->
                <div class="mb-3">
                    <label for="nominal" class="form-label">Nominal</label>
                    <input type="text" class="form-control" id="nominal" readonly value="">
                </div>

                <!-- Bukti Transfer -->
                <div class="mb-3">
                    <label class="form-label">Bukti Transfer</label>
                    <div id="bukti_transfer_container" class="border rounded p-3 text-center bg-light"
                        style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                        <div id="bukti_transfer_placeholder">
                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Bukti Transfer</p>
                        </div>
                        <img id="bukti_transfer_image" src="" alt="Bukti Transfer" class="img-fluid d-none"
                            style="max-height: 300px;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Tombol untuk status Pending -->
                <div id="pending_actions" style="display: none;">
                    <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal"
                        style="background-color: white; border-color: #17a2b8; color: #17a2b8;">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                    <button type="button" class="btn btn-info text-white" id="btnVerifikasi">
                        <i class="fas fa-check"></i> Verivikasi
                    </button>
                </div>

                <!-- Tombol untuk status Terkonfirmasi -->
                <div id="confirmed_action" style="display: none;">
                    <button type="button" class="btn btn-info text-white w-100" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentModal = document.getElementById('paymentModal');
        const btnVerifikasi = document.getElementById('btnVerifikasi');

        let currentBookingId = null;

        // Set payment data when modal is shown
        paymentModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            currentBookingId = button.getAttribute('data-booking-id');

            // Reset form fields
            document.getElementById('jenis_payment').value = '';
            document.getElementById('nominal').value = '';
            document.getElementById('bukti_transfer_image').src = '';
            document.getElementById('bukti_transfer_placeholder').classList.remove('d-none');
            document.getElementById('bukti_transfer_image').classList.add('d-none');

            // Reset badge
            document.getElementById('payment_status_badge').style.display = 'none';

            // Reset tombol
            document.getElementById('pending_actions').style.display = 'none';
            document.getElementById('confirmed_action').style.display = 'none';

            // Fetch payment data
            fetch(`/super-admin/payment/${currentBookingId}/json`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const payment = data.payment;

                        // Set jenis payment
                        document.getElementById('jenis_payment').value = payment.jenis_payment ||
                            '-';

                        // Set nominal with currency format
                        document.getElementById('nominal').value = 'Rp ' + new Intl.NumberFormat(
                            'id-ID').format(payment.nominal);

                        // Set bukti transfer image
                        const placeholder = document.getElementById('bukti_transfer_placeholder');
                        const image = document.getElementById('bukti_transfer_image');

                        if (payment.bukti_transfer_url) {
                            const imageUrl = payment.bukti_transfer_url;
                            console.log('Loading image from:', imageUrl);

                            image.src = imageUrl;

                            // Handle image load error
                            image.onerror = function() {
                                console.error('Failed to load image:', imageUrl);
                                placeholder.classList.remove('d-none');
                                image.classList.add('d-none');
                            };

                            // Handle image load success
                            image.onload = function() {
                                console.log('Image loaded successfully:', imageUrl);
                                placeholder.classList.add('d-none');
                                image.classList.remove('d-none');
                            };
                        } else {
                            placeholder.classList.remove('d-none');
                            image.classList.add('d-none');
                        }

                        // Tampilkan badge status payment
                        const statusBadge = document.getElementById('payment_status_badge');
                        if (payment.status === 'Terkonfirmasi') {
                            statusBadge.textContent = 'Terkonfirmasi';
                            statusBadge.className = 'badge bg-success mt-2';
                            statusBadge.style.display = 'inline-block';
                        } else if (payment.status === 'Pending') {
                            statusBadge.textContent = 'Pending';
                            statusBadge.className = 'badge bg-warning mt-2';
                            statusBadge.style.display = 'inline-block';
                        } else if (payment.status === 'Ditolak') {
                            statusBadge.textContent = 'Ditolak';
                            statusBadge.className = 'badge bg-danger mt-2';
                            statusBadge.style.display = 'inline-block';
                        }

                        // Tampilkan tombol berdasarkan status payment
                        const pendingActions = document.getElementById('pending_actions');
                        const confirmedAction = document.getElementById('confirmed_action');

                        if (payment.status === 'Terkonfirmasi') {
                            // Payment sudah dikonfirmasi, tampilkan tombol tutup saja
                            pendingActions.style.display = 'none';
                            confirmedAction.style.display = 'block';
                        } else {
                            // Payment belum dikonfirmasi, tampilkan tombol Tolak dan Verifikasi
                            pendingActions.style.display = 'block';
                            confirmedAction.style.display = 'none';
                        }
                    } else {
                        const modal = bootstrap.Modal.getInstance(paymentModal);
                        modal.hide();

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Gagal memuat data pembayaran',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const modal = bootstrap.Modal.getInstance(paymentModal);
                    modal.hide();

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memuat data pembayaran',
                        confirmButtonText: 'OK'
                    });
                });
        });

        // Set verifikasi button action
        btnVerifikasi.addEventListener('click', function() {
            if (!currentBookingId) {
                return;
            }

            // Disable button
            btnVerifikasi.disabled = true;
            btnVerifikasi.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                'content');

            // Send verification request
            fetch(`/super-admin/payment/${currentBookingId}/verifikasi`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(paymentModal);
                        modal.hide();

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Pembayaran berhasil diverifikasi',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reload page
                            window.location.reload();
                        });
                    } else {
                        // Re-enable button
                        btnVerifikasi.disabled = false;
                        btnVerifikasi.innerHTML = '<i class="fas fa-check"></i> Verivikasi';

                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Gagal memverifikasi pembayaran',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Re-enable button
                    btnVerifikasi.disabled = false;
                    btnVerifikasi.innerHTML = '<i class="fas fa-check"></i> Verivikasi';

                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memverifikasi pembayaran',
                        confirmButtonText: 'OK'
                    });
                });
        });
    });
</script>
