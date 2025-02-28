@extends('layouts.admin.app')

@section('title', 'Detail Komentar')

@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Komentar oleh {{ $comment->nama }}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Nama:</strong> {{ $comment->nama }}
                </div>
                <div class="mb-3">
                    <strong>Isi Komentar:</strong>
                    <p>{{ $comment->isi_komentar }}</p>
                </div>
                <div class="mb-3">
                    <strong>Rating :</strong>
                    <p>{{ $comment->rating }}</p>
                </div>
                <div class="mb-3">
                    <strong>Tanggal Komentar:</strong>
                    {{ \Carbon\Carbon::parse($comment->tanggal_komentar)->format('d M Y') }}
                </div>
                <div class="mb-3">
                    <strong>Jam Komentar:</strong> {{ \Carbon\Carbon::parse($comment->jam_komentar)->format('H:i') }}
                </div>
                <div class="mb-3">
                    <strong>Berita Terkait:</strong> 
                    <a href="{{ route('berita.show', $comment->berita_id) }}">
                        {{ $comment->berita->judul ?? 'Berita tidak ditemukan' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
