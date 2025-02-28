@extends('layouts.admin.app')

@section('title', 'Data Komentar')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Halaman Data Komentar</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Komentar</h6>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCommentModal">
                    <i class="fas fa-plus"></i>
                    Tambah Komentar
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Komentar</th>
                                <th>Berita</th>
                                <th>Rating</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $index => $comment)
                                <tr>
                                    <td>{{ ($comments->currentPage() - 1) * $comments->perPage() + $loop->iteration }}</td>
                                    <td>{{ $comment->nama }}</td>
                                    <td>{{ Str::limit($comment->isi_komentar, 100, '...') }}</td>
                                    <td>{{ $comment->berita->judul ?? 'Tidak Ada' }}</td>
                                    <td>{{ $comment->rating }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#editCommentModal{{ $comment->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 512 512">
                                                    <path fill="white"
                                                        d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                                                </svg>
                                            </button>

                                            <a href="{{ url('/comments/' . $comment->id) }}" class="btn btn-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                    <path fill="#ffffff"
                                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                </svg>
                                            </a>

                                            <button type="button" class="btn btn-danger"
                                                onclick="hapusComment({{ $comment->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <form id="delete-form-{{ $comment->id }}"
                                                action="{{ url('/comments/' . $comment->id) }}" method="POST">
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
                        {{ $comments->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Komentar -->
        <div class="modal fade" id="createCommentModal" tabindex="-1" role="dialog" aria-labelledby="createCommentLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Komentar Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="isi_komentar">Komentar</label>
                                <textarea class="form-control" name="isi_komentar" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <input type="number" class="form-control" name="rating" required>
                            </div>
                            <div class="form-group">
                                <label for="berita_id">Berita</label>
                                <select class="form-control" name="berita_id" required>
                                    <option value="" disabled selected>Pilih Berita</option>
                                    @foreach ($berita as $item)
                                        <option value="{{ $item->id }}">{{ $item->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Komentar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit Komentar -->
        @foreach ($comments as $comment)
            <div class="modal fade" id="editCommentModal{{ $comment->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editCommentLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Komentar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama"
                                        value="{{ $comment->nama }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="isi_komentar">Komentar</label>
                                    <textarea class="form-control" name="isi_komentar" rows="4" required>{{ $comment->isi_komentar }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="rating">Rating</label>
                                    <input type="number" class="form-control" name="rating"
                                        value="{{ $comment->rating }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="berita_id">Berita</label>
                                    <select class="form-control" name="berita_id" required>
                                        @foreach ($berita as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $comment->berita_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->judul }}
                                            </option>
                                        @endforeach
                                    </select>
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

    </div>

    <script>
        function hapusKomentar(id) {
            if (confirm("Apakah Anda yakin ingin menghapus komentar ini?")) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endsection
