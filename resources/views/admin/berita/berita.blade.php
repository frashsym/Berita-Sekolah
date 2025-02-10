@extends('layouts.admin.app')

@section('title', 'Data Berita')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Halaman Data Berita</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Berita</h6>
            </div>
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
                                <th>Tanggal Publikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($berita as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ Str::limit($item->isi_berita, 100, '...') }}</td> {{-- Tambahkan "..." di akhir --}}
                                    <td>{{ $item->kategori->kategori ?? 'Tidak Ada' }}</td>
                                    <td>{{ $item->penulis }}</td>
                                    <td>{{ $item->tanggal_publikasi }}</td>
                                    <td class="d-flex align-items-center gap-2">
                                        {{-- Tombol Detail (dengan ID berita) --}}
                                        <a href="{{ url('/berita/' . $item->id) }}" class="btn btn-info btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-info-circle"></i>
                                            </span>
                                        </a>

                                        {{-- Tombol Edit (Opsional, jika ingin ada edit) --}}
                                        <a href="{{ url('/berita/edit/' . $item->id) }}"
                                            class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                        </a>

                                        {{-- Tombol Hapus (dengan konfirmasi sebelum menghapus) --}}
                                        <form action="{{ url('/berita/' . $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
@endsection
