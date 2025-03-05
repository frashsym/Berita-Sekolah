@extends('layouts.admin.app')

@section('title', 'Detail Berita')

@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $berita->judul }}</h6>
            </div>
            <div class="card-body">
                @if ($berita->gambar_utama)
                    <div class="mb-3">
                        <img src="{{ asset('images/berita/' . $berita->gambar_utama) }}" alt="Gambar Berita"
                            class="img-fluid rounded" style="max-width: 500px; max-height: 500px;">
                    </div>
                @endif
                <div class="mb-3">
                    <strong>Penulis:</strong> {{ $berita->penulis }}
                </div>
                <div class="mb-3">
                    <strong>Kategori:</strong> {{ $berita->kategori->kategori ?? 'Tidak Ada' }}
                </div>
                <div class="mb-3">
                    <strong>Tanggal Publikasi:</strong>
                    {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') }}
                    {{ \Carbon\Carbon::parse($berita->jam_publikasi)->format('H:i') }}
                </div>
                <div class="mb-3">
                    <strong>Dilihat:</strong> {{ $berita->views ?? 'Tidak Ada' }}
                </div>
                <div class="mb-3">
                    <strong>Isi Berita:</strong>
                    <p>{{ $berita->isi_berita }}</p>
                </div>
            </div>
        </div>
    </div>
    @endsection
