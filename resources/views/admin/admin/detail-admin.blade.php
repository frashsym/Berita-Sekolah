@extends('layouts.admin.app')

@section('title', 'Detail Admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Profile {{ $user->username }}</h6>
            </div>
            <div class="card-body">
                @if ($user->photo)
                    <div class="mb-3 text-center">
                        <img src="{{ $user->photo ? asset('images/profile/' . $user->photo) : asset('images/undraw_profile.svg') }}"
                            class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                @endif
                <div class="mb-3">
                    <strong>Nama Lengkap:</strong> {{ $user->name }}
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> {{ $user->email }}
                </div>
                <div class="mb-3">
                    <strong>Role:</strong> {{ ucfirst($user->role->role) }}
                </div>
                <div class="mb-3">
                    <strong>Tanggal Bergabung:</strong>
                    {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                </div>
            </div>
        </div>
    </div>
@endsection
