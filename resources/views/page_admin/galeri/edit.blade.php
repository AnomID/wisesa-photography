@extends('template_admin.layout')

@section('content')
    <section class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard-asisten">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Galeri</a></li>
                                <li class="breadcrumb-item" aria-current="page">Form Edit Data Galeri</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Form Edit Data Galeri</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row justify-content-center">
                <!-- [ form-element ] start -->
                <div class="col-sm-6">
                    <!-- Basic Inputs -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Form Edit Data Galeri</h5>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('galeri.update', $galeri->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="form-label">Judul Galeri</label>
                                    <input type="text" name="judul_galeri"
                                        class="form-control @error('judul_galeri') is-invalid @enderror"
                                        value="{{ old('judul_galeri', $galeri->judul_galeri) }}" required>
                                    @error('judul_galeri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ old('keterangan', $galeri->keterangan) }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Layanan</label>
                                    <select name="layanan_id" class="form-control @error('layanan_id') is-invalid @enderror"
                                        required>
                                        <option value="">Pilih Layanan</option>
                                        @foreach ($layanans as $layanan)
                                            <option value="{{ $layanan->id }}"
                                                {{ old('layanan_id', $galeri->layanan_id) == $layanan->id ? 'selected' : '' }}>
                                                {{ $layanan->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('layanan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gambar</label>
                                    <input type="file" name="gambar"
                                        class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">Format: jpeg, png, jpg, gif, svg. Maksimal 7MB. Kosongkan jika
                                        tidak ingin mengubah gambar.</small>
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($galeri->gambar)
                                        <div class="mt-2">
                                            <label class="form-label">Gambar Saat Ini</label>
                                            <img src="{{ asset('upload/galeri/' . $galeri->gambar) }}"
                                                alt="Gambar {{ $galeri->keterangan }}" class="img-thumbnail"
                                                style="max-height: 200px;">
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <button type="reset" class="btn btn-light">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <!-- Ckeditor js -->
    <script src="{{ asset('admin/assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
    <script>
        let editor;

        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi CKEditor
            ClassicEditor.create(document.querySelector('#keterangan'))
                .then(editorInstance => {
                    editor = editorInstance;
                })
                .catch((error) => {
                    console.error(error);
                });

            // Validasi form submit
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (editor) {
                        const content = editor.getData();
                        if (!content || content.trim() === '' || content === '<p></p>') {
                            e.preventDefault();
                            alert('Keterangan tidak boleh kosong!');
                            editor.focus();
                            return false;
                        }
                    }
                });
            }
        });
    </script>
@endsection
