@extends('layouts.admin.app')

@section('title', 'Data Berita')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Halaman Data Berita</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!-- Header dengan tombol di kanan -->
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Berita</h6>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBeritaModal">
                    <i class="fas fa-plus"></i>
                    Tambah Berita
                </button>
            </div>

            <!-- Isi Tabel -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul Berita</th>
                                <th>Isi Berita</th>
                                <th>Kategori Berita</th>
                                <th>Penulis Berita</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($berita as $index => $item)
                                <tr>
                                    <td>{{ ($berita->currentPage() - 1) * $berita->perPage() + $loop->iteration }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ Str::limit($item->isi_berita, 100, '...') }}</td>
                                    <td>{{ $item->kategori->kategori ?? 'Tidak Ada' }}</td>
                                    <td>{{ $item->penulis }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#editBeritaModal{{ $item->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 512 512">
                                                    <path fill="white"
                                                        d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                                                </svg>
                                            </button>
                                            <!-- Tombol Detail -->
                                            <a href="{{ url('/berita/' . $item->id) }}" class="btn btn-warning">
                                                <span class="icon text-white-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                        <path fill="#ffffff"
                                                            d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <!-- Tombol Hapus -->
                                            <button type="button" class="btn btn-danger"
                                                onclick="hapusBerita({{ $item->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <!-- Form Hapus (Disembunyikan) -->
                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ url('/berita/' . $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $berita->links() }}
                    </div>
                </div>
            </div>

            <!-- Modal Create Berita -->
            <div class="modal fade" id="createBeritaModal" tabindex="-1" role="dialog" aria-labelledby="createBeritaLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createBeritaLabel">Tambah Berita Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="judul">Judul Berita</label>
                                    <input type="text" class="form-control" id="judul" name="judul" required>
                                </div>
                                <div class="form-group">
                                    <label for="isi_berita">Isi Berita</label>
                                    <textarea class="form-control" id="isi_berita" name="isi_berita" rows="4" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="penulis">Penulis</label>
                                    <input type="text" class="form-control" id="penulis" name="penulis" required>
                                </div>
                                <div class="form-group">
                                    <label for="kategori_id">Kategori</label>
                                    <select class="form-control" id="kategori_id" name="kategori_id" required>
                                        <option value="" disabled selected>Pilih Kategori</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="gambar_utama">Gambar Utama</label>
                                    <input type="file" class="form-control-file" id="gambar_utama" name="gambar_utama">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Berita</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($berita as $item)
                <!-- Modal Edit Berita untuk setiap berita -->
                <div class="modal fade" id="editBeritaModal{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editBeritaLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editBeritaLabel">Edit Berita</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('berita.update', $item->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="judul">Judul Berita</label>
                                        <input type="text" class="form-control" id="judul" name="judul"
                                            value="{{ old('judul', $item->judul) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="isi_berita">Isi Berita</label>
                                        <textarea class="form-control" id="isi_berita" name="isi_berita" rows="4" required>{{ old('isi_berita', $item->isi_berita) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_publikasi">Tanggal Publikasi</label>
                                        <input type="date" class="form-control" id="tanggal_publikasi"
                                            name="tanggal_publikasi"
                                            value="{{ old('tanggal_publikasi', $item->tanggal_publikasi) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jam_publikasi">Jam Publikasi</label>
                                        <input type="time" step="1" class="form-control" id="jam_publikasi"
                                            name="jam_publikasi" value="{{ old('jam_publikasi', $item->jam_publikasi) }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="penulis">Penulis</label>
                                        <input type="text" class="form-control" id="penulis" name="penulis"
                                            value="{{ old('penulis', $item->penulis) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori_id">Kategori</label>
                                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                                            <option value="" disabled>Pilih Kategori</option>
                                            @foreach ($kategori as $kat)
                                                <option value="{{ $kat->id }}"
                                                    {{ old('kategori_id', $item->kategori_id) == $kat->id ? 'selected' : '' }}>
                                                    {{ $kat->kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="gambar_utama">Ganti Gambar</label>
                                        <input type="file" class="form-control-file" id="gambar_utama"
                                            name="gambar_utama">

                                        @if (!empty($item->gambar_utama))
                                            <div class="mt-2">
                                                <img src="{{ asset('images/berita/' . $item->gambar_utama) }}"
                                                    alt="Gambar Berita" class="img-thumbnail" width="150">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endsection
