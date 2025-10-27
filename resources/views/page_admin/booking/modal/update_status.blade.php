<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Status Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStatusForm" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="Diterima" {{ $booking->status == 'Diterima' ? 'selected' : '' }}>Diterima
                            </option>
                            <option value="Diproses" {{ $booking->status == 'Diproses' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="Selesai" {{ $booking->status == 'Selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="Ditolak" {{ $booking->status == 'Ditolak' ? 'selected' : '' }}>Ditolak
                            </option>
                            <option value="Dibatalkan" {{ $booking->status == 'Dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>

                        {{-- Tampilkan riwayat catatan jika sudah dalam format array --}}
                        @if ($booking->catatan && is_array($booking->catatan) && count($booking->catatan) > 0)
                            <div class="card bg-light border mb-3">
                                <div class="card-header bg-transparent border-0 py-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-history text-primary me-2"></i>
                                        <strong>Riwayat Catatan</strong>
                                    </h6>
                                </div>
                                <div class="card-body py-2" style="max-height: 200px; overflow-y: auto;">
                                    @foreach (array_reverse($booking->catatan) as $index => $item)
                                        <div class="border-start border-primary border-3 ps-3 mb-3 pb-2"
                                            style="background-color: #f8f9fa;">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <div>
                                                    <span
                                                        class="badge
                                                        @if ($item['status'] == 'Pending') bg-warning
                                                        @elseif($item['status'] == 'Ditolak') bg-danger
                                                        @elseif($item['status'] == 'Diterima') bg-info
                                                        @elseif($item['status'] == 'Diproses') bg-primary
                                                        @elseif($item['status'] == 'Selesai') bg-success
                                                        @else bg-secondary @endif
                                                        text-white me-2">
                                                        {{ $item['status'] }}
                                                    </span>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>{{ $item['tanggal'] ?? '' }}
                                                        <i class="fas fa-clock ms-2 me-1"></i>{{ $item['waktu'] ?? '' }}
                                                    </small>
                                                </div>
                                            </div>
                                            <p class="mb-0 mt-2"
                                                style="line-height: 1.6; white-space: pre-wrap; font-size: 0.9rem;">
                                                {{ $item['isi'] ?? '' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @elseif ($booking->catatan && is_string($booking->catatan))
                            {{-- Fallback untuk catatan lama yang masih string --}}
                            <div class="alert alert-info alert-sm mb-2" role="alert">
                                <strong><i class="fas fa-sticky-note me-2"></i>Catatan:</strong>
                                <p class="mb-0 mt-1" style="white-space: pre-wrap;">{{ $booking->catatan }}</p>
                            </div>
                        @endif

                        <textarea class="form-control" id="catatan" name="catatan" rows="4"
                            placeholder="Masukkan catatan tambahan untuk perubahan status ini (opsional)"></textarea>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>Catatan baru akan ditambahkan sebagai riwayat dengan
                            timestamp
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateStatusModal = document.getElementById('updateStatusModal');
        const updateStatusForm = document.getElementById('updateStatusForm');

        // Set form action URL when modal is shown
        updateStatusModal.addEventListener('show.bs.modal', function(event) {
            const bookingId = event.relatedTarget.getAttribute('data-booking-id');
            updateStatusForm.action = `/super-admin/booking/${bookingId}/update-status`;
        });

        // Handle form submission
        updateStatusForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');

            // Disable submit button to prevent double submission
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                'content');

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    // Check if response is ok
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message ||
                                `HTTP error! status: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Close modal first
                        const modal = bootstrap.Modal.getInstance(updateStatusModal);
                        modal.hide();

                        // Show success message with SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Status booking berhasil diperbarui',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            // Reload page to show updated status
                            window.location.reload();
                        });
                    } else {
                        // Re-enable button on error
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'Simpan';

                        // Show error message with SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message ||
                                'Terjadi kesalahan saat memperbarui status',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Re-enable button on error
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Simpan';

                    // Show error message with SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message || 'Terjadi kesalahan saat memperbarui status',
                        confirmButtonText: 'OK'
                    });
                });
        });
    });
</script>
