<!-- Selected Photos Modal -->
<div id="selectedPhotosModal" class="modal-overlay" style="display: none;">
    <div class="modal-container" style="width: 65%; max-width: 800px; height: 75vh; max-height: 650px;">
        <div class="modal-content" style="height: 100%; display: flex; flex-direction: column;">
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Selected Photos</h3>
                <button type="button" class="modal-close" onclick="closeSelectedPhotosModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="flex: 1; overflow: hidden; display: flex; flex-direction: column;">
                <div id="form-content" style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">
                    <form id="selectedPhotosForm" style="height: 100%; display: flex; flex-direction: column;">
                        @csrf
                        <div class="form-field"
                            style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">
                            <label for="selected_photos_link" class="form-label"
                                style="font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">Selected
                                Photos</label>
                            @if ($booking->progress && $booking->progress->selected_photos && $booking->progress->selected_photos_link)
                                <!-- Display as clickable links when data exists -->
                                <div id="selected-photos-display" class="form-input"
                                    style="flex: 1; min-height: 0; resize: none; overflow-y: auto; padding: 12px; white-space: pre-wrap; word-wrap: break-word;">
                                </div>
                            @else
                                <!-- Show as editable textarea when no data -->
                                <textarea name="selected_photos_link" id="selected_photos_link" class="form-input"
                                    placeholder="Masukkan link Google Drive atau keterangan selected photos..."
                                    style="flex: 1; min-height: 0; resize: none; overflow-y: auto;"></textarea>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" id="selectedPhotosFooter" style="flex-shrink: 0;">
                <button type="button" class="btn-cancel" onclick="closeSelectedPhotosModal()">Batal</button>
                <button type="button" class="btn-save" onclick="submitSelectedPhotosForm()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to make URLs clickable
    function makeLinksClickable(text) {
        const urlRegex = /(https?:\/\/[^\s\n]+|www\.[^\s\n]+)/g;
        return text.replace(urlRegex, function(url) {
            let href = url;
            if (url.startsWith('www.')) {
                href = 'https://' + url;
            }
            return '<a href="' + href +
                '" target="_blank" style="color: #007bff; text-decoration: underline; word-break: break-all;">' +
                url + '</a>';
        });
    }

    // Function to update clickable links when modal opens
    function updateSelectedPhotosDisplay() {
        const displayDiv = document.getElementById('selected-photos-display');
        if (displayDiv) {
            const content = @json($booking->progress->selected_photos_link ?? '');
            if (content) {
                displayDiv.innerHTML = makeLinksClickable(content);
            }
        }
    }

    // Load clickable links when modal opens (for saved data)
    @if ($booking->progress && $booking->progress->selected_photos && $booking->progress->selected_photos_link)
        // Update display when modal is opened
        const selectedPhotosModal = document.getElementById('selectedPhotosModal');
        if (selectedPhotosModal) {
            // Use MutationObserver to detect when modal opens
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'style') {
                        const isVisible = selectedPhotosModal.style.display === 'flex';
                        if (isVisible) {
                            updateSelectedPhotosDisplay();
                        }
                    }
                });
            });
            observer.observe(selectedPhotosModal, {
                attributes: true
            });
        }
    @endif

    // Selected Photos Modal Functions
    function closeSelectedPhotosModal() {
        document.getElementById('selectedPhotosModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function submitSelectedPhotosForm() {
        const form = document.getElementById('selectedPhotosForm');
        const formData = new FormData(form);

        // Validate form (check if textarea exists and has value)
        const textarea = document.getElementById('selected_photos_link');
        if (!textarea || !textarea.value.trim()) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Mohon isi selected photos link',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            return;
        }

        // Show loading state
        const saveBtn = document.querySelector('#selectedPhotosModal .btn-save');
        const originalText = saveBtn.textContent;
        saveBtn.textContent = 'Menyimpan...';
        saveBtn.disabled = true;

        // Submit form
        fetch('{{ route('booking.selected-photos.store', $booking->id) }}', {
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
                    closeSelectedPhotosModal();

                    // Show success alert using SweetAlert after modal is closed
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#28a745',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }, 300);
                } else {
                    // Reset button for error case
                    saveBtn.textContent = originalText;
                    saveBtn.disabled = false;

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Terjadi kesalahan saat menyimpan selected photos',
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
                    text: 'Terjadi kesalahan saat menyimpan selected photos',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            });
    }

    // Close modal when clicking outside
    document.getElementById('selectedPhotosModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeSelectedPhotosModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSelectedPhotosModal();
        }
    });
</script>
