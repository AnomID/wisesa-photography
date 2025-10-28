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
                                    <label class="form-label">Gambar Utama</label>
                                    <input type="file" name="gambar" id="gambar-utama"
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
                                                id="preview-gambar-utama" alt="Gambar {{ $galeri->keterangan }}"
                                                class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    @endif
                                </div>

                                <!-- List Gallery Existing -->
                                @if ($galeri->list_gallery && count($galeri->list_gallery) > 0)
                                    <div class="form-group">
                                        <label class="form-label">Gallery Tambahan (Existing)</label>
                                        @foreach ($galeri->list_gallery as $index => $item)
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <input type="hidden" name="list_index[]" value="{{ $index }}">
                                                    <h6 class="card-title">Item Gallery {{ $index + 1 }}</h6>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            @if (isset($item['gambar']))
                                                                <img src="{{ asset('upload/galeri/' . $item['gambar']) }}"
                                                                    class="img-thumbnail" style="max-height: 100px;"
                                                                    alt="Gallery Image">
                                                                <input type="file" name="list_gambar[]"
                                                                    class="form-control mt-2" accept="image/*">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label class="form-label">Judul</label>
                                                                <input type="text" name="list_judul_existing[]"
                                                                    class="form-control"
                                                                    value="{{ $item['judul_galeri'] ?? '' }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Keterangan</label>
                                                                <textarea name="list_keterangan_existing[]" class="form-control list-keterangan-existing"
                                                                    id="list_keterangan_existing_{{ $index }}" rows="3">{{ $item['keterangan'] ?? '' }}</textarea>
                                                            </div>
                                                            <div class="btn-group" role="group">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-success btn-swap-existing"
                                                                    data-index="{{ $index }}">
                                                                    <i class="ti ti-refresh"></i> Swap
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger hapus-gallery-existing"
                                                                    data-index="{{ $index }}">
                                                                    <i class="ti ti-trash"></i> Hapus
                                                                </button>
                                                            </div>
                                                            <input type="hidden" name="hapus_gambar[]"
                                                                id="hapus_{{ $index }}" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- List Gallery New -->
                                <div class="form-group">
                                    <label class="form-label">Tambah Gallery Baru</label>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <button type="button" class="btn btn-sm btn-info" id="tambah-gallery">
                                            <i class="ti ti-plus"></i> Tambah Item Gallery
                                        </button>
                                        <div class="new-gallery-pagination"></div>
                                    </div>
                                    <div id="list-gallery-container"></div>
                                    <small class="text-muted d-block mt-2">
                                        <i class="ti ti-info-circle"></i> Tips: Menampilkan 5 item per halaman. Anda dapat
                                        menukar posisi gambar utama dengan klik tombol swap pada setiap item gallery.
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
        let galleryCounter = {{ $galeri->list_gallery ? count($galeri->list_gallery) : 0 }};
        let editors = {};
        let gambarUtamaValue = '{{ $galeri->gambar }}';
        let currentPageNew = 1;
        const itemsPerPageNew = 5;
        let allNewGalleryItems = [];

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor.create(document.querySelector('#keterangan'))
                .then(editorInstance => {
                    editor = editorInstance;
                })
                .catch((error) => {
                    console.error(error);
                });

            document.querySelectorAll('.list-keterangan-existing').forEach(function(textarea) {
                const id = textarea.id;
                ClassicEditor.create(textarea)
                    .then(editorInstance => {
                        editors[id] = editorInstance;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
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

            const gambarUtamaInput = document.getElementById('gambar-utama');
            const previewGambarUtama = document.getElementById('preview-gambar-utama');

            document.querySelectorAll('.hapus-gallery-existing').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    const hiddenInput = document.getElementById('hapus_' + index);
                    if (hiddenInput) {
                        hiddenInput.value = index;
                    }
                    const editorId = 'list_keterangan_existing_' + index;
                    if (editors[editorId]) {
                        editors[editorId].destroy();
                        delete editors[editorId];
                    }
                    this.closest('.card').style.display = 'none';
                });
            });

            document.querySelectorAll('.btn-swap-existing').forEach(function(btn) {
                btn.addEventListener('click', async function() {
                    const index = this.getAttribute('data-index');
                    const galeriId = {{ $galeri->id }};

                    Swal.fire({
                        title: 'Memproses swap...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    try {
                        const response = await fetch('{{ route('galeri.swap') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                gallery_id: galeriId,
                                gallery_index: index
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: result.message,
                                timer: 2000,
                                showConfirmButton: false,
                                didClose: () => {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: result.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat men-swap.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });

            function renderPaginationNew() {
                const totalPages = Math.ceil(allNewGalleryItems.length / itemsPerPageNew);
                const paginationDiv = document.querySelector('.new-gallery-pagination');

                if (totalPages <= 1) {
                    paginationDiv.innerHTML = '';
                    return;
                }

                let paginationHTML = '<nav><ul class="pagination pagination-sm mb-0">';
                for (let i = 1; i <= totalPages; i++) {
                    paginationHTML += `<li class="page-item ${i === currentPageNew ? 'active' : ''}">
                        <button class="page-link" type="button" data-page="${i}">${i}</button>
                    </li>`;
                }
                paginationHTML += '</ul></nav>';
                paginationDiv.innerHTML = paginationHTML;

                paginationDiv.querySelectorAll('.page-link').forEach(btn => {
                    btn.addEventListener('click', function() {
                        currentPageNew = parseInt(this.getAttribute('data-page'));
                        renderNewGalleryItems();
                    });
                });
            }

            function renderNewGalleryItems() {
                const listGalleryContainer = document.getElementById('list-gallery-container');
                listGalleryContainer.innerHTML = '';

                const startIndex = (currentPageNew - 1) * itemsPerPageNew;
                const endIndex = startIndex + itemsPerPageNew;
                const itemsToShow = allNewGalleryItems.slice(startIndex, endIndex);

                itemsToShow.forEach(item => {
                    listGalleryContainer.appendChild(item);
                });

                renderPaginationNew();
            }

            const tambahGalleryBtn = document.getElementById('tambah-gallery');
            if (tambahGalleryBtn) {
                tambahGalleryBtn.addEventListener('click', function() {
                    const galleryItem = document.createElement('div');
                    galleryItem.classList.add('card', 'mb-2', 'gallery-item');
                    galleryItem.setAttribute('data-index', galleryCounter);

                    galleryItem.innerHTML = `
                        <div class="card-body">
                            <h6 class="card-title">Item Gallery Baru ${galleryCounter + 1}</h6>
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
                                    <i class="ti ti-refresh"></i> Swap
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
                    allNewGalleryItems.push(galleryItem);

                    galleryItem.querySelector('.hapus-gallery').addEventListener('click', function() {
                        const index = galleryItem.getAttribute('data-index');
                        if (editors[index]) {
                            editors[index].destroy();
                            delete editors[index];
                        }
                        allNewGalleryItems = allNewGalleryItems.filter(item => item !==
                        galleryItem);
                        renderNewGalleryItems();
                    });

                    galleryItem.querySelector('.btn-swap').addEventListener('click', async function() {
                        const index = this.getAttribute('data-index');
                        const galleryItem = this.closest('.gallery-item');
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
                            .getData() : '';

                        // Ambil nilai dari gambar utama
                        const utamaFiles = gambarUtamaInput.files;
                        const utamaJudulValue = judulUtamaInput.value;
                        const utamaKeteranganValue = editor.getData();

                        // Validasi: file gallery harus ada untuk swap
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

                        // Validasi: file utama harus ada untuk swap (atau ada file yang sudah ada)
                        if (utamaFiles.length === 0 && !gambarUtamaValue) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan!',
                                text: 'Tidak ada gambar untuk di-swap',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            return;
                        }

                        try {
                            const tempGalleryFile = galleryFiles.length > 0 ? galleryFiles[0] :
                                null;
                            const tempUtamaFile = utamaFiles.length > 0 ? utamaFiles[0] : null;

                            try {
                                if (tempGalleryFile && tempGalleryFile instanceof File) {
                                    const dt1 = new DataTransfer();
                                    dt1.items.add(tempGalleryFile);
                                    gambarUtamaInput.files = dt1.files;
                                    console.log('✓ Swapped main image:', tempGalleryFile.name);

                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        if (previewGambarUtama) {
                                            previewGambarUtama.src = e.target.result;
                                        }
                                    };
                                    reader.readAsDataURL(tempGalleryFile);
                                }

                                if (tempUtamaFile && tempUtamaFile instanceof File) {
                                    const dt2 = new DataTransfer();
                                    dt2.items.add(tempUtamaFile);
                                    galleryGambar.files = dt2.files;
                                    console.log('✓ Swapped gallery image:', tempUtamaFile.name);
                                }
                            } catch (fileSwapError) {
                                console.warn('File swap partial - metadata swapped:',
                                    fileSwapError);
                            }

                            galleryJudul.value = utamaJudulValue;
                            judulUtamaInput.value = galleryJudulValue;

                            if (galleryKeterangan) {
                                galleryKeterangan.setData(utamaKeteranganValue);
                            }
                            editor.setData(galleryKeteranganValue);

                            await Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Gambar, judul dan keterangan berhasil di-swap',
                                timer: 2000,
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

                    renderNewGalleryItems();
                });
            }
        });
    </script>
@endsection
