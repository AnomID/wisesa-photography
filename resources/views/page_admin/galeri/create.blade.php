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
                                <li class="breadcrumb-item" aria-current="page">Form Tambah Data Galeri</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Form Tambah Data Galeri</h2>
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
                            <h5>Form Tambah Data Galeri</h5>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Judul Galeri</label>
                                    <input type="text" name="judul_galeri"
                                        class="form-control @error('judul_galeri') is-invalid @enderror"
                                        value="{{ old('judul_galeri') }}" placeholder="Masukkan judul galeri" required>
                                    @error('judul_galeri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                        placeholder="Masukkan keterangan">{{ old('keterangan') }}</textarea>
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
                                                {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                                {{ $layanan->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('layanan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gambar Utama</label>
                                    <input type="file" name="gambar" id="gambar-utama"
                                        class="form-control @error('gambar') is-invalid @enderror" accept="image/*"
                                        required>
                                    <small class="text-muted">Format: jpeg, png, jpg, gif, svg. Maksimal 7MB</small>
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- List Gallery -->
                                <div class="form-group">
                                    <label class="form-label">Gallery Tambahan (Optional)</label>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <button type="button" class="btn btn-sm btn-info" id="tambah-gallery">
                                            <i class="ti ti-plus"></i> Tambah Item Gallery
                                        </button>
                                        <div class="gallery-pagination"></div>
                                    </div>
                                    <div id="list-gallery-container"></div>
                                    <small class="text-muted d-block mt-2">
                                        <i class="ti ti-info-circle"></i> Tips: Anda dapat menukar posisi gambar utama
                                        dengan klik tombol swap pada setiap item gallery.
                                    </small>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let editor;
        let galleryCounter = 0;
        let editors = {};
        let fileStorage = {
            main: null,
            galleries: {}
        };
        let currentPage = 1;
        const itemsPerPage = 5;
        let allGalleryItems = [];

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor.create(document.querySelector('#keterangan'))
                .then(editorInstance => {
                    editor = editorInstance;
                })
                .catch((error) => {
                    console.error(error);
                });

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

            const tambahGalleryBtn = document.getElementById('tambah-gallery');
            const listGalleryContainer = document.getElementById('list-gallery-container');
            const gambarUtamaInput = document.getElementById('gambar-utama');
            const keteranganTextarea = document.querySelector('#keterangan');

            if (gambarUtamaInput) {
                gambarUtamaInput.addEventListener('change', function(e) {
                    if (this.files && this.files.length > 0) {
                        fileStorage.main = this.files[0];
                        console.log('Main file stored:', this.files[0].name);
                    }
                });
            }

            function renderPagination() {
                const totalPages = Math.ceil(allGalleryItems.length / itemsPerPage);
                const paginationDiv = document.querySelector('.gallery-pagination');

                if (totalPages <= 1) {
                    paginationDiv.innerHTML = '';
                    return;
                }

                let paginationHTML = '<nav><ul class="pagination pagination-sm mb-0">';

                for (let i = 1; i <= totalPages; i++) {
                    paginationHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                        <button class="page-link" type="button" data-page="${i}">${i}</button>
                    </li>`;
                }

                paginationHTML += '</ul></nav>';
                paginationDiv.innerHTML = paginationHTML;

                paginationDiv.querySelectorAll('.page-link').forEach(btn => {
                    btn.addEventListener('click', function() {
                        currentPage = parseInt(this.getAttribute('data-page'));
                        renderGalleryItems();
                    });
                });
            }

            function renderGalleryItems() {
                listGalleryContainer.innerHTML = '';

                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                const itemsToShow = allGalleryItems.slice(startIndex, endIndex);

                itemsToShow.forEach(item => {
                    listGalleryContainer.appendChild(item);
                });

                renderPagination();
            }

            tambahGalleryBtn.addEventListener('click', function() {
                const galleryItem = document.createElement('div');
                galleryItem.classList.add('card', 'mb-2', 'gallery-item');
                galleryItem.setAttribute('data-index', galleryCounter);

                galleryItem.innerHTML = `
                    <div class="card-body">
                        <h6 class="card-title">Item Gallery ${galleryCounter + 1}</h6>
                        <input type="hidden" name="list_swap_indicator[]" class="swap-indicator" value="">
                        <div class="form-group">
                            <label class="form-label">Judul</label>
                            <input type="text" name="list_judul[]" class="form-control" placeholder="Judul gallery">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="list_gambar[]" class="form-control gallery-gambar" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea name="list_keterangan[]" class="form-control list-keterangan" id="list_keterangan_${galleryCounter}" rows="3" placeholder="Keterangan gallery"></textarea>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-success btn-swap" data-index="${galleryCounter}">
                                <i class="ti ti-refresh"></i> Swap dengan Gambar Utama
                            </button>
                            <button type="button" class="btn btn-sm btn-danger hapus-gallery">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                `;

                const textarea = galleryItem.querySelector('.list-keterangan');
                ClassicEditor.create(textarea)
                    .then(editorInstance => {
                        editors[galleryCounter] = editorInstance;
                    })
                    .catch((error) => {
                        console.error(error);
                    });

                galleryCounter++;
                allGalleryItems.push(galleryItem);

                const galleryFileInput = galleryItem.querySelector('.gallery-gambar');
                if (galleryFileInput) {
                    galleryFileInput.addEventListener('change', function(e) {
                        const index = galleryItem.getAttribute('data-index');
                        if (this.files && this.files.length > 0) {
                            fileStorage.galleries[index] = this.files[0];
                            console.log('Gallery file stored for index', index, ':', this.files[0]
                                .name);
                        }
                    });
                }

                galleryItem.querySelector('.hapus-gallery').addEventListener('click', function() {
                    const index = galleryItem.getAttribute('data-index');
                    if (editors[index]) {
                        editors[index].destroy();
                        delete editors[index];
                    }
                    delete fileStorage.galleries[index];
                    allGalleryItems = allGalleryItems.filter(item => item !== galleryItem);
                    renderGalleryItems();
                });

                galleryItem.querySelector('.btn-swap').addEventListener('click', async function() {
                    const index = this.getAttribute('data-index');
                    const galleryGambar = galleryItem.querySelector('.gallery-gambar');
                    const galleryJudul = galleryItem.querySelector(
                        'input[name="list_judul[]"]');
                    const galleryKeterangan = editors[index];
                    const judulUtamaInput = document.querySelector(
                        'input[name="judul_galeri"]');

                    // Ambil nilai dari gallery
                    const galleryFiles = galleryGambar.files;
                    const galleryJudulValue = galleryJudul.value;
                    const galleryKeteranganValue = galleryKeterangan ? galleryKeterangan
                        .getData() :
                        '';

                    // Ambil nilai dari gambar utama
                    const utamaFiles = gambarUtamaInput.files;
                    const utamaJudulValue = judulUtamaInput.value;
                    const utamaKeteranganValue = editor.getData();

                    if (galleryFiles.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan!',
                            text: 'Silakan pilih gambar terlebih dahulu pada item gallery ini',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    if (utamaFiles.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan!',
                            text: 'Gambar utama wajib dipilih terlebih dahulu',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    try {
                        const tempGalleryFile = fileStorage.galleries[index] || (galleryFiles
                            .length > 0 ? galleryFiles[0] : null);
                        const tempUtamaFile = fileStorage.main || (utamaFiles.length > 0 ?
                            utamaFiles[0] : null);

                        console.log('Swapping files:', {
                            galleryFile: tempGalleryFile?.name,
                            utamaFile: tempUtamaFile?.name
                        });

                        if (tempGalleryFile && tempGalleryFile instanceof File) {
                            const dt1 = new DataTransfer();
                            dt1.items.add(tempGalleryFile);
                            gambarUtamaInput.files = dt1.files;
                            fileStorage.main = tempGalleryFile;
                            gambarUtamaInput.dispatchEvent(new Event('change', {
                                bubbles: true
                            }));
                            console.log('✓ Main image swapped to:', tempGalleryFile.name);
                        }

                        if (tempUtamaFile && tempUtamaFile instanceof File) {
                            const dt2 = new DataTransfer();
                            dt2.items.add(tempUtamaFile);
                            galleryGambar.files = dt2.files;
                            fileStorage.galleries[index] = tempUtamaFile;
                            galleryGambar.dispatchEvent(new Event('change', {
                                bubbles: true
                            }));
                            console.log('✓ Gallery image swapped to:', tempUtamaFile.name);
                        }

                        const swapIndicator = galleryItem.querySelector('.swap-indicator');
                        if (swapIndicator) {
                            swapIndicator.value = 'swapped';
                        }

                        galleryJudul.value = utamaJudulValue;
                        judulUtamaInput.value = galleryJudulValue;

                        if (galleryKeterangan) {
                            galleryKeterangan.setData(utamaKeteranganValue);
                        }
                        if (editor) {
                            editor.setData(galleryKeteranganValue);
                        }

                        await Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Gambar, judul dan keterangan berhasil di-swap. File akan diproses saat submit.',
                            timer: 2500,
                            showConfirmButton: false
                        });

                    } catch (error) {
                        console.error('Error swapping files:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat men-swap file. Silakan coba lagi.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });

                renderGalleryItems();
            });
        });
    </script>
@endsection
