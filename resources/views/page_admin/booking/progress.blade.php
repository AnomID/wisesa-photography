@extends('template_admin.layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Update Progress Booking - {{ $booking->nama }}</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="alert alert-info">
                            <strong>Info:</strong> Centang checklist akan otomatis menyimpan timestamp.
                        </div>

                        <form action="{{ route('admin.booking.progress.update', $booking->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="jadwal_foto" id="jadwal_foto"
                                            value="1" {{ $booking->progress->jadwal_foto ? 'checked' : '' }}>
                                        <label class="form-check-label" for="jadwal_foto">
                                            <strong>Jadwal Foto</strong>
                                            @if ($booking->progress->jadwal_foto_at)
                                                <br><small class="text-muted">Selesai:
                                                    {{ $booking->progress->jadwal_foto_at->format('d M Y H:i') }}</small>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="file_jpg_upload"
                                            id="file_jpg_upload" value="1"
                                            {{ $booking->progress->file_jpg_upload ? 'checked' : '' }}>
                                        <label class="form-check-label" for="file_jpg_upload">
                                            <strong>File JPG Upload</strong>
                                            @if ($booking->progress->file_jpg_upload_at)
                                                <br><small class="text-muted">Selesai:
                                                    {{ $booking->progress->file_jpg_upload_at->format('d M Y H:i') }}</small>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label">Link File JPG</label>
                                        <input type="text" name="file_jpg_link" class="form-control"
                                            value="{{ $booking->progress->file_jpg_link }}"
                                            placeholder="https://drive.google.com/...">
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="selected_photos"
                                            id="selected_photos" value="1"
                                            {{ $booking->progress->selected_photos ? 'checked' : '' }}>
                                        <label class="form-check-label" for="selected_photos">
                                            <strong>Selected Photos</strong>
                                            @if ($booking->progress->selected_photos_at)
                                                <br><small class="text-muted">Selesai:
                                                    {{ $booking->progress->selected_photos_at->format('d M Y H:i') }}</small>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label">Link Selected Photos</label>
                                        <input type="text" name="selected_photos_link" class="form-control"
                                            value="{{ $booking->progress->selected_photos_link }}"
                                            placeholder="https://drive.google.com/...">
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="file_raw_upload"
                                            id="file_raw_upload" value="1"
                                            {{ $booking->progress->file_raw_upload ? 'checked' : '' }}>
                                        <label class="form-check-label" for="file_raw_upload">
                                            <strong>File RAW Upload</strong>
                                            @if ($booking->progress->file_raw_upload_at)
                                                <br><small class="text-muted">Selesai:
                                                    {{ $booking->progress->file_raw_upload_at->format('d M Y H:i') }}</small>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="editing_foto"
                                            id="editing_foto" value="1"
                                            {{ $booking->progress->editing_foto ? 'checked' : '' }}>
                                        <label class="form-check-label" for="editing_foto">
                                            <strong>Editing Foto</strong>
                                            @if ($booking->progress->editing_foto_at)
                                                <br><small class="text-muted">Selesai:
                                                    {{ $booking->progress->editing_foto_at->format('d M Y H:i') }}</small>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="foto_edited_upload"
                                            id="foto_edited_upload" value="1"
                                            {{ $booking->progress->foto_edited_upload ? 'checked' : '' }}>
                                        <label class="form-check-label" for="foto_edited_upload">
                                            <strong>Foto Edited Upload</strong>
                                            @if ($booking->progress->foto_edited_upload_at)
                                                <br><small class="text-muted">Selesai:
                                                    {{ $booking->progress->foto_edited_upload_at->format('d M Y H:i') }}</small>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Progress
                                </button>
                                <a href="{{ route('admin.booking.show', $booking->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
