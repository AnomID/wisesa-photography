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
                                <li class="breadcrumb-item"><a href="{{ route('layanan.index') }}">Layanan</a></li>
                                <li class="breadcrumb-item" aria-current="page">Form Tambah Layanan</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Form Tambah Layanan</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Form Tambah Layanan</h5>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label" for="judul">Judul Layanan</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                        id="judul" name="judul" placeholder="Masukkan judul layanan"
                                        value="{{ old('judul') }}" />
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="deskripsi">Deskripsi Layanan</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                        placeholder="Masukkan deskripsi layanan">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="gambar">Gambar Layanan</label>
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                        id="gambar" name="gambar" accept="image/*" />
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="preview" src="#" alt="Preview" class="img-thumbnail d-none"
                                            style="max-height: 200px;">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="price_list_pdf">Price List PDF (Opsional)</label>
                                    <input type="file" class="form-control @error('price_list_pdf') is-invalid @enderror"
                                        id="price_list_pdf" name="price_list_pdf" accept=".pdf" />
                                    <small class="text-muted">Format: PDF. Maksimal 10MB</small>
                                    @error('price_list_pdf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <a href="{{ route('layanan.index') }}" class="btn btn-light">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
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
            ClassicEditor.create(document.querySelector('#deskripsi'))
                .then(editorInstance => {
                    editor = editorInstance;
                })
                .catch((error) => {
                    console.error(error);
                });

            // Preview gambar
            var inputGambar = document.getElementById('gambar');
            if (!inputGambar) return;
            inputGambar.addEventListener('change', function(e) {
                var preview = document.getElementById('preview');
                var file = e.target.files[0];
                if (!file) return;
                var reader = new FileReader();
                reader.onload = function(ev) {
                    preview.src = ev.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
