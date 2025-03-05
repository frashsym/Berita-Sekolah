@extends('layouts.admin.app')

@section('title', 'Profile')

@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Profile {{ $user->username }}</h6>
            </div>
            <div class="card-body text-center">
                <img src="{{ $user->photo ? asset('images/profile/' . $user->photo) : asset('images/undraw_profile.svg') }}"
                    class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">

                <h5>{{ $user->name }}</h5>
                <p class="text-muted">{{ $user->email }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role->role) }}</p>
                <p><strong>Tanggal Bergabung:</strong> {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</p>

                <!-- Button untuk membuka modal edit -->
                <button class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">
                    Edit Profile
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto Profile</label>
                            <input type="file" class="form-control-file" id="photo" name="photo">
                            @if ($user->photo)
                                <div class="mt-2">
                                    <img src="{{ asset('images/profile/' . $user->photo) }}" class="img-thumbnail"
                                        width="100">
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password">
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
@endsection
