<!-- Modal Riwayat Catatan -->
<div class="modal fade" id="riwayatCatatanModal" tabindex="-1" aria-labelledby="riwayatCatatanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="riwayatCatatanModalLabel">
                    <i class="fas fa-history me-2"></i>
                    Riwayat Catatan Booking #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($booking->catatan && is_array($booking->catatan) && count($booking->catatan) > 0)
                    <div style="max-height: 500px; overflow-y: auto;">
                        @foreach (array_reverse($booking->catatan) as $index => $item)
                            <div
                                class="border-start border-3 ps-3 mb-3 pb-3
                                @if ($item['status'] == 'Pending') border-warning
                                @elseif($item['status'] == 'Ditolak') border-danger
                                @elseif($item['status'] == 'Diterima') border-info
                                @elseif($item['status'] == 'Diproses') border-primary
                                @elseif($item['status'] == 'Selesai') border-success
                                @else border-secondary @endif">
                                <div class="d-flex align-items-center mb-2">
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
                                    <span class="text-muted small">
                                        <i class="fas fa-calendar me-1"></i>{{ $item['tanggal'] ?? '-' }}
                                        <i class="fas fa-clock ms-2 me-1"></i>{{ $item['waktu'] ?? '-' }}
                                    </span>
                                </div>
                                <p class="mb-0" style="white-space: pre-wrap; word-wrap: break-word;">
                                    {{ $item['isi'] ?? '-' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @elseif ($booking->catatan && is_string($booking->catatan))
                    {{-- Fallback untuk catatan lama yang masih string --}}
                    <div class="p-3 border rounded">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $booking->catatan }}</p>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x mb-3 text-muted opacity-50"></i>
                        <p class="text-muted mb-0">Belum ada catatan untuk booking ini.</p>
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
    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #999;
    }
</style>
