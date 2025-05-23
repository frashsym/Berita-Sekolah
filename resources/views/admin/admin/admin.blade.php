@extends('layouts.admin.app')

@section('title', 'Data Admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Halaman Data Admin</h1>

        <!-- Tabel Admin -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Admin</h6>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAdminModal">
                    <i class="fas fa-plus"></i>
                    Tambah Admin
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->role->role }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#editAdminModal{{ $user->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 512 512">
                                            <path fill="white"
                                                d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                                        </svg>
                                    </button>

                                    <!-- Tombol Detail -->
                                    <a href="{{ url('/admin/' . $user->id) }}" class="btn btn-warning">
                                        <span class="icon text-white-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                <path fill="#ffffff"
                                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                            </svg>
                                        </span>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <button type="button" class="btn btn-danger" onclick="hapusAdmin({{ $user->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Form Hapus (Disembunyikan) -->
                                    <form id="delete-form-{{ $user->id }}" action="{{ url('/admin/' . $user->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Admin -->
                            <div class="modal fade" id="editAdminModal{{ $user->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Admin</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form action="{{ route('admin.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ $user->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" name="username"
                                                        value="{{ $user->username }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Role</label>
                                                    <select class="form-control" name="role_id" required>
                                                        <option value="" disabled selected>Pilih Role</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}"
                                                                {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                                {{ $role->role }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{ $user->email }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="photo">Foto Profile</label>
                                                    <input type="file" class="form-control-file" id="photo" name="photo">
                                                
                                                    @if (!empty($user->photo))
                                                        <div class="mt-2">
                                                            <img src="{{ asset('images/profile/' . $user->photo) }}" class="img-thumbnail" width="100">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>Password (Opsional)</label>
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Kosongkan jika tidak ingin mengubah">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Admin -->
<div class="modal fade" id="createAdminModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Admin</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="role_id" required>
                            <option value="" disabled selected>Pilih Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="photo">Foto Profil</label>
                        <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
