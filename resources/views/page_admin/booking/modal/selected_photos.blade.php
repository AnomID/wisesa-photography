<!-- Modal Selected Photos -->
<div class="modal fade" id="selectedPhotosModal" tabindex="-1" aria-labelledby="selectedPhotosModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectedPhotosModalLabel">
                    <i class="fas fa-images me-2"></i>
                    Selected Photos Booking #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($booking->progress && $booking->progress->selected_photos && $booking->progress->selected_photos_link)
                    <div class="mb-3">
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Selected Photos telah diupload!</strong>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-link me-2"></i>
                                Link Selected Photos
                            </h6>
                        </div>
                        <div class="card-body" id="selected-photos-content"
                            style="max-height: 500px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;">
                            <!-- Content will be populated by JavaScript -->
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3 opacity-50"></i>
                        <p class="mb-0">Belum ada Selected Photos untuk booking ini.</p>
                        <p class="mb-0 mt-2">Selected Photos akan muncul setelah ditambahkan oleh user.</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    #selected-photos-content::-webkit-scrollbar {
        width: 8px;
    }

    #selected-photos-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #selected-photos-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    #selected-photos-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    #selected-photos-content a {
        color: #007bff !important;
        text-decoration: underline;
        word-break: break-all;
        display: inline-block;
        margin: 2px 0;
    }

    #selected-photos-content a:hover {
        color: #0056b3 !important;
        text-decoration: underline !important;
    }
</style>

<script>
    // Function to make URLs clickable
    function makeLinksClickable(text) {
        if (!text) return '';

        const urlRegex = /(https?:\/\/[^\s]+|www\.[^\s]+)/g;
        let result = text;
        let match;

        // Find all URLs and replace them with clickable links
        const processedText = text.replace(urlRegex, function(url) {
            let href = url;
            if (url.startsWith('www.')) {
                href = 'https://' + url;
            }
            return '<a href="' + href + '" target="_blank" rel="noopener noreferrer">' + url + '</a>';
        });

        return processedText;
    }

    // Update content when modal is shown
    document.addEventListener('DOMContentLoaded', function() {
        const selectedPhotosModal = document.getElementById('selectedPhotosModal');

        if (selectedPhotosModal) {
            selectedPhotosModal.addEventListener('show.bs.modal', function(event) {
                const contentDiv = document.getElementById('selected-photos-content');

                @if ($booking->progress && $booking->progress->selected_photos && $booking->progress->selected_photos_link)
                    const content = @json($booking->progress->selected_photos_link ?? '');
                    if (content && contentDiv) {
                        contentDiv.innerHTML = makeLinksClickable(content);
                    }
                @endif
            });
        }
    });
</script>
